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
								<th width="100">Kode Pesanan</th>
								<th>Nama</th>
								<th>Alamat</th>
								<th width="120">Jadwal Antar</th>
								<th>Catatan</th>
								<th width="70">Status</th>
								<th width="50">Aksi</th>
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

<!-- MODAL KONFIRMASI -->
<div class="modal confirm-pesanan" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Foto Bukti Pembayaran</h4>
			</div>
			<div class="modal-body">
				<img src="" id="bukti_pembayaran" style="width: 100%;">
				<div class="text-center m-t-20">
					<button type="button" class="btn btn-danger waves-effect" id="refuse-pesanan"><i class="md-close"></i> Tolak Pesanan</button>
					<button type="button" class="btn btn-success waves-effect" id="acc-pesanan"><i class="md-check"></i> Verifikasi Pesanan</button>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

<!-- MODAL DETAIL -->
<div class="modal detail-pesanan" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Detail Alat</h4>
			</div>
			<div class="modal-body" style="padding: 20px 40px 20px 40px">
				<ul class="list-group list-group-flush">
					<li class="list-group-item row">
						<b class="col-sm-4 p-0">Kode Pemesanan: </b>
						<span class="col-sm-8 p-0" id="dtl_kd_pemesanan"></span>
					</li>
					<li class="list-group-item row">
						<b class="col-sm-4 p-0">Nama Pemesan: </b>
						<span class="col-sm-8 p-0" id="dtl_nama"></span>
					</li>
					<li class="list-group-item row">
						<b class="col-sm-4 p-0">Telepon: </b>
						<span class="col-sm-8 p-0" id="dtl_no_telepon"></span>
					</li>
					<li class="list-group-item row">
						<b class="col-sm-4 p-0">WhatsApp: </b>
						<span class="col-sm-8 p-0" id="dtl_no_wa"></span>
					</li>
					<li class="list-group-item row">
						<b class="col-sm-4 p-0">Tanggal Antar: </b>
						<span class="col-sm-8 p-0" id="dtl_tanggal_antar"></span>
					</li>
					<li class="list-group-item row">
						<b class="col-sm-4 p-0">Paket Pesanan: </b>
						<span class="col-sm-8 p-0 row" id="dtl_paket"></span>
					</li>
					<li class="list-group-item row">
						<b class="col-sm-4 p-0">Additional: </b>
						<span class="col-sm-8 p-0 row" id="dtl_additional"></span>
					</li>
					<li class="list-group-item row">
						<b class="col-sm-4 p-0">Catatan: </b>
						<span class="col-sm-8 p-0" id="dtl_catatan"></span>
					</li>
					<li class="list-group-item row">
						<b class="col-sm-4 p-0">Alamat: </b>
						<span class="col-sm-8 p-0" id="dtl_deskripsi_lokasi"></span>
					</li>
					<li class="list-group-item row" id="setMaps">
						<div class="col-sm-12 p-0 gmaps" id="mapView" style="height: 200px;" hidden=""></div>
					</li>
				</ul>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

@endsection

