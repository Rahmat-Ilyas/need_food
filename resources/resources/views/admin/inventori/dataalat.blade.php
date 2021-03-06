@extends('admin.layout')
@section('content')
<div class="content">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h4 class="page-title">Data Alat</h4>
				<ol class="breadcrumb">
					<li>
						<a href="#">Kesiniku</a>
					</li>
					<li>
						<a href="#">Inventori</a>
					</li>
					<li class="active">
						Data Alat
					</li>
				</ol>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
					<h4 class="m-t-0 header-title"><b>Data Inventori Alat</b></h4>
					<button type="button" class="btn btn-default btn-rounded waves-effect waves-light m-t-10 m-b-20" data-toggle="modal" data-target=".modal-add-alat"><i class="fa fa-plus-circle"></i> &nbsp;Alat Baru</button>
					<button type="button" class="btn btn-primary btn-rounded waves-effect waves-light m-t-10 m-b-20" data-toggle="modal" data-target=".modal-add-stok"><i class="md-restaurant-menu"></i> &nbsp;Tambah Stok</button>
					<button type="button" class="btn btn-inverse btn-rounded waves-effect waves-light m-t-10 m-b-20" data-toggle="modal" data-target=".modal-alat-hilang" id="btn-alat-hilang"><i class="fa fa-exclamation-circle"></i> &nbsp;Alat Hilang</button>
					<table id="dataTableAlat" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>No</th>
								<th>Foto</th>
								<th>Kode Alat</th>
								<th>Nama Alat</th>
								<th>Kategori</th>
								<th>Jumlah</th>
								<th>Keluar</th>
								<th>Sisa</th>
								<th style="width: 120px;" class="text-center">Aksi</th>
							</tr>
						</thead>

						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div> 
</div>

<!-- MODAL TAMBAH ALAT-->
<div class="modal modal-add-alat" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myLargeModalLabel">Tambah Inventori Alat</h4>
			</div>
			<div class="modal-body" style="padding: 20px 50px 0 50px">
				<form id="fromAlat" action="#" enctype="multipart/form-data">
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Nama Alat</label>
						<div class="col-sm-9">
							<input type="text" class="nb-edt form-control" required="" autocomplete="off" placeholder="Nama Alat" name="nama" id="nama">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Foto</label>
						<div class="col-sm-9 bootstrap-filestyle">
							<input type="file" class="filestyle" data-placeholder="Belum ada foto" name="foto" id="foto" required="">
							<div class="row text-info" id="viewProgress" hidden="">
								<span class="col-sm-5">Sedang mengapload foto... <b><i id="progress">0%</i></b></span>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label">Kategori</label>
						<div class="col-sm-9">
							<select name="kategori_id" id="kategori" class="form-control">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Jumlah Beli</label>
						<div class="col-sm-9">
							<input type="number" class="form-control" required="" placeholder="Jumlah Beli" name="jumlah_alat" id="jumlah_alat">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Total Harga Beli</label>
						<div class="input-group col-sm-9">
							<span class="input-group-addon">Rp.</i></span>
							<input type="number" class="form-control" required="" placeholder="Total Harga" name="total_harga" id="total_harga">
							<span class="input-group-addon">.00</span>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Nama Supplier</label>
						<div class="col-sm-9">
							<select name="supplier_id" id="supplier" class="form-control">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-3"></div>
						<div class="col-sm-9">
							<button type="submit" name="simpanAlat" class="btn btn-default" id="upload">Simpan</button>
							<button type="" class="btn btn-primary" id="batal" data-dismiss="modal" aria-hidden="true">Batal</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- MODAL TAMBAH STOK-->
