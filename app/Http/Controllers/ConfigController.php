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
			}
		}
	}
}
