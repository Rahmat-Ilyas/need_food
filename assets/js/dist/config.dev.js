"use strict";

$(document).ready(function () {
  var url = $('#configurl').val();
  var host = $('#host').val();
  var headers = {
    "Accept": "application/json",
    "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjA3YWE1Y2M3MDA1YTdjMDA2YzgwZWNjNjIxN2E4Y2VhOTUwMTEzMWNmM2MxOTVmMDk2YjJmZTAwY2I2MGI4ODAxNzE1ZGJmYjQ1YTYzMmIwIn0.eyJhdWQiOiIxIiwianRpIjoiMDdhYTVjYzcwMDVhN2MwMDZjODBlY2M2MjE3YThjZWE5NTAxMTMxY2YzYzE5NWYwOTZiMmZlMDBjYjYwYjg4MDE3MTVkYmZiNDVhNjMyYjAiLCJpYXQiOjE2MDA1MTI5NTEsIm5iZiI6MTYwMDUxMjk1MSwiZXhwIjoxNjMyMDQ4OTUwLCJzdWIiOiIxMyIsInNjb3BlcyI6W119.oHghL81Jc0xq-vvDVFde3QeqYs3s0Me6XukZtGy8G8HegV4LV2ImqKlpw_wdwxBOtKhBfodMFICi0YmNcPov7A",
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
  };
  $('.modal-add-alat').modal({
    backdrop: 'static',
    keyboard: false,
    show: false
  });

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
  } //GET ALAT


  function getAlat() {
    $("#dataTableAlat").dataTable().fnDestroy();
    $('#dataTableAlat').DataTable({
      processing: true,
      serverSide: true,
      ajax: host + '/datatable?req=dtGetAlat',
      columns: [{
        data: 'no',
        name: 'no'
      }, {
        data: 'foto',
        name: 'foto',
        orderable: false,
        searchable: false
      }, {
        data: 'kd_alat',
        name: 'kd_alat'
      }, {
        data: 'nama',
        name: 'nama'
      }, {
        data: 'kategori',
        name: 'kategori'
      }, {
        data: 'jumlah_alat',
        name: 'jumlah_alat'
      }, {
        data: 'alat_keluar',
        name: 'alat_keluar'
      }, {
        data: 'sisa_alat',
        name: 'sisa_alat'
      }, {
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false
      }]
    });
  } // DETAIL ALAT


  $(document).on('click', '#detail-alat', function (e) {
    var id = $(this).attr('dta-id');
    $('#collapseOne-2').addClass('in');
    detailAlat(id);
  });

  function detailAlat(id) {
    $.ajax({
      url: host + "/api/inventori/getalat/" + id,
      method: "GET",
      headers: headers,
      success: function success(data) {
        $.each(data.result, function (el, val) {
          $('#dtl_' + el).text(val);
        });
        var tableDetail = $('#tableDetail').DataTable();
        tableDetail.clear().draw();
        var no = 1;
        $.each(data.result.riwayat_beli, function (key, vl) {
          tableDetail.row.add([no, vl.kd_beli, vl.created_at, vl.jumlah_beli + ' pcs', 'Rp. ' + vl.total_harga, '<a href="#" id="detail-supplier" data-id="' + vl.supplier_id + '">' + vl.supplier + '</a>', "<td class=\"text-center\">\n\t\t\t\t\t\t<a href=\"#\" class=\"text-primary\" id=\"edit-add-alat\" data-id=\"" + vl.id + "\"><i class=\"fa fa-pencil\"></i></a>&nbsp;\n\t\t\t\t\t\t<a href=\"#\" class=\"text-danger\" id=\"delete-add-alat\" data-id=\"" + vl.id + "\"><i class=\"fa fa-trash-o\"></i></a>\n\t\t\t\t\t\t</td>"]).draw(false);
          no = no + 1;
        });
      }
    });
  } // EDIT ADD ALAT


  $(document).on('click', '#edit-add-alat', function (e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    $.ajax({
      url: host + "/configuration",
      method: "POST",
      headers: headers,
      data: {
        req: 'databelialat',
        id: id
      },
      success: function success(data) {
        swal({
          title: "Edit Data Pembelian",
          html: data,
          showCancelButton: true,
          confirmButtonClass: 'btn-primary btn-md waves-effect waves-light',
          cancelButtonClass: 'btn-white btn-md waves-effect',
          confirmButtonText: 'Update',
          focusConfirm: false,
          preConfirm: function preConfirm() {
            var data = $('#alatPembelian').serialize();
            $.ajax({
              url: host + "/configuration",
              method: "POST",
              headers: headers,
              data: data + '&id=' + id + '&req=updatealatbeli',
              success: function success(data) {
                getAlat();
                detailAlat(data.id);
                swal(data.title, data.message, data.status);
              }
            });
          }
        });
      }
    });
  }); // HAPUS ADD ALAT

  $(document).on('click', '#delete-add-alat', function (e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    swal({
      title: "Yakin Ingin Menghapus?",
      html: "Data pembelian ini akan di hapus!",
      type: "error",
      showCancelButton: true,
      cancelButtonClass: 'btn-white btn-md waves-effect',
      confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
      confirmButtonText: 'Hapus',
      focusConfirm: false,
      preConfirm: function preConfirm() {
        $.ajax({
          url: host + "/configuration",
          method: "POST",
          headers: headers,
          data: {
            req: 'deletealatbeli',
            id: id
          },
          success: function success(data) {
            getAlat();
            detailAlat(data.id);
            swal(data.title, data.message, data.status);
          }
        });
      }
    });
  }); // VIEW GAMBAR ALAT

  $(document).on('click', '#view-gambar-alat', function () {
    var id = $(this).attr('data-id');
    $('#setImage').attr('src', '');
    $.ajax({
      url: host + "/api/inventori/getalat/" + id,
      method: "GET",
      headers: headers,
      success: function success(data) {
        $('#setImage').attr('src', host + '/assets/images/alat/' + data.result.foto);
      }
    });
  }); // ADD ALAT

  $('#fromAlat').submit(function (e) {
    e.preventDefault();
    var data = new FormData($(this)[0]);
    $.ajax({
      url: host + "/api/inventori/setalat",
      enctype: "multipart/form-data",
      method: "POST",
      data: data,
      headers: headers,
      xhr: function xhr() {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener('progress', function (evt) {
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
      contentType: false,
      processData: false,
      success: function success(data) {
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
          onClose: function onClose() {
            $('.modal-add-alat').modal('hide');
          }
        });
      },
      error: function error(data) {
        $('#viewProgress').attr('hidden', '');
        $('#upload').removeAttr('disabled');
        $('#batal').removeAttr('disabled');
        $('#progress').text('0%');
        setError(data);
      }
    });
  }); // EDIT ALAT

  $('#fromEditAlat').submit(function (e) {
    e.preventDefault();
    var data = new FormData(this);
    var id = $('#edt_id').val();
    $.ajax({
      url: host + "/api/inventori/editalat/" + id,
      enctype: "multipart/form-data",
      method: "POST",
      data: data,
      headers: headers,
      xhr: function xhr() {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener('progress', function (evt) {
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
      contentType: false,
      processData: false,
      cache: false,
      success: function success(data) {
        getAlat();
        $('#viewProgress').attr('hidden', '');
        $('#upload').removeAttr('disabled');
        $('#batal').removeAttr('disabled');
        $('#progress').text('0%');
        $('#fromEditAlat')[0].reset();
        Swal.fire({
          title: 'Berhasil Diproses',
          text: 'Data alat berhasil diupdate',
          type: 'success',
          onClose: function onClose() {
            $('.modal-edit-alat').modal('hide');
          }
        });
      },
      error: function error(data) {
        $('#viewProgress').attr('hidden', '');
        $('#upload').removeAttr('disabled');
        $('#batal').removeAttr('disabled');
        $('#progress').text('0%');
        setError(data);
      }
    });
  }); // ADD STOK ALAT

  $('#fromStokAlat').submit(function (ev) {
    ev.preventDefault();
    var data = $(this).serialize();
    $.ajax({
      url: host + "/api/inventori/setstokalat",
      method: "POST",
      data: data,
      headers: headers,
      success: function success(data) {
        getAlat();
        $('#fromStokAlat')[0].reset();
        $('#nama_alat').select2({
          placeholder: 'Pilih Alat',
          allowClear: true
        });
        Swal.fire({
          title: 'Berhasil Diproses',
          text: 'Data alat baru berhasil ditambah',
          type: 'success',
          onClose: function onClose() {
            $('.modal-add-stok').modal('hide');
          }
        });
      },
      error: function error(data) {
        setError(data);
      }
    });
  }); // DELETE ALAT

  $('#delete-alat').click(function () {
    var id = $(this).attr('data-id');
    $.ajax({
      url: host + "/api/inventori/deletealat/" + id,
      method: "DELETE",
      headers: headers,
      success: function success(data) {
        getAlat();
        Swal.fire({
          title: 'Berhasil Diproses',
          text: 'Data berhasil dihapus',
          type: 'success',
          onClose: function onClose() {
            $('.modal-delete').modal('hide');
          }
        });
      },
      error: function error(data) {
        setError(data);
      }
    });
  }); //GET BAHAN

  function getBahan() {
    $("#dataTableBahan").dataTable().fnDestroy();
    $('#dataTableBahan').DataTable({
      processing: true,
      serverSide: true,
      ajax: host + '/datatable?req=dtGetBahan',
      columns: [{
        data: 'no',
        name: 'no'
      }, {
        data: 'foto',
        name: 'foto',
        orderable: false,
        searchable: false
      }, {
        data: 'kd_bahan',
        name: 'kd_bahan'
      }, {
        data: 'nama',
        name: 'nama'
      }, {
        data: 'kategori',
        name: 'kategori'
      }, {
        data: 'jumlah_bahan',
        name: 'jumlah_bahan'
      }, {
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false
      }]
    });
  } // DETAIL BAHAN


  $(document).on('click', '#detail-bahan', function (e) {
    var id = $(this).attr('dta-id');
    $('#collapseOne-2').addClass('in');
    detailBahan(id);
  });

  function detailBahan(id) {
    $.ajax({
      url: host + "/api/inventori/getbahan/" + id,
      method: "GET",
      headers: headers,
      success: function success(data) {
        $.each(data.result, function (el, val) {
          $('#dtl_' + el).text(val);
        });
        var tableDetail = $('#tableDetail').DataTable();
        tableDetail.clear().draw();
        var no = 1;
        $.each(data.result.riwayat_beli, function (key, vl) {
          tableDetail.row.add([no, vl.kd_beli, vl.created_at, vl.jumlah_beli + ' ' + data.result.satuan, 'Rp. ' + vl.total_harga, '<a href="#" id="detail-supplier" data-id="' + vl.supplier_id + '">' + vl.supplier + '</a>', "<td class=\"text-center\">\n\t\t\t\t\t\t<a href=\"#\" class=\"text-primary\" id=\"edit-add-bahan\" data-id=\"" + vl.id + "\"><i class=\"fa fa-pencil\"></i></a>&nbsp;\n\t\t\t\t\t\t<a href=\"#\" class=\"text-danger\" id=\"delete-add-bahan\" data-id=\"" + vl.id + "\"><i class=\"fa fa-trash-o\"></i></a>\n\t\t\t\t\t\t</td>"]).draw(false);
          no = no + 1;
        });
      }
    });
  } // EDIT ADD BAHAN


  $(document).on('click', '#edit-add-bahan', function (e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    $.ajax({
      url: host + "/configuration",
      method: "POST",
      headers: headers,
      data: {
        req: 'databelibahan',
        id: id
      },
      success: function success(data) {
        swal({
          title: "Edit Data Pembelian",
          html: data,
          showCancelButton: true,
          confirmButtonClass: 'btn-primary btn-md waves-effect waves-light',
          cancelButtonClass: 'btn-white btn-md waves-effect',
          confirmButtonText: 'Update',
          focusConfirm: false,
          preConfirm: function preConfirm() {
            var data = $('#bahanPembelian').serialize();
            $.ajax({
              url: host + "/configuration",
              method: "POST",
              headers: headers,
              data: data + '&id=' + id + '&req=updatebahanbeli',
              success: function success(data) {
                getBahan();
                detailBahan(data.id);
                swal(data.title, data.message, data.status);
              }
            });
          }
        });
      }
    });
  }); // HAPUS ADD BAHAN

  $(document).on('click', '#delete-add-bahan', function (e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    swal({
      title: "Yakin Ingin Menghapus?",
      html: "Data pembelian ini akan di hapus!",
      type: "error",
      showCancelButton: true,
      cancelButtonClass: 'btn-white btn-md waves-effect',
      confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
      confirmButtonText: 'Hapus',
      focusConfirm: false,
      preConfirm: function preConfirm() {
        $.ajax({
          url: host + "/configuration",
          method: "POST",
          headers: headers,
          data: {
            req: 'deletebahanbeli',
            id: id
          },
          success: function success(data) {
            getBahan();
            detailBahan(data.id);
            swal(data.title, data.message, data.status);
          }
        });
      }
    });
  }); // VIEW GAMBAR BAHAN

  $(document).on('click', '#view-gambar-bahan', function () {
    var id = $(this).attr('data-id');
    $('#setImage').attr('src', '');
    $.ajax({
      url: host + "/api/inventori/getbahan/" + id,
      method: "GET",
      headers: headers,
      success: function success(data) {
        $('#setImage').attr('src', host + '/assets/images/bahan/' + data.result.foto);
      }
    });
  }); // ADD BAHAN

  $('#fromBahan').submit(function (e) {
    e.preventDefault();
    var data = new FormData($(this)[0]);
    $.ajax({
      url: host + "/api/inventori/setbahan",
      enctype: "multipart/form-data",
      method: "POST",
      data: data,
      headers: headers,
      xhr: function xhr() {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener('progress', function (evt) {
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
      contentType: false,
      processData: false,
      success: function success(data) {
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
          onClose: function onClose() {
            $('.modal-add-bahan').modal('hide');
          }
        });
      },
      error: function error(data) {
        $('#viewProgress').attr('hidden', '');
        $('#upload').removeAttr('disabled');
        $('#batal').removeAttr('disabled');
        $('#progress').text('0%');
        setError(data);
      }
    });
  }); // EDIT BAHAN

  $('#fromEditBahan').submit(function (e) {
    e.preventDefault();
    var data = new FormData(this);
    var id = $('#edt_id').val();
    $.ajax({
      url: host + "/api/inventori/editbahan/" + id,
      enctype: "multipart/form-data",
      method: "POST",
      data: data,
      headers: headers,
      xhr: function xhr() {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener('progress', function (evt) {
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
      contentType: false,
      processData: false,
      cache: false,
      success: function success(data) {
        getBahan();
        $('#viewProgress').attr('hidden', '');
        $('#upload').removeAttr('disabled');
        $('#batal').removeAttr('disabled');
        $('#progress').text('0%');
        $('#fromEditBahan')[0].reset();
        Swal.fire({
          title: 'Berhasil Diproses',
          text: 'Data bahan berhasil diupdate',
          type: 'success',
          onClose: function onClose() {
            $('.modal-edit-bahan').modal('hide');
          }
        });
      },
      error: function error(data) {
        $('#viewProgress').attr('hidden', '');
        $('#upload').removeAttr('disabled');
        $('#batal').removeAttr('disabled');
        $('#progress').text('0%');
        setError(data);
      }
    });
  }); // ADD STOK ALAT

  $('#fromStokBahan').submit(function (ev) {
    ev.preventDefault();
    var data = $(this).serialize();
    $.ajax({
      url: host + "/api/inventori/setstokbahan",
      method: "POST",
      data: data,
      headers: headers,
      success: function success(data) {
        getBahan();
        $('#fromStokBahan')[0].reset();
        $('#nama_bahan').select2({
          placeholder: 'Pilih Bahan',
          allowClear: true
        });
        Swal.fire({
          title: 'Berhasil Diproses',
          text: 'Data bahan baru berhasil ditambah',
          type: 'success',
          onClose: function onClose() {
            $('.modal-add-stok').modal('hide');
          }
        });
      },
      error: function error(data) {
        setError(data);
      }
    });
  }); // DELETE ALAT

  $('#delete-bahan').click(function () {
    var id = $(this).attr('data-id');
    $.ajax({
      url: host + "/api/inventori/deletebahan/" + id,
      method: "DELETE",
      headers: headers,
      success: function success(data) {
        getBahan();
        Swal.fire({
          title: 'Berhasil Diproses',
          text: 'Data berhasil dihapus',
          type: 'success',
          onClose: function onClose() {
            $('.modal-delete').modal('hide');
          }
        });
      },
      error: function error(data) {
        setError(data);
      }
    });
  }); // GET KATEGORI

  function getKategori() {
    $("#tableKategori").dataTable().fnDestroy();
    $('#tableKategori').DataTable({
      processing: true,
      serverSide: true,
      ajax: host + '/datatable?req=dtKategori',
      columns: [{
        data: 'no',
        name: 'no'
      }, {
        data: 'foto',
        name: 'foto',
        orderable: false,
        searchable: false
      }, {
        data: 'kategori',
        name: 'kategori'
      }, {
        data: 'jenis',
        name: 'jenis'
      }, {
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false
      }]
    });
  } // SET KATEGORI


  $('#fromKategori').submit(function (ev) {
    ev.preventDefault();
    var data = new FormData($(this)[0]);
    $.ajax({
      url: host + "/api/inventori/setkategori",
      enctype: "multipart/form-data",
      method: "POST",
      data: data,
      headers: headers,
      xhr: function xhr() {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener('progress', function (evt) {
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
      contentType: false,
      processData: false,
      success: function success(data) {
        getKategori();
        $('#viewProgress').attr('hidden', '');
        $('#upload').removeAttr('disabled');
        $('#batal').removeAttr('disabled');
        $('#progress').text('0%');
        $('#fromKategori')[0].reset();
        Swal.fire({
          title: 'Berhasil Diproses',
          text: 'Data alat kategori berhasil ditambah',
          type: 'success',
          onClose: function onClose() {
            $('.modal-add').modal('hide');
          }
        });
      },
      error: function error(data) {
        $('#viewProgress').attr('hidden', '');
        $('#upload').removeAttr('disabled');
        $('#batal').removeAttr('disabled');
        $('#progress').text('0%');
        setError(data);
      }
    });
  }); // PUT KATEGORI

  $('#fromEdtKategori').submit(function (ev) {
    ev.preventDefault();
    var data = new FormData($(this)[0]);
    var id = $('#edt_id').val();
    $.ajax({
      url: host + "/api/inventori/editkategori/" + id,
      enctype: "multipart/form-data",
      method: "POST",
      data: data,
      headers: headers,
      xhr: function xhr() {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener('progress', function (evt) {
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
      contentType: false,
      processData: false,
      cache: false,
      success: function success(data) {
        getKategori();
        $('#viewProgress').attr('hidden', '');
        $('#upload').removeAttr('disabled');
        $('#batal').removeAttr('disabled');
        $('#progress').text('0%');
        $('#fromEdtKategori')[0].reset();
        Swal.fire({
          title: 'Berhasil Diproses',
          text: 'Data kategori berhasil diupdate',
          type: 'success',
          onClose: function onClose() {
            $('.modal-edit').modal('hide');
          }
        });
      },
      error: function error(data) {
        $('#viewProgress').attr('hidden', '');
        $('#upload').removeAttr('disabled');
        $('#batal').removeAttr('disabled');
        $('#progress').text('0%');
        setError(data);
      }
    });
  }); // DELETE KATEGORI

  $('#delete-kategori').click(function () {
    var id = $(this).attr('data-id');
    $.ajax({
      url: host + "/api/inventori/deletekategori/" + id,
      method: "DELETE",
      headers: headers,
      success: function success(data) {
        getKategori();
        Swal.fire({
          title: 'Berhasil Diproses',
          text: 'Data berhasil dihapus',
          type: 'success',
          onClose: function onClose() {
            $('.modal-delete').modal('hide');
          }
        });
      },
      error: function error(data) {
        setError(data);
      }
    });
  }); // GET SUPPLIER

  function getSupplier() {
    var dataTable = $('#tableSupplier').DataTable();
    $.ajax({
      url: host + "/api/getsupplier",
      method: "GET",
      headers: headers,
      success: function success(data) {
        dataTable.clear().draw();
        var no = 1;
        $.each(data.result, function (key, val) {
          if (val.id != 0) {
            dataTable.row.add([no, val.nama_supplier, val.alamat, val.telepon, val.email, val.kategori, "<div class=\"text-center\">\n\t\t\t\t\t\t\t<button type=\"button\" class=\"btn btn-success btn-sm waves-effect waves-light\" id=\"edit-supplier\" data-toggle1=\"tooltip\" title=\"Edit\" data-toggle=\"modal\" data-target=\".modal-edit\" data-id=\"" + val.id + "\"><i class=\"fa fa-edit\"></i></button>\n\t\t\t\t\t\t\t<button type=\"button\" class=\"btn btn-danger btn-sm waves-effect waves-light\" id=\"hapus-supplier\" data-toggle1=\"tooltip\" title=\"Hapus\" data-toggle=\"modal\" data-target=\".modal-delete\" data-id=\"" + val.id + "\"><i class=\"fa fa-trash\"></i></button>\n\t\t\t\t\t\t\t</div>"]).draw(false);
            no = no + 1;
          }
        });
      }
    });
  } // SET SUPPLIER


  $('#fromSupplier').submit(function (ev) {
    ev.preventDefault();
    var data = $(this).serialize();
    $.ajax({
      url: host + "/api/setsupplier",
      method: "POST",
      data: data,
      headers: headers,
      success: function success(data) {
        $('#fromSupplier')[0].reset();
        getSupplier();
        Swal.fire({
          title: 'Berhasil Diproses',
          text: 'Data supplier baru berhasil ditambah',
          type: 'success',
          onClose: function onClose() {
            $('.modal-add').modal('hide');
          }
        });
      },
      error: function error(data) {
        setError(data);
      }
    });
  }); // PUT SUPPLIER

  $('#fromEdtSupplier').submit(function (ev) {
    ev.preventDefault();
    var data = $(this).serialize();
    var id = $('#id').val();
    $.ajax({
      url: host + "/api/editsupplier/" + id,
      method: "PUT",
      data: data,
      headers: headers,
      success: function success(data) {
        $('#fromEdtSupplier')[0].reset();
        getSupplier();
        Swal.fire({
          title: 'Berhasil Diproses',
          text: 'Data berhasil diupdate',
          type: 'success',
          onClose: function onClose() {
            $('.modal-edit').modal('hide');
          }
        });
      },
      error: function error(data) {
        setError(data);
      }
    });
  }); // DELETE SUPPLIER

  $('#delete-supplier').click(function () {
    var id = $(this).attr('data-id');
    $.ajax({
      url: host + "/api/deletesupplier/" + id,
      method: "DELETE",
      headers: headers,
      success: function success(data) {
        getSupplier();
        Swal.fire({
          title: 'Berhasil Diproses',
          text: 'Data berhasil dihapus',
          type: 'success',
          onClose: function onClose() {
            $('.modal-delete').modal('hide');
          }
        });
      },
      error: function error(data) {
        setError(data);
      }
    });
  }); // GET PAKET

  function getPaket() {
    $.ajax({
      url: host + "/configuration",
      method: "POST",
      headers: headers,
      data: {
        req: 'getPaket'
      },
      success: function success(data) {
        $('#setPaket').html(data);
      }
    });
  } // ADD PAKET


  $('#fromPaket').submit(function (e) {
    e.preventDefault();
    var data = new FormData($(this)[0]);
    $.ajax({
      url: host + "/api/kelolamenu/setpaket",
      enctype: "multipart/form-data",
      method: "POST",
      data: data,
      headers: headers,
      xhr: function xhr() {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener('progress', function (evt) {
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
      contentType: false,
      processData: false,
      success: function success(data) {
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
          onClose: function onClose() {
            $('.modal-add-paket').modal('hide');
          }
        });
      },
      error: function error(data) {
        $('#viewProgress').attr('hidden', '');
        $('#upload').removeAttr('disabled');
        $('#batal').removeAttr('disabled');
        $('#progress').text('0%');
        setError(data);
      }
    });
  }); // GET DRIVER

  function getDriver() {
    $("#tableDriver").dataTable().fnDestroy();
    $('#tableDriver').DataTable({
      processing: true,
      serverSide: true,
      ajax: host + '/datatable?req=dtDriver',
      columns: [{
        data: 'no',
        name: 'no'
      }, {
        data: 'foto',
        name: 'foto',
        orderable: false,
        searchable: false
      }, {
        data: 'nama',
        name: 'nama'
      }, {
        data: 'alamat',
        name: 'alamat'
      }, {
        data: 'email',
        name: 'email'
      }, {
        data: 'telepon',
        name: 'telepon'
      }, {
        data: 'username',
        name: 'username'
      }, {
        data: 'status',
        name: 'status',
        orderable: false,
        searchable: false
      }, {
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false
      }]
    });
  } // SET DRIVER


  $('#fromDriver').submit(function (ev) {
    ev.preventDefault();
    var data = $(this).serialize();
    $.ajax({
      url: host + "/api/setdriver",
      method: "POST",
      data: data,
      headers: headers,
      success: function success(data) {
        getDriver();
        $('#fromDriver')[0].reset();
        Swal.fire({
          title: 'Berhasil Diproses',
          text: 'Data driver baru berhasil ditambah',
          type: 'success',
          onClose: function onClose() {
            $('.modal-add').modal('hide');
          }
        });
      },
      error: function error(data) {
        setError(data);
      }
    });
  }); // PUT DRIVER

  $('#fromEdtDriver').submit(function (ev) {
    ev.preventDefault();
    var data = $(this).serialize();
    var id = $('#edt_id').val();
    $.ajax({
      url: host + "/api/editdriver/" + id,
      method: "POST",
      data: data,
      headers: headers,
      success: function success(data) {
        getDriver();
        $('#fromEdtDriver')[0].reset();
        Swal.fire({
          title: 'Berhasil Diproses',
          text: 'Data driver berhasil diupdate',
          type: 'success',
          onClose: function onClose() {
            $('.modal-edit').modal('hide');
          }
        });
      },
      error: function error(data) {
        setError(data);
      }
    });
  }); // DELETE DRIVER

  $('#delete-driver').click(function () {
    var id = $(this).attr('dta-id');
    $.ajax({
      url: host + "/api/deletedriver/" + id,
      method: "DELETE",
      headers: headers,
      success: function success(data) {
        getDriver();
        Swal.fire({
          title: 'Berhasil Diproses',
          text: 'Data berhasil dihapus',
          type: 'success',
          onClose: function onClose() {
            $('.modal-delete').modal('hide');
          }
        });
      },
      error: function error(data) {
        setError(data);
      }
    });
  });
});