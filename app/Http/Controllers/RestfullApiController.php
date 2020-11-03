<?php

namespace App\Http\Controllers;

use App\Model\PaketPesanan;
use App\Model\AdtPesanan;
use App\Model\Additional;
use App\Model\Pemesanan;
use App\Model\Transaksi;
use App\Model\ItemPaket;
use App\Model\Kategori;
use App\Model\Supplier;
use App\Model\AddBahan;
use App\Model\AddAlat;
use App\Model\Paket;
use App\Model\Bahan;
use App\Model\Alat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use File;

class RestfullApiController extends Controller
{
    // INVENTORI ALAT
	public function invGetsalat(Request $request)
	{
		$data = Alat::orderBy('id', 'desc')->get();
		$result = [];
		foreach ($data as $dta) {
			if (is_null($dta->alat_keluar)) $dta->alat_keluar = 0;
			$dta->sisa_alat = $dta->jumlah_alat - $dta->alat_keluar;
			$riwayat = AddAlat::where('alat_id', $dta->id)->get();
			$kategori = Kategori::where('id', $dta->kategori_id)->first();
			$dta['kategori'] = $kategori->kategori;

			$riwayat_beli = [];
			foreach ($riwayat as $rw) {
				$supplier = Supplier::where('id', $rw->supplier_id)->first();
				$rw['supplier'] = $supplier->nama_supplier;
				$riwayat_beli[] = $rw;
			}
			$dta->riwayat_beli = $riwayat_beli;

			$result[] = $dta;
		}

		return response()->json([
			'success' => true,
			'message' => 'Success get data',
			'result'  => $result
		], 200);
	}

