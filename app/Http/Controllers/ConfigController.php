<?php

namespace App\Http\Controllers;

use App\Model\PaketPesanan;
use App\Model\AdtPesanan;
use App\Model\Additional;
use App\Model\Pemesanan;
use App\Model\Transaksi;
use App\Model\Kategori;
use App\Model\Supplier;
use App\Model\AddBahan;
use App\Model\AddAlat;
use App\Model\Paket;
use App\Model\Bahan;
use App\Model\Alat;

use Illuminate\Http\Request;
use DataTables;
use Validator;

class ConfigController extends Controller
{
	public function config(Request $request)
	{
		if (isset($request->req)) {
			if ($request->req == 'pesananbaru') {
				$request = [];
				$pemesanan = Pemesanan::where('status', 'waiting')->get();
				foreach ($pemesanan as $dta) {
					$dta['jadwal_antar'] = date('d/m/Y', strtotime($dta->tanggal_antar)).' ('.$dta->waktu_antar.')';
					$result[] = $dta;
				}

				if ($result) {
					return response()->json([
						'success' => true,
						'message' => 'Success get data',
						'result'  => $result
					], 200);
				} else {
					return response()->json([
						'success' => false,
						'message' => 'Data not found'
					], 404);
				}
			} else if ($request->req == 'seleksibahanpaket') {
				$bahan = Bahan::orderBy('id', 'desc')->get();
				$result = $bahan->except($request->item);
				return response()->json($result, 200);
			} else if ($request->req == 'getdataprint') {
				$data = $request->val_chek;

				$result = [];
				foreach ($data as $dta) {
					$pemesanan = Pemesanan::where('id', $dta)->first();
					$result[] = $pemesanan->only('kd_pemesanan', 'nama', 'no_telepon', 'no_wa', 'deskripsi_lokasi');
				}

				return response()->json([
					'success' => true,
					'message' => 'Success get data',
					'result'  => $result
				], 200);
			} else if ($request->req == 'printalat') {
				$pemesanan = Pemesanan::where('id', $request->id)->first();

				if ($pemesanan){
					$result['kd_pemesanan'] = $pemesanan->kd_pemesanan;
					$result['tanggal_antar'] = date('d F Y', strtotime($pemesanan->tanggal_antar));
					$result['nama'] = $pemesanan->nama;
					$result['no_telepon'] = $pemesanan->no_telepon;
					$result['no_wa'] = $pemesanan->no_wa;
					$result['deskripsi_lokasi'] = $pemesanan->deskripsi_lokasi;
				}
				else $result = null;

				return response()->json([
					'success' => true,
					'message' => 'Success get data',
					'result'  => $result
				], 200);
			} else if ($request->req == 'geteditalat') {
				$data = Alat::where('id', $request->id)->first();
				return response()->json($data, 200);
			} else if ($request->req == 'geteditbahan') {
				$data = Bahan::where('id', $request->id)->first();
				return response()->json($data, 200);
			}
		}
	}

