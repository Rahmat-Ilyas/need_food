<?php

namespace App\Http\Controllers;

use App\Model\PaketPesanan;
use App\Model\AlatPesanan;
use App\Model\AdtPesanan;
use App\Model\Additional;
use App\Model\Pemesanan;
use App\Model\Transaksi;
use App\Model\ItemPaket;
use App\Model\AuthLogin;
use App\Model\Kategori;
use App\Model\Supplier;
use App\Model\AddBahan;
use App\Model\SetBahan;
use App\Model\AddAlat;
use App\Model\SetAlat;
use App\Model\Driver;
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
			$kategori = Kategori::where('id', $dta->kategori_id)->first();
			$dta['kategori'] = $kategori->kategori;

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
		$data = Alat::where('kategori_id', $id)->get();
		$result = [];
		foreach ($data as $dta) {
			if (is_null($dta->alat_keluar)) $dta->alat_keluar = 0;
			$dta->sisa_alat = $dta->jumlah_alat - $dta->alat_keluar;

			$kategori = Kategori::where('id', $dta->kategori_id)->first();
			$dta['kategori'] = $kategori->kategori;

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
	}

	public function invSetalat(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'nama' => 'required',
			'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
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

	public function invPutalat(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'nama' => 'required',
			'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
			'kategori_id' => 'required|integer',
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		try {
			$update = Alat::find($id);
			if ($update) {
				$update->nama = $request->nama;
				$update->kategori_id = $request->kategori_id;
				if ($request->file('foto')) {
					$foto = $request->file('foto');
					$nama_foto = 'img_alat_'.time().'.'.$foto->getClientOriginalExtension();

					// Update Foto
					$path = 'assets/images/alat';
					$foto->move($path, $nama_foto);
					// Delete Old Foto
					File::delete('assets/images/alat/'.$update->foto);
					// Save to Database
					$update->foto = $nama_foto;
				}
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
				File::delete('assets/images/alat/'.$delete->foto);
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
			$kategori = Kategori::where('id', $dta->kategori_id)->first();
			$dta['kategori'] = $kategori->kategori;

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
		$data = Bahan::where('kategori_id', $id)->get();
		$result = [];
		foreach ($data as $dta) {
			$kategori = Kategori::where('id', $dta->kategori_id)->first();
			$dta['kategori'] = $kategori->kategori;

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
	}

	public function invSetbahan(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'nama' => 'required',
			'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
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

	public function invPutbahan(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'nama' => 'required',
			'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
			'kategori_id' => 'required|integer',
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		try {
			$update = Bahan::find($id);
			if ($update) {
				$update->nama = $request->nama;
				$update->kategori_id = $request->kategori_id;
				$update->satuan = $request->satuan;
				if ($request->file('foto')) {
					$foto = $request->file('foto');
					$nama_foto = 'img_bahan_'.time().'.'.$foto->getClientOriginalExtension();

					// Update Foto
					$path = 'assets/images/bahan';
					$foto->move($path, $nama_foto);
					// Delete Old Foto
					File::delete('assets/images/bahan/'.$update->foto);
					// Save to Database
					$update->foto = $nama_foto;
				}
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
				File::delete('assets/images/bahan/'.$delete->foto);
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
			'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240'
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
				if ($request->file('foto')) {
					$foto = $request->file('foto');
					$nama_foto = 'img_kategori_'.time().'.'.$foto->getClientOriginalExtension();

					// Update Foto
					$path = 'assets/images/kategori';
					$foto->move($path, $nama_foto);
					// Delete Old Foto
					File::delete('assets/images/kategori/'.$update->foto);
					// Save to Database
					$update->foto = $nama_foto;
				}
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
					File::delete('assets/images/alat/'.$dta->foto);
				}
			}
			if ($bahan) {
				foreach ($bahan as $dta) {
					$dta->delete();
					File::delete('assets/images/bahan/'.$dta->foto);
				}
			}

			if ($delete) {
				$delete->delete();
				File::delete('assets/images/kategori/'.$delete->foto);
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
			$data = Supplier::where('kategori', '!=', 'Supplier Bahan')->orderBy('id', 'desc')->get();
		else if (isset($request->kategori) && $request->kategori == 'bahan')
			$data = Supplier::where('kategori', '!=', 'Supplier Alat')->orderBy('id', 'desc')->get();
		else 
			$data = Supplier::orderBy('id', 'desc')->get();

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
				// Update Supplier Alat/Bahan
				if ($request->kategori == "Supplier Alat") {
					$bahan = AddBahan::where('supplier_id', $id)->get();
					if ($bahan) {
						foreach ($bahan as $bhn) {
							$bhn->supplier_id = 0;
							$bhn->save();
						}
					}
				} else if ($request->kategori == "Supplier Bahan") {
					$alat = AddAlat::where('supplier_id', $id)->get();
					if ($alat) {
						foreach ($alat as $alt) {
							$alt->supplier_id = 0;
							$alt->save();
						}
					}
				} else if ($request->kategori == "Supplier Alat & Bahan") {
					$bahan = AddBahan::where('supplier_id', $id)->get();
					if ($bahan) {
						foreach ($bahan as $bhn) {
							$bhn->supplier_id = $id;
							$bhn->save();
						}
					}

					$alat = AddAlat::where('supplier_id', $id)->get();
					if ($alat) {
						foreach ($alat as $alt) {
							$alt->supplier_id = $id;
							$alt->save();
						}
					}
				}

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
			if ($delete) {
				$bahan = AddBahan::where('supplier_id', $id)->get();
				if ($bahan) {
					foreach ($bahan as $bhn) {
						$bhn->supplier_id = 0;
						$bhn->save();
					}
				}

				$alat = AddAlat::where('supplier_id', $id)->get();
				if ($alat) {
					foreach ($alat as $alt) {
						$alt->supplier_id = 0;
						$alt->save();
					}
				}

				$delete->delete();
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

	// DRIVER
	public function setDriver(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'nama' => 'required',
			'alamat' => 'required',
			'telepon' => 'required',
			'email' => 'required',
			'username' => 'required',
		]);


		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		try {
			$data = $request->all();
			$data['foto'] = 'img_driver_default.png';
			$data['password'] = bcrypt('driver_needfood');
			$data['status'] = 'active';

			$driver = Driver::where('username', $request->username)->first();
			$admin = AuthLogin::where('username', $request->username)->first();

			if ($driver || $admin) {
				return response()->json([
					'success' => false,
					'message' => 'Username telah terdaftar'
				], 401);   
			}

			Driver::create($data);

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

	public function putDriver(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'nama' => 'required',
			'alamat' => 'required',
			'telepon' => 'required',
			'email' => 'required',
			'status' => 'required',
			'username' => 'required',
		]);


		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		try {
			$update = Driver::find($id);

			if ($update) {
				$driver = Driver::where('username', $request->username)->first();
				$driver_now = Driver::where('username', $update->username)->first();
				$admin = AuthLogin::where('username', $request->username)->first();

				if (($driver && $driver != $driver_now) || $admin) {
					return response()->json([
						'success' => false,
						'message' => 'Username telah terdaftar'
					], 401);   
				}

				$update->nama = $request->nama;
				$update->alamat = $request->alamat;
				$update->telepon = $request->telepon;
				$update->email = $request->email;
				$update->status = $request->status;
				$update->username = $request->username;
				if ($request->password) $update->password = bcrypt($request->password);
				if ($request->file('foto')) {
					$foto = $request->file('foto');
					$nama_foto = 'img_driver_'.time().'.'.$foto->getClientOriginalExtension();

					// Update Foto
					$path = 'assets/images/driver';
					$foto->move($path, $nama_foto);
					// Delete Old Foto
					if ($update->foto != 'img_driver_default.png') {
						File::delete('assets/images/driver/'.$update->foto);
					}
					// Save to Database
					$update->foto = $nama_foto;
				}
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

	public function deleteDriver($id)
	{
		try {
			$delete = Driver::find($id);
			if ($delete) {
				if ($delete->foto != 'img_driver_default.png') {
					File::delete('assets/images/driver/'.$delete->foto);
				}
				$delete->delete();
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
		if ($request->status) $pemesanan = Pemesanan::where('status', $request->status)->orderBy('id', 'desc')->get();
		else $pemesanan = Pemesanan::orderBy('id', 'desc')->get();

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

	public function getStatusPesanan($status)
	{
		$pemesanan = Pemesanan::where('status', $status)->orderBy('id', 'desc')->get();
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

	public function getPesananToday(Request $request, $status)
	{
		$data = [];
		$pemesanan = Pemesanan::where('status', $status)->orderBy('id', 'desc')->get();
		foreach ($pemesanan as $res) {
			if (date('dmy') == date('dmy', strtotime($res->tanggal_antar))) {
				$data[] = $res;
			}
		}
		$result = $this->getDataPesanan($data);

		if (count($result) > 0) {
			return response()->json([
				'success' => true,
				'message' => 'Success get data',
				'result'  => $result
			], 200);
		} else {
			return response()->json([
				'success' => false,
				'message' => 'Data is empty'
			], 404);
		}
	}

	protected function getDataPesanan($pemesanan, $id = null)
	{
		if ($pemesanan) {
			if ($id) {
				$set_paket = [];
				// Data Paket Pesanan
				$getPaket = PaketPesanan::where('pemesanan_id', $id)->get();
				foreach ($getPaket as $i => $pkt) {
					$getPkt = Paket::where('id', $pkt->paket_id)->first();
					$paket[$i]['pemesanan_id'] = $pkt->pemesanan_id;
					$paket[$i]['paket_id'] = $pkt->paket_id;
					$paket[$i]['nama_paket'] = $getPkt ? $getPkt->nama : null;
					$paket[$i]['harga'] = $getPkt ? $getPkt->harga : null;
					$paket[$i]['jumlah'] = $pkt->jumlah;
					$paket[$i]['total_harga'] = $pkt->total_harga;

					$set_paket[] = ['paket_id' => $pkt->paket_id, 'jumlah' => $pkt->jumlah];
				}

				// Data Additional Pesanan
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

				// Data Transaksi Pesanan
				$transaksi = Transaksi::where('pemesanan_id', $id)->first();
				unset($transaksi['created_at']);
				unset($transaksi['updated_at']);

				$pemesanan['paket'] = $paket;
				$pemesanan['additional'] = $additional;
				$pemesanan['transaksi'] = $transaksi;
				$pemesanan['bahan'] = $this->set_paket($set_paket, $id, 'bahan');
				$pemesanan['alat'] = $this->set_paket($set_paket, $id, 'alat');
			} else {
				foreach ($pemesanan as $i => $pesanan) {
					$set_paket = [];
					// Data Paket Pesanan
					$getPaket = PaketPesanan::where('pemesanan_id', $pesanan->id)->get();
					foreach ($getPaket as $i => $pkt) {
						$getPkt = Paket::where('id', $pkt->paket_id)->first();
						$paket[$i]['pemesanan_id'] = $pkt->pemesanan_id;
						$paket[$i]['paket_id'] = $pkt->paket_id;
						$paket[$i]['nama_paket'] = $getPkt ? $getPkt->nama : null;
						$paket[$i]['harga'] = $getPkt ? $getPkt->harga : null;
						$paket[$i]['jumlah'] = $pkt->jumlah;
						$paket[$i]['total_harga'] = $pkt->total_harga;

						$set_paket[] = ['paket_id' => $pkt->paket_id, 'jumlah' => $pkt->jumlah];
					}

					// Data Additional Pesanan
					$getAdditional = AdtPesanan::where('pemesanan_id', $pesanan->id)->get();
					$additional = [];
					if ($getAdditional) {
						foreach ($getAdditional as $i => $adt) {
							$getAdt = Additional::where('id', $adt->additional_id)->first();
							if ($getAdt) {
								$additional[$i]['pemesanan_id'] = $adt->pemesanan_id;
								$additional[$i]['additional_id'] = $adt->additional_id;
								$additional[$i]['nama_daging'] = $getAdt->nama_daging;
								$additional[$i]['harga'] = $getAdt->harga;
								$additional[$i]['berat'] = $getAdt->berat;
								$additional[$i]['jumlah'] = $adt->jumlah;
								$additional[$i]['total_harga'] = $adt->total_harga;
							}
						}
					}

					// Data Transaksi Pesanan
					$transaksi = Transaksi::where('pemesanan_id', $pesanan->id)->first();
					unset($transaksi['created_at']);
					unset($transaksi['updated_at']);

					$pesanan['paket'] = $paket;
					$pesanan['additional'] = $additional;
					$pesanan['transaksi'] = $transaksi;
					$pesanan['bahan'] = $this->set_paket($set_paket, $pesanan->id, 'bahan');
					$pesanan['alat'] = $this->set_paket($set_paket, $pesanan->id, 'alat');
				}
			}
		}
		return $pemesanan;
	}

	protected function set_paket($set_paket, $pemesanan_id, $req)
	{
		// Data Set Alat/Bahan Pesanan
		$bahan = [];
		$alat = [];
		$total_paket = 0;
		$x = 0;
		$y = 0;
		foreach ($set_paket as $set) {
			$paket_id = $set['paket_id'];
			$jumlah_paket = $set['jumlah'];
			$total_paket = $total_paket + $set['jumlah'];
			// Set Bahan
			$get_set_bahan = SetBahan::where('paket_id', $paket_id)->get();
			foreach ($get_set_bahan as $bhn) {
				$set_jum_bhn = floor($jumlah_paket / $bhn->per_paket)  * $bhn->jumlah;
				if ($set_jum_bhn > 0) {
					$get_bahan = Bahan::where('id', $bhn->bahan_id)->first();
					if (isset($bhn->maksimal)) $jumlah = $bhn->maksimal;
					else $jumlah = $set_jum_bhn;
					$bahan[$x] = [
						'key' => $x,
						'bahan_id' => $bhn->bahan_id,
						'nama_bahan' => $get_bahan ? $get_bahan->nama : null,
						'jumlah_bahan' => $jumlah,
						'satuan' => $get_bahan ? $get_bahan->satuan : null,
					];
					$x = $x + 1;
				}
			}

			// Set Alat
			$get_set_alat = SetAlat::where('paket_id', $paket_id)->get();
			foreach ($get_set_alat as $alt) {
				$set_jum_alt = floor($jumlah_paket / $alt->per_paket)  * $alt->jumlah;
				if ($set_jum_alt > 0) {
					$get_kategori = Kategori::where('id', $alt->kategori_alat_id)->first();
					if (isset($alt->maksimal)) $jumlah = $alt->maksimal;
					else $jumlah = $set_jum_alt;
					$alat_dipilih = [];
					$alat_pesanan = AlatPesanan::where('pemesanan_id', $pemesanan_id)->where('kategori_alat_id', $alt->kategori_alat_id)->get();
					foreach ($alat_pesanan as $alpes) {
						$get_alat = Alat::where('id', $alpes->alat_id)->first();
						$alat_dipilih[] = [
							'alat_id' => $alpes->alat_id,
							'nama_alat' => $get_alat->nama,
							'jumlah' => $alpes->jumlah.' pcs',
						];
					}
					
					$alat[$y] = [
						'key' => $y,
						'kategori_alat_id' => $alt->kategori_alat_id,
						'kategori_alat' => $get_kategori ? $get_kategori->kategori : null,
						'jumlah_alat' => $jumlah,
						'alat_dipilih' => $alat_dipilih
					];
					$y = $y + 1;
				}
			}
		}

		// Set Bahan Fix
		$search = array_column($bahan, 'key', 'bahan_id');
		$bahan_fix = [];
		foreach ($search as $fix => $key) {
			$jumlah = 0;
			foreach ($bahan as $ext) {
				if ($ext['bahan_id'] == $fix) {
					$jumlah = $jumlah + $ext['jumlah_bahan'];
				}
			}
			$bahan[$key]['jumlah_bahan'] = $jumlah.' '.$bahan[$key]['satuan'];
			unset($bahan[$key]['key']);
			unset($bahan[$key]['satuan']);
			$bahan_fix[] = $bahan[$key];
		}

		// Set Alat Fix
		$search = array_column($alat, 'key', 'kategori_alat_id');
		$alat_fix = [];
		if ($total_paket >= 5) {
			foreach ($search as $fix => $key) {
				$jumlah = 0;
				foreach ($alat as $ext) {
					if ($ext['kategori_alat_id'] == $fix) {
						$jumlah = $jumlah + $ext['jumlah_alat'];
					}
				}
				$alat[$key]['jumlah_alat'] = $jumlah.' pcs';
				unset($alat[$key]['key']);
				$alat_fix[] = $alat[$key];
			}
		}

		if ($req == 'bahan') return $bahan_fix;
		else if ($req == 'alat') return $alat_fix;
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

	public function updateDriverPesanan(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'driver_id' => 'required|integer',
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
				if ($request->status == 'pengantaran') {
					$update->pengantaran = $request->driver_id;
				} else if ($request->status == 'penjemputan') {
					$update->penjemputan = $request->driver_id;
				} else {
					return response()->json([
						'success' => false,
						'message' => 'status not found'
					], 404); 
				}
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

	// PAKET
	public function setPaket(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'nama' => 'required',
			'harga' => 'required',
			'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
			'keterangan' => 'required'
		]);


		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		try {
			$data_paket = $request->all();
			$foto = $request->file('foto');
			$nama_foto = 'img_paket_'.time().'.'.$foto->getClientOriginalExtension();
			$data_paket['foto'] = $nama_foto;
			$paket = Paket::create($data_paket);

			$path = 'assets/images/paket';
			$foto->move($path, $paket->foto);

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

	public function getsPaket()
	{
		$result = Paket::all();
		$data = [];
		foreach ($result as $dta) {
			$get_item = SetBahan::where('paket_id', $dta->id)->where('jenis', 'utama')->get();
			$item = [];
			foreach ($get_item as $get) {
				$bahan = Bahan::where('id', $get->bahan_id)->first();
				$item[] = $bahan->nama;
			}
			$dta['item_paket'] = $item;
			$data[] = $dta;
		}
		return response()->json([
			'success' => true,
			'message' => 'Success get data',
			'result' => $data
		], 200);
	}

	public function getPaket($id)
	{
		$data = Paket::where('id', $id)->first();

		if ($data) {
			$get_item = SetBahan::where('paket_id', $id)->where('jenis', 'utama')->get();
			$item = [];
			foreach ($get_item as $get) {
				$bahan = Bahan::where('id', $get->bahan_id)->first();
				$item[] = $bahan->nama;
			}
			$data['item_paket'] = $item;

			return response()->json([
				'success' => true,
				'message' => 'Success get data',
				'result' => $data
			], 200);
		} else {
			return response()->json([
				'success' => false,
				'message' => 'Data not found'
			], 404);
		}
	}

	public function putPaket(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'nama' => 'required',
			'harga' => 'required',
			'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
			'keterangan' => 'required'
		]);


		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		try {
			$update = Paket::find($id);

			if ($update) {
				$update->nama = $request->nama;
				$update->harga = $request->harga;
				$update->keterangan = $request->keterangan;
				if ($request->file('foto')) {
					$foto = $request->file('foto');
					$nama_foto = 'img_paket_'.time().'.'.$foto->getClientOriginalExtension();

					// Update Foto
					$path = 'assets/images/paket';
					$foto->move($path, $nama_foto);
					// Delete Old Foto
					File::delete('assets/images/paket/'.$update->foto);
					// Save to Database
					$update->foto = $nama_foto;
				}
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

	public function deletePaket($id)
	{
		try {
			$delete = Paket::find($id);

			if ($delete) {
				$delete->delete();
				$setalat = SetAlat::where('paket_id', $id)->get();
				foreach ($setalat as $del_alat) {
					$del_alat->delete();
				}
				$setbahan = SetBahan::where('paket_id', $id)->get();
				foreach ($setbahan as $del_bahan) {
					$del_bahan->delete();
				}
				File::delete('assets/images/paket/'.$delete->foto);
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

	public function getAlatPaket(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'paket_id' => 'required|array',
			'jumlah' => 'required|array'
		]);


		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		if (!is_array($request->paket_id) || !is_array($request->jumlah)) {
			return response()->json([
				'success' => false,
				'message' => 'input is not array'
			], 401);  
		}

		$set_paket = [];
		foreach ($request->paket_id as $i => $dta) {
			$set_paket[] = ['paket_id' => $request->paket_id[$i], 'jumlah' => $request->jumlah[$i]];
		}

		$result = $this->set_paket($set_paket, 1, 'alat');

		return response()->json([
			'success' => false,
			'message' => 'success get data',
			'result' => $result
		], 401); 
	}

	// ADDITIONAL
	public function getsAdditional()
	{
		$data = Additional::all();
		$result = [];
		foreach ($data as $dta) {
			$bahan = Bahan::where('id', $dta->bahan_id)->first();
			$dta['foto'] = $bahan->foto;
			unset($dta['created_at']);
			unset($dta['updated_at']);
			$result[] = $dta;
		}
		return response()->json([
			'success' => true,
			'message' => 'Success get data',
			'result' => $data
		], 200);
	}

	public function getAdditional($id)
	{
		$data = Additional::where('id', $id)->first();

		if ($data) {
			$bahan = Bahan::where('id', $data->bahan_id)->first();
			unset($data['created_at']);
			unset($data['updated_at']);
			$data['foto'] = $bahan->foto;
			return response()->json([
				'success' => true,
				'message' => 'Success get data',
				'result' => $data
			], 200);
		} else {
			return response()->json([
				'success' => false,
				'message' => 'Data not found'
			], 404);
		}
	}
}