<?php

namespace App\Http\Controllers;

use App\Model\PaketPesanan;
use App\Model\KritikSaran;
use App\Model\AdtPesanan;
use App\Model\Additional;
use App\Model\Pemesanan;
use App\Model\Transaksi;
use App\Model\Kategori;
use App\Model\Supplier;
use App\Model\Keuangan;
use App\Model\AddBahan;
use App\Model\SetBahan;
use App\Model\AddAlat;
use App\Model\SetAlat;
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
				$result = [];
				$pemesanan = Pemesanan::where('status', 'New')->orWhere('status', 'Accept')->get();
				foreach ($pemesanan as $dta) {
					if ($dta->status == 'New') {
						$dta['status'] = '<span class="label label-info">Pesanan Baru</span>';
						$dta['chek'] = 'disabled';
					}
					else if ($dta->status == 'Accept') {
						$dta['status'] = '<span class="label label-primary">Selesai Bayar</span>';
						$dta['chek'] = 'data-target=".confirm-pesanan"';
					}
					$dta['jadwal_antar'] = date('d/m/Y', strtotime($dta->tanggal_antar)).' ('.$dta->waktu_antar.')';
					$result[] = $dta;
				}

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
					], 204);
				}
			} else if ($request->req == 'setMapspesanandetail') {
				$result = [];
				$pemesanan = Pemesanan::where('status', 'Proccess')->orWhere('status', 'Delivery')->orWhere('status', 'Arrived')->orWhere('status', 'Taking')->get();

				if (count($pemesanan) > 0) {
					return response()->json([
						'success' => true,
						'message' => 'Success get data',
						'result'  => $pemesanan
					], 200);
				} else {
					return response()->json([
						'success' => false,
						'message' => 'Data not found'
					], 204);
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
			} else if ($request->req == 'getPaket') {
				$paket = Paket::all();
				$result = '';

				$jumbahan = [];
				$getid = [];
				foreach ($paket as $i => $set) {
					$setutama = SetBahan::where('paket_id', $set->id)->where('jenis', 'utama')->get();
					$jumbahan[] = count($setutama);
					foreach ($setutama as $item) {
						$getid[$set->id][] = $item->bahan_id;
					}
				}

				foreach ($paket as $dta) {
					$get_bahan_utama = [];
					$get_bahan_utama = SetBahan::where('paket_id', $dta->id)->where('jenis', 'utama')->get();
					$bahan_utama = '';
					for ($i=0; $i < max($jumbahan); $i++) {
						isset($getid[$dta->id][$i]) ? $bahan_id = $getid[$dta->id][$i] : $bahan_id = null;
						$bahan = Bahan::where('id', $bahan_id)->first();
						if ($bahan) $bahan_utama .= '<li>'.$bahan->nama.'</li>';
						else $bahan_utama .= '<li>-</li>';
					}

					$result .= '
					<div class="col-md-4">
					<div class="price_card text-center">
					<div class="pricing-header text-dark" style="background-image: url('. asset('assets/images/paket/'.$dta->foto) .'); background-repeat: no-repeat; background-position: center; background-size: cover;">
					<span class="price text-white" style="text-shadow: black 0.1em 0.1em 0.2em;">'.substr($dta->harga, 0, strlen($dta->harga)-3).'K/pax</span>
					<span class="name text-white" style="font-size: 20px; text-shadow: black 0.1em 0.1em 0.2em;">'.$dta->nama.'</span>
					</div>
					<p class="m-t-20"><i><b>'.$dta->keterangan.'</b></i></p>
					<ul class="price-features" id="bahan-utama">'.$bahan_utama.'</ul>
					<hr class="m-b-0">
					<div class="container">
					<div class="row">
					<div class="col-md-6">
					<button class="btn btn-block btn-inverse btn-sm waves-effect waves-light" data-toggle="modal" data-target=".modal-set-bahan" id="set-bahan" data-id="'.$dta->id.'"><i class="md-shopping-basket"></i> Set Bahan</button>
					</div>
					<div class="col-md-6">
					<button class="btn btn-block btn-purple btn-sm waves-effect waves-light" data-toggle="modal" data-target=".modal-set-alat" id="set-alat" data-id="'.$dta->id.'"><i class="md-restaurant-menu"></i> Set Alat</button>
					</div>
					<div class="col-md-6">
					<button class="btn btn-block btn-info btn-sm waves-effect waves-light" data-toggle="modal" data-target=".modal-edit" id="edit-paket" data-id="'.$dta->id.'"><i class="fa fa-edit"></i> Edit</button>
					</div>
					<div class="col-md-6">
					<button class="btn btn-block btn-danger btn-sm waves-effect waves-light" data-toggle="modal" data-target=".modal-hapus" id="hapus-paket" data-id="'.$dta->id.'"><i class="fa fa-trash"></i> Hapus</button>
					</div>
					</div>
					</div>
					</div>
					</div>';
				}
				return response()->json($result);
			}

			// SET BAHAN PAKET 
			if ($request->req == 'setBahanClick') {
				$bahan_exits = SetBahan::where('paket_id', $request->paket_id)->get();
				$added = '';
				foreach ($bahan_exits as $dta) {
					$bahan = Bahan::where('id', $dta->bahan_id)->first();
					if ($dta->jenis == 'utama') $check = 'checked'; else $check = '';
					$added .= '<tr id="this-form-added">
					<td>'. $bahan->nama .'</td>
					<td class="form-inline text-center">
					<input type="hidden" name="getid_bahan[]" value="'. $bahan->id .'">
					<input type="number" class="form-control" style="height: 30px; width: 60px;" name="jumlah[]" value="'.$dta->jumlah.'" required>
					<span><b>'.$bahan->satuan.'</b> /</span>
					<input type="number" class="form-control" style="height: 30px; width: 60px;" name="per_paket[]" value="'.$dta->per_paket.'" required>
					<span><b>pax</b></span>
					</td>
					<td class="form-inline">
					<input type="number" class="form-control" style="height: 30px; width: 90px;" name="maksimal[]" value="'.$dta->maksimal.'" placeholder="Isi jika ada..">
					<span><b>'.$bahan->satuan.'</b></span>
					</td>
					<td class="text-center">
					<input type="checkbox" '.$check.' data-plugin="switchery" data-size="small" name="jenis[]" value="utama">
					</td>
					<td class="text-center">
					<a href="#" class="text-danger" data-toggle1="tooltip" title="Remove" id="remove-bahan"><i class="fa fa-trash"></i></a>
					</td>
					</tr>';
				}

				if (count($bahan_exits) == 0) {
					$added .= '<tr class="text-center" id="empty"><td colspan="5"><i>Beluam ada data yang ditambah</i></td></tr>';
				}

				$result = ['added' => $added, 'res' => $bahan_exits];
				return response()->json($result);
			} else if ($request->req == 'addSetBahan') {
				$bahan = Bahan::where('id', $request->bahan_id)->first();
				$added = '<tr id="this-form-added">
				<td>'. $bahan->nama .'</td>
				<td class="form-inline text-center">
				<input type="hidden" name="getid_bahan[]" value="'. $bahan->id .'">
				<input type="number" class="form-control" style="height: 30px; width: 60px;" name="jumlah[]" value="" required>
				<span><b>'.$bahan->satuan.'</b> /</span>
				<input type="number" class="form-control" style="height: 30px; width: 60px;" name="per_paket[]" value="" required>
				<span><b>pax</b></span>
				</td>
				<td class="form-inline">
				<input type="number" class="form-control" style="height: 30px; width: 90px;" name="maksimal[]" placeholder="Isi jika ada">
				<span><b>'.$bahan->satuan.'</b></span>
				</td>
				<td class="text-center">
				<input type="checkbox" data-plugin="switchery" data-size="small" name="jenis[]" value="utama">
				</td>
				<td class="text-center">
				<a href="#" class="text-danger" data-toggle1="tooltip" title="Remove" id="remove-bahan"><i class="fa fa-trash"></i></a>
				</td>
				</tr>';
				$result = ['added' => $added];
				return response()->json($result);
			} else if ($request->req == 'getBahanExcept') {
				$bahan = Bahan::all();
				$option = '<option value="">Pilih Bahan</option>';
				foreach ($bahan as $dta) {
					$request->getid_bahan ? $request->getid_bahan : $request->getid_bahan = ['0'];
					if (in_array($dta->id, $request->getid_bahan)) $option .= '';
					else $option .= '<option value="'.$dta->id.'">'.$dta->nama.'</option>';
				}
				$result = ['result' => $option];
				return response()->json($result);
			} else if ($request->req == 'ifEmptyBahan') {
				if ($request->getid_bahan) $data = 'notempty';
				else $data = 'empty';
				return response()->json($data);
			} else if ($request->req == 'setBahanPaket') {
				if ($request->getid_bahan) {
					$setbahan = SetBahan::where('paket_id', $request->paket_id)->get();
					foreach ($setbahan as $delete) {
						$delete->delete();
					}

					$data = [];
					foreach ($request->getid_bahan as $i => $dta) {
						$data['paket_id'] = $request->paket_id;
						$data['bahan_id'] = $dta;
						$data['jumlah'] = $request->jumlah[$i];
						$data['per_paket'] = $request->per_paket[$i];
						$data['maksimal'] = $request->maksimal[$i];
						if (isset($request->jenis[$i])) $data['jenis'] = 'utama';
						else $data['jenis'] = 'lainnya';
						SetBahan::create($data);
					}
					$result = ['status' => 'success', 'title' => 'Berhasil Diatur', 'message' => 'Bahan paket berhasil diatur'];
				} else {
					$setbahan = SetBahan::where('paket_id', $request->paket_id)->get();
					foreach ($setbahan as $delete) {
						$delete->delete();
					}
					$result = ['status' => 'warning', 'title' => 'Data Kosong', 'message' => 'Tidak ada data diatur'];
				}
				return response()->json($result);
			}

			// SET ALAT PAKET 
			if ($request->req == 'setAlatClick') {
				$alat_exits = SetAlat::where('paket_id', $request->paket_id)->get();
				$added = '';
				foreach ($alat_exits as $dta) {
					$alat = Kategori::where('jenis', 'Kategori Alat')->where('id', $dta->kategori_alat_id)->first();
					if ($dta->jenis == 'utama') $check = 'checked'; else $check = '';
					$added .= '<tr id="this-form-added1">
					<td>'. $alat->kategori .'</td>
					<td class="form-inline text-center">
					<input type="hidden" name="getid_alat[]" value="'. $alat->id .'">
					<input type="number" class="form-control" style="height: 30px; width: 60px;" name="jumlah[]" value="'.$dta->jumlah.'" required>
					<span><b>pcs</b> /</span>
					<input type="number" class="form-control" style="height: 30px; width: 60px;" name="per_paket[]" value="'.$dta->per_paket.'" required>
					<span><b>pax</b></span>
					</td>
					<td class="form-inline">
					<input type="number" class="form-control" style="height: 30px; width: 90px;" name="maksimal[]" value="'.$dta->maksimal.'" placeholder="Isi jika ada..">
					<span><b>pcs</b></span>
					</td>
					<td class="text-center">
					<a href="#" class="text-danger" data-toggle1="tooltip" title="Remove" id="remove-alat"><i class="fa fa-trash"></i></a>
					</td>
					</tr>';
				}

				if (count($alat_exits) == 0) {
					$added .= '<tr class="text-center" id="empty1"><td colspan="4"><i>Beluam ada data yang ditambah</i></td></tr>';
				}

				$result = ['added' => $added, 'res' => $alat_exits];
				return response()->json($result);
			} else if ($request->req == 'addSetAlat') {
				$alat = Kategori::where('jenis', 'Kategori Alat')->where('id', $request->alat_id)->first();
				$added = '<tr id="this-form-added1">
				<td>'. $alat->kategori .'</td>
				<td class="form-inline text-center">
				<input type="hidden" name="getid_alat[]" value="'. $alat->id .'">
				<input type="number" class="form-control" style="height: 30px; width: 60px;" name="jumlah[]" value="" required>
				<span><b>pcs</b> /</span>
				<input type="number" class="form-control" style="height: 30px; width: 60px;" name="per_paket[]" value="" required>
				<span><b>pax</b></span>
				</td>
				<td class="form-inline">
				<input type="number" class="form-control" style="height: 30px; width: 90px;" name="maksimal[]" placeholder="Isi jika ada">
				<span><b>pcs</b></span>
				</td>
				<td class="text-center">
				<a href="#" class="text-danger" data-toggle1="tooltip" title="Remove" id="remove-alat"><i class="fa fa-trash"></i></a>
				</td>
				</tr>';
				$result = ['added' => $added];
				return response()->json($result);
			} else if ($request->req == 'getAlatExcept') {
				$alat = Kategori::where('jenis', 'Kategori Alat')->get();;
				$option = '<option value="">Pilih Alat</option>';
				foreach ($alat as $dta) {
					$request->getid_alat ? $request->getid_alat : $request->getid_alat = ['0'];
					if (in_array($dta->id, $request->getid_alat)) $option .= '';
					else $option .= '<option value="'.$dta->id.'">'.$dta->kategori.'</option>';
				}
				$result = ['result' => $option];
				return response()->json($result);
			} else if ($request->req == 'ifEmptyAlat') {
				if ($request->getid_alat) $data = 'notempty';
				else $data = 'empty';
				return response()->json($data);
			} else if ($request->req == 'setAlatPaket') {
				if ($request->getid_alat) {
					$setalat = SetAlat::where('paket_id', $request->paket_id)->get();
					foreach ($setalat as $delete) {
						$delete->delete();
					}

					$data = [];
					foreach ($request->getid_alat as $i => $dta) {
						$data['paket_id'] = $request->paket_id;
						$data['kategori_alat_id'] = $dta;
						$data['jumlah'] = $request->jumlah[$i];
						$data['per_paket'] = $request->per_paket[$i];
						$data['maksimal'] = $request->maksimal[$i];
						SetAlat::create($data);
					}
					$result = ['status' => 'success', 'title' => 'Berhasil Diatur', 'message' => 'Alat paket berhasil diatur'];
				} else {
					$setalat = SetAlat::where('paket_id', $request->paket_id)->get();
					foreach ($setalat as $delete) {
						$delete->delete();
					}
					$result = ['status' => 'warning', 'title' => 'Data Kosong', 'message' => 'Tidak ada data diatur'];
				}
				return response()->json($result);
			}

			// GET EDIT PAKET 
			if ($request->req == 'geteditpaket') {
				$data = Paket::where('id', $request->id)->first();
				return response()->json($data, 200);
			}

			// GET DAGING
			if ($request->req == 'getDaging') {
				$option = '<option value="">Pilih Daging Additional</option>';
				$kat_daging = Kategori::where('jenis', 'Kategori Bahan')->where('kategori', 'like', '%Daging%')->get();
				foreach ($kat_daging as $kat) {
					$daging = Bahan::where('kategori_id', $kat->id)->get();
					foreach ($daging as $dta) {
						$additional = Additional::where('bahan_id', $dta->id)->first();
						if ($request->this_adt == $dta->id) $option .= '<option value="'.$dta->id.'" selected>'.$dta->nama.'</option>';
						else if ($additional) $option .= '';
						else $option .= '<option value="'.$dta->id.'">'.$dta->nama.'</option>';
					}
				}
				$result = ['result' => $option];
				return response()->json($result);
			}

			// GET SATUAN
			if ($request->req == 'setSatuan') {
				$bahan = Bahan::where('id', $request->bahan_id)->first();
				$result = ['result' => $bahan->satuan];
				return response()->json($result);
			}

			// SET ADDITIONAL 
			if ($request->req == 'setAdditional') {
				$validator = Validator::make($request->all(), [
					'bahan_id' => 'required',
					'berat' => 'required|integer',
					'harga' => 'required|integer',
					'keterangan' => 'required',
				]);


				if ($validator->fails()) {
					return response()->json([
						'success' => false,
						'message' => $validator->errors()
					], 401);            
				}

				try {
					$data = $request->all();
					$bahan = Bahan::where('id', $request->bahan_id)->first();
					$data['nama_daging'] = $bahan->nama;
					$data['berat'] = $request->berat.' ('.$bahan->satuan.')';
					unset($data['req']);

					Additional::create($data);

					return response()->json([
						'success' => true,
						'message' => 'Success add data',
						'result' => $data
					], 200);
				} catch(QueryException $ex) {
					return response()->json([
						'success' => false,
						'message' => $ex->getMessage(),
					], 500);	
				}
			}

			// GET EDIT ADDITIONAL 
			if ($request->req == 'geteditadditional') {
				$data = Additional::where('id', $request->id)->first();
				$data['berat'] = intval($data->berat);
				$bahan = Bahan::where('id', $data->bahan_id)->first();
				$data['satuan_edt'] = $bahan->satuan;
				return response()->json($data, 200);
			}

			// EDIT ADDITIONAL
			if ($request->req == 'putAdditional') {
				$validator = Validator::make($request->all(), [
					'bahan_id' => 'required',
					'berat' => 'required|integer',
					'harga' => 'required|integer',
					'keterangan' => 'required',
				]);


				if ($validator->fails()) {
					return response()->json([
						'success' => false,
						'message' => $validator->errors()
					], 401);            
				}

				try {
					$update = Additional::find($request->id);

					if ($update) {
						$update->bahan_id = $request->bahan_id;
						$bahan = Bahan::where('id', $request->bahan_id)->first();
						$nama_daging = $bahan->nama;
						$berat = $request->berat.' ('.$bahan->satuan.')';
						$update->nama_daging = $nama_daging;
						$update->berat = $berat;
						$update->harga = $request->harga;
						$update->keterangan = $request->keterangan;
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

			// DELETE ADDITIONAL
			if ($request->req == 'deleteAdditional') {
				try {
					$delete = Additional::find($request->id);

					if ($delete) {
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

			// SET ALAT FROM KITCHEN
			if ($request->req == 'setAlatPilih') {
				$result = '';
				foreach ($request->data as $dta) {
					// Option
					$option = '<option value="">Pilih Alat</option>';
					$get_option = Alat::where('kategori_id', $dta['kategori_alat_id'])->get();
					foreach ($get_option as $opt) {
						$option .= '<option value="'.$opt->id.'">'.$opt->nama.'</option>';
					}

					// Set Alat
					$alat_dipilih = '';
					if (isset($dta['alat_dipilih'])) {
						foreach ($dta['alat_dipilih'] as $adp) {
							$alat_dipilih .= '
								<tr id="this-remove">
									<td width="250">'.$adp['nama_alat'].'</td>
									<td class="row">
										<div class="col-sm-8">
											<input type="hidden" name="kategori_id[]" value="'.$dta['kategori_alat_id'].'">
											<input type="hidden" name="alat_id[]" value="'.$adp['alat_id'].'">
											<input type="number" class="form-control" name="jumlah[]" required="" value="'.filter_var($adp['jumlah'], FILTER_SANITIZE_NUMBER_INT).'" placeholder="Jumlah..." style="height: 35px; width: 100%;">
										</div>
										<div class="col-sm-4 p-0">
											<input type="text" class="form-control" value="PCS" disabled style="height: 35px;">
										</div>
									</div>
									</td>
									<td width="50">
										<a href="#" class="btn btn-danger btn-sm" id="hapus-item" ktgr-id="'.$dta['kategori_alat_id'].'"><i class="fa fa-trash"></i> Hapus</a>
									</td>
								</tr>';
						}
					}

					// Set Kategori
					$result .= '
						<tr>
							<td>'.$dta['kategori_alat'].'</td>
							<td>'.$dta['jumlah_alat'].'</td>
							<td>
								<div class="form-group row">
									<div class="col-sm-10">
			                            <select class="form-control select2" style="height: 35px; width: 100%;" id="alat-dipilih'.$dta['kategori_alat_id'].'" ktgr-id="'.$dta['kategori_alat_id'].'">
			                                '.$option.'
			                            </select>
									</div>
								</div>
								<table class="table m-b-0">
									<tbody id="pilih-alat'.$dta['kategori_alat_id'].'">
										'.$alat_dipilih.'
									</tbody>
								</table>
							</td>
						</tr>';
				}

				return response()->json($result);
			}

			// SELECT ALAT FROM KITCHEN
			if ($request->req == 'alatSelected') {
				$alat = Alat::where('id', $request->alat_id)->first();
				$result = '';
				if ($alat) {
					$result = '
					<tr id="this-remove">
						<td width="250">'.$alat->nama.'</td>
						<td class="row">
							<div class="col-sm-8">
								<input type="hidden" name="kategori_id[]" value="'.$alat->kategori_id.'">
								<input type="hidden" name="alat_id[]" value="'.$alat->id.'">
								<input type="number" class="form-control" name="jumlah[]" required="" placeholder="Jumlah..." style="height: 35px; width: 100%;">
							</div>
							<div class="col-sm-4 p-0">
								<input type="text" class="form-control" value="PCS" disabled style="height: 35px;">
							</div>
						</div>
						</td>
						<td width="50">
							<a href="#" class="btn btn-danger btn-sm" id="hapus-item" ktgr-id="'.$alat->kategori_id.'"><i class="fa fa-trash"></i> Hapus</a>
						</td>
					</tr>';
				}

				return response()->json($result);
			}

			// CHECK ALAT EXITS KITCHEN
			if ($request->req == 'cekAlatExits') {
				$getid_alat = Alat::where('kategori_id', $request->ktgr_id)->get();
				$option = '<option value="">Pilih Alat</option>';

				if (isset($request->alat_id)) {
					foreach ($getid_alat as $opt) {
						if (!in_array($opt->id, $request->alat_id)) {
							$option .= '<option value="'.$opt->id.'">'.$opt->nama.'</option>';
						}
					}
				} else {
					foreach ($getid_alat as $opt) {
						$option .= '<option value="'.$opt->id.'">'.$opt->nama.'</option>';
					}
				}
				return response()->json($option);
			}

			// GET YEAR 
			if ($request->req == 'getyears') {
				$result = Keuangan::all();
				$year = [];
				foreach ($result as $dta) {
					$year[] = date('Y', strtotime($dta->tanggal));
				}
				sort($year);
				$option = '';
				foreach (array_unique($year) as $thn) {
					if ($thn == date('Y')) $select = 'selected';
					else $select = '';
					$option .= '<option value="'.$thn.'" '.$select.'>'.$thn.'</option>';
				}

				return response()->json($option);
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
		} else if ($request->req == 'dtGetAdditional') {
			$result = Additional::all();
			$data = [];
			$no = 1;
			foreach ($result as $dta) {
				$dta->no = $no;
				$dta->harga = 'Rp. '.$dta->harga;
				$data[] = $dta;
				$no = $no + 1;
			}

			return Datatables::of($data)
			->addColumn('action', function($dta) {
				return '<div class="text-center">
				<a href="#" role="button" class="btn btn-primary btn-sm waves-effect waves-light" id="edit-additional" dta-id="'.$dta->id.'" data-toggle1="tooltip" title="Edit" data-toggle="modal" data-target=".modal-edit"><i class="fa fa-edit"></i></a>
				<a href="#" role="button" class="btn btn-danger btn-sm waves-effect waves-light" id="hapus-additional" dta-id="'.$dta->id.'" data-toggle1="tooltip" title="Hapus" data-toggle="modal" data-target=".modal-delete"><i class="fa fa-trash"></i></a>
				</div>';
			})->rawColumns(['action'])->toJson();
		} else if ($request->req == 'dtGetKritiksaran') {
			$result = KritikSaran::orderBy('id', 'desc')->get();
			$data = [];
			$no = 1;
			foreach ($result as $dta) {
				$dta->no = $no;
				$dta->tanggal = date('d/m/Y', strtotime($dta->created_at));
				$data[] = $dta;
				$no = $no + 1;
			}

			return Datatables::of($data)
			->addColumn('action', function($dta) {
				return '<div class="text-center">
				<a href="#" role="button" class="btn btn-primary btn-sm waves-effect waves-light" id="detail-kritiksaran" dta-id="'.$dta->id.'" data-toggle1="tooltip" title="Detail" data-toggle="modal" data-target=".modal-detail"><i class="fa fa-eye"></i></a>
				<a href="#" role="button" class="btn btn-danger btn-sm waves-effect waves-light" id="hapus-kritiksaran" dta-id="'.$dta->id.'" data-toggle1="tooltip" title="Hapus" data-toggle="modal" data-target=".modal-delete"><i class="fa fa-trash"></i></a>
				</div>';
			})->rawColumns(['action'])->toJson();
		}
	}
}
