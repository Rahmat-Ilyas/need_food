@extends('admin.layout')
@section('content')
<div class="content">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h4 class="page-title">Pesanan Diproses</h4>
				<ol class="breadcrumb">
					<li>
						<a href="#">Kesiniku</a>
					</li>
					<li>
						<a href="#">Data Pesanan</a>
					</li>
					<li class="active">
						Pesanan Diproses
					</li>
				</ol>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<ul class="nav nav-tabs tabs" style="width: 100%;">
					<li class="tab active" style="width: 25%;">
						<a href="#home-2" data-toggle="tab" aria-expanded="true" data-status="proccess" class="getStatus active"> 
							<span class="hidden-xs"><i class="md-access-time"></i> Diproses Dapur</span>
							<span class="badge badge-danger" id="badge-proccess" style="font-size: 11px; margin-bottom: 10px;">0</span> 
						</a> 
					</li> 
					<li class="tab" style="width: 25%;"> 
						<a href="#profile-2" data-toggle="tab" aria-expanded="false" data-status="delivery" class="getStatus "> 
							<span class="hidden-xs"><i class="md-local-shipping"></i> Pesanan Diantar</span>
							<span class="badge badge-danger" id="badge-delivery" style="font-size: 11px; margin-bottom: 10px;">0</span> 
						</a> 
					</li> 
					<li class="tab" style="width: 25%;"> 
						<a href="#messages-2" data-toggle="tab" aria-expanded="false" data-status="arrived" class="getStatus "> 
							<span class="hidden-xs"><i class="md-local-restaurant"></i> Pesanan Sampai</span>
							<span class="badge badge-danger" id="badge-arrived" style="font-size: 11px; margin-bottom: 10px;">0</span> 
						</a> 
					</li> 
					<li class="tab" style="width: 25%;"> 
						<a href="#settings-2" data-toggle="tab" aria-expanded="false" data-status="taking" class="getStatus "> 
							<span class="hidden-xs"><i class="fa fa-truck"></i> Pesanan Dijemput</span>
							<span class="badge badge-danger" id="badge-taking" style="font-size: 11px; margin-bottom: 10px;">0</span> 
						</a> 
					</li> 
				</ul>

				<div class="tab-content"> 
					<h4 class="m-b-20 header-title" style="margin-top: -10px;" id="titleStatus"><b>Diproses Dapur</b></h4>
					<table id="tabelDataPesanan" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th width="110">Kode Pesanan</th>
								<th>Nama</th>
								<th>Alamat</th>
								<th>Telepon</th>
								<th>WhatsApp</th>
								<th width="120">Jadwal Antar</th>
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
						<b class="col-sm-4 p-0">Metode Bayar: </b>
						<span class="col-sm-8 p-0" id="dtl_metode_bayar"></span>
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

		// SET MAPS 
		$.ajax({
			url     : host+"/configuration",
			method  : "POST",
			headers	: headers,
			data	: { req: 'setMapspesanandetail' },
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

		// GET STATUS 
		$('.getStatus').click(function(event) {
			var status = $(this).attr('data-status');
			$('#titleStatus').text($(this).children('.hidden-xs').text());
			getPesanan(status);
		});

		//GET PESANAN
		$('#tabelDataPesanan').DataTable({ "order": [] });
		getPesanan('proccess');
		function getPesanan(status) {
			badgeCount();
			var dataTable = $('#tabelDataPesanan').DataTable();
			dataTable.clear().draw();
			$.ajax({
				url     : host+"/api/datapesanan/status/"+status,
				method  : "GET",
				headers	: headers,
				success : function(data) {
					$.each(data.result, function(key, val) {
						var dt = new Date(val.tanggal_antar);
						var month = dt.getMonth()+1;
						var date = dt.getDate();
						if (month < 10) month = '0'+month;
						if (dt.getDate() < 10) date = '0'+dt.getDate();

						dataTable.row.add([
							val.kd_pemesanan,
							val.nama,
							val.deskripsi_lokasi,
							val.no_telepon,
							val.no_wa,
							date+'/'+month+'/'+dt.getFullYear()+' ('+val.waktu_antar+')',
							`<div class="text-center">
							<a href="#" role="button" class="btn btn-primary btn-sm waves-effect waves-light" id="detail-pesanan" dta-id="`+ val.id +`" data-toggle1="tooltip" title="Detail Pesanan" data-toggle="modal" data-target=".detail-pesanan"><i class="fa fa-eye"></i> Detail</a>
							</div>`,
							]).draw(false);
					});
				}
			});
		}

		// GET JUMLAH STATUS
		$('#badge-proccess, #badge-delivery, #badge-arrived, #badge-taking').hide();
		function badgeCount() {
			$.ajax({
				url     : host+"/configuration",
				method  : "POST",
				headers	: headers,
				data	: { req: 'badgeCount' },
				success : function(data) {
					console.log(data.proccess);
					if (data.proccess > 0) $('#badge-proccess').show().text(data.proccess);
					else $('#badge-proccess').hide().text(data.proccess);

					if (data.delivery > 0) $('#badge-delivery').show().text(data.delivery);
					else $('#badge-delivery').hide().text(data.delivery);

					if (data.arrived > 0) $('#badge-arrived').show().text(data.arrived);
					else $('#badge-arrived').hide().text(data.arrived);

					if (data.taking > 0) $('#badge-taking').show().text(data.taking);
					else $('#badge-taking').hide().text(data.taking);
				}
			});
		}

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
							var month = dt.getMonth()+1;
                            var date = dt.getDate();
                            if (month < 10) month = '0'+month;
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
						$('#dtl_additional').append('<p>- '+val.nama_daging+' ('+val.jumlah+' pax)</p>');
						countAdt = countAdt + 1;
					});

					if (countAdt == 0) $('#dtl_additional').html('-');
				}
			});
		});

		// NOTIF FIRBASE
		const messaging = firebase.messaging();

		messaging.onMessage((payload) => {
			console.log('Notification ', payload);
			getPesanan('proccess');
			notifCountView();
		});
	});
</script>
@endsection
