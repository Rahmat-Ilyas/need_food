$(document).ready(function() {
	var url = $('#configurl').val();
	var host = $('#host').val();

	var headers = {
		"Content-Type"  : "application/x-www-form-urlencoded",
		"Accept"		: "application/json",
		"Authorization" : "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjA3YWE1Y2M3MDA1YTdjMDA2YzgwZWNjNjIxN2E4Y2VhOTUwMTEzMWNmM2MxOTVmMDk2YjJmZTAwY2I2MGI4ODAxNzE1ZGJmYjQ1YTYzMmIwIn0.eyJhdWQiOiIxIiwianRpIjoiMDdhYTVjYzcwMDVhN2MwMDZjODBlY2M2MjE3YThjZWE5NTAxMTMxY2YzYzE5NWYwOTZiMmZlMDBjYjYwYjg4MDE3MTVkYmZiNDVhNjMyYjAiLCJpYXQiOjE2MDA1MTI5NTEsIm5iZiI6MTYwMDUxMjk1MSwiZXhwIjoxNjMyMDQ4OTUwLCJzdWIiOiIxMyIsInNjb3BlcyI6W119.oHghL81Jc0xq-vvDVFde3QeqYs3s0Me6XukZtGy8G8HegV4LV2ImqKlpw_wdwxBOtKhBfodMFICi0YmNcPov7A",
	}

	$('.modal-add-alat').modal({
      backdrop: 'static',
      keyboard: false,
      show: false
    });

	//GET SUPPLIER
	$.ajax({
		url     : host+"/api/getsupplier",
		method  : "GET",
		headers	: headers,
		success : function(data) {
			$.each(data.result, function(key, val) {
				$('#supplier').append('<option value="' + val.id + '">' + val.nama_supplier + '</option>');		
			});
		}
	});

	//GET ALAT
	getAlat();
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
						<a href="#" role="button" class="btn btn-info btn-sm waves-effect waves-light" data-toggle1="tooltip" title="Detail" data-toggle="modal" data-target=".detail-barang"><i class="fa fa-eye"></i></a>
						<a href="#" role="button" class="btn btn-success btn-sm waves-effect waves-light" data-toggle1="tooltip" title="Edit" data-toggle="modal" data-target=".detail-barang"><i class="fa fa-edit"></i></a>
						<a href="#" role="button" class="btn btn-danger btn-sm waves-effect waves-light" data-toggle1="tooltip" title="Hapus" data-toggle="modal" data-target=".detail-barang"><i class="fa fa-trash"></i></a>
						</div>`,
						]).draw(false);
					no = no + 1;
				});
			}
		});
	}

	// VIEW GAMBAR
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
      var data = new FormData($('#fromAlat')[0]);

      $.ajax({
        url     : 'controller.php',
        method  : "POST",
        data    : data,
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
          viewData();
          $('#viewProgress').attr('hidden', '');
          $('#upload').removeAttr('disabled');
          $('#batal').removeAttr('disabled');
          $('#progress').text('0%');

          $('.modal-add-alat').modal('hide');
        }
      });
    });
});