<div class="modal modal-add-stok" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myLargeModalLabel">Tambah Stok Alat</h4>
			</div>
			<div class="modal-body" style="padding: 20px 50px 0 50px">
				<form id="fromStokAlat" action="#" enctype="multipart/form-data">
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Nama Alat</label>
						<div class="col-sm-9">
							<select class="form-control select2" name="alat_id" id="nama_alat" required="">
								<option value="">Pilih Alat</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Jumlah Beli</label>
						<div class="col-sm-9">
							<input type="number" class="form-control" required="" placeholder="Jumlah Beli" name="jumlah_beli">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Total Harga Beli</label>
						<div class="input-group col-sm-9">
							<span class="input-group-addon">Rp.</i></span>
							<input type="number" class="form-control" required="" placeholder="Total Harga" name="total_harga">
							<span class="input-group-addon">.00</span>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Nama Supplier</label>
						<div class="col-sm-9">
							<select name="supplier_id" id="supplier_" class="form-control">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-3"></div>
						<div class="col-sm-9">
							<button type="submit" class="btn btn-default">Simpan</button>
							<button type="" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Batal</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- MODAL EDIT ALAT-->
<div class="modal modal-edit-alat" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myLargeModalLabel">Edit Inventori Alat</h4>
			</div>
			<div class="modal-body" style="padding: 20px 50px 0 50px">
				<form id="fromEditAlat" action="#" enctype="multipart/form-data">
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Kode Alat</label>
						<div class="col-sm-9">
							<input type="text" class="nb-edt form-control" autocomplete="off" placeholder="Kode Alat" id="edt_kd_alat" name="kd_alat" readonly="">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Nama Alat</label>
						<div class="col-sm-9">
							<input type="hidden" name="id" id="edt_id">
							<input type="text" class="nb-edt form-control" required="" autocomplete="off" placeholder="Nama Alat" name="nama" id="edt_nama_alat">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Foto</label>
						<div class="col-sm-9 bootstrap-filestyle">
							<input type="file" name="foto" id="edt_foto">
							<div class="row text-info" id="viewProgress" hidden="">
								<span class="col-sm-5">Sedang mengapload foto... <b><i id="progress">0%</i></b></span>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label">Kategori</label>
						<div class="col-sm-9">
							<select name="kategori_id" id="edt_kategori" class="form-control">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-3"></div>
						<div class="col-sm-9">
							<button type="submit" name="simpanAlat" class="btn btn-default" id="upload">Simpan</button>
							<button type="" class="btn btn-primary" id="batal" data-dismiss="modal" aria-hidden="true">Batal</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- MODAL DETAIL -->
<div class="modal detail-alat" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Detail Alat</h4>
			</div>
			<div class="modal-body" style="padding: 20px 40px 20px 40px">
				<dl class="row mb-0">
					<div class="col-sm-6 row">
						<dt class="col-sm-5">Kode Alat:</dt>
						<dd class="col-sm-7" id="dtl_kd_alat"></dd>	
					</div>
					<div class="col-sm-6 row">
						<dt class="col-sm-5">Jumlah Alat:</dt>
						<dd class="col-sm-7"><span id="dtl_jumlah_alat"></span> pcs</dd>
					</div>
					<div class="col-sm-6 row">
						<dt class="col-sm-5">Nama Alat:</dt>
						<dd class="col-sm-7" id="dtl_nama"></dd>
					</div>
					<div class="col-sm-6 row">
						<dt class="col-sm-5">Alat Keluar:</dt>
						<dd class="col-sm-7"><span id="dtl_alat_keluar"></span> pcs</dd>
					</div>
					<div class="col-sm-6 row">
						<dt class="col-sm-5">Kategori:</dt>
						<dd class="col-sm-7" id="dtl_kategori"></dd>
					</div>
					<div class="col-sm-6 row">
						<dt class="col-sm-5">Sisa Alat:</dt>
						<dd class="col-sm-7"><span id="dtl_sisa_alat"></span> pcs</dd>
					</div>
				</dl>
				<hr>
				<div class="panel-group" id="accordion-test-2"> 
					<div class="panel panel-default"> 
						<div class="panel-heading"> 
							<h4 class="panel-title"> 
								<a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapseOne-2" aria-expanded="false" class="collapsed">
									Riwayat Pembelian Alat
								</a> 
							</h4> 
						</div> 
						<div id="collapseOne-2" class="panel-collapse collapse"> 
							<div class="panel-body">
								<table class="table table-bordered" id="tableDetail" style="margin-top: -15px; font-size: 13px;">
									<thead>
										<tr>
											<th>No</th>
											<th>KD Pembelian</th>
											<th>Tggl Pembelian</th>
											<th>Jumlah Beli</th>
											<th>Total Harga</th>
											<th>Supplier</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody id="riwayat-beli">
										
									</tbody>
								</table>
							</div> 
						</div> 
					</div>
				</div> 
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Tutup</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<!-- MODAL ALAT HILANG -->
<div class="modal modal-alat-hilang" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Data Alat Hilang</h4>
			</div>
			<div class="modal-body">
				<button type="button" class="btn btn-primary btn-rounded waves-effect waves-light m-t-10 m-b-20" data-toggle="modal" data-target=".modal-add-stok"><i class="md-restaurant-menu"></i> &nbsp;Input Alat Hilang</button>
				<table class="table table-bordered" id="tableAlatHilang" style="margin-top: -15px; font-size: 13px;">
					<thead>
						<tr>
							<th>No</th>
							<th>KD Pemesanan</th>
							<th>Nama Pemesan</th>
							<th>Nama Alat</th>
							<th>Jumlah Hilang</th>
							<th>Tggl Hilang</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody id="alat-hilang">

					</tbody>
				</table>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Tutup</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<!-- MODAL HAPUS -->
