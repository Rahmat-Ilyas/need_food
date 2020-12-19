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
<div class="modal set-alat" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Detail Alat</h4>
			</div>
			<div class="modal-body" style="padding: 10px 40px 10px 40px">
				<table class="table table-bordered" id="tableDetail" style="font-size: 13px;">
					<thead>
						<tr>
							<th width="200">Kategori Alat</th>
							<th>Alat Dipilih</th>
						</tr>
					</thead>
					<tbody id="kategori-alat">
						<tr>
							<td>Kompor</td>
							<td>
								<div class="form-group form-inline row">
									<div class="col-sm-9">
										<input type="hidden" name="id" id="id">
			                            <select class="form-control select2" style="height: 35px; width: 100%;" id="daging_edt" required="">
			                                
			                            </select>
									</div>
									<div class="col-sm-3">
										<a href="#" class="btn btn-primary btn-sm btn-block"><i class="fa fa-plus" id="tambah-item"></i> Tambah Alat</a>
									</div>
								</div>
								<table class="table m-b-0">
									<tbody id="pilih-alat">
										<tr>
											<td width="250">Kompor Konvina</td>
											<td class="row">
												<div class="col-sm-8">
													<input type="hidden" name="kategori_id[]">
													<input type="hidden" name="alat_id[]" id="alat_id">
													<input type="number" class="form-control" name="jumlah[]" placeholder="Jumlah..." style="height: 35px; width: 100%;">
												</div>
												<div class="col-sm-4 p-0">
													<input type="text" class="form-control" value="PCS" disabled style="height: 35px;">
												</div>
											</div>
											</td>
											<td width="50">
												<a href="#" class="btn btn-danger btn-sm" id="hapus-item"><i class="fa fa-trash"></i> Hapus Alat</a>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
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
				url     : host+"/api/datapesanan",
				method  : "GET",
				headers	: headers,
				success : function(data) {
					dataTable.clear().draw();
					$.each(data.result, function(key, val) {
						var dt = new Date(val.tanggal_antar);
						dataTable.row.add([
							val.kd_pemesanan,
							val.nama,
							val.no_telepon,
							val.no_wa,
							dt.getDate()+'/'+dt.getMonth()+'/'+dt.getYear()+' ('+val.waktu_antar+')',
							val.deskripsi_lokasi,
							val.catatan,
							`<div class="text-center">
							<a href="#" role="button" class="btn btn-info btn-sm waves-effect waves-light" id="set-alat" dta-id="`+ val.id +`" data-toggle1="tooltip" title="Set Alat Pesanan" data-toggle="modal" data-target=".set-alat"><i class="md-restaurant-menu"></i> Set Alat</a>
							</div>`,
							]).draw(false);
					});
				}
			});
		}

		$(document).on('click', '#set-alat', function(event) {
			event.preventDefault();
			var id = $(this).attr('dta-id');

			$.ajax({
				url     : host+"/api/datapesanan/"+id,
				method  : "GET",
				headers	: headers,
				success : function(data) {
					console.log(data.result)
				}
			});
		});
	});
</script>
@endsection
