@extends('admin.layout')
@section('content')
<div class="content">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h4 class="page-title">Pesanan Baru</h4>
				<ol class="breadcrumb">
					<li>
						<a href="#">Kesiniku</a>
					</li>
					<li>
						<a href="#">Data Pesanan</a>
					</li>
					<li class="active">
						Pesanan Baru
					</li>
				</ol>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
					<h4 class="m-t-0 header-title"><b>Data Pesanan Baru</b></h4>
					<table id="tabelPesananbaru" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Kode Pesanan</th>
								<th>Nama</th>
								<th>Telepon</th>
								<th>WhhatsApp</th>
								<th>Jadwal Antar</th>
								<th>Alamat</th>
								<th>Catatan</th>
								<th class="text-center">Aksi</th>
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
						<dt class="col-sm-5">Kode Barang:</dt>
						<dd class="col-sm-7" id="dtl_kd_alat"></dd>	
					</div>
					<div class="col-sm-6 row">
						<dt class="col-sm-5">Jumlah Alat:</dt>
						<dd class="col-sm-7"><span id="dtl_jumlah_alat"></span> pcs</dd>
					</div>
					<div class="col-sm-6 row">
						<dt class="col-sm-5">Nama Barang:</dt>
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
									Riwayat Pembelian Barang
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
		getPesanan();
		function getPesanan() {
			var dataTable = $('#tabelPesananbaru').DataTable();
			$.ajax({
				url     : host+"/configuration",
				method  : "POST",
				headers	: headers,
				data	: { req: 'pesananbaru' },
				success : function(data) {
					console.log(data)
					dataTable.clear().draw();
					$.each(data.result, function(key, val) {
						dataTable.row.add([
							val.kd_pemesanan,
							val.nama,
							val.no_telepon,
							val.no_wa,
							val.jadwal_antar,
							val.deskripsi_lokasi,
							val.catatan,
							`<div class="text-center">
							<a href="#" role="button" class="btn btn-info btn-sm waves-effect waves-light" id="detail-alat" dta-id="`+ val.id +`" data-toggle1="tooltip" title="Detail" data-toggle="modal" data-target=".detail-alat"><i class="fa fa-eye"></i></a>
							</div>`,
							]).draw(false);
					});
				}
			});
		}
	});
</script>
@endsection
