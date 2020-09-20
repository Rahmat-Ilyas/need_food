@extends('admin.layout')
@section('content')
<div class="content">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h4 class="page-title">Data Alat</h4>
				<ol class="breadcrumb">
					<li>
						<a href="#">NeedFood</a>
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
					<button type="button" class="btn btn-primary btn-rounded waves-effect waves-light m-t-10 m-b-20"><i class="md-restaurant-menu"></i> &nbsp;Tambah Stok</button>
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

<!-- MODAL TAMBAH -->
<div class="modal modal-add-alat" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myLargeModalLabel">Tambah Inventori Alat</h4>
			</div>
			<div class="modal-body" style="padding: 20px 50px 0 50px">
				<form id="fromAlat" action="{{ url('inventori/setalat') }}" method="POST" enctype="multipart/form-data">
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
							<select name="kategori" id="kategori" class="form-control">
								<option>Alat Dapur</option>
								<option>Alat Service</option>
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
		
	});
</script>
@endsection