@section('javascript')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA5g4U_FtOK7LX789QyNyJe90DmnastiI8&callback=initMap&libraries=&v=weekly" defer></script>
<script>
	var latitude = -5.146512141348986;
	var longitude = 119.43296873064695;
	function initMap() {
		var center = { lat: latitude, lng: longitude };

		var map = new google.maps.Map(document.getElementById("mapView"), {
			zoom: 18,
			center: center,
		});

		var marker = new google.maps.Marker({
			position: center,
			map,
		});
	}

	$(document).ready(function() {
		var url = $('#configurl').val();
		var host = $('#host').val();

		var headers = {
			"Accept"		: "application/json",
			"Authorization" : "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjA3YWE1Y2M3MDA1YTdjMDA2YzgwZWNjNjIxN2E4Y2VhOTUwMTEzMWNmM2MxOTVmMDk2YjJmZTAwY2I2MGI4ODAxNzE1ZGJmYjQ1YTYzMmIwIn0.eyJhdWQiOiIxIiwianRpIjoiMDdhYTVjYzcwMDVhN2MwMDZjODBlY2M2MjE3YThjZWE5NTAxMTMxY2YzYzE5NWYwOTZiMmZlMDBjYjYwYjg4MDE3MTVkYmZiNDVhNjMyYjAiLCJpYXQiOjE2MDA1MTI5NTEsIm5iZiI6MTYwMDUxMjk1MSwiZXhwIjoxNjMyMDQ4OTUwLCJzdWIiOiIxMyIsInNjb3BlcyI6W119.oHghL81Jc0xq-vvDVFde3QeqYs3s0Me6XukZtGy8G8HegV4LV2ImqKlpw_wdwxBOtKhBfodMFICi0YmNcPov7A",
			'X-CSRF-TOKEN'	: $('meta[name="csrf-token"]').attr('content')
		}

		function setError(data) {
			var error = '';
			result = data.responseJSON.message;
			if (jQuery.type(result) == 'object') {
				$.each(result, function (key, val) {
					error = error + ' ' + val[0];
				});
			} else {
				error = data.responseJSON.message;
			}

			Swal.fire({
				title: 'Gagal Diproses',
				text: error,
				type: 'error'
			});
		}

		$.ajax({
			url     : host+"/configuration",
			method  : "POST",
			headers	: headers,
			data	: { req: 'pesananbaru' },
			success : function(data) {
				google.maps.event.addDomListener(window, 'load', initMap);
				$.each(data.result, function(key, val) {

					$('#setMaps').append(`<div class="col-sm-12 p-0 gmaps" id="mapView`+val.id+`" style="height: 250px;" hidden=""></div>`);

					var lng = val.longitude;
					var lat = val.latitude;
					var lokasi = val.deskripsi_lokasi;
					var nama = val.nama;
					function initMap() {
						var propertiPeta = {
							center:new google.maps.LatLng(lat,lng), 
							zoom:15,
							mapTypeId:google.maps.MapTypeId.ROADMAP
						};
						var peta = new google.maps.Map(document.getElementById("mapView"+val.id), propertiPeta);
						var marker = new google.maps.Marker({
							position: new google.maps.LatLng(lat,lng),
							map: peta
						});
						var contentString = '<b>Nama Pemesan: ' + nama + '</b><p>Lokasi: ' + lokasi + '</p>';
						var infowindow = new google.maps.InfoWindow({
							content: contentString
						});
						infowindow.open(peta, marker);
					}
					google.maps.event.addDomListener(window, 'load', initMap);
				});
			}
		});

		//GET PESANAN
		getPesanan();
		function getPesanan() {
			var dataTable = $('#tabelPesananbaru').DataTable();
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
							val.deskripsi_lokasi,
							val.jadwal_antar,
							val.catatan,
							val.status,
							`<div class="text-center">
							<a href="#" role="button" class="btn btn-success btn-sm waves-effect waves-light" id="confirm-pesanan" dta-id="`+ val.id +`" data-toggle1="tooltip" title="Konfirmasi Pembayaran" data-toggle="modal" `+val.chek+`><i class="fa fa-check-circle"></i></a>
							<a href="#" role="button" class="btn btn-primary btn-sm waves-effect waves-light" id="detail-pesanan" dta-id="`+ val.id +`" data-toggle1="tooltip" title="Detail Pesanan" data-toggle="modal" data-target=".detail-pesanan"><i class="fa fa-eye"></i></a>
							</div>`,
							]).draw(false);
					});
				}
			});
		}

		// KONFIRMASI PESANAN
		$(document).on('click', '#confirm-pesanan', function(e) {
			e.preventDefault();

			var id = $(this).attr('dta-id');

			$.ajax({
				url     : host+"/api/datapesanan/"+id,
				method  : "GET",
				headers : headers,
				success : function(data) {
					$('#bukti_pembayaran').attr('src', host+'/assets/images/konfirmasi/'+data.result.bukti_pembayaran);
					$('#acc-pesanan').attr('data-id', id);
					$('#refuse-pesanan').attr('data-id', id);
				}
			});
		});

		// ACCEPT PESANAN
		$(document).on('click', '#acc-pesanan', function(e) {
			var id = $(this).attr('data-id');
			swal({
				title: "Verifikasi Pesanan?",
				html: "Pesanan akan diverifikasi. Lanjutkan?",
				type: "info",
				confirmButtonText: 'Lanjutkan',
				showCancelButton: true,
				confirmButtonClass: 'btn-success btn-md waves-effect waves-light',
				cancelButtonClass: 'btn-white btn-md waves-effect',
				focusConfirm: true,
				preConfirm: () => {
					$.ajax({
						url: host + "/api/datapesanan/updatestatus/"+id,
						method: "PUT",
						data: { status: 'Proccess' },
						headers: headers,
						success: function (data) {
							getPesanan();
							swal('Selesai', 'Pesanan telah diverifikasi!', 'success');
							$('.modal').modal('hide');
						},
						error: function (data) {
							setError(data);
						}
					});
				}
			});
		});

		// TOLAK PESANAN
		$(document).on('click', '#refuse-pesanan', function(e) {
			var id = $(this).attr('data-id');
			swal({
				title: "Tolak Pesanan?",
				html: "Pesanan akan ditolak. Lanjutkan?",
				type: "warning",
				confirmButtonText: 'Tolak',
				showCancelButton: true,
				confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
				cancelButtonClass: 'btn-white btn-md waves-effect',
				focusConfirm: true,
				preConfirm: () => {
					$.ajax({
						url: host + "/api/datapesanan/updatestatus/"+id,
						method: "PUT",
						data: { status: 'Refuse' },
						headers: headers,
						success: function (data) {
							getPesanan();
							swal('Selesai', 'Pesanan telah ditolak!', 'success');
							$('.modal').modal('hide');
						},
						error: function (data) {
							setError(data);
						}
					});
				}
			});
		});

		// DETAIL PESANAN
		$(document).on('click', '#detail-pesanan', function(e) {
			e.preventDefault();

			var id = $(this).attr('dta-id');

			$('.gmaps').attr('hidden', '');
			google.maps.event.addDomListener(window, 'load', initMap);
			$('#mapView'+id).removeAttr('hidden');

			$.ajax({
				url     : host+"/api/datapesanan/"+id,
				method  : "GET",
				headers : headers,
				success : function(data) {
					$.each(data.result, function(key, val) {
						$('#dtl_'+key).text(val);
						if (key == 'tanggal_antar') {
							var dt = new Date(val);
							var month = dt.getMonth();
							var date = dt.getDate();
							if (dt.getMonth() < 10) month = '0'+dt.getMonth();
							if (dt.getDate() < 10) date = '0'+dt.getDate();
							var tanggal = date+'/'+month+'/'+dt.getFullYear();
							$('#dtl_tanggal_antar').text(tanggal+' ('+data.result.waktu_antar+')');
						}
					});

					$('#dtl_paket').html('');
					$.each(data.result.paket, function(key, val) {
						$('#dtl_paket').append('<p>- '+val.nama_paket+' ('+val.jumlah+' pax)</p>');
					});

					var countAdt = 0;
					$('#dtl_additional').html('');
					$.each(data.result.additional, function(key, val) {
						$('#dtl_additional').append('<p>- '+val.nama_daging+'</p>');
						countAdt = countAdt + 1;
					});

					if (countAdt == 0) $('#dtl_additional').html('-');
				}
			});
		});
	});
</script>
@endsection
