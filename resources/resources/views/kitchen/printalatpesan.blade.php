@extends('kitchen.layout')
@section('content')
<div class="content">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h4 class="page-title">Alat Pesanan</h4>
				<ol class="breadcrumb">
					<li>
						<a href="#">Kesiniku</a>
					</li>
					<li>
						<a href="#">Print</a>
					</li>
					<li class="active">
						Alat Pesanan
					</li>
				</ol>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
					<h4 class="m-t-0 header-title"><b>Data Pesanan</b></h4>
					<table id="tablePrintalat" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th style="width: 120px;">Kode Pesanan</th>
								<th>Nama</th>
								<th>Telepon/WA</th>
								<th>Tanggal</th>
								<th>Alamat</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
			<div class="print" hidden="">
				<div class="col-sm-12">
					<div class="card-box row">
						<h4 class="text-center"><u><b>LIST ALAT PESANAN</b></u></h4>
						<div style="width: 40%; float: left;">
							<p><b>Kode Pesanan:</b> <span id="kd_pemesanan"></span></p>
							<p><b>Tanggal Pesan:</b> <span id="tanggal_antar"></span></p>
							<p><b>Nama Pemesan:</b> <span id="nama"></span></p>
						</div>
						<div style="width: 60%; float: left;">
							<p><b>Telepon:</b> <span id="no_telepon"></span></p>
							<p><b>WhatsApp:</b> <span id="no_wa"></span></p>
							<p><b>Alamat:</b> <span id="deskripsi_lokasi"></span></p>
						</div>
						<table class="table table-bordered m-t-10" id="tableDetail" style="margin-top: -15px; font-size: 13px;">
							<thead>
								<tr>
									<th rowspan="2" style="padding-bottom: 30px; width: 2px;">No</th>
									<th rowspan="2" style="padding-bottom: 30px;">Kategori</th>
									<th rowspan="2" style="padding-bottom: 30px;">Nama Alat</th>
									<th rowspan="2" style="padding-bottom: 30px;">Jumlah</th>
									<th colspan="2">Keterangan</th>
								</tr>
								<tr>
									<th style="width: 100px;">Ada</th>
									<th style="width: 100px;">Tidak</th>
								</tr>
							</thead>
							<tbody id="data-alat">
								
							</tbody>
						</table>
					</div>
				</div>
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

		//GET PESANAN
		getPesanan();
		function getPesanan() {
			var dataTable = $('#tablePrintalat').DataTable();
			$.ajax({
				url     : host+"/configuration",
				method  : "POST",
				headers	: headers,
				data	: { req: 'pesananbaru' },
				success : function(data, textStatus, xhr) {
					dataTable.clear().draw();
					if (xhr.status == 200) {
						$.each(data.result, function(key, val) {
							dataTable.row.add([
								val.kd_pemesanan,
								val.nama,
								val.no_telepon+ '/' +val.no_wa,
								val.jadwal_antar,
								val.deskripsi_lokasi,
								`<div class="text-center">
								<a href="#" role="button" class="btn btn-info btn-sm waves-effect waves-light" id="print-alat" dta-id="`+ val.id +`" data-toggle1="tooltip" title="Print Alat Pesanan"><i class="fa fa-print"></i> Print Alat Pesanan</a>
								</div>`,
								]).draw(false);
						});
					}
				}
			});
		}

		$(document).on('click', '#print-alat', function() {
			var id = $(this).attr('dta-id');
			var data_alat = [];
			$.ajax({
				url     : host+"/api/datapesanan/"+id,
				method  : "GET",
				headers	: headers,
				success : function(data) {
					var dt = new Date(data.result.tanggal_antar);
					data.result.tanggal_antar = dt.getDate()+'/'+dt.getMonth()+'/'+dt.getFullYear();
					$.each(data.result, function(key, val) {
						$('#'+key).text(val);
					});

					$.each(data.result.alat, function(key, val) {
						$.each(val.alat_dipilih, function(key1, val1) {
							val1['kategori'] = val.kategori_alat;			
							data_alat.push(val1);
						});					
					});

					var nomor = 1;
					$('#data-alat').html('');
					$.each(data_alat, function(index, val) {
						$('#data-alat').append(`
							<tr>
								<td>`+nomor+`</td>
								<td>`+val.kategori+`</td>
								<td>`+val.nama_alat+`</td>
								<td>`+val.jumlah+`</td>
								<td></td>
								<td></td>
							</tr>
						`);
						nomor = nomor + 1;
					});

					$('.print').printArea();
				}
			});
		});

	});
</script>
@endsection
