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
				<form id="form-check">
					<div class="card-box table-responsive">
						<h4 class="m-t-0 header-title"><b>Data Pesanan</b></h4>
						<table class="tablesaw table table-bordered">
							<thead>
								<tr>
									<th class="text-center" style="width: 10px;">
										<input type="checkbox" id="chek-all">
									</th>
									<th>Kode Pesanan</th>
									<th>Nama</th>
									<th>Telepon</th>
									<th>WhatsApp</th>
									<th>Alamat</th>
								</tr>
							</thead>
							<tbody id="tb-print">

							</tbody>
						</table>
						<button type="button" class="btn btn-default btn-rounded waves-effect waves-light m-t-10 m-b-20 btn-sm" id="action-print"><i class="fa fa-print"></i> &nbsp;Print Label</button>
					</div>
				</form>
			</div>
			<div class="col-sm-12" hidden="">
				<div class="card-box row print" id="label-print">

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
					$.each(data.result, function(key, val) {
						$('#tb-print').append(`
							<tr>
							<td>
							<input type="checkbox" id="chek-print" value="`+ val.id +`" name="val_chek[]">
							</td>
							<td>`+ val.kd_pemesanan +`</td>
							<td>`+ val.nama +`</td>
							<td>`+ val.no_telepon +`</td>
							<td>`+ val.no_wa +`</td>
							<td>`+ val.deskripsi_lokasi +`</td>
							</tr>
							`);
					});
				}
			});
		}

		$(document).on('click', '#action-print', function(e) {
			e.preventDefault();
			var data = $('#form-check').serialize();

			$.ajax({
				url     : host+"/configuration",
				method  : "POST",
				headers	: headers,
				data	: data+'&req=getdataprint',
				success : function(data) {
					$('#label-print').html('');
					$.each(data.result, function(key, val) {
						$('#label-print').append(`
							<div style="width: 50%; float: left; padding-left: 10px;">
							<div class="card-box text-center" style="font-size: 11px;">
							<h4 class="m-t-0"><b>`+ val.kd_pemesanan +`</b></h4>
							<p class="m-b-0"><b>`+ val.nama +`</b></p>
							<p class="m-b-0">`+ val.no_telepon +`/`+ val.no_wa +`</p>
							<p class="m-b-0">`+ val.deskripsi_lokasi +`</p>
							</div>
							</div>
							`);
					});

					if (data.result) {
						$('.print').printArea();
					}
				}
			});
		});

		$('#chek-all').click(function(event) {
			$('input:checkbox').not(this).prop('checked', this.checked);
		});

		$(document).on('click', '#chek-print', function(event) {
			$('#chek-all').prop('checked', false);
		});

	});
</script>
@endsection
