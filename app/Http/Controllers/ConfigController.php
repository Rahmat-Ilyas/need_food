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
}
