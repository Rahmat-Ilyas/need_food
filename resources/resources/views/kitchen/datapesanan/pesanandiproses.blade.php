@extends('kitchen.layout')
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
				<div class="card-box table-responsive">
					<h4 class="m-t-0 header-title"><b>Data Pesanan Diproses</b></h4>
					<table id="tabelPesananbaru" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th width="100">Kode Pesanan</th>
								<th>Nama</th>
								<th>Telepon</th>
								<th>WhatsApp</th>
								<th>Jadwal Antar</th>
								<th>Kategori Menu</th>
								<th>Catatan</th>
								<th width="60" class="text-center">Detail</th>
								<th width="60" class="text-center">Aksi</th>
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

<!-- MODAL DETAIL BAHAN PESANAN -->
<div class="modal detail-bahan-psn" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Detail Bahan Pesanan</h4>
			</div>
			<div class="modal-body" style="padding: 10px 40px 10px 40px">
				<h4><u>Bahan Paket</u></h4>
				<table class="table table-bordered" id="tableDetail" style="font-size: 13px;">
					<thead>
						<tr>
							<th width="10">No</th>
							<th>Foto Bahan</th>
							<th>Nama Bahan</th>
							<th>Ukuran Jumlah</th>
						</tr>
					</thead>
					<tbody id="data-bahan-pesanan">
						<tr>
							<td colspan="4" class="text-center">
								<i>Tidak ada data</i>
							</td>
						</tr>
					</tbody>
				</table>

				<h4><u>Additional Pesanan</u></h4>
				<table class="table table-bordered" id="tableDetailAdt" style="font-size: 13px;">
					<thead>
						<tr>
							<th width="10">No</th>
							<th>Foto Bahan</th>
							<th>Nama Daging</th>
							<th>Berat Daging</th>
							<th>Jumlah Pax</th>
						</tr>
					</thead>
					<tbody id="data-additional-pesanan">
						<tr>
							<td colspan="5" class="text-center">
								<i>Tidak ada additional untuk pesanan ini</i>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="text-right">
					<button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div><!-- /.modal-dialog -->
</div>