<div class="modal modal-delete" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticModalLabel">Hapus Data</h5>
			</div>
			<div class="modal-body">
				<p>Yakin ingin menghapus data ini?</p>
			</div>
			<div class="modal-footer form-inline">
				<button type="button" class="btn btn-danger" id="delete-alat">Hapus</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
			</div>
		</div>
	</div>
</div>

<!-- MODAL VIEW GAMBAR -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-gambar-alat">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content p-0 text-right">
			<div style="margin-right: -25px;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
			</div>
			<div class="modal-body">
				<img id="setImage" src="" style="width: 100%;margin: -20px 0px -20px 0px;">
			</div>
		</div>
	</div>
</div>

@endsection

@section('javascript')
<script>
	$(document).ready(function() {
		var url = $('#configurl').val();
		var host = $('#host').val();

		var headers = {
			"Accept"		: "application/json",
			"Authorization" : "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjA3YWE1Y2M3MDA1YTdjMDA2YzgwZWNjNjIxN2E4Y2VhOTUwMTEzMWNmM2MxOTVmMDk2YjJmZTAwY2I2MGI4ODAxNzE1ZGJmYjQ1YTYzMmIwIn0.eyJhdWQiOiIxIiwianRpIjoiMDdhYTVjYzcwMDVhN2MwMDZjODBlY2M2MjE3YThjZWE5NTAxMTMxY2YzYzE5NWYwOTZiMmZlMDBjYjYwYjg4MDE3MTVkYmZiNDVhNjMyYjAiLCJpYXQiOjE2MDA1MTI5NTEsIm5iZiI6MTYwMDUxMjk1MSwiZXhwIjoxNjMyMDQ4OTUwLCJzdWIiOiIxMyIsInNjb3BlcyI6W119.oHghL81Jc0xq-vvDVFde3QeqYs3s0Me6XukZtGy8G8HegV4LV2ImqKlpw_wdwxBOtKhBfodMFICi0YmNcPov7A",
			'X-CSRF-TOKEN'	: $('meta[name="csrf-token"]').attr('content')
		}

		//GET KATEGORI
		$.ajax({
			url     : host+"/api/inventori/getkategori",
			method  : "GET",
			headers	: headers,
			data	: { kategori: 'alat' },
			success : function(data) {
				$.each(data.result, function(key, val) {
					$('#kategori').append('<option value="'+ val.id +'">' + val.kategori + '</option>');
					$('#edt_kategori').append('<option value="'+ val.id +'">' + val.kategori + '</option>');
				});
			}
		});

		//GET SUPPLIER
		$.ajax({
			url     : host+"/api/getsupplier",
			method  : "GET",
			headers	: headers,
			data	: { kategori: 'alat' },
			success : function(data) {
				$.each(data.result, function(key, val) {
					$('#supplier').append('<option value="' + val.id + '">' + val.nama_supplier + '</option>');
					$('#supplier_').append('<option value="' + val.id + '">' + val.nama_supplier + '</option>');
				});
			}
		});

		//GET ALAT
		getDataAlat();
		function getDataAlat() {
			$('#nama_alat').html('<option value="">Pilih Alat</option>');
			$.ajax({
				url     : host+"/api/inventori/getalat",
				method  : "GET",
				headers	: headers,
				success : function(data) {
					$.each(data.result, function(key, val) {
						$('#nama_alat').append('<option value="'+ val.id +'">'+ val.kd_alat +'/'+ val.nama +'</option>');
					});
				}
			});
		}

		$('.modal-add-stok').on('shown.bs.modal', function() {
			getDataAlat();
		});

		$('#dataTableAlat').DataTable({
			processing: true,
			serverSide: true,
			ajax: host+'/datatable?req=dtGetAlat',
			columns: [
			{ data: 'no', name: 'no' },
			{ data: 'foto', name: 'foto', orderable: false, searchable: false },
			{ data: 'kd_alat', name: 'kd_alat' },
			{ data: 'nama', name: 'nama' },
			{ data: 'kategori', name: 'kategori' },
			{ data: 'jumlah_alat', name: 'jumlah_alat' },
			{ data: 'alat_keluar', name: 'alat_keluar' },
			{ data: 'sisa_alat', name: 'sisa_alat' },
			{ data: 'action', name: 'action', orderable: false, searchable: false },
			]
		});

		//EDIT DATA ALAT
		$(document).on('click', '#edit-alat', function() {
			var id = $(this).attr('dta-id');
			$.ajax({
				url     : host+"/configuration",
				method  : "POST",
				headers	: headers,
				data	: { req: 'geteditalat', id: id },
				success : function(data) {
					$('#edt_id').val(data.id);
					$('#edt_kd_alat').val(data.kd_alat);
					$('#edt_nama_alat').val(data.nama);
					$('#edt_foto').filestyle({placeholder: data.foto, buttonText: 'Pilih Foto'});
					$('#edt_kategori').val(data.kategori_id);
				}
			});
		});

		//HAPUS DATA ALAT
		$(document).on('click', '#hapus-alat', function() {
			var id = $(this).attr('dta-id');
			$('#delete-alat').attr('data-id', id);
		});

		// Detail Supplier
		$(document).on('click', '#detail-supplier', function(e) {
			e.preventDefault();
			var id = $(this).attr('data-id');
			$.ajax({
				url     : host+"/configuration",
				method  : "POST",
				headers	: headers,
				data	: { req: 'detailsupplier', id: id },
				success : function(data) {
					swal({
						title: "Detail Supplier",
						html: data,
					});
				}
			});
		});

		// ALAT HILANG
		$('#btn-alat-hilang').click(function() {
			$.ajax({
				url: host + "/api/inventori/getalathilang",
				method: "GET",
				headers: headers,
				success: function (data) {
					var tableAlatHilang = $('#tableAlatHilang').DataTable();
					tableAlatHilang.clear().draw();
					var no = 1;
					$.each(data.result, function (key, vl) {
						tableAlatHilang.row.add([
							no,
							vl.kd_pemesanan,
							vl.nama_pemesan,
							vl.nama_alat,
							vl.jumlah_hilang,
							vl.tanggal_hilang,
							`<td class="text-center">
							<a href="#" class="btn btn-sm btn-default" id="set-alat-kembali" data-id="` + vl.id + `" ><i class="fa fa-reply"></i> Telah Kembali</a>
							</td>`
							]).draw(false);
						no = no + 1;
					});
				}
			});
		});

	});
</script>
@endsection
