<?php

namespace App\Http\Controllers;

use App\Model\DataRekening;
use App\Model\PaketPesanan;
use App\Model\KritikSaran;
use App\Model\AlatPesanan;
use App\Model\AdtPesanan;
use App\Model\AlatHilang;
use App\Model\Additional;
use App\Model\Pemesanan;
use App\Model\Transaksi;
use App\Model\ItemPaket;
use App\Model\AuthLogin;
use App\Model\Kategori;
use App\Model\Keuangan;
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

	public function invAlathilang()
	{
		$data = AlatHilang::orderBy('id', 'desc')->get();
		$result = [];
		foreach ($data as $dta) {
			$pesanan = Pemesanan::where('id', $dta->pemesanan_id)->first();
			$alat = Alat::where('id', $dta->alat_id)->first();
			$dta['kd_pemesanan'] = $pesanan->kd_pemesanan;
			$dta['nama_pemesan'] = $pesanan->nama;
			$dta['nama_alat'] = $alat->nama;
			$dta['jumlah_hilang'] = $dta->jumlah_hilang.' pcs';
			$dta['tanggal_hilang'] = date('Y-m-d', strtotime($dta->created_at));
			unset($dta->created_at);
			unset($dta->updated_at);


			$result[] = $dta;
		}

		return response()->json([
			'success' => true,
			'message' => 'Success get data',
			'result'  => $result
		], 200);
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

			$this->debitkredit($beli->id, 'alat');

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

			$this->debitkredit($crt->id, 'alat');

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

	public function setAlatkembali(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'jumlah_alat' => 'required|integer',
		]);


		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		$alathilang = AlatHilang::where('id', $id)->first();
		$alat = Alat::where('id', $alathilang->alat_id)->first();
		if ($request->jumlah_alat > $alathilang->jumlah_hilang || $request->jumlah_alat <= 0) {
			return response()->json([
				'success' => false,
				'message' => 'Jumlah alat melebihi ketentuan'
			], 401); 
		} else if ($request->jumlah_alat == $alathilang->jumlah_hilang) {
			$alathilang->delete();
		} else {
			$alathilang->jumlah_hilang = $alathilang->jumlah_hilang - $request->jumlah_alat;
			$alathilang->save();
		}

		$alat->jumlah_alat = $alat->jumlah_alat + $request->jumlah_alat;
		$alat->save();

		return response()->json([
			'success' => true,
			'message' => 'Success set alat kembali'
		], 200);
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

			$this->debitkredit($beli->id, 'bahan');

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
			$this->debitkredit($crt->id, 'bahan');
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
			'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
			'password' => 'min:5'
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

	public function changePassword(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'old_password' => 'required|min:5',
			'new_password' => 'required|min:5'
		]);


		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		$driver = Driver::find($id);

		if ($driver) {
			$credential = [
				'username' => $driver->username,
				'password' => $request->old_password,
			];

			if(Auth::guard('driver')->attempt($credential)) {
				$driver->password = bcrypt($request->new_password);
				$driver->save();
				
				return response()->json([
					'success' => true,
					'message' => 'Success update password',
				], 200);
			} else {
				return response()->json([
					'success' => false,
					'message' => 'password lama tidak sesuai'
				], 200);
			}
		} else {
			return response()->json([
				'success' => false,
				'message' => 'id not found'
			], 401);
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
			'tanggal_antar' => 'required|date',
			'waktu_antar' => 'required',
			'deskripsi_lokasi' => 'required',
			'latitude' => 'required',
			'longitude' => 'required',
			'paket_id' => 'required|array',
			'jumlah_paket' => 'required|array',
			'additional_id' => 'array',
			'jumlah_adt' => 'array',
			'biaya_pengiriman' => 'required|integer',
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
			$date = date('dmy');
			if ($getId) {
				$findId = sprintf('%04s', $getId->id+1);
				$kd_pemesanan = 'KSN-'.$findId.$date;
			}
			else $kd_pemesanan = 'KSN-0001'.$date;

			// set data
			$pemesanan = $request->all();
			$pemesanan['kd_pemesanan'] = $kd_pemesanan;
			$pemesanan['status'] = 'New';
			$request->catatan ? $request->catatan : $pemesanan['catatan'] = '-';
			unset($pemesanan['paket_id']);
			unset($pemesanan['jumlah_paket']);
			unset($pemesanan['additional_id']);
			unset($pemesanan['jumlah_adt']);
			unset($pemesanan['biaya_pengiriman']);
			$pmsn = Pemesanan::create($pemesanan);

			$this->notification('New', $pmsn->id);

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
			$transaksi['biaya_pengiriman'] = $request->biaya_pengiriman;
			$transaksi['harga_lainnya'] = 0;
			$transaksi['total_harga'] = $harga_paket + $harga_additional + $request->biaya_pengiriman;
			Transaksi::create($transaksi);

			// Kirim WA Ke Pelanggan
			$this->sendMessageWhatsApp('order_detail', $pmsn->id);

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
			], 205);
		}
	}

	public function getPesananToday(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'status' => 'required',
			'tanggal' => 'required',
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		$data = [];
		$pemesanan = Pemesanan::where('status', $request->status)->orderBy('id', 'desc')->get();
		foreach ($pemesanan as $res) {
			if (date('dmy', strtotime($request->tanggal)) == date('dmy', strtotime($res->tanggal_antar))) {
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

	public function getPesananDriver(Request $request, $id)
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

		if ($request->status != 'pengantaran' && $request->status != 'penjemputan') {
			return response()->json([
				'success' => false,
				'message' => 'status not found'
			], 401);   
		}

		$pemesanan = Pemesanan::where($request->status, $id)->orderBy('id', 'desc')->get();
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
				'message' => 'Data is empty'
			], 404);
		}
	}

	public function getPesananUserold(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'no_telepon' => 'required',
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		$user = Pemesanan::where('no_telepon', $request->no_telepon)->first();

		if ($user) {
			unset($user['id']);
			unset($user['kd_pemesanan']);
			unset($user['tanggal_antar']);
			unset($user['waktu_antar']);
			unset($user['catatan']);
			unset($user['status']);
			unset($user['pengantaran']);
			unset($user['penjemputan']);
			unset($user['bukti_pembayaran']);
			unset($user['foto_pesanan']);
			unset($user['created_at']);
			unset($user['updated_at']);
			return response()->json([
				'success' => true,
				'message' => 'Success get data',
				'result'  => $user
			], 200);
		} else {
			return response()->json([
				'success' => true,
				'message' => 'Nomor belum terdaftar sebelumnya'
			], 200);
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
							'nama_alat' => $get_alat ? $get_alat->nama : null,
							'jumlah' => $alpes->jumlah.' pcs',
						];
					}
					
					if ($req == 'alat_front') {
						$alat[$y] = [
							'key' => $y,
							'kategori_alat_id' => $alt->kategori_alat_id,
							'kategori_alat' => $get_kategori ? $get_kategori->kategori : null,
							'jumlah_alat' => $jumlah,
							'foto' => $get_kategori ? $get_kategori->foto : null,
						];
					} else {
						$alat[$y] = [
							'key' => $y,
							'kategori_alat_id' => $alt->kategori_alat_id,
							'kategori_alat' => $get_kategori ? $get_kategori->kategori : null,
							'jumlah_alat' => $jumlah,
							'alat_dipilih' => $alat_dipilih
						];
					}
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
		// Dapat alat minimal 1 paket
		if ($total_paket >= 1) {
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
		else if ($req == 'alat_front') return $alat_fix;
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

			$this->notification($request->status, $id);
			if ($request->status == 'Delivery' || $request->status == 'delivery') {
				$this->reduceAlatBahan($id);
			}

			if ($request->status == 'Proccess' || $request->status == 'proccess') {
				$this->debitkredit($id, 'pesanan');
			}

			// Kirim Pesanan WA ke Pelanggan if status batal dan proccess
			if ($request->status == 'Proccess' || $request->status == 'proccess') {
				$this->sendMessageWhatsApp('order_accept', $id);
			} else if ($request->status == 'Refuse' || $request->status == 'refuse') {
				$this->sendMessageWhatsApp('order_refuse', $id);
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
					], 401); 
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

	public function konfirmasiPesanan(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'pemesanan_id' => 'required|integer',
			'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		$pesanan = Pemesanan::where('id', $request->pemesanan_id)->first();
		if ($pesanan) {
			$foto = $request->file('foto');
			$nama_foto = 'img_konfirmasi_'.time().'.'.$foto->getClientOriginalExtension();

			$pesanan->bukti_pembayaran = $nama_foto;
			$pesanan->status = 'Accept';
			$pesanan->save();

			$path = 'assets/images/konfirmasi';
			$foto->move($path, $nama_foto);

			$this->notification('Accept', $pesanan->id);

			// Kirim WA Ke Admin
			$this->sendMessageWhatsApp('upload_payment', $request->pemesanan_id);

			return response()->json([
				'success' => true,
				'message' => 'Success upload bukti pembayaran'
			], 200);
		} else {
			return response()->json([
				'success' => false,
				'message' => 'data not found'
			], 401);   
		}

	}

	public function fotoPesanan(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		$pesanan = Pemesanan::where('id', $id)->first();
		if ($pesanan) {
			$foto = $request->file('foto');
			$nama_foto = 'img_pesanan_'.time().'.'.$foto->getClientOriginalExtension();

			$pesanan->foto_pesanan = $nama_foto;
			$pesanan->save();

			$path = 'assets/images/pesanan';
			$foto->move($path, $nama_foto);

			// Kirim WA Ke Pelanggan
			$this->sendMessageWhatsApp('order_done', $id);

			return response()->json([
				'success' => true,
				'message' => 'Success upload foto pesanan'
			], 200);
		} else {
			return response()->json([
				'success' => false,
				'message' => 'data not found'
			], 401);   
		}

	}

	public function setAlatPesanan(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'pesanan_id' => 'required|integer',
		]);

		$set_paket = [];
		$getPaket = PaketPesanan::where('pemesanan_id', $request->pesanan_id)->get();
		foreach ($getPaket as $pkt) {
			$set_paket[] = ['paket_id' => $pkt->paket_id, 'jumlah' => $pkt->jumlah];
		}
		$getAlatPaket = $this->set_paket($set_paket, $request->pesanan_id,'alat');

		$error = null;
		if ($validator->fails()) $error = $validator->errors();
		else if (!is_array($request->kategori_id) || !is_array($request->alat_id) || !is_array($request->jumlah)) $error = 'Inputan tidak lengkap';
		else if (!isset($request->kategori_id) || !isset($request->alat_id) || !isset($request->jumlah) || count($request->kategori_id) != count($request->alat_id) || count($request->kategori_id) != count($request->jumlah) || count($request->alat_id) != count($request->jumlah)) $error = 'Inputan tidak lengkap';
		else if (count($getAlatPaket) == 0) $error = 'Paket tidak ada';

		$data = [];
		$input = [];
		if (is_array($request->kategori_id) && is_array($request->alat_id) && is_array($request->jumlah)) {
			foreach ($request->kategori_id as $i => $kat) {
				$data[] = [
					'key' => $i,
					'kategori_id' => $kat, 
					'alat_id' => $request->alat_id[$i], 
					'jumlah' => $request->jumlah[$i]
				];

				$input[] = [
					'pemesanan_id' => $request->pesanan_id,
					'kategori_alat_id' => $kat,
					'alat_id' => $request->alat_id[$i], 
					'jumlah' => $request->jumlah[$i]
				];
			}

			$search = array_column($data, 'key', 'kategori_id');
			$alat_req = [];
			foreach ($search as $fix => $key) {
				$jumlah = 0;
				foreach ($data as $ext) {
					if ($ext['kategori_id'] == $fix) {
						$jumlah = $jumlah + $ext['jumlah'];
					}
				}
				$data[$key]['jumlah'] = $jumlah;
				unset($data[$key]['key']);
				$alat_req[] = $data[$key];
			}

			foreach ($getAlatPaket as $alt) {
				$cek = $this->search($alt['kategori_alat_id'], $alat_req);
				$jumlah_alat = filter_var($alt['jumlah_alat'], FILTER_SANITIZE_NUMBER_INT);
				if ($cek != false) {
					if ($cek > $jumlah_alat) {
						$error = "Jumlah alat (".$alt['kategori_alat'].") melebihi ketentuan";
						break;
					} else if ($cek < $jumlah_alat) {
						$error = "Jumlah alat (".$alt['kategori_alat'].") tidak memenuhi";
						break;
					}
				} else {
					$error = "Lengkapi semua jumlah alat yang diminta";
					break;
				}
			}

		}

		if ($error != null) {
			return response()->json([
				'success' => false,
				'message' => $error
			], 401);
		} else {
			$alat_pesanan = AlatPesanan::where('pemesanan_id', $request->pesanan_id)->get();
			foreach ($alat_pesanan as $del_aps) {
				$del_aps->delete();
			}

			foreach ($input as $aps) {
				AlatPesanan::create($aps);
			}

			return response()->json([
				'success' => true,
				'message' => 'Alat pesanan berhasil diatur'
			], 200);
		}

	}

	public function cekAlatDriver(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'alat_id' => 'required|array',
			'jumlah' => 'required|array'
		]);


		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		if (!is_array($request->alat_id) || !is_array($request->jumlah) || count($request->alat_id) != count($request->jumlah)) {
			return response()->json([
				'success' => false,
				'message' => 'input tidak sesuai'
			], 401);  
		}

		$pemesanan = Pemesanan::where('id', $id)->first();
		$result = $this->getDataPesanan($pemesanan, $id);

		$i = 0;
		foreach ($result->alat as $kat) {
			foreach ($kat['alat_dipilih'] as $alt) {
				if (!in_array($alt['alat_id'], $request->alat_id)) {
					return response()->json([
						'success' => false,
						'message' => 'alat_id tidak sesuai dengan paakaet'
					], 401);
				}

				if ($request->jumlah[$i] > $alt['jumlah']) {
					return response()->json([
						'success' => false,
						'message' => 'jumlah yang di input melebihi ketentuan'
					], 401);
				}

				$jumlah_keluar = filter_var($alt['jumlah'], FILTER_SANITIZE_NUMBER_INT);

				// Alat Hilang
				if ($request->jumlah[$i] < $jumlah_keluar) {
					$jumlah_hilang = $jumlah_keluar - $request->jumlah[$i];
					$alat_id = $request->alat_id[$i];
					$alat_hlg = Alat::where('id', $request->alat_id[$i])->first();
					$jumlah_alat = $alat_hlg->jumlah_alat - $jumlah_hilang;
					if ($jumlah_alat < 0) $jumlah_alat = 0;
					$alat_hlg->jumlah_alat = $jumlah_alat;
					$alat_hlg->save();

					$data = [];
					$data['pemesanan_id'] = $id;
					$data['alat_id'] = $alat_id;
					$data['jumlah_hilang'] = $jumlah_hilang;
					AlatHilang::create($data);
				}

				// Alat Kembali
				$alat = Alat::where('id', $alt['alat_id'])->first();
				$alat_keluar = $alat->alat_keluar;
				$update_alat = $alat_keluar - $jumlah_keluar;
				if ($update_alat <= 0) $update_alat = NULL;
				$alat->alat_keluar = $update_alat;
				$alat->save();

				$i = $i + 1;
			}
		}

		return response()->json([
			'success' => true,
			'message' => 'Pengecekan alat selesai'
		], 200);
	}

	private function search($key, $data) 
	{
		foreach ($data as $dta) {
			if ($key == $dta['kategori_id']) {
				return $dta['jumlah'];
			}
		}
		return false;
	}

	private function reduceAlatBahan($pesanan_id)
	{
		$pemesanan = Pemesanan::where('id', $pesanan_id)->first();
		$result = $this->getDataPesanan($pemesanan, $pesanan_id);
		// Kurangi Bahan
		foreach ($result->bahan as $bhn) {
			$bahan = Bahan::where('id', $bhn['bahan_id'])->first();
			$jumlah_keluar = filter_var($bhn['jumlah_bahan'], FILTER_SANITIZE_NUMBER_INT);
			$jumlah_bahan = $bahan->jumlah_bahan;
			$update_bahan = $jumlah_bahan - $jumlah_keluar;
			if ($update_bahan < 0) $update_bahan = 0; 
			$bahan->jumlah_bahan = $update_bahan;
			$bahan->save();
		}

		// Kurangi Alat
		foreach ($result->alat as $kat) {
			foreach ($kat['alat_dipilih'] as $alt) {
				$alat = Alat::where('id', $alt['alat_id'])->first();
				$jumlah_keluar = filter_var($alt['jumlah'], FILTER_SANITIZE_NUMBER_INT);
				$alat_keluar = $alat->alat_keluar;
				$update_alat = $alat_keluar + $jumlah_keluar;
				$alat->alat_keluar = $update_alat;
				$alat->save();
			}
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

		$result = $this->set_paket($set_paket, null,'alat_front');

		if (count($result) > 0) {
			return response()->json([
				'success' => true,
				'message' => 'Success get data',
				'result'  => $result
			], 200);
		} else {
			return response()->json([
				'success' => false,
				'message' => 'Tidak ada alat tersedia'
			], 200);
		} 
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

	// KEUANGAN 
	public function getsKeuangan(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'jenis' => 'required',
			'waktu' => 'required'
		]);

		if (!isset($request->order)) $order = 'asc';
		else $order = 'desc';

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}
		
		if (($request->jenis != 'Debit' && $request->jenis != 'debit') && ($request->jenis != 'Kredit' && $request->jenis != 'kredit') && ($request->jenis != 'All' && $request->jenis != 'all')) {
			return response()->json([
				'success' => false,
				'message' => 'Jenis tidak sesuai'
			], 401);  
		}

		if ($request->jenis == 'All' || $request->jenis == 'all') {
			$result = Keuangan::orderBy('tanggal', $order)->get();
		} else if ($request->jenis == 'Debit' || $request->jenis == 'debit') {
			$result = Keuangan::where('jenis', 'Debit')->orderBy('tanggal', $order)->get();
		} else if ($request->jenis == 'Kredit' || $request->jenis == 'kredit') {
			$result = Keuangan::where('jenis', 'Kredit')->orderBy('tanggal', $order)->get();
		}

		$data = [];
		$data_kas = [];
		$uang_kas = 0;
		$total_debit = 0;
		$total_kredit = 0;

		if (strlen($request->waktu) == 10) {
			foreach ($result as $dta) {
				if (date('dmy', strtotime($dta->tanggal)) == date('dmy', strtotime($request->waktu))) {
					$data[] = $dta;
					if ($dta->jenis == 'Debit') {
						$uang_kas = $uang_kas + $dta->nominal;						
						$total_debit = $total_debit + $dta->nominal;						
					} else if ($dta->jenis == 'Kredit') {
						$uang_kas = $uang_kas - $dta->nominal;						
						$total_kredit = $total_kredit + $dta->nominal;	
					}
				}
			}
		} else if (strlen($request->waktu) == 7) {
			foreach ($result as $dta) {
				if (date('Y-m', strtotime($dta->tanggal)) == $request->waktu) {
					$data[] = $dta;
					if ($dta->jenis == 'Debit') {
						$uang_kas = $uang_kas + $dta->nominal;						
						$total_debit = $total_debit + $dta->nominal;						
					} else if ($dta->jenis == 'Kredit') {
						$uang_kas = $uang_kas - $dta->nominal;						
						$total_kredit = $total_kredit + $dta->nominal;	
					}
				}
			}
		} else if (strlen($request->waktu) == 4) {
			foreach ($result as $dta) {
				if (date('Y', strtotime($dta->tanggal)) == $request->waktu) {
					$data[] = $dta;
					if ($dta->jenis == 'Debit') {
						$uang_kas = $uang_kas + $dta->nominal;						
						$total_debit = $total_debit + $dta->nominal;						
					} else if ($dta->jenis == 'Kredit') {
						$uang_kas = $uang_kas - $dta->nominal;						
						$total_kredit = $total_kredit + $dta->nominal;	
					}
				}
			}
		}

		if ($request->jenis == 'Debit' || $request->jenis == 'debit' || $request->jenis == 'Kredit' || $request->jenis == 'kredit') $uang_kas = 0;

		$data_kas['uang_kas'] = $uang_kas;
		$data_kas['total_debit'] = $total_debit;
		$data_kas['total_kredit'] = $total_kredit;

		if (count($data) > 0 && count($data_kas) > 0) {
			return response()->json([
				'success' => true,
				'message' => 'Success get data',
				'data_kas' => $data_kas,
				'result' => $data
			], 200);
		} else {
			return response()->json([
				'success' => false,
				'message' => 'Data not found',
			], 203);
		}
	}

	public function getKeuangan($id)
	{
		$data = Keuangan::where('id', $id)->first();
		if ($data) {
			$get_kd = substr($data->uraian, strlen($data->uraian)-15, 14);
			$pesanan = Pemesanan::where('kd_pemesanan', $get_kd)->first();
			$data['pemesanan_id'] = $pesanan ? $pesanan->id : null;
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

	public function setKeuangan(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'uraian' => 'required',
			'jenis' => 'required',
			'nominal' => 'required|integer',
			'tanggal' => 'required|date'
		]);


		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		if ($request->jenis != 'Debit' && $request->jenis != 'Kredit') {
			return response()->json([
				'success' => false,
				'message' => 'Jenis tidak sesuai'
			], 401);  
		}

		try {
			$data = $request->all();
			$data['tanggal'] = date('Y-m-d', strtotime($request->tanggal)).' '.date('H:i:s');
			Keuangan::create($data);

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

	public function putKeuangan(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'uraian' => 'required',
			'jenis' => 'required',
			'nominal' => 'required|integer',
			'tanggal' => 'required|date'
		]);


		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		try {
			$update = Keuangan::find($id);
			if ($update) {
				$update->uraian = $request->uraian;
				$update->jenis = $request->jenis;
				$update->nominal = $request->nominal;
				$update->tanggal = $request->tanggal;
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

	public function deleteKeuangan($id)
	{
		try {
			$delete = Keuangan::find($id);
			if ($delete) {
				$delete->delete();
				return response()->json([
					'success' => true,
					'message' => 'Success delete data'
				], 200);				
			} else {
				return response()->json([
					'success' => false,
					'message' => 'id not found'
				], 401); 
			}
		} catch(QueryException $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 500);	
		}
	}

	protected function debitkredit($id, $from)
	{
		$data = [];
		if ($from == 'pesanan') {
			$pesanan = Pemesanan::where('id', $id)->first();
			$transaksi = Transaksi::where('pemesanan_id', $id)->first();
			$data['uraian'] = 'Pemesanan dengan kode pesanan ('.$pesanan->kd_pemesanan.')';
			$data['nominal'] = $transaksi->total_harga;
			$data['jenis'] = 'Debit';
			$data['tanggal'] = date('Y-m-d H:i:s', strtotime($transaksi->created_at));
		} else if ($from == 'alat') {
			$addalat = AddAlat::where('id', $id)->first();
			$alat = Alat::where('id', $addalat->alat_id)->first();
			$data['uraian'] = 'Pembelian alat ('.$alat->nama.')';
			$data['nominal'] = $addalat->total_harga;
			$data['jenis'] = 'Kredit';
			$data['tanggal'] = date('Y-m-d H:i:s', strtotime($addalat->created_at));
		} else if ($from == 'bahan') {
			$addbahan = AddBahan::where('id', $id)->first();
			$bahan = Bahan::where('id', $addbahan->bahan_id)->first();
			$data['uraian'] = 'Pembelian bahan ('.$bahan->nama.')';
			$data['nominal'] = $addbahan->total_harga;
			$data['jenis'] = 'Kredit';
			$data['tanggal'] = date('Y-m-d H:i:s', strtotime($addbahan->created_at));
		}
		Keuangan::create($data);
	}

	// KRITIK & SARAN 
	public function getsKritiksaran(Request $request)
	{
		$result = KritikSaran::orderBy('id', 'desc')->get();

		if (count($result) > 0) {
			return response()->json([
				'success' => true,
				'message' => 'Success get data',
				'result' => $result
			], 200);
		} else {
			return response()->json([
				'success' => false,
				'message' => 'Data not found',
			], 203);
		}
	}

	public function getKritiksaran($id)
	{
		$data = KritikSaran::where('id', $id)->first();
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
	public function setKritiksaran(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'nama' => 'required',
			'email' => 'required|email',
			'pesan' => 'required'
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validator->errors()
			], 401);            
		}

		try {
			$data = $request->all();
			$res = KritikSaran::create($data);

			$this->notification('Kritiksaran', $res->id);

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

	public function deleteKritiksaran($id)
	{
		try {
			$delete = KritikSaran::find($id);
			if ($delete) {
				$delete->delete();
				return response()->json([
					'success' => true,
					'message' => 'Success delete data'
				], 200);				
			} else {
				return response()->json([
					'success' => false,
					'message' => 'id not found'
				], 401); 
			}
		} catch(QueryException $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 500);	
		}
	}

	// NOTIFIKASI
	protected function notification($status, $pesanan_id) 
	{
		if ($status == 'New' || $status == 'new') {
			$to = 'admin_device';
			$title = 'Pesanan Baru';
			$body = 'Pesanan baru masuk, mohon diperiksa';
		} else if ($status == 'Accept' || $status == 'accept') {
			$to = 'admin_device';
			$title = 'Bukti Pembayaran';
			$body = 'Pelanggan telah mengirimkan bukti pembayaran';
		} else if ($status == 'Proccess' || $status == 'proccess') {
			$to = 'kitchen_device';
			$title = 'Pesanan Baru';
			$body = 'Terdapat pesanan baru yang harus di proses';
		} else if ($status == 'Delivery' || $status == 'delivery') {
			$to = 'driver_device';
			$title = 'Pesanan Siap Diantar';
			$body = 'Terdapat pesanan yang harus di antar';
		} else if ($status == 'Arrived' || $status == 'arrived') {
			$to = 'admin_device';
			$title = 'Pesanan Sampai';
			$body = 'Pesanan telah sampai di tujuan';
		} else if ($status == 'Taking' || $status == 'taking') {
			$to = 'driver_device';
			$title = 'Pesanan Selseai';
			$body = 'Pesanan telah selesai dan siap di jemput kembali';
		} else if ($status == 'Done' || $status == 'done') {
			$to = 'admin_device';
			$title = 'Pesanan Selesai';
			$body = 'Satu pesanan telah selesai';
		} else if ($status == 'Kritiksaran') {
			$to = 'admin_device';
			$title = 'Pesan Masuk';
			$body = 'Kritik & Saran dari costumer, cek segera';
		} else {
			return;
		}

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://kesiniku-default-rtdb.firebaseio.com/device_token/'.$to.'.json',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => ['Content-Type:application/json'],
			CURLOPT_ENCODING => 'json',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_CUSTOMREQUEST => 'GET',
		));

		$response = json_decode(curl_exec($curl), true);
		$firebaseToken = [];
		foreach ($response as $key => $value) {
			if (isset($value['token'])) {
				$firebaseToken[] = $value['token'];
			}
		}

		curl_close($curl);

		$SERVER_API_KEY = 'AAAA0eQ6FxQ:APA91bH4GjxST2iA14lp29LpvtJafU9C_IDfvX7tmPQ5YmyoOsbZmDxtm9M2XJsJfpVANtUFUNdqx8y-_VMLsvv5BfUrapkNjL2LjnrPF8XnpPCNTQxFVdR3ZJH2pda71tzSLEZPeQLm';

		$data = [
			"registration_ids" => $firebaseToken,
			"notification" => [
				"title" => $title,
				"body" => $body,  
			],
			"webpush" => [
				"headers" => [
					"Urgency" => "high"
				]
			],
			"android" => [
				"priority" => "high"
			],
			"data" => [
				"needfood.technest.com.KEY_SYNC_REQUEST" => "sync",
				'pesanan_id' => $pesanan_id
			],
			"priority" => 10
		];
		$dataString = json_encode($data);

		$headers = [
			'Authorization: key=' . $SERVER_API_KEY,
			'Content-Type: application/json',
		];

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

		$response = curl_exec($ch);
	}

	// SEND MESSAGE WHATSAPP
	protected function sendMessageWhatsApp($tipe, $id) 
	{
		$rek = DataRekening::first();
		$pemesanan = Pemesanan::where('id', $id)->first();
		$psn = $this->getDataPesanan($pemesanan, $id);

		$no_whatsapp = $psn->no_wa;
		$wa_admin = $rek->telepon;
		$key = '553709ba9cca8ff2d35acbbd3f4e7e07c77267da14eefb11';

        // Generet Token 
		$crypt = '17'.$id.'-'.$psn->no_wa.'_'.$psn->kd_pemesanan;
		$token = crypt($id+14, $crypt);
		$token = str_replace('/', 'R', $token);
		$token = str_replace('?', 'M', $token);
		$token = str_replace('=', 'T', $token);

		if ($tipe == 'order_detail') {
			$paket = '';
			$additional = '';
			foreach ($psn->paket as $pkt) {
				$paket .= '*'.$pkt['nama_paket'].' '.$pkt['jumlah'].' Pax\n';
			}

			foreach ($psn->additional as $adt) {
				$additional .= '*'.$adt['nama_daging'].' '.$adt['berat'].'\n';
			}

			$message = 'Selamat datang di Kesiniku Kak *'.$psn->nama.'*\n🙏🙏😊\nKami sudah terima pesanan anda dengan rincian sebagai berikut: \n\nPaket Pesanan:\n'.$paket.'\nAdditional Daging:\n'.$additional.'\nHarga Paket: Rp. '.number_format($psn->transaksi->harga_paket).'\nHarga Additional: Rp. '.number_format($psn->transaksi->harga_additional).'\nOngkir: Rp. '.number_format($psn->transaksi->biaya_pengiriman).'\nTotal: Rp. '.number_format($psn->transaksi->total_harga).'\n\nDikirim ke: '.$psn->deskripsi_lokasi.'\n\nSilahkan transfer ke rekening dibawah ini:\n'.$rek->nama_bank.'\nNo. Rek: '.$rek->no_rekening.'\nAtas Nama: '.$rek->nama.'\n\nUpload bukti pembayaran di link berikut:\nhttps://kesiniku.com/konfirmasi/'.$token.'\n\n_*Jika link tidak aktif, balas pesan ini untuk mengaktifkan link dan buka kembali_';

			$url = 'http://116.203.191.58/api/send_message';
			$data = array(
				"phone_no"=> $no_whatsapp,
				"key"     => $key,
				"message" => $message
			);
		} else if ($tipe == 'order_accept') {
			$message = 'Hai, Kak *'.$psn->nama.'*\nTerima kasih telah menyelesaikan pembayaran. Pesanan anda telah di konfirmasi, kami akan segara memproses pesanan anda!';

			$url = 'http://116.203.191.58/api/send_message';
			$data = array(
				"phone_no"=> $no_whatsapp,
				"key"     => $key,
				"message" => $message
			);
		} else if ($tipe == 'order_refuse') {
			$message = 'Hai, Kak *'.$psn->nama.'*\nMohon maaf, pesanan anda tidak dapat kami proses, silahkan kunjungi https://kesiniku.com untuk pemesanan ulang!';

			$url = 'http://116.203.191.58/api/send_message';
			$data = array(
				"phone_no"=> $no_whatsapp,
				"key"     => $key,
				"message" => $message
			);
		} else if ($tipe == 'order_done') {
			$message = 'Hai, Kak *'.$psn->nama.'*\nPesanan anda telah siap diantar, driver kami telah menuju ke lokasi yang anda daftarkan. Mohon untuk menunggu 🙏🙏\n\nSilahkan menikmati pesanan anda, semoga layanan kami memuaskan😊😊\n\nMohon untuk mengklik link berikut apabila telah selesa:\nhttps://kesiniku.com/done/'.$token;

			$url = 'http://116.203.191.58/api/send_image_url';
			$img_url = 'https://kesiniku.com/assets/images/pesanan/'.$psn->foto_pesanan;
			$data = array(
				"phone_no" => $no_whatsapp,
				"key"      => $key,
				"url"      => $img_url,
				"message"  => $message
			);
		} else if ($tipe == 'upload_payment') {
			$message = 'Bukti pembayaran telah di uplaod\n\nKode Pesanan: '.$psn->kd_pemesanan.'\nNama: '.$psn->nama.'\nTotal: Rp. '.number_format($psn->transaksi->total_harga).'\n\nSilahkan buka aplikasi mobile Kesiniku atau Website Admin Panel Kesiniku untuk mengkonfirmasi pesanan.';

			$url = 'http://116.203.191.58/api/send_image_url';
			$img_url = 'https://kesiniku.com/assets/images/konfirmasi/'.$psn->bukti_pembayaran;
			$data = array(
				"phone_no" => $wa_admin,
				"key"      => $key,
				"url"      => $img_url,
				"message"  => $message
			);
		}

		$data_string = json_encode($data);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 360);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data_string)
		]);
		curl_close($ch);
	} 
}