<!-- MODAL ATUR ALAT -->
<div class="modal set-alat" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<form id="formPilihAlat">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModalLabel">Atur Alat Pesanan Yang Akan Dikirim</h4>
				</div>
				<div class="modal-body" style="padding: 10px 40px 10px 40px">
					<table class="table table-bordered" id="tableDetail" style="font-size: 13px;">
						<thead>
							<tr>
								<th width="150">Kategori Alat</th>
								<th width="20">Jumlah</th>
								<th>Alat Dipilih</th>
							</tr>
						</thead>
						<tbody id="kategori-alat">
							
						</tbody>
					</table>
					<input type="hidden" name="pesanan_id" id="pesanan_id">
					<button type="submit" class="btn btn-default waves-effect">Simpan</button>
					<button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</form>
	</div><!-- /.modal-dialog -->
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

		//GET KATEGORI
		getPesanan();
		function getPesanan() {
			var dataTable = $('#tabelPesananbaru').DataTable();
			dataTable.clear().draw();
			$.ajax({
				url     : host+"/api/datapesanan/status/proccess",
				method  : "GET",
				headers	: headers,
				success : function(data, textStatus, xhr) {
					if (xhr.status == 200) {
						$.each(data.result, function(key, val) {
							var dt = new Date(val.tanggal_antar);
							var month = dt.getMonth()+1;
							var date = dt.getDate();
							if (month < 10) month = '0'+month;
							if (dt.getDate() < 10) date = '0'+dt.getDate();
							var katmenu = '';
							var target = '';
							var disabled = 'disabled';
							if (val.kategori_menu == 1) {
								katmenu = 'Home Service';
								target = '.set-alat';
								disabled = '';
							} else if (val.kategori_menu == 2) katmenu = 'Bahan Saja';
							else if (val.kategori_menu == 3) katmenu = 'Food Stall';
							dataTable.row.add([
								val.kd_pemesanan,
								val.nama,
								val.no_telepon,
								val.no_wa,
								date+'/'+month+'/'+dt.getFullYear()+' ('+val.waktu_antar+')',
								katmenu,
								val.catatan,
								`<div class="text-center">
								<a href="#" role="button" class="btn btn-info btn-sm waves-effect waves-light" id="detail-pesanan" dta-id="`+ val.id +`" data-toggle1="tooltip" title="Detail Pesanan" data-toggle="modal" data-target=".detail-pesanan"><i class="fa fa-eye"></i></a>
								<a href="#" role="button" class="btn btn-purple btn-sm waves-effect waves-light" id="detail-bahan-psn" dta-id="`+ val.id +`" data-toggle1="tooltip" title="Detail Bahan Pesanan" data-toggle="modal" data-target=".detail-bahan-psn"><i class="fa fa-shopping-basket"></i></a>`,
								`<a href="#" role="button" class="btn btn-primary btn-sm waves-effect waves-light" id="set-alat" dta-id="`+ val.id +`" data-toggle1="tooltip" title="Atur Alat Pesanan" data-toggle="modal" data-target="`+target+`"`+disabled+`><i class="md-restaurant-menu"></i></a>
								<a href="#" role="button" class="btn btn-success btn-sm waves-effect waves-light" id="selesai-packing" dta-id="`+ val.id +`" data-toggle1="tooltip" title="Selesai Packing"><i class="md-assignment-turned-in"></i></a>
								</div>`,
								]).draw(false);
						});
					}
				}
			});
			notifCountView();
		}

		$(document).on('click', '#detail-bahan-psn', function(event) {
			event.preventDefault();
			var id = $(this).attr('dta-id');

			$.ajax({
				url     : host+"/api/datapesanan/"+id,
				method  : "GET",
				headers	: headers,
				success : function(data) {
					if (data.result.bahan.length>0) {
						var colBahan = '';
						var no = 1;
						$.each(data.result.bahan, function(key, val) {
							var foto = getFoto(val.bahan_id);
							colBahan += `
							<tr>
							<td>`+no+`</td>
							<td>
							<img src="`+host+`/assets/images/bahan/`+foto+`" width="60">
							</td>
							<td>`+val.nama_bahan+`</td>
							<td>`+val.jumlah_bahan+`</td>
							</tr>
							`;
							no=no+1;
						});
						$('#data-bahan-pesanan').html(colBahan);
					}

					if (data.result.additional.length>0) {
						var colAdditional = '';
						var no = 1;
						$.each(data.result.additional, function(key, val) {
							var foto = getFoto(val.additional_id, 'adt');
							colAdditional += `
							<tr>
							<td>`+no+`</td>
							<td>
							<img src="`+host+`/assets/images/bahan/`+foto+`" width="60">
							</td>
							<td>`+val.nama_daging+`</td>
							<td>`+val.berat+`</td>
							<td>`+val.jumlah+` pax</td>
							</tr>
							`;
							no=no+1;
						});
						$('#data-additional-pesanan').html(colAdditional);
					}
				}
			});
		});

		function getFoto(id, adt=null) {
			var foto = '';
			if (!adt) {
				$.ajax({
					url     : host+"/api/inventori/getbahan/"+id,
					method  : "GET",
					headers	: headers,
					success : function(data) {
						if (data.result) {
							foto = data.result.foto;
						}
					},
					async: false
				});
			} else {
				$.ajax({
					url     : host+"/api/kelolamenu/getadditional/"+id,
					method  : "GET",
					headers	: headers,
					success : function(data) {
						if (data.result) {
							foto = data.result.foto;
						}
					},
					async: false
				});
			}
			return foto;
		}

		$(document).on('click', '#set-alat', function(event) {
			event.preventDefault();
			var id = $(this).attr('dta-id');
			$('#pesanan_id').val(id);

			$.ajax({
				url     : host+"/api/datapesanan/"+id,
				method  : "GET",
				headers	: headers,
				success : function(data) {
					var data = data.result.alat;
					$.ajax({
						url: host + "/configuration",
						method: "POST",
						headers: headers,
						data: { data: data, req: 'setAlatPilih' },
						success: function(result) {
							$('#kategori-alat').html(result);
							$('.select2').select2({
								placeholder: "Pilih Alat"
							});

							$.each(data, function(index, val) {
								cekAlatExits(val.kategori_alat_id)
							});
						}
					});
				}
			});
		});

		$(document).on('change', '.select2', function(event) {
			event.preventDefault();
			var ktgr_id = $(this).attr('ktgr-id');
			var alat_dipilih = $(this).val();

			$.ajax({
				url: host + "/configuration",
				method: "POST",
				headers: headers,
				data: { kategori_id: ktgr_id, alat_id: alat_dipilih, req: 'alatSelected' },
				success: function(data) {
					$('#pilih-alat'+ktgr_id).append(data);
					cekAlatExits(ktgr_id);
				}
			});
		});

		$(document).on('click', '#hapus-item', function(event) {
			var ktgr_id = $(this).attr('ktgr-id');
			$(this).parents('#this-remove').remove();
			cekAlatExits(ktgr_id);
		});

		function cekAlatExits(ktgr_id) {
			var data = $('#formPilihAlat').serialize();
			$.ajax({
				url: host + "/configuration",
				method: "POST",
				headers: headers,
				data: data+'&ktgr_id='+ktgr_id+'&req=cekAlatExits',
				success: function(data) {
					$('#alat-dipilih'+ktgr_id).html(data);
				}
			});
		}

		$(document).on('click', '#selesai-packing', function(event) {
			event.preventDefault();
			var id = $(this).attr('dta-id');
			var unset = null;

			$.ajax({
				url     : host+"/api/datapesanan/"+id,
				method  : "GET",
				headers	: headers,
				success : function(data) {
					var data = data.result.alat;
					$.each(data, function(index, val) {
						if (val.alat_dipilih.length == 0) unset = true;
					});

					if (unset) {
						Swal.fire({
							title: 'Alat Belum Diatur',
							text: 'Pastikan anda telah mengatur alat yang akan dikirim sebelum melakukan proses ini!',
							type: 'warning'
						});
					} else {
						$.ajax({
							url     : host+"/api/datapesanan/updatestatus/"+id,
							method  : "PUT",
							headers	: headers,
							data 	: { status: 'Delivery' },
							success : function(data) {
								getPesanan();
								Swal.fire({
									title: 'Berhasil Diproses',
									text: 'Pesanan telah diselesaikan, pemberitahuan akan di kirim ke Driver',
									type: 'success'
								});
							}, error: function (data) {
								Swal.fire({
									title: 'Gagal Diproses',
									text: data.message,
									type: 'error'
								});
							}
						});
					}
				}
			});
		});

		// SET MAPS
		$.ajax({
			url     : host+"/configuration",
			method  : "POST",
			headers	: headers,
			data	: { req: 'selesaiDiproses' },
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
			getPesanan();
			notifCountView();
		});
	});
</script>
@endsection
