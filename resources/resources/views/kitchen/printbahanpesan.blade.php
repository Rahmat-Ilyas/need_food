@extends('kitchen.layout')
@section('content')
<div class="content">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h4 class="page-title">Bahan Pesanan</h4>
				<ol class="breadcrumb">
					<li>
						<a href="#">Kesiniku</a>
					</li>
					<li>
						<a href="#">Print</a>
					</li>
					<li class="active">
						Bahan Pesanan
					</li>
				</ol>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
					<h4 class="m-t-0 header-title"><b>Data Pesanan</b></h4>
					<table id="tablePrintbahan" class="table table-striped table-bordered">
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
							<p><b>Nama Pemesan:</b> <span id="nama_pemesan"></span></p>
						</div>
						<div style="width: 60%; float: left;">
							<p><b>Telepon:</b> <span id="no_telepon"></span></p>
							<p><b>WhatsApp:</b> <span id="no_wa"></span></p>
							<p><b>Alamat:</b> <span id="deskripsi_lokasi"></span></p>
						</div>
						<h4 class="m-t-20"><b>Bahan Utama</b></h4>
						<table class="table table-bordered m-t-10" id="tableDetail" style="margin-top: -15px; font-size: 13px;">
							<thead>
								<tr>
									<th rowspan="2" style="padding-bottom: 30px; width: 2px;">No</th>
									<th rowspan="2" style="padding-bottom: 30px;">Nama Bahan</th>
									<th rowspan="2" style="padding-bottom: 30px;">Jumlah</th>
									<th colspan="2">Keterangan</th>
								</tr>
								<tr>
									<th style="width: 100px;">Ada</th>
									<th style="width: 100px;">Tidak</th>
								</tr>
							</thead>
							<tbody id="data-bahan">
								
							</tbody>
						</table>
						<h4 class="m-t-20"><b>Bahan Additional</b></h4>
						<table class="table table-bordered m-t-10" style="margin-top: -15px; font-size: 13px;">
							<thead>
								<tr>
									<th rowspan="2" style="padding-bottom: 30px; width: 2px;">No</th>
									<th rowspan="2" style="padding-bottom: 30px;">Nama Daging</th>
									<th rowspan="2" style="padding-bottom: 30px;">Jumlah</th>
									<th colspan="2">Keterangan</th>
								</tr>
								<tr>
									<th style="width: 100px;">Ada</th>
									<th style="width: 100px;">Tidak</th>
								</tr>
							</thead>
							<tbody id="data-bahan-adt">

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
			var dataTable = $('#tablePrintbahan').DataTable();
			$.ajax({
				url     : host+"/configuration",
				method  : "POST",
				headers	: headers,
				data	: { req: 'getviewprint' },
				success : function(data, textStatus, xhr) {
					dataTable.clear().draw();
					if (xhr.status == 200) {
						$.each(data.result, function(key, val) {
							if (val.status != 'New') {
								dataTable.row.add([
									val.kd_pemesanan,
									val.nama,
									val.no_telepon+ '/' +val.no_wa,
									val.jadwal_antar,
									val.deskripsi_lokasi,
									`<div class="text-center">
									<a href="#" role="button" class="btn btn-info btn-sm waves-effect waves-light" id="print-bahan" dta-id="`+ val.id +`" data-toggle1="tooltip" title="Print Bahan Pesanan"><i class="fa fa-print"></i> Print Bahan Pesanan</a>
									</div>`,
									]).draw(false);
							}
						});
					}
				}
			});
		}

		$(document).on('click', '#print-bahan', function() {
			var id = $(this).attr('dta-id');
			var data_bahan = [];
			var data_bahan_adt = [];
			$.ajax({
				url     : host+"/api/datapesanan/"+id,
				method  : "GET",
				headers	: headers,
				success : function(data) {
					var dt = new Date(data.result.tanggal_antar);
					var month = dt.getMonth()+1;
					var date = dt.getDate();
					if (month < 10) month = '0'+month;
					if (dt.getDate() < 10) date = '0'+dt.getDate();
					data.result.tanggal_antar = date+'/'+month+'/'+dt.getFullYear();
					$.each(data.result, function(key, val) {
						$('#'+key).text(val);
						if (key == 'nama') $('#nama_pemesan').text(val);
					});

					$.each(data.result.bahan, function(key, val) {			
						data_bahan.push(val);
					});

					$.each(data.result.additional, function(key, val) {			
						data_bahan_adt.push(val);
					});

					var nomor_bhn = 1;
					$('#data-bahan').html('');
					$.each(data_bahan, function(index, val) {
						$('#data-bahan').append(`
							<tr>
							<td>`+nomor_bhn+`</td>
							<td>`+val.nama_bahan+`</td>
							<td>`+val.jumlah_bahan+`</td>
							<td></td>
							<td></td>
							</tr>
							`);
						nomor_bhn = nomor_bhn + 1;
					});
					if (nomor_bhn == 1) $('#data-bahan').html('<tr><td colspan="5" class="text-center">Tidak Ada Bahan</td></tr>');

					var nomor_adt = 1;
					$('#data-bahan-adt').html('');
					$.each(data_bahan_adt, function(index, val) {
						$('#data-bahan-adt').append(`
							<tr>
							<td>`+nomor_adt+`</td>
							<td>`+val.nama_daging+` (`+val.berat+`)</td>
							<td>`+val.jumlah+` Pax</td>
							<td></td>
							<td></td>
							</tr>
							`);
						nomor_adt = nomor_adt + 1;
					});

					if (nomor_adt == 1) $('#data-bahan-adt').html('<tr><td colspan="5" class="text-center">Tidak Ada Additional</td></tr>');

					$('.print').printArea();
				}
			});
		});

	});
</script>
@endsection
