@extends('kitchen.layout')
@section('content')
<div class="content">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h4 class="page-title">Pesanan Baru</h4>
				<ol class="breadcrumb">
					<li>
						<a href="#">NeedFood</a>
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
									<th rowspan="2" style="padding-bottom: 30px;">Kode Alat</th>
									<th rowspan="2" style="padding-bottom: 30px;">Nama Alat</th>
									<th rowspan="2" style="padding-bottom: 30px;">Jumlah</th>
									<th colspan="2">Keterangan</th>
								</tr>
								<tr>
									<th style="width: 100px;">Ada</th>
									<th style="width: 100px;">Tidak</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>1</td>
									<td>2ad2-0244</td>
									<td>Panci Suki Besar (single)</td>
									<td>1</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>2</td>
									<td>au45-sd32</td>
									<td>Kompor Konvina Portebel</td>
									<td>1</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>3</td>
									<td>e988-95c3</td>
									<td>Grill Pan Bundar</td>
									<td>1</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>4</td>
									<td>65dd-2223</td>
									<td>Pirex Kotak</td>
									<td>5</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>5</td>
									<td>c81f-ec1c</td>
									<td>Sumpit Kayu</td>
									<td>5</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>6</td>
									<td>0cef-27d1</td>
									<td>Jepitan stainlees</td>
									<td>5</td>
									<td></td>
									<td></td>
								</tr>
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
				success : function(data) {
					dataTable.clear().draw();
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
			});
		}

		$(document).on('click', '#print-alat', function() {
			var id = $(this).attr('dta-id');
			$.ajax({
				url     : host+"/configuration",
				method  : "POST",
				headers	: headers,
				data	: { req: 'printalat', id: id },
				success : function(data) {
					$.each(data.result, function(key, val) {
						$('#'+key).text(val);
					});

					$('.print').printArea();
				}
			});
		});

	});
</script>
@endsection
