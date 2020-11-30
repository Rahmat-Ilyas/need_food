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
use App\Model\Driver;
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
			} else if ($request->req == 'databelialat') {
				$data = AddAlat::where('id', $request->id)->first();
				$alat = Alat::where('id', $data->alat_id)->first();
				$get_supplier = Supplier::where('kategori', '!=', 'Supplier Bahan')->orderBy('id', 'desc')->get();
				$supplier = '';
				foreach ($get_supplier as $dta) {
					if ($dta->id == $data->supplier_id) 
						$supplier .= '<option value="'.$dta->id.'" selected>'.$dta->nama_supplier.'</option>';
					else
						$supplier .= '<option value="'.$dta->id.'">'.$dta->nama_supplier.'</option>';
				}

				$result = '<form id="alatPembelian">
				<div class="text-left">
				<div class="form-group">
				<label for="jumlah_beli">Nama Alat</label>
				<input type="text" class="form-control" required="" placeholder="Nama Alat" value="'.$alat->nama.'" disabled="">
				</div>
				<div class="form-group">
				<label for="jumlah_beli">Jumlah Beli</label>
				<div class="input-group col-sm-12">
				<input type="number" class="form-control" required="" placeholder="Jumlah Beli" name="jumlah_beli" value="'.$data->jumlah_beli.'">
				<span class="input-group-addon">pcs</span>
				</div>
				</div>
				<div class="form-group">
				<label for="total_harga">Total Harga Beli</label>
				<div class="input-group col-sm-12">
				<span class="input-group-addon">Rp.</i></span>
				<input type="number" class="form-control" required="" placeholder="Total Harga" name="total_harga" value="'.$data->total_harga.'">
				<span class="input-group-addon">.00</span>
				</div>
				</div>
				<div class="form-group">
				<label for="supplier_id">Nama Supplier</label>
				<select name="supplier_id" id="edt_supplier" class="form-control">
				'.$supplier.'
				</select>
				</div>
				</div>
				</form>';
				return response()->json($result, 200);
			} else if ($request->req == 'updatealatbeli') {
				$validator = Validator::make($request->all(), [
					'jumlah_beli' => 'required|integer',
					'total_harga' => 'required|integer',
					'supplier_id' => 'required|integer',
				]);

				if ($validator->fails()) {
					return response()->json([
						'status' => 'error',
						'title' => 'Gagal mengupdate data!',
						'message' => 'Form tidak boleh kosong',
					]);            
				}

				try {
					$update = AddAlat::find($request->id);
					$update->jumlah_beli = $request->jumlah_beli;
					$update->total_harga = $request->total_harga;
					$update->supplier_id = $request->supplier_id;
					$update->save();

					$get_jumlah = AddAlat::where('alat_id', $update->alat_id)->get();
					$jumlah_alat = 0;
					foreach ($get_jumlah as $jum) {
						$jumlah_alat = $jumlah_alat + $jum->jumlah_beli;
					}

					$updt_jum = Alat::where('id', $update->alat_id)->first();
					$updt_jum->jumlah_alat = $jumlah_alat;
					$updt_jum->save();

					return response()->json([
						'status' => 'success',
						'title' => 'Berhasil mengupdate data!',
						'message' => 'Data pembelian berhasil di update',
						'id' => $updt_jum->id
					]); 
				} catch(QueryException $ex) {
					return response()->json([
						'status' => 'error',
						'title' => 'Gagal mengupdate data!',
						'message' => 'Terjadi kesalahan',
					]);
				}
			} else if ($request->req == 'deletealatbeli') {
				try {
					$delete = AddAlat::find($request->id);
					$delete->delete();

					$get_jumlah = AddAlat::where('alat_id', $delete->alat_id)->get();
					$jumlah_alat = 0;
					foreach ($get_jumlah as $jum) {
						$jumlah_alat = $jumlah_alat + $jum->jumlah_beli;
					}

					$updt_jum = Alat::where('id', $delete->alat_id)->first();
					$updt_jum->jumlah_alat = $jumlah_alat;
					$updt_jum->save();

					return response()->json([
						'status' => 'success',
						'title' => 'Berhasil menghapus data!',
						'message' => 'Data pembelian berhasil di hapus',
						'id' => $updt_jum->id
					]);
				} catch(QueryException $ex) {
					return response()->json([
						'status' => 'error',
						'title' => 'Gagal menghapus data!',
						'message' => 'Terjadi kesalahan',
					]);	
				}
			} else if ($request->req == 'detailsupplier') {
				$data = Supplier::where('id', $request->id)->first();
				$result = '<div class="p-20 text-left">
				<div class="m-b-20"><b>Nama Supplier: </b><span>'.$data->nama_supplier.'</span></div>
				<div class="m-b-20"><b>Alamat: </b><span>'.$data->alamat.'</span></div>
				<div class="m-b-20"><b>Telepon: </b><span>'.$data->telepon.'</span></div>
				<div class="m-b-20"><b>Email: </b><span>'.$data->email.'</span></div>
				</div>';
				return response()->json($result, 200);
			} else if ($request->req == 'databelibahan') {
				$data = AddBahan::where('id', $request->id)->first();
				$bahan = Bahan::where('id', $data->bahan_id)->first();
				$get_supplier = Supplier::where('kategori', '!=', 'Supplier Alat')->orderBy('id', 'desc')->get();
				$supplier = '';
				foreach ($get_supplier as $dta) {
					if ($dta->id == $data->supplier_id) 
						$supplier .= '<option value="'.$dta->id.'" selected>'.$dta->nama_supplier.'</option>';
					else
						$supplier .= '<option value="'.$dta->id.'">'.$dta->nama_supplier.'</option>';
				}

				$result = '<form id="bahanPembelian">
				<div class="text-left">
				<div class="form-group">
				<label for="jumlah_beli">Nama Bahan</label>
				<input type="text" class="form-control" required="" placeholder="Nama Bahan" value="'.$bahan->nama.'" disabled="">
				</div>
				<div class="form-group">
				<label for="jumlah_beli">Jumlah Beli</label>
				<div class="input-group col-sm-12">
				<input type="number" class="form-control" required="" placeholder="Jumlah Beli" name="jumlah_beli" value="'.$data->jumlah_beli.'">
				<span class="input-group-addon">'.$bahan->satuan.'</span>
				</div>
				</div>
				<div class="form-group">
				<label for="total_harga">Total Harga Beli</label>
				<div class="input-group col-sm-12">
				<span class="input-group-addon">Rp.</i></span>
				<input type="number" class="form-control" required="" placeholder="Total Harga" name="total_harga" value="'.$data->total_harga.'">
				<span class="input-group-addon">.00</span>
				</div>
				</div>
				<div class="form-group">
				<label for="supplier_id">Nama Supplier</label>
				<select name="supplier_id" id="edt_supplier" class="form-control">
				'.$supplier.'
				</select>
				</div>
				</div>
				</form>';
				return response()->json($result, 200);
			} else if ($request->req == 'updatebahanbeli') {
				$validator = Validator::make($request->all(), [
					'jumlah_beli' => 'required|integer',
					'total_harga' => 'required|integer',
					'supplier_id' => 'required|integer',
				]);

				if ($validator->fails()) {
					return response()->json([
						'status' => 'error',
						'title' => 'Gagal mengupdate data!',
						'message' => 'Form tidak boleh kosong',
					]);            
				}

				try {
					$update = AddBahan::find($request->id);
					$update->jumlah_beli = $request->jumlah_beli;
					$update->total_harga = $request->total_harga;
					$update->supplier_id = $request->supplier_id;
					$update->save();

					$get_jumlah = AddBahan::where('bahan_id', $update->bahan_id)->get();
					$jumlah_bahan = 0;
					foreach ($get_jumlah as $jum) {
						$jumlah_bahan = $jumlah_bahan + $jum->jumlah_beli;
					}

					$updt_jum = Bahan::where('id', $update->bahan_id)->first();
					$updt_jum->jumlah_bahan = $jumlah_bahan;
					$updt_jum->save();

					return response()->json([
						'status' => 'success',
						'title' => 'Berhasil mengupdate data!',
						'message' => 'Data pembelian berhasil di update',
						'id' => $updt_jum->id
					]); 
				} catch(QueryException $ex) {
					return response()->json([
						'status' => 'error',
						'title' => 'Gagal mengupdate data!',
						'message' => 'Terjadi kesalahan',
					]);
				}
			} else if ($request->req == 'deletebahanbeli') {
				try {
					$delete = AddBahan::find($request->id);
					$delete->delete();

					$get_jumlah = AddBahan::where('bahan_id', $delete->bahan_id)->get();
					$jumlah_bahan = 0;
					foreach ($get_jumlah as $jum) {
						$jumlah_bahan = $jumlah_bahan + $jum->jumlah_beli;
					}

					$updt_jum = Bahan::where('id', $delete->bahan_id)->first();
					$updt_jum->jumlah_bahan = $jumlah_bahan;
					$updt_jum->save();

					return response()->json([
						'status' => 'success',
						'title' => 'Berhasil menghapus data!',
						'message' => 'Data pembelian berhasil di hapus',
						'id' => $updt_jum->id
					]);
				} catch(QueryException $ex) {
					return response()->json([
						'status' => 'error',
						'title' => 'Gagal menghapus data!',
						'message' => 'Terjadi kesalahan',
					]);	
				}
			} else if ($request->req == 'addSetBahan') {
            $bahan = Bahan::where('id', $request->bahan_id)->first();
            $exits = '<input type="hidden" name="exits[]" value="'. $bahan->id .'">';
            $added = '<tr>
                           <td>'. $bahan->nama .'</td>
                           <td class="form-inline text-center">
                              <input type="number" class="form-control" style="height: 30px; width: 60px;"
                                 name="jumlah">
                              <span><b>pcs</b> /</span>
                              <input type="number" class="form-control" style="height: 30px; width: 60px;" name="per_paket"
                                 value="1">
                              <span><b>pax</b></span>
                           </td>
                           <td class="form-inline">
                              <input type="number" class="form-control" style="height: 30px; width: 90px;"
                                 name="maksimal">
                              <span><b>pcs</b></span>
                           </td>
                           <td class="text-center">
                              <input type="checkbox" data-plugin="switchery" data-size="small" name="jenis">
                           </td>
                           <td class="text-center">
                              <a href="#" class="text-danger" data-toggle1="tooltip" title="Remove" id="remove-bahan"><i class="fa fa-trash"></i></a>
                           </td>
                     </tr>';
            $result = ['exits' => $exits, 'added' => $added];
            return response()->json($result);
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
		} else if ($request->req == 'dtDriver') {
			$result = Driver::all();
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
				return '<a href="#" id="view-gambar-driver" data-toggle="modal" data-target="#modal-gambar" data-id="'.$dta->id.'"> <img src="'.$url.'/assets/images/driver/'.$dta->foto.'" class="img-responsive thumb-md rounded-circle" style="border-radius: 50%;"> </a>';
			})->addColumn('status', function($dta) {
				if ($dta->status == 'active') {
					$label = '<span class="label label-table label-success">Active</span>';
				} else {
					$label = '<span class="label label-table label-danger">Suspended</span>';
				}
				return $label;
			})->addColumn('action', function($dta) {
				return '<div class="text-center">
				<a href="#" role="button" class="btn btn-primary btn-sm waves-effect waves-light" id="edit-driver" dta-id="'.$dta->id.'" data-toggle1="tooltip" title="Edit" data-toggle="modal" data-target=".modal-edit"><i class="fa fa-edit"></i></a>
				<a href="#" role="button" class="btn btn-danger btn-sm waves-effect waves-light" id="hapus-driver" dta-id="'.$dta->id.'" data-toggle1="tooltip" title="Hapus" data-toggle="modal" data-target=".modal-delete"><i class="fa fa-trash"></i></a>
				</div>';
			})->rawColumns(['foto', 'status', 'action'])->toJson();
		}
	}
}
