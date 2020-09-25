<?php

namespace App\Http\Controllers;

use App\Model\Supplier;
use App\Model\AddAlat;
use App\Model\Alat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

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
			'kategori' => 'required',
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
			AddAlat::create($add_alat);

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
}