	public function datatable(Request $request)
	{
		if ($request->req == 'dtKategori') {
			$result = Kategori::all();
			$data = [];
			$no = 1;
			foreach ($result as $dta) {
				$dta->no = $no;
				$data[] = $dta;
				$no = $no + 1;
			}

			return Datatables::of($data)
			->addColumn('foto', function($dta) {
				$url = url('/');
				return '<a href="#" id="view-gambar-kategori" data-toggle="modal" data-target="#modal-gambar-kategori" data-id="'.$dta->id.'"> <img src="'.$url.'/assets/images/kategori/'.$dta->foto.'" class="img-responsive thumb-md"> </a>';
			})->addColumn('action', function($dta) {
				return '<div class="text-center">
						<button type="button" class="btn btn-success btn-sm waves-effect waves-light" id="edit-kategori" data-toggle1="tooltip" title="Edit" data-toggle="modal" data-target=".modal-edit" data-id="'.$dta->id.'"><i class="fa fa-edit"></i></button>
						<button type="button" class="btn btn-danger btn-sm waves-effect waves-light" id="hapus-kategori" data-toggle1="tooltip" title="Hapus" data-toggle="modal" data-target=".modal-delete" data-id="'.$dta->id.'"><i class="fa fa-trash"></i></button>
						</div>';
			})->rawColumns(['foto', 'action'])->toJson();
		} else if ($request->req == 'dtGetBahan') {
			$result = Bahan::all();
			$data = [];
			$no = 1;
			foreach ($result as $dta) {
				$ktgr = Kategori::where('id', $dta->kategori_id)->first();
				$dta->no = $no;
				$dta->jumlah_bahan = $dta->jumlah_bahan.' '.$dta->satuan;
				$dta->kategori = $ktgr->kategori;
				$data[] = $dta;
				$no = $no + 1;
			}

			return Datatables::of($data)
			->addColumn('foto', function($dta) {
				$url = url('/');
				return '<a href="#" id="view-gambar-bahan" data-toggle="modal" data-target="#modal-gambar-bahan" data-id="'.$dta->id.'"> <img src="'.$url.'/assets/images/bahan/'.$dta->foto.'" class="img-responsive thumb-md"> </a>';
			})->addColumn('action', function($dta) {
				return '<div class="text-center">
                        <a href="#" role="button" class="btn btn-info btn-sm waves-effect waves-light" id="detail-bahan" dta-id="'.$dta->id.'" data-toggle1="tooltip" title="Detail" data-toggle="modal" data-target=".detail-bahan"><i class="fa fa-eye"></i></a>
                        <a href="#" role="button" class="btn btn-success btn-sm waves-effect waves-light" id="edit-bahan" dta-id="'.$dta->id.'" data-toggle1="tooltip" title="Edit" data-toggle="modal" data-target=".modal-edit-bahan"><i class="fa fa-edit"></i></a>
                        <a href="#" role="button" class="btn btn-danger btn-sm waves-effect waves-light" id="hapus-bahan" dta-id="'.$dta->id.'" data-toggle1="tooltip" title="Hapus" data-toggle="modal" data-target=".modal-delete"><i class="fa fa-trash"></i></a>
                        </div>';
			})->rawColumns(['foto', 'action'])->toJson();
		}  else if ($request->req == 'dtGetAlat') {
			$result = Alat::all();
			$data = [];
			$no = 1;
			foreach ($result as $dta) {
				$ktgr = Kategori::where('id', $dta->kategori_id)->first();
				if (is_null($dta->alat_keluar)) $dta->alat_keluar = 0;
				$dta->no = $no;
				$dta->sisa_alat = $dta->jumlah_alat - $dta->alat_keluar.' pcs';
				$dta->jumlah_alat = $dta->jumlah_alat.' pcs';
				$dta->alat_keluar = $dta->alat_keluar.' pcs';
				$dta->kategori = $ktgr->kategori;
				$data[] = $dta;
				$no = $no + 1;
			}

			return Datatables::of($data)
			->addColumn('foto', function($dta) {
				$url = url('/');
				return '<a href="#" id="view-gambar-alat" data-toggle="modal" data-target="#modal-gambar-alat" data-id="'.$dta->id.'"> <img src="'.$url.'/assets/images/alat/'.$dta->foto.'" class="img-responsive thumb-md"> </a>';
			})->addColumn('action', function($dta) {
				return '<div class="text-center">
                        <a href="#" role="button" class="btn btn-info btn-sm waves-effect waves-light" id="detail-alat" dta-id="'.$dta->id.'" data-toggle1="tooltip" title="Detail" data-toggle="modal" data-target=".detail-alat"><i class="fa fa-eye"></i></a>
                        <a href="#" role="button" class="btn btn-success btn-sm waves-effect waves-light" id="edit-alat" dta-id="'.$dta->id.'" data-toggle1="tooltip" title="Edit" data-toggle="modal" data-target=".modal-edit-alat"><i class="fa fa-edit"></i></a>
                        <a href="#" role="button" class="btn btn-danger btn-sm waves-effect waves-light" id="hapus-alat" dta-id="'.$dta->id.'" data-toggle1="tooltip" title="Hapus" data-toggle="modal" data-target=".modal-delete"><i class="fa fa-trash"></i></a>
                        </div>';
			})->rawColumns(['foto', 'action'])->toJson();
		}
	}
}