	public function invGetalat($id)
	{
		$data = Alat::where('id', $id)->first();
		if ($data) {
			if (is_null($data->alat_keluar)) $data->alat_keluar = 0;
			$data->sisa_alat = $data->jumlah_alat - $data->alat_keluar;

			$riwayat = AddAlat::where('alat_id', $data->id)->get();
			$kategori = Kategori::where('id', $data->kategori_id)->first();
			$data['kategori'] = $kategori->kategori;

			$riwayat_beli = [];
			foreach ($riwayat as $rw) {
				$supplier = Supplier::where('id', $rw->supplier_id)->first();
				$rw['supplier'] = $supplier->nama_supplier;
				$riwayat_beli[] = $rw;
			}
			$data->riwayat_beli = $riwayat_beli;

			$result = $data;

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
	}

	public function invGetalatkategori($id)
	{
		$data = Alat::where('kategori_id', $id)->first();
		if ($data) {
			if (is_null($data->alat_keluar)) $data->alat_keluar = 0;
			$data->sisa_alat = $data->jumlah_alat - $data->alat_keluar;

			$riwayat = AddAlat::where('alat_id', $data->id)->get();
			$kategori = Kategori::where('id', $data->kategori_id)->first();
			$data['kategori'] = $kategori->kategori;

			$riwayat_beli = [];
			foreach ($riwayat as $rw) {
				$supplier = Supplier::where('id', $rw->supplier_id)->first();
				$rw['supplier'] = $supplier->nama_supplier;
				$riwayat_beli[] = $rw;
			}
			$data->riwayat_beli = $riwayat_beli;

			$result = $data;

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
	}

	public function invSetalat(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'nama' => 'required',
			'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			'kategori_id' => 'required|integer',
			'jumlah_alat' => 'required|integer',
			'total_harga' => 'required|integer',
			'supplier_id' => 'required|integer',
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		try {
			$data_alat = $request->except('foto', 'total_harga', 'supplier_id');
			$data_alat['kd_alat'] = $this->generate($request->nama);
			$foto = $request->file('foto');
			$nama_foto = 'img_alat_'.time().'.'.$foto->getClientOriginalExtension();
			$data_alat['foto'] = $nama_foto;
			$alat = Alat::create($data_alat);

			$path = 'assets/images/alat';
			$foto->move($path, $alat->foto);

			$supplier = Supplier::where('id', $request->supplier_id)->first();
			$add_alat = $request->only('total_harga', 'supplier_id');
			$add_alat['jumlah_beli'] = $request->jumlah_alat;
			$add_alat['alat_id'] = $alat->id;
			$add_alat['kd_beli'] = $this->generate($request->nama.$supplier->nama_supplier);
			$beli = AddAlat::create($add_alat);
			$result = $alat;

			return response()->json([
				'success' => true,
				'message' => 'Success add data'
			], 200);
		} catch(QueryException $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 500);	
		}
	}

	public function setStokalat(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'alat_id' => 'required|integer',
			'jumlah_beli' => 'required|integer',
			'total_harga' => 'required|integer',
			'supplier_id' => 'required|integer',
		]);


		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		try {
			$supplier = Supplier::where('id', $request->supplier_id)->first();
			$add_alat = $request->all();
			$add_alat['kd_beli'] = $this->generate($request->nama.$supplier->nama_supplier);
			$crt = AddAlat::create($add_alat);
			$updt = Alat::where('id', $crt->alat_id)->first();
			$updt->jumlah_alat = $updt->jumlah_alat + $crt->jumlah_beli;
			$updt->save();

			return response()->json([
				'success' => true,
				'message' => 'Success add data'
			], 200);
		} catch(QueryException $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 500);	
		}
	}

	public function deleteAlat($id)
	{
		try {
			$delete = Alat::find($id);

			if ($delete) {
				$delete->delete();
				File::delete(public_path('assets/images/alat/'.$delete->foto));
			} else {
				return response()->json([
					'success' => false,
					'message' => 'id not found'
				], 401); 
			}

			return response()->json([
				'success' => true,
				'message' => 'Success delete data'
			], 200);
		} catch(QueryException $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 500);	
		}
	}

	// INVENTORI BAHAN 
	public function invGetsbahan()
	{
		$data = Bahan::orderBy('id', 'desc')->get();
		$result = [];
		foreach ($data as $dta) {
			$riwayat = AddBahan::where('bahan_id', $dta->id)->get();
			$kategori = Kategori::where('id', $dta->kategori_id)->first();
			$dta['kategori'] = $kategori->kategori;

			$riwayat_beli = [];
			foreach ($riwayat as $rw) {
				$supplier = Supplier::where('id', $rw->supplier_id)->first();
				$rw['supplier'] = $supplier->nama_supplier;
				$riwayat_beli[] = $rw;
			}
			$dta->riwayat_beli = $riwayat_beli;

			$result[] = $dta;
		}

		return response()->json([
			'success' => true,
			'message' => 'Success get data',
			'result'  => $result
		], 200);
	}

	public function invGetbahan($id)
	{
		$data = Bahan::where('id', $id)->first();
		if ($data) {
			$riwayat = AddBahan::where('bahan_id', $data->id)->get();
			$kategori = Kategori::where('id', $data->kategori_id)->first();
			$data['kategori'] = $kategori->kategori;
			
			$riwayat_beli = [];
			foreach ($riwayat as $rw) {
				$supplier = Supplier::where('id', $rw->supplier_id)->first();
				$rw['supplier'] = $supplier->nama_supplier;
				$riwayat_beli[] = $rw;
			}
			$data->riwayat_beli = $riwayat_beli;

			$result = $data;

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
	}

	public function invGetbahankategori($id)
	{
		$data = Bahan::where('kategori_id', $id)->first();
		if ($data) {
			$riwayat = AddBahan::where('bahan_id', $data->id)->get();
			$kategori = Kategori::where('id', $data->kategori_id)->first();
			$data['kategori'] = $kategori->kategori;
			
			$riwayat_beli = [];
			foreach ($riwayat as $rw) {
				$supplier = Supplier::where('id', $rw->supplier_id)->first();
				$rw['supplier'] = $supplier->nama_supplier;
				$riwayat_beli[] = $rw;
			}
			$data->riwayat_beli = $riwayat_beli;

			$result = $data;

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
	}

	public function invSetbahan(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'nama' => 'required',
			'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			'kategori_id' => 'required|integer',
			'jumlah_bahan' => 'required|integer',
			'total_harga' => 'required|integer',
			'supplier_id' => 'required|integer',
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		try {
			$data_bahan = $request->except('foto', 'total_harga', 'supplier_id');
			$data_bahan['kd_bahan'] = $this->generate($request->nama);
			$foto = $request->file('foto');
			$nama_foto = 'img_bahan_'.time().'.'.$foto->getClientOriginalExtension();
			$data_bahan['foto'] = $nama_foto;
			$bahan = Bahan::create($data_bahan);

			$path = 'assets/images/bahan';
			$foto->move($path, $bahan->foto);

			$supplier = Supplier::where('id', $request->supplier_id)->first();
			$add_bahan = $request->only('total_harga', 'supplier_id');
			$add_bahan['jumlah_beli'] = $request->jumlah_bahan;
			$add_bahan['bahan_id'] = $bahan->id;
			$add_bahan['kd_beli'] = $this->generate($request->nama.$supplier->nama_supplier);
			$beli = AddBahan::create($add_bahan);
			$result = $bahan;

			return response()->json([
				'success' => true,
				'message' => 'Success add data'
			], 200);
		} catch(QueryException $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 500);	
		}
	}

	public function setStokbahan(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'bahan_id' => 'required|integer',
			'jumlah_beli' => 'required|integer',
			'total_harga' => 'required|integer',
			'supplier_id' => 'required|integer',
		]);


		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		try {
			$supplier = Supplier::where('id', $request->supplier_id)->first();
			$add_bahan = $request->all();
			$add_bahan['kd_beli'] = $this->generate($request->nama.$supplier->nama_supplier);
			$crt = AddBahan::create($add_bahan);
			$updt = Bahan::where('id', $crt->bahan_id)->first();
			$updt->jumlah_bahan = $updt->jumlah_bahan + $crt->jumlah_beli;
			$updt->save();

			return response()->json([
				'success' => true,
				'message' => 'Success add data'
			], 200);
		} catch(QueryException $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 500);	
		}
	}

	public function deleteBahan($id)
	{
		try {
			$delete = Bahan::find($id);

			if ($delete) {
				$delete->delete();
				File::delete(public_path('assets/images/bahan/'.$delete->foto));
			} else {
				return response()->json([
					'success' => false,
					'message' => 'id not found'
				], 401); 
			}

			return response()->json([
				'success' => true,
				'message' => 'Success delete data'
			], 200);
		} catch(QueryException $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 500);	
		}
	}

	// KATEGORI
	public function getsKategori(Request $request)
	{
		if (isset($request->kategori) && $request->kategori == 'alat')
			$data = Kategori::where('jenis', 'Kategori Alat')->get();
		else if (isset($request->kategori) && $request->kategori == 'bahan')
			$data = Kategori::where('jenis', 'Kategori Bahan')->get();
		else 
			$data = Kategori::orderBy('jenis', 'desc')->get();

		$result = $data;

		return response()->json([
			'success' => true,
			'message' => 'Success get data',
			'result'  => $result
		], 200);
	}

	public function getKategori($id)
	{
		$data = Kategori::where('id', $id)->first();
		if ($data) {
			$result = $data;

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
	}

	public function setKategori(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'kategori' => 'required',
			'jenis' => 'required',
			'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
		]);


		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		try {
			$data = $request->all();

			$foto = $request->file('foto');
			$nama_foto = 'img_kategori_'.time().'.'.$foto->getClientOriginalExtension();
			$data['foto'] = $nama_foto;
			$kategori = Kategori::create($data);

			$path = 'assets/images/kategori';
			$foto->move($path, $kategori->foto);

			return response()->json([
				'success' => true,
				'message' => 'Success add data'
			], 200);
		} catch(QueryException $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 500);	
		}
	}

	public function putKategori(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'kategori' => 'required',
			'jenis' => 'required',
		]);


		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		try {
			$update = Kategori::find($id);
			if ($update) {
				$update->kategori = $request->kategori;
				$update->jenis = $request->jenis;
				$update->save();
			} else {
				return response()->json([
					'success' => false,
					'message' => 'id not found'
				], 401); 
			}

			return response()->json([
				'success' => true,
				'message' => 'Success update data'
			], 200);
		} catch(QueryException $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 500);	
		}
	}

	public function deleteKategori($id)
	{
		try {
			$delete = Kategori::find($id);
			$alat = Alat::where('kategori_id', $id)->get();
			$bahan = Bahan::where('kategori_id', $id)->get();
			if ($alat) {
				foreach ($alat as $dta) {
					$dta->delete();
					File::delete(public_path('assets/images/alat/'.$dta->foto));
				}
			}
			if ($bahan) {
				foreach ($bahan as $dta) {
					$dta->delete();
					File::delete(public_path('assets/images/bahan/'.$dta->foto));
				}
			}

			if ($delete) {
				$delete->delete();
				File::delete(public_path('assets/images/kategori/'.$delete->foto));
			}
			else {
				return response()->json([
					'success' => false,
					'message' => 'id not found'
				], 401); 
			}

			return response()->json([
				'success' => true,
				'message' => 'Success delete data'
			], 200);
		} catch(QueryException $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 500);	
		}
	}

	// GENERATE CODE
	protected function generate($nama_produk)
	{
		$getNama = md5($nama_produk);
		$str1 = '';
		$str2 = '';
		for ($i=0; $i < 4; $i++) { 
			$str1 .= $getNama[rand(0, strlen($getNama)/2)];
			$str2 .= $getNama[rand(strlen($getNama)/2, strlen($getNama)-1)];
		}

		$uniqueCode = $str1."-".$str2;
		return $uniqueCode;
	}

    //SUPPLIER
	public function getsSupplier(Request $request)
	{
		if (isset($request->kategori) && $request->kategori == 'alat')
			$data = Supplier::where('kategori', '!=', 'Supplier Bahan')->get();
		else if (isset($request->kategori) && $request->kategori == 'bahan')
			$data = Supplier::where('kategori', '!=', 'Supplier Alat')->get();
		else 
			$data = Supplier::all();

		$result = $data;

		return response()->json([
			'success' => true,
			'message' => 'Success get data',
			'result'  => $result
		], 200);
	}

	public function getSupplier($id)
	{
		$data = Supplier::where('id', $id)->first();
		if ($data) {
			$result = $data;

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
	}

	public function setSupplier(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'nama_supplier' => 'required',
			'alamat' => 'required',
			'telepon' => 'required',
			'email' => 'required',
			'kategori' => 'required',
		]);


		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		try {
			$data = $request->all();
			Supplier::create($data);

			return response()->json([
				'success' => true,
				'message' => 'Success add data'
			], 200);
		} catch(QueryException $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 500);	
		}
	}

	public function putSupplier(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'nama_supplier' => 'required',
			'alamat' => 'required',
			'telepon' => 'required',
			'email' => 'required',
			'kategori' => 'required',
		]);


		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		try {
			$update = Supplier::find($id);
			if ($update) {
				$update->nama_supplier = $request->nama_supplier;
				$update->alamat = $request->alamat;
				$update->telepon = $request->telepon;
				$update->email = $request->email;
				$update->kategori = $request->kategori;
				$update->save();
			} else {
				return response()->json([
					'success' => false,
					'message' => 'id not found'
				], 401); 
			}

			return response()->json([
				'success' => true,
				'message' => 'Success update data'
			], 200);
		} catch(QueryException $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 500);	
		}
	}

	public function deleteSupplier($id)
	{
		try {
			$delete = Supplier::find($id);
			if ($delete) $delete->delete();
			else {
				return response()->json([
					'success' => false,
					'message' => 'id not found'
				], 401); 
			}

			return response()->json([
				'success' => true,
				'message' => 'Success delete data'
			], 200);
		} catch(QueryException $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 500);	
		}
	}

	// PEMESANAN
	public function setPesanan(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'nama' => 'required',
			'no_telepon' => 'required',
			'no_wa' => 'required',
			'tanggal_antar' => 'required',
			'waktu_antar' => 'required',
			'deskripsi_lokasi' => 'required',
			'latitude' => 'required',
			'logitude' => 'required',
			'paket_id' => 'required',
			'jumlah_paket' => 'required',
		]);


		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		try {
			// set kode
			$getId = Pemesanan::orderBy('id', 'desc')->first();
			$date = date('dmY');
			if ($getId) {
				$findId = sprintf('%02s', $getId->id+1);
				$kd_pemesanan = 'NFC-'.$findId.$date;
			}
			else $kd_pemesanan = 'NFC-01'.$date;

			// set data
			$pemesanan = $request->all();
			$pemesanan['kd_pemesanan'] = $kd_pemesanan;
			$pemesanan['status'] = 'waiting';
			$request->catatan ? $request->catatan : $pemesanan['catatan'] = '-';
			unset($pemesanan['paket_id']);
			unset($pemesanan['jumlah_paket']);
			unset($pemesanan['additional_id']);
			unset($pemesanan['jumlah_adt']);
			$pmsn = Pemesanan::create($pemesanan);

			$harga_paket = 0;
			$harga_additional = 0;

			foreach ($request->paket_id as $i => $paket_id) {
				$getPaket = Paket::where('id', $paket_id)->first();
				$paket = [];
				$paket['pemesanan_id'] = $pmsn->id;
				$paket['paket_id'] = $paket_id;
				$paket['jumlah'] = $request->jumlah_paket[$i];
				$paket['total_harga'] = $request->jumlah_paket[$i] * $getPaket->harga;
				$setPaket = PaketPesanan::create($paket);
				$harga_paket = $harga_paket + $request->jumlah_paket[$i] * $getPaket->harga;
			}

			if ($request->additional_id) {
				foreach ($request->additional_id as $i => $adt_id) {
					$getAdt = Additional::where('id', $adt_id)->first();
					$adt = [];
					$adt['pemesanan_id'] = $pmsn->id;
					$adt['additional_id'] = $adt_id;
					$adt['jumlah'] = $request->jumlah_adt[$i];
					$adt['total_harga'] = $request->jumlah_adt[$i] * $getAdt->harga;
					$setPaket = AdtPesanan::create($adt);
					$harga_additional = $harga_additional + $request->jumlah_adt[$i] * $getAdt->harga;
				}
			}

			$transaksi = [];
			$transaksi['pemesanan_id'] = $pmsn->id;
			$transaksi['harga_paket'] = $harga_paket;
			$transaksi['harga_additional'] = $harga_additional;
			$transaksi['biaya_pengiriman'] = 0;
			$transaksi['harga_lainnya'] = 0;
			$transaksi['total_harga'] = $harga_paket + $harga_additional;
			Transaksi::create($transaksi);

			return response()->json([
				'success' => true,
				'message' => 'Success add data'
			], 200);
		} catch(QueryException $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 500);	
		}
	}

	public function getsPesanan(Request $request)
	{
		if ($request->status) $pemesanan = Pemesanan::where('status', $request->status)->get();
		else $pemesanan = Pemesanan::all();

		$result = $this->getDataPesanan($pemesanan);

		if (count($result) > 0) {
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
	}

	public function getPesanan($id)
	{
		$pemesanan = Pemesanan::where('id', $id)->first();
		$result = $this->getDataPesanan($pemesanan, $id);

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
	}

	public function getStatusPesanan($status)
	{
		$pemesanan = Pemesanan::where('status', $status)->get();
		$result = $this->getDataPesanan($pemesanan);

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
	}

	protected function getDataPesanan($pemesanan, $id = null)
	{
		if ($pemesanan) {
			if ($id) {
				$getPaket = PaketPesanan::where('pemesanan_id', $id)->get();
				foreach ($getPaket as $i => $pkt) {
					$getPkt = Paket::where('id', $pkt->paket_id)->first();
					$paket[$i]['pemesanan_id'] = $pkt->pemesanan_id;
					$paket[$i]['paket_id'] = $pkt->paket_id;
					$paket[$i]['nama_paket'] = $getPkt->nama;
					$paket[$i]['harga'] = $getPkt->harga;
					$paket[$i]['jumlah'] = $pkt->jumlah;
					$paket[$i]['total_harga'] = $pkt->total_harga;
				}

				$getAdditional = AdtPesanan::where('pemesanan_id', $id)->get();
				$additional = [];
				if ($getAdditional) {
					foreach ($getAdditional as $i => $adt) {
						$getAdt = Additional::where('id', $adt->additional_id)->first();
						$additional[$i]['pemesanan_id'] = $adt->pemesanan_id;
						$additional[$i]['additional_id'] = $adt->additional_id;
						$additional[$i]['nama_daging'] = $getAdt->nama_daging;
						$additional[$i]['harga'] = $getAdt->harga;
						$additional[$i]['berat'] = $getAdt->berat;
						$additional[$i]['jumlah'] = $adt->jumlah;
						$additional[$i]['total_harga'] = $adt->total_harga;
					}
				}

				$transaksi = Transaksi::where('pemesanan_id', $id)->first();
				unset($transaksi['created_at']);
				unset($transaksi['updated_at']);

				$pemesanan['paket'] = $paket;
				$pemesanan['additional'] = $additional;
				$pemesanan['transaksi'] = $transaksi;
			} else {
				foreach ($pemesanan as $i => $pesanan) {
					$getPaket = PaketPesanan::where('pemesanan_id', $pesanan->id)->get();
					foreach ($getPaket as $i => $pkt) {
						$getPkt = Paket::where('id', $pkt->paket_id)->first();
						$paket[$i]['pemesanan_id'] = $pkt->pemesanan_id;
						$paket[$i]['paket_id'] = $pkt->paket_id;
						$paket[$i]['nama_paket'] = $getPkt->nama;
						$paket[$i]['harga'] = $getPkt->harga;
						$paket[$i]['jumlah'] = $pkt->jumlah;
						$paket[$i]['total_harga'] = $pkt->total_harga;
					}

					$getAdditional = AdtPesanan::where('pemesanan_id', $pesanan->id)->get();
					$additional = [];
					if ($getAdditional) {
						foreach ($getAdditional as $i => $adt) {
							$getAdt = Additional::where('id', $adt->additional_id)->first();
							$additional[$i]['pemesanan_id'] = $adt->pemesanan_id;
							$additional[$i]['additional_id'] = $adt->additional_id;
							$additional[$i]['nama_daging'] = $getAdt->nama_daging;
							$additional[$i]['harga'] = $getAdt->harga;
							$additional[$i]['berat'] = $getAdt->berat;
							$additional[$i]['jumlah'] = $adt->jumlah;
							$additional[$i]['total_harga'] = $adt->total_harga;
						}
					}

					$transaksi = Transaksi::where('pemesanan_id', $pesanan->id)->first();
					unset($transaksi['created_at']);
					unset($transaksi['updated_at']);

					$pesanan['paket'] = $paket;
					$pesanan['additional'] = $additional;
					$pesanan['transaksi'] = $transaksi;
				}
			}
		}
		return $pemesanan;
	}

	public function updateStatusPesanan(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'status' => 'required',
		]);


		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}
		
		try {
			$update = Pemesanan::find($id);
			if ($update) {
				$update->status = $request->status;
				$update->save();
			} else {
				return response()->json([
					'success' => false,
					'message' => 'id not found'
				], 401); 
			}

			return response()->json([
				'success' => true,
				'message' => 'Success update data'
			], 200);
		} catch(QueryException $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 500);	
		}
	}

	public function updateTransaksiPesanan(Request $request, $id)
	{
		if (!$request->biaya_pengiriman && !$request->harga_lainnya) {
			return response()->json([
				'success' => false,
				'message' => 'biaya_pengiriman atau harga_lainnya tidak boleh kosong'
			], 401);  
		}

		try {
			$update = Transaksi::where('pemesanan_id', $id)->first();
			if ($update) {
				if ($request->biaya_pengiriman && $request->harga_lainnya) {
					$update->biaya_pengiriman = $request->biaya_pengiriman;
					$update->harga_lainnya = $request->harga_lainnya;
				} else if ($request->biaya_pengiriman) {
					$update->biaya_pengiriman = $request->biaya_pengiriman;
				} else if ($request->harga_lainnya) {
					$update->harga_lainnya = $request->harga_lainnya;
				}
				$total_harga = $update->harga_paket + $update->harga_additional + $update->biaya_pengiriman + $update->harga_lainnya;
				$update->total_harga = $total_harga;
				$update->save();
			} else {
				return response()->json([
					'success' => false,
					'message' => 'id not found'
				], 401); 
			}

			return response()->json([
				'success' => true,
				'message' => 'Success update data'
			], 200);
		} catch(QueryException $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 500);	
		}
	}

	// PEMESANAN
	public function setPaket(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'nama' => 'required',
			'harga' => 'required',
			'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			'item' => 'required',
			'keterangan' => 'required'
		]);


		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		try {
			$data_paket = $request->except('item');
			$foto = $request->file('foto');
			$nama_foto = 'img_paket_'.time().'.'.$foto->getClientOriginalExtension();
			$data_paket['foto'] = $nama_foto;
			$paket = Paket::create($data_paket);

			$path = 'assets/images/paket';
			$foto->move($path, $paket->foto);
			foreach ($request->item as $item) {
				$item_paket = [];
				$item_paket['paket_id'] = $paket->id;
				$item_paket['nama_bahan'] = $item;
				ItemPaket::create($item_paket);
			}

			return response()->json([
				'success' => true,
				'message' => 'Success add data'
			], 200);
		} catch(QueryException $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 500);	
		}
	}

	public function loginMobile(Request $request)
	{
		
	}
}