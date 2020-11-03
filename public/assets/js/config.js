$(document).ready(function() {
	var url = $('#configurl').val();
	var host = $('#host').val();

	var headers = {
		"Accept"		: "application/json",
		"Authorization" : "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjA3YWE1Y2M3MDA1YTdjMDA2YzgwZWNjNjIxN2E4Y2VhOTUwMTEzMWNmM2MxOTVmMDk2YjJmZTAwY2I2MGI4ODAxNzE1ZGJmYjQ1YTYzMmIwIn0.eyJhdWQiOiIxIiwianRpIjoiMDdhYTVjYzcwMDVhN2MwMDZjODBlY2M2MjE3YThjZWE5NTAxMTMxY2YzYzE5NWYwOTZiMmZlMDBjYjYwYjg4MDE3MTVkYmZiNDVhNjMyYjAiLCJpYXQiOjE2MDA1MTI5NTEsIm5iZiI6MTYwMDUxMjk1MSwiZXhwIjoxNjMyMDQ4OTUwLCJzdWIiOiIxMyIsInNjb3BlcyI6W119.oHghL81Jc0xq-vvDVFde3QeqYs3s0Me6XukZtGy8G8HegV4LV2ImqKlpw_wdwxBOtKhBfodMFICi0YmNcPov7A",
	}

	$('.modal-add-alat').modal({
		backdrop: 'static',
		keyboard: false,
		show: false
	});

	function setError(data) {
		var error = '';
		result = data.responseJSON.message;
		$.each(result, function(key, val) {
			error = error + ' ' + val[0];
		});

		Swal.fire({
			title: 'Gagal Diproses',
			text: error,
			type: 'error'
		});
	}

	//GET ALAT
	function getAlat() {
		var dataTable = $('#dataTableAlat').DataTable();
		$.ajax({
			url     : host+"/api/inventori/getalat",
			method  : "GET",
			headers	: headers,
			success : function(data) {
				dataTable.clear().draw();
				var no = 1;
				$.each(data.result, function(key, val) {
					dataTable.row.add([
						no,
						`<a href="#" id="view-gambar-alat" data-toggle="modal" data-target="#modal-gambar-alat" data-id="`+ val.id +`">
						<img src="`+ host +`/assets/images/alat/`+ val.foto +`" class="img-responsive thumb-md">
						</a>`,
						val.kd_alat,
						val.nama,
						val.kategori,
						val.jumlah_alat+' pcs',
						val.alat_keluar+' pcs',
						val.sisa_alat+' pcs',
						`<div class="text-center">
						<a href="#" role="button" class="btn btn-info btn-sm waves-effect waves-light" id="detail-alat" dta-id="`+ val.id +`" data-toggle1="tooltip" title="Detail" data-toggle="modal" data-target=".detail-alat"><i class="fa fa-eye"></i></a>
						<a href="#" role="button" class="btn btn-success btn-sm waves-effect waves-light" data-toggle1="tooltip" title="Edit" data-toggle="modal" data-target=".detail-barang"><i class="fa fa-edit"></i></a>
						<a href="#" role="button" class="btn btn-danger btn-sm waves-effect waves-light" id="hapus-alat" dta-id="`+ val.id +`" data-toggle1="tooltip" title="Hapus" data-toggle="modal" data-target=".modal-delete"><i class="fa fa-trash"></i></a>
						</div>`,
						]).draw(false);
					no = no + 1;
				});
			}
		});
	}

	// DETAIL ALAT
	$(document).on('click', '#detail-alat', function(e) {
		var id = $(this).attr('dta-id');
		$('#collapseOne-2').addClass('in');

		$.ajax({
			url     : host+"/api/inventori/getalat/"+id,
			method  : "GET",
			headers	: headers,
			success : function(data) {
				$.each(data.result, function(el, val) {
					$('#dtl_'+el).text(val);
				});

				var tableDetail = $('#tableDetail').DataTable();
				tableDetail.clear().draw();
				var no = 1;
				$.each(data.result.riwayat_beli, function(key, vl) {
					tableDetail.row.add([
						no,
						vl.kd_beli,
						vl.created_at,
						vl.jumlah_beli+' pcs',
						'Rp. '+vl.total_harga,
						vl.supplier,
						]).draw(false);

					no = no + 1;
				});
			}
		});
	});

	// VIEW GAMBAR ALAT
	$(document).on('click', '#view-gambar-alat', function() {
		var id = $(this).attr('data-id');
		$('#setImage').attr('src', '');

		$.ajax({
			url     : host+"/api/inventori/getalat/"+id,
			method  : "GET",
			headers	: headers,
			success : function(data) {
				$('#setImage').attr('src', host + '/assets/images/alat/' + data.result.foto);
			}
		});
	});

	// ADD ALAT
	$('#fromAlat').submit(function(e) {
		e.preventDefault();
		var data = new FormData($(this)[0]);

		$.ajax({
			url     : host+"/api/inventori/setalat",
			enctype : "multipart/form-data",
			method  : "POST",
			data    : data,
			headers	: headers,
			xhr     : function() {
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener('progress', function(evt) {
					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;

						$('#viewProgress').removeAttr('hidden');
						$('#upload').attr('disabled', '');
						$('#batal').attr('disabled', '');

						var progress = Math.round(percentComplete * 100);
						$('#progress').text(progress + '%');
					}
				}, false);
				return xhr;
			},
			contentType : false,
			processData: false,
			success : function(data) {
				getAlat();
				$('#viewProgress').attr('hidden', '');
				$('#upload').removeAttr('disabled');
				$('#batal').removeAttr('disabled');
				$('#progress').text('0%');
				$('#fromAlat')[0].reset();

				Swal.fire({
					title: 'Berhasil Diproses',
					text: 'Data alat baru berhasil ditambah',
					type: 'success',
					onClose: () => {
						$('.modal-add-alat').modal('hide');
					}
				});
			}, 
			error: function(data) {
				$('#viewProgress').attr('hidden', '');
				$('#upload').removeAttr('disabled');
				$('#batal').removeAttr('disabled');
				$('#progress').text('0%');

				setError(data);
			}
		});
	});

	// ADD STOK ALAT
	$('#fromStokAlat').submit(function(ev) {
		ev.preventDefault();
		var data = $(this).serialize();

		$.ajax({
			url     : host+"/api/inventori/setstokalat",
			method  : "POST",
			data    : data,
			headers	: headers,
			success : function(data) {
				getAlat();
				$('#fromStokAlat')[0].reset();
				$('#nama_alat').select2({ placeholder: 'Pilih Alat', allowClear: true });

				Swal.fire({
					title: 'Berhasil Diproses',
					text: 'Data alat baru berhasil ditambah',
					type: 'success',
					onClose: () => {
						$('.modal-add-stok').modal('hide');
					}
				});
			}, 
			error: function(data) {
				setError(data);
			}
		});
	});

	// DELETE ALAT
	$('#delete-alat').click(function() {
		var id = $(this).attr('data-id');

		$.ajax({
			url     : host+"/api/inventori/deletealat/"+id,
			method  : "DELETE",
			headers	: headers,
			success : function(data) {
				getAlat();

				Swal.fire({
					title: 'Berhasil Diproses',
					text: 'Data berhasil dihapus',
					type: 'success',
					onClose: () => {
						$('.modal-delete').modal('hide');
					}
				});
			}, 
			error: function(data) {
				setError(data);
			}
		});
	});

	//GET BAHAN
	function getBahan() {
		var dataTable = $('#dataTableBahan').DataTable();
		$.ajax({
			url     : host+"/api/inventori/getbahan",
			method  : "GET",
			headers	: headers,
			success : function(data) {
				dataTable.clear().draw();
				var no = 1;
				$.each(data.result, function(key, val) {
					dataTable.row.add([
						no,
						`<a href="#" id="view-gambar-bahan" data-toggle="modal" data-target="#modal-gambar-bahan" data-id="`+ val.id +`">
						<img src="`+ host +`/assets/images/bahan/`+ val.foto +`" class="img-responsive thumb-md">
						</a>`,
						val.kd_bahan,
						val.nama,
						val.kategori,
						val.jumlah_bahan+' '+val.satuan,
						`<div class="text-center">
						<a href="#" role="button" class="btn btn-info btn-sm waves-effect waves-light" id="detail-bahan" dta-id="`+ val.id +`" data-toggle1="tooltip" title="Detail" data-toggle="modal" data-target=".detail-bahan"><i class="fa fa-eye"></i></a>
						<a href="#" role="button" class="btn btn-success btn-sm waves-effect waves-light" data-toggle1="tooltip" title="Edit" data-toggle="modal" data-target=".detail-barang"><i class="fa fa-edit"></i></a>
						<a href="#" role="button" class="btn btn-danger btn-sm waves-effect waves-light" data-toggle1="tooltip" title="Hapus" data-toggle="modal" data-target=".detail-barang"><i class="fa fa-trash"></i></a>
						</div>`,
						]).draw(false);
					no = no + 1;
				});
			}
		});
	}

	// VIEW GAMBAR BAHAN
	$(document).on('click', '#view-gambar-bahan', function() {
		var id = $(this).attr('data-id');
		$('#setImage').attr('src', '');

		$.ajax({
			url     : host+"/api/inventori/getbahan/"+id,
			method  : "GET",
			headers	: headers,
			success : function(data) {
				$('#setImage').attr('src', host + '/assets/images/bahan/' + data.result.foto);
			}
		});
	});

	// ADD BAHAN
	$('#fromBahan').submit(function(e) {
		e.preventDefault();
		var data = new FormData($(this)[0]);

		$.ajax({
			url     : host+"/api/inventori/setbahan",
			enctype : "multipart/form-data",
			method  : "POST",
			data    : data,
			headers	: headers,
			xhr     : function() {
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener('progress', function(evt) {
					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;

						$('#viewProgress').removeAttr('hidden');
						$('#upload').attr('disabled', '');
						$('#batal').attr('disabled', '');

						var progress = Math.round(percentComplete * 100);
						$('#progress').text(progress + '%');
					}
				}, false);
				return xhr;
			},
			contentType : false,
			processData: false,
			success : function(data) {
				getBahan();
				$('#viewProgress').attr('hidden', '');
				$('#upload').removeAttr('disabled');
				$('#batal').removeAttr('disabled');
				$('#progress').text('0%');
				$('#fromBahan')[0].reset();

				Swal.fire({
					title: 'Berhasil Diproses',
					text: 'Data bahan baru berhasil ditambah',
					type: 'success',
					onClose: () => {
						$('.modal-add-bahan').modal('hide');
					}
				});
			}, 
			error: function(data) {
				$('#viewProgress').attr('hidden', '');
				$('#upload').removeAttr('disabled');
				$('#batal').removeAttr('disabled');
				$('#progress').text('0%');

				setError(data);
			}
		});
	});

	// ADD STOK ALAT
	$('#fromStokBahan').submit(function(ev) {
		ev.preventDefault();
		var data = $(this).serialize();

		$.ajax({
			url     : host+"/api/inventori/setstokbahan",
			method  : "POST",
			data    : data,
			headers	: headers,
			success : function(data) {
				getBahan();
				$('#fromStokBahan')[0].reset();
				$('#nama_bahan').select2({ placeholder: 'Pilih Bahan', allowClear: true });

				Swal.fire({
					title: 'Berhasil Diproses',
					text: 'Data bahan baru berhasil ditambah',
					type: 'success',
					onClose: () => {
						$('.modal-add-stok').modal('hide');
					}
				});
			}, 
			error: function(data) {
				setError(data);
			}
		});
	});

	// DELETE ALAT
	$('#delete-bahan').click(function() {
		var id = $(this).attr('data-id');

		$.ajax({
			url     : host+"/api/inventori/deletebahan/"+id,
			method  : "DELETE",
			headers	: headers,
			success : function(data) {
				getBahan();

				Swal.fire({
					title: 'Berhasil Diproses',
					text: 'Data berhasil dihapus',
					type: 'success',
					onClose: () => {
						$('.modal-delete').modal('hide');
					}
				});
			}, 
			error: function(data) {
				setError(data);
			}
		});
	});

	// GET KATEGORI
	function getKategori() {
		var dataTable = $('#tableKategori').DataTable();
		$.ajax({
			url     : host+"/api/inventori/getkategori",
			method  : "GET",
			headers	: headers,
			success : function(data) {
				dataTable.clear().draw();
				var no = 1;
				$.each(data.result, function(key, val) {
					dataTable.row.add([
						no,
						`<a href="#" id="view-gambar-kategori" data-toggle="modal" data-target="#modal-gambar-kategori" data-id="`+ val.id +`">
						<img src="`+ host +`/assets/images/kategori/`+ val.foto +`" class="img-responsive thumb-md">
						</a>`,
						val.kategori,
						val.jenis,
						`<div class="text-center">
						<button type="button" class="btn btn-success btn-sm waves-effect waves-light" id="edit-kategori" data-toggle1="tooltip" title="Edit" data-toggle="modal" data-target=".modal-edit" data-id="`+ val.id +`"><i class="fa fa-edit"></i></button>
						<button type="button" class="btn btn-danger btn-sm waves-effect waves-light" id="hapus-kategori" data-toggle1="tooltip" title="Hapus" data-toggle="modal" data-target=".modal-delete" data-id="`+ val.id +`"><i class="fa fa-trash"></i></button>
						</div>`,
						]).draw(false);
					no = no + 1;
				});
			}
		});
	}

	// SET KATEGORI
	$('#fromKategori').submit(function(ev) {
		ev.preventDefault();
		var data = new FormData($(this)[0]);

		$.ajax({
			url     : host+"/api/inventori/setkategori",
			enctype : "multipart/form-data",
			method  : "POST",
			data    : data,
			headers	: headers,
			xhr     : function() {
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener('progress', function(evt) {
					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;

						$('#viewProgress').removeAttr('hidden');
						$('#upload').attr('disabled', '');
						$('#batal').attr('disabled', '');

						var progress = Math.round(percentComplete * 100);
						$('#progress').text(progress + '%');
					}
				}, false);
				return xhr;
			},
			contentType : false,
			processData: false,
			success : function(data) {
				getKategori();
				$('#viewProgress').attr('hidden', '');
				$('#upload').removeAttr('disabled');
				$('#batal').removeAttr('disabled');
				$('#progress').text('0%');
				$('#fromKategori')[0].reset();

				Swal.fire({
					title: 'Berhasil Diproses',
					text: 'Data alat baru berhasil ditambah',
					type: 'success',
					onClose: () => {
						$('.modal-add').modal('hide');
					}
				});
			}, 
			error: function(data) {
				$('#viewProgress').attr('hidden', '');
				$('#upload').removeAttr('disabled');
				$('#batal').removeAttr('disabled');
				$('#progress').text('0%');

				setError(data);
			}
		});
	});

	// PUT KATEGORI
	$('#fromEdtKategori').submit(function(ev) {
		ev.preventDefault();
		var data = $(this).serialize();
		var id = $('#edt_id').val();

		$.ajax({
			url     : host+"/api/inventori/editkategori/"+id,
			method  : "PUT",
			data    : data,
			headers	: headers,
			success : function(data) {
				$('#fromEdtKategori')[0].reset();
				getKategori();

				Swal.fire({
					title: 'Berhasil Diproses',
					text: 'Data berhasil diupdate',
					type: 'success',
					onClose: () => {
						$('.modal-edit').modal('hide');
					}
				});
			}, 
			error: function(data) {
				setError(data);
			}
		});
	});

	// DELETE KATEGORI
	$('#delete-kategori').click(function() {
		var id = $(this).attr('data-id');

		$.ajax({
			url     : host+"/api/inventori/deletekategori/"+id,
			method  : "DELETE",
			headers	: headers,
			success : function(data) {
				getKategori();

				Swal.fire({
					title: 'Berhasil Diproses',
					text: 'Data berhasil dihapus',
					type: 'success',
					onClose: () => {
						$('.modal-delete').modal('hide');
					}
				});
			}, 
			error: function(data) {
				setError(data);
			}
		});
	});

	// GET SUPPLIER
	function getSupplier() {
		var dataTable = $('#tableSupplier').DataTable();
		$.ajax({
			url     : host+"/api/getsupplier",
			method  : "GET",
			headers	: headers,
			success : function(data) {
				dataTable.clear().draw();
				var no = 1;
				$.each(data.result, function(key, val) {
					dataTable.row.add([
						no,
						val.nama_supplier,
						val.alamat,
						val.telepon,
						val.email,
						val.kategori,
						`<div class="text-center">
						<button type="button" class="btn btn-success btn-sm waves-effect waves-light" id="edit-supplier" data-toggle1="tooltip" title="Edit" data-toggle="modal" data-target=".modal-edit" data-id="`+ val.id +`"><i class="fa fa-edit"></i></button>
						<button type="button" class="btn btn-danger btn-sm waves-effect waves-light" id="hapus-supplier" data-toggle1="tooltip" title="Hapus" data-toggle="modal" data-target=".modal-delete" data-id="`+ val.id +`"><i class="fa fa-trash"></i></button>
						</div>`,
						]).draw(false);
					no = no + 1;
				});
			}
		});
	}

	// SET KATEGORI
	$('#fromSupplier').submit(function(ev) {
		ev.preventDefault();
		var data = $(this).serialize();

		$.ajax({
			url     : host+"/api/setsupplier",
			method  : "POST",
			data    : data,
			headers	: headers,
			success : function(data) {
				$('#fromSupplier')[0].reset();
				getSupplier();

				Swal.fire({
					title: 'Berhasil Diproses',
					text: 'Data supplier baru berhasil ditambah',
					type: 'success',
					onClose: () => {
						$('.modal-add').modal('hide');
					}
				});
			}, 
			error: function(data) {
				setError(data);
			}
		});
	});

	// PUT SUPPLIER
	$('#fromEdtSupplier').submit(function(ev) {
		ev.preventDefault();
		var data = $(this).serialize();
		var id = $('#id').val();

		$.ajax({
			url     : host+"/api/editsupplier/"+id,
			method  : "PUT",
			data    : data,
			headers	: headers,
			success : function(data) {
				$('#fromEdtSupplier')[0].reset();
				getSupplier();

				Swal.fire({
					title: 'Berhasil Diproses',
					text: 'Data berhasil diupdate',
					type: 'success',
					onClose: () => {
						$('.modal-edit').modal('hide');
					}
				});
			}, 
			error: function(data) {
				setError(data);
			}
		});
	});

	// DELETE SUPPLIER
	$('#delete-supplier').click(function() {
		var id = $(this).attr('data-id');

		$.ajax({
			url     : host+"/api/deletesupplier/"+id,
			method  : "DELETE",
			headers	: headers,
			success : function(data) {
				getSupplier();

				Swal.fire({
					title: 'Berhasil Diproses',
					text: 'Data berhasil dihapus',
					type: 'success',
					onClose: () => {
						$('.modal-delete').modal('hide');
					}
				});
			}, 
			error: function(data) {
				setError(data);
			}
		});
	});

	// GET PAKET
	function getPaket() {
		var dataTable = $('#tableKategori').DataTable();
		$.ajax({
			url     : host+"/api/inventori/getkategori",
			method  : "GET",
			headers	: headers,
			success : function(data) {
				dataTable.clear().draw();
				var no = 1;
				$.each(data.result, function(key, val) {
					dataTable.row.add([
						no,
						val.kategori,
						val.jenis,
						`<div class="text-center">
						<button type="button" class="btn btn-success btn-sm waves-effect waves-light" id="edit-kategori" data-toggle1="tooltip" title="Edit" data-toggle="modal" data-target=".modal-edit" data-id="`+ val.id +`"><i class="fa fa-edit"></i></button>
						<button type="button" class="btn btn-danger btn-sm waves-effect waves-light" id="hapus-kategori" data-toggle1="tooltip" title="Hapus" data-toggle="modal" data-target=".modal-delete" data-id="`+ val.id +`"><i class="fa fa-trash"></i></button>
						</div>`,
						]).draw(false);
					no = no + 1;
				});
			}
		});
	}

	// ADD PAKET
	$('#fromPaket').submit(function(e) {
		e.preventDefault();
		var data = new FormData($(this)[0]);

		$.ajax({
			url     : host+"/api/kelolamenu/setpaket",
			enctype : "multipart/form-data",
			method  : "POST",
			data    : data,
			headers	: headers,
			xhr     : function() {
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener('progress', function(evt) {
					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;

						$('#viewProgress').removeAttr('hidden');
						$('#upload').attr('disabled', '');
						$('#batal').attr('disabled', '');

						var progress = Math.round(percentComplete * 100);
						$('#progress').text(progress + '%');
					}
				}, false);
				return xhr;
			},
			contentType : false,
			processData: false,
			success : function(data) {
				console.log(data);
				getPaket();
				$('#viewProgress').attr('hidden', '');
				$('#upload').removeAttr('disabled');
				$('#batal').removeAttr('disabled');
				$('#progress').text('0%');
				$('#fromPaket')[0].reset();
				$('#item').html('');
				$('#tambah-item').removeClass('disabled');
				$('#reset').css('display', 'none');

				Swal.fire({
					title: 'Berhasil Diproses',
					text: 'Data paket baru berhasil ditambah',
					type: 'success',
					onClose: () => {
						$('.modal-add-paket').modal('hide');
					}
				});
			}, 
			error: function(data) {
				$('#viewProgress').attr('hidden', '');
				$('#upload').removeAttr('disabled');
				$('#batal').removeAttr('disabled');
				$('#progress').text('0%');

				setError(data);
			}
		});
	});
});