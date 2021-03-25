$(document).ready(function () {
   var url = $('#configurl').val();
   var host = $('#host').val();

   var headers = {
      "Accept": "application/json",
      "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjA3YWE1Y2M3MDA1YTdjMDA2YzgwZWNjNjIxN2E4Y2VhOTUwMTEzMWNmM2MxOTVmMDk2YjJmZTAwY2I2MGI4ODAxNzE1ZGJmYjQ1YTYzMmIwIn0.eyJhdWQiOiIxIiwianRpIjoiMDdhYTVjYzcwMDVhN2MwMDZjODBlY2M2MjE3YThjZWE5NTAxMTMxY2YzYzE5NWYwOTZiMmZlMDBjYjYwYjg4MDE3MTVkYmZiNDVhNjMyYjAiLCJpYXQiOjE2MDA1MTI5NTEsIm5iZiI6MTYwMDUxMjk1MSwiZXhwIjoxNjMyMDQ4OTUwLCJzdWIiOiIxMyIsInNjb3BlcyI6W119.oHghL81Jc0xq-vvDVFde3QeqYs3s0Me6XukZtGy8G8HegV4LV2ImqKlpw_wdwxBOtKhBfodMFICi0YmNcPov7A",
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
   }

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
   }

   //GET ALAT
   function getAlat() {
      $("#dataTableAlat").dataTable().fnDestroy();
      $('#dataTableAlat').DataTable({
         processing: true,
         serverSide: true,
         ajax: host + '/datatable?req=dtGetAlat',
         columns: [{
            data: 'no',
            name: 'no'
         },
         {
            data: 'foto',
            name: 'foto',
            orderable: false,
            searchable: false
         },
         {
            data: 'kd_alat',
            name: 'kd_alat'
         },
         {
            data: 'nama',
            name: 'nama'
         },
         {
            data: 'kategori',
            name: 'kategori'
         },
         {
            data: 'jumlah_alat',
            name: 'jumlah_alat'
         },
         {
            data: 'alat_keluar',
            name: 'alat_keluar'
         },
         {
            data: 'sisa_alat',
            name: 'sisa_alat'
         },
         {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
         },
         ]
      });
   }

   // DETAIL ALAT
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
         success: function (data) {
            $.each(data.result, function (el, val) {
               $('#dtl_' + el).text(val);
            });

            var tableDetail = $('#tableDetail').DataTable();
            tableDetail.clear().draw();
            var no = 1;
            $.each(data.result.riwayat_beli, function (key, vl) {
               tableDetail.row.add([
                  no,
                  vl.kd_beli,
                  vl.created_at,
                  vl.jumlah_beli + ' pcs',
                  'Rp. ' + vl.total_harga,
                  '<a href="#" id="detail-supplier" data-id="' + vl.supplier_id + '">' + vl.supplier + '</a>',
                  `<td class="text-center">
                  <a href="#" class="text-primary" id="edit-add-alat" data-id="` + vl.id + `"><i class="fa fa-pencil"></i></a>&nbsp;
                  <a href="#" class="text-danger" id="delete-add-alat" data-id="` + vl.id + `"><i class="fa fa-trash-o"></i></a>
                  </td>`
                  ]).draw(false);
               no = no + 1;
            });
         }
      });
   }

   // EDIT ADD ALAT
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
         success: function (data) {
            swal({
               title: "Edit Data Pembelian",
               html: data,
               showCancelButton: true,
               confirmButtonClass: 'btn-primary btn-md waves-effect waves-light',
               cancelButtonClass: 'btn-white btn-md waves-effect',
               confirmButtonText: 'Update',
               focusConfirm: false,
               preConfirm: () => {
                  var data = $('#alatPembelian').serialize();
                  $.ajax({
                     url: host + "/configuration",
                     method: "POST",
                     headers: headers,
                     data: data + '&id=' + id + '&req=updatealatbeli',
                     success: function (data) {
                        getAlat();
                        detailAlat(data.id);
                        swal(data.title, data.message, data.status);
                     }
                  });
               }
            });
         }
      });
   });

   // HAPUS ADD ALAT
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
         preConfirm: () => {
            $.ajax({
               url: host + "/configuration",
               method: "POST",
               headers: headers,
               data: {
                  req: 'deletealatbeli',
                  id: id
               },
               success: function (data) {
                  getAlat();
                  detailAlat(data.id);
                  swal(data.title, data.message, data.status);
               }
            });
         }
      });
   });

   // VIEW GAMBAR ALAT
   $(document).on('click', '#view-gambar-alat', function () {
      var id = $(this).attr('data-id');
      $('#setImage').attr('src', '');

      $.ajax({
         url: host + "/api/inventori/getalat/" + id,
         method: "GET",
         headers: headers,
         success: function (data) {
            $('#setImage').attr('src', host + '/assets/images/alat/' + data.result.foto);
         }
      });
   });

   // ADD ALAT
   $('#fromAlat').submit(function (e) {
      e.preventDefault();
      var data = new FormData($(this)[0]);

      $.ajax({
         url: host + "/api/inventori/setalat",
         enctype: "multipart/form-data",
         method: "POST",
         data: data,
         headers: headers,
         xhr: function () {
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
         success: function (data) {
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
         error: function (data) {
            $('#viewProgress').attr('hidden', '');
            $('#upload').removeAttr('disabled');
            $('#batal').removeAttr('disabled');
            $('#progress').text('0%');

            setError(data);
         }
      });
   });

   // EDIT ALAT
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
         xhr: function () {
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
         success: function (data) {
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
               onClose: () => {
                  $('.modal-edit-alat').modal('hide');
               }
            });
         },
         error: function (data) {
            $('#viewProgress').attr('hidden', '');
            $('#upload').removeAttr('disabled');
            $('#batal').removeAttr('disabled');
            $('#progress').text('0%');

            setError(data);
         }
      });
   });

   // ADD STOK ALAT
   $('#fromStokAlat').submit(function (ev) {
      ev.preventDefault();
      var data = $(this).serialize();

      $.ajax({
         url: host + "/api/inventori/setstokalat",
         method: "POST",
         data: data,
         headers: headers,
         success: function (data) {
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
               onClose: () => {
                  $('.modal-add-stok').modal('hide');
               }
            });
         },
         error: function (data) {
            setError(data);
         }
      });
   });

   // SET ALAT KEMBALI 
   $(document).on('click', '#add-alat-hilang', function(e) {
      $.ajax({
         url     : host+"/api/datapesanan",
         method  : "GET",
         headers  : headers,
         success : function(data) {
            $('.info-alat').attr('hidden', '');
            var optionSwal='';

            if (data.result) {
               $.each(data.result, function(key, val) {
                  optionSwal += '<option value="'+val.id+'">'+val.kd_pemesanan+'/'+val.nama+'/'+val.no_telepon+'</option>';
               });
            }

            Swal.fire({
               title: "Input Alat Hilang",
               html: `<form id="formSetAlatHilang">
               <div class="text-left">
               <div class="m-b-20">
               <h5><label>Temukan Data Pesanan</label></h5>
               <select class="form-control select2-swal" name="pemesanan_id" id="data_pesanan_swal" required="">
               <option value=""></option>
               `+ optionSwal +`
               </select>
               </div>
               <div class="m-b-20">
               <h5><label>Pilh Alat Yang Hilang</label></h5>
               <select class="form-control select2-swal1" name="alatpsn_id" id="alat_id_swal" required="">
               <option value=""></option>
               </select>
               <span class="info-alat text-danger" hidden=""><i>Tidak ada alat di set untuk pesanan yang dipilih. Cek pesanan yang lain!</i></span>
               </div>
               <div class="m-b-20 row">
               <div class="col-sm-8">
               <h5><label>Input Jumlah Alat Hilang</label></h5>
               <div class="form-group row">
               <div class="col-sm-8">
               <input type="number" class="form-control" name="jumlah" id="input_alat_hilang" placeholder="Jumlah Alat Hilang" value="">
               </div>
               <div class="col-sm-4">
               <input type="text" class="form-control" value="pcs" disabled>
               </div>
               </div>
               </div>
               </div>
               </form>`,
               showCancelButton: true,
               confirmButtonClass: 'btn-primary btn-md waves-effect waves-light',
               cancelButtonClass: 'btn-white btn-md waves-effect',
               confirmButtonText: 'Selesai',
               allowOutsideClick: false,
               width: '500px',
               onOpen: () => {
                  $('.select2-swal').select2({
                     placeholder: 'Pilih Kode Pesanan/Nama Pemesan/Nomor Telepon'
                  });
                  $('.select2-swal1').select2({
                     placeholder: 'Pilih Alat Yang Telah Hilang'
                  });
               },
               preConfirm: () => {
                  var data = {};
                  data.pesanan_id = document.getElementById('data_pesanan_swal').value;
                  data.alat_id = document.getElementById('alat_id_swal').value;
                  data.alat_hilang = document.getElementById('input_alat_hilang').value;
                  return data;
               }
            }).then((result) => {
               if (result.value.pesanan_id == '' || result.value.alat_id == '' || result.value.alat_hilang == '') {
                  Swal.fire({
                     title: 'Terdapat Inputan Kosong',
                     text: 'Pastikan semua inputan telah terisi semua. Silahkan isi form yang ada!',
                     type: 'warning'
                  });
               } else {
                  var data = $('#formSetAlatHilang').serialize();
                  $.ajax({
                     url     : host+"/api/inventori/setalathilang",
                     method  : "POST",
                     headers  : headers,
                     data: data,
                     success : function(data) {
                        Swal.fire({
                           title: 'Berhasil Diproses',
                           text: 'Data alat hilang berhasil ditambah',
                           type: 'success'
                        });

                        $.ajax({
                           url: host + "/api/inventori/getalathilang",
                           method: "GET",
                           headers: headers,
                           success: function (data) {
                              var tableAlatHilang = $('#tableAlatHilang').DataTable();
                              tableAlatHilang.clear().draw();
                              var no = 1;
                              $.each(data.result, function (key, vl) {
                                 tableAlatHilang.row.add([
                                    no,
                                    vl.kd_pemesanan,
                                    vl.nama_pemesan,
                                    vl.nama_alat,
                                    vl.jumlah_hilang,
                                    vl.tanggal_hilang,
                                    `<td class="text-center">
                                    <a href="#" class="btn btn-sm btn-default" id="set-alat-kembali" data-id="` + vl.id + `" ><i class="fa fa-reply"></i> Telah Kembali</a>
                                    </td>`
                                    ]).draw(false);
                                 no = no + 1;
                              });
                           }
                        });
                     },
                     error: function (data) {
                        setError(data);
                     }
                  });
               }
            });
         }
      });
});

$(document).on('change', '.select2-swal', function(event) {
   event.preventDefault();
   $('.select2-swal1').select2({
      placeholder: 'Pilih Alat Yang Telah Hilang'
   });
   var pesanan_id = $(this).val();
   $.ajax({
      url     : host+"/api/datapesanan/getalatpesanan/"+pesanan_id,
      method  : "GET",
      headers  : headers,
      success : function(data) {
         var optionAlatSwal='<option value=""></option>';
         $('.select2-swal1').html(optionAlatSwal);
         if (data.result) {
            $.each(data.result, function(key, val) {
               optionAlatSwal += '<option value="'+val.id+'">'+val.nama_alat+' / JUMLAH KELUAR: '+val.jumlah+' pcs</option>';
            });
            $('.select2-swal1').html(optionAlatSwal);
            $('.info-alat').attr('hidden', '');
         } else {
            $('.info-alat').removeAttr('hidden');
         }
      }
   });
});

   // SET ALAT KEMBALI 
   $(document).on('click', '#set-alat-kembali', function(e) {
      var id = $(this).attr('data-id');
      swal({
         title: "Alat Kembali",
         html: `<form id="thisalatKembali">
         <div class="text-left">
         <div class="form-group row">
         <div class="col-sm-9">
         <input type="number" class="form-control" required="" name="jumlah_alat" placeholder="Jumlah Alat Kembali" value="">
         </div>
         <div class="col-sm-3">
         <input type="tex" class="form-control" value="pcs" disabled>
         </div>
         </div>
         </div>
         </form>`,
         showCancelButton: true,
         confirmButtonClass: 'btn-primary btn-md waves-effect waves-light',
         cancelButtonClass: 'btn-white btn-md waves-effect',
         confirmButtonText: 'Selesai',
         focusConfirm: false,
         preConfirm: () => {
            var data = $(document).find('#thisalatKembali').serialize();
            $.ajax({
               url: host + "/api/inventori/setalatkembali/"+id,
               method: "POST",
               headers: headers,
               data: data,
               success: function (data) {
                  Swal.fire({
                     title: 'Berhasil Diproses',
                     text: 'Alat telah kembali',
                     type: 'success',
                     onClose: () => {
                        $('.modal').modal('hide');
                     }
                  });
               },
               error: function (data) {
                  setError(data);
               }
            });
         }
      });
   });

   // DELETE ALAT
   $('#delete-alat').click(function () {
      var id = $(this).attr('data-id');

      $.ajax({
         url: host + "/api/inventori/deletealat/" + id,
         method: "DELETE",
         headers: headers,
         success: function (data) {
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
         error: function (data) {
            setError(data);
         }
      });
   });

   //GET BAHAN
   function getBahan() {
      $("#dataTableBahan").dataTable().fnDestroy();
      $('#dataTableBahan').DataTable({
         processing: true,
         serverSide: true,
         ajax: host + '/datatable?req=dtGetBahan',
         columns: [{
            data: 'no',
            name: 'no'
         },
         {
            data: 'foto',
            name: 'foto',
            orderable: false,
            searchable: false
         },
         {
            data: 'kd_bahan',
            name: 'kd_bahan'
         },
         {
            data: 'nama',
            name: 'nama'
         },
         {
            data: 'kategori',
            name: 'kategori'
         },
         {
            data: 'jumlah_bahan',
            name: 'jumlah_bahan'
         },
         {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
         },
         ]
      });
   }

   // DETAIL BAHAN
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
         success: function (data) {
            $.each(data.result, function (el, val) {
               $('#dtl_' + el).text(val);
            });

            var tableDetail = $('#tableDetail').DataTable();
            tableDetail.clear().draw();
            var no = 1;
            $.each(data.result.riwayat_beli, function (key, vl) {
               tableDetail.row.add([
                  no,
                  vl.kd_beli,
                  vl.created_at,
                  vl.jumlah_beli + ' ' + data.result.satuan,
                  'Rp. ' + vl.total_harga,
                  '<a href="#" id="detail-supplier" data-id="' + vl.supplier_id + '">' + vl.supplier + '</a>',
                  `<td class="text-center">
                  <a href="#" class="text-primary" id="edit-add-bahan" data-id="` + vl.id + `"><i class="fa fa-pencil"></i></a>&nbsp;
                  <a href="#" class="text-danger" id="delete-add-bahan" data-id="` + vl.id + `"><i class="fa fa-trash-o"></i></a>
                  </td>`
                  ]).draw(false);

               no = no + 1;
            });
         }
      });
   }

   // EDIT ADD BAHAN
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
         success: function (data) {
            swal({
               title: "Edit Data Pembelian",
               html: data,
               showCancelButton: true,
               confirmButtonClass: 'btn-primary btn-md waves-effect waves-light',
               cancelButtonClass: 'btn-white btn-md waves-effect',
               confirmButtonText: 'Update',
               focusConfirm: false,
               preConfirm: () => {
                  var data = $('#bahanPembelian').serialize();
                  $.ajax({
                     url: host + "/configuration",
                     method: "POST",
                     headers: headers,
                     data: data + '&id=' + id + '&req=updatebahanbeli',
                     success: function (data) {
                        getBahan();
                        detailBahan(data.id);
                        swal(data.title, data.message, data.status);
                     }
                  });
               }
            });
         }
      });
   });

   // HAPUS ADD BAHAN
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
         preConfirm: () => {
            $.ajax({
               url: host + "/configuration",
               method: "POST",
               headers: headers,
               data: {
                  req: 'deletebahanbeli',
                  id: id
               },
               success: function (data) {
                  getBahan();
                  detailBahan(data.id);
                  swal(data.title, data.message, data.status);
               }
            });
         }
      });
   });

   // VIEW GAMBAR BAHAN
   $(document).on('click', '#view-gambar-bahan', function () {
      var id = $(this).attr('data-id');
      $('#setImage').attr('src', '');

      $.ajax({
         url: host + "/api/inventori/getbahan/" + id,
         method: "GET",
         headers: headers,
         success: function (data) {
            $('#setImage').attr('src', host + '/assets/images/bahan/' + data.result.foto);
         }
      });
   });

   // ADD BAHAN
   $('#fromBahan').submit(function (e) {
      e.preventDefault();
      var data = new FormData($(this)[0]);

      $.ajax({
         url: host + "/api/inventori/setbahan",
         enctype: "multipart/form-data",
         method: "POST",
         data: data,
         headers: headers,
         xhr: function () {
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
         success: function (data) {
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
         error: function (data) {
            $('#viewProgress').attr('hidden', '');
            $('#upload').removeAttr('disabled');
            $('#batal').removeAttr('disabled');
            $('#progress').text('0%');

            setError(data);
         }
      });
   });

   // EDIT BAHAN
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
         xhr: function () {
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
         success: function (data) {
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
               onClose: () => {
                  $('.modal-edit-bahan').modal('hide');
               }
            });
         },
         error: function (data) {
            $('#viewProgress').attr('hidden', '');
            $('#upload').removeAttr('disabled');
            $('#batal').removeAttr('disabled');
            $('#progress').text('0%');

            setError(data);
         }
      });
   });

   // ADD STOK ALAT
   $('#fromStokBahan').submit(function (ev) {
      ev.preventDefault();
      var data = $(this).serialize();

      $.ajax({
         url: host + "/api/inventori/setstokbahan",
         method: "POST",
         data: data,
         headers: headers,
         success: function (data) {
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
               onClose: () => {
                  $('.modal-add-stok').modal('hide');
               }
            });
         },
         error: function (data) {
            setError(data);
         }
      });
   });

   // DELETE ALAT
   $('#delete-bahan').click(function () {
      var id = $(this).attr('data-id');

      $.ajax({
         url: host + "/api/inventori/deletebahan/" + id,
         method: "DELETE",
         headers: headers,
         success: function (data) {
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
         error: function (data) {
            setError(data);
         }
      });
   });

   // GET KATEGORI
   function getKategori() {
      $("#tableKategori").dataTable().fnDestroy();
      $('#tableKategori').DataTable({
         processing: true,
         serverSide: true,
         ajax: host + '/datatable?req=dtKategori',
         columns: [{
            data: 'no',
            name: 'no'
         },
         {
            data: 'foto',
            name: 'foto',
            orderable: false,
            searchable: false
         },
         {
            data: 'kategori',
            name: 'kategori'
         },
         {
            data: 'jenis',
            name: 'jenis'
         },
         {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
         },
         ],
      });
   }

   // SET KATEGORI
   $('#fromKategori').submit(function (ev) {
      ev.preventDefault();
      var data = new FormData($(this)[0]);

      $.ajax({
         url: host + "/api/inventori/setkategori",
         enctype: "multipart/form-data",
         method: "POST",
         data: data,
         headers: headers,
         xhr: function () {
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
         success: function (data) {
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
               onClose: () => {
                  $('.modal-add').modal('hide');
               }
            });
         },
         error: function (data) {
            $('#viewProgress').attr('hidden', '');
            $('#upload').removeAttr('disabled');
            $('#batal').removeAttr('disabled');
            $('#progress').text('0%');

            setError(data);
         }
      });
   });

   // PUT KATEGORI
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
         xhr: function () {
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
         success: function (data) {
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
               onClose: () => {
                  $('.modal-edit').modal('hide');
               }
            });
         },
         error: function (data) {
            $('#viewProgress').attr('hidden', '');
            $('#upload').removeAttr('disabled');
            $('#batal').removeAttr('disabled');
            $('#progress').text('0%');

            setError(data);
         }
      });
   });

   // DELETE KATEGORI
   $('#delete-kategori').click(function () {
      var id = $(this).attr('data-id');

      $.ajax({
         url: host + "/api/inventori/deletekategori/" + id,
         method: "DELETE",
         headers: headers,
         success: function (data) {
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
         error: function (data) {
            setError(data);
         }
      });
   });

   // GET SUPPLIER
   function getSupplier() {
      var dataTable = $('#tableSupplier').DataTable();
      $.ajax({
         url: host + "/api/getsupplier",
         method: "GET",
         headers: headers,
         success: function (data) {
            dataTable.clear().draw();
            var no = 1;
            $.each(data.result, function (key, val) {
               if (val.id != 0) {
                  dataTable.row.add([
                     no,
                     val.nama_supplier,
                     val.alamat,
                     val.telepon,
                     val.email,
                     val.kategori,
                     `<div class="text-center">
                     <button type="button" class="btn btn-success btn-sm waves-effect waves-light" id="edit-supplier" data-toggle1="tooltip" title="Edit" data-toggle="modal" data-target=".modal-edit" data-id="` + val.id + `"><i class="fa fa-edit"></i></button>
                     <button type="button" class="btn btn-danger btn-sm waves-effect waves-light" id="hapus-supplier" data-toggle1="tooltip" title="Hapus" data-toggle="modal" data-target=".modal-delete" data-id="` + val.id + `"><i class="fa fa-trash"></i></button>
                     </div>`,
                     ]).draw(false);
                  no = no + 1;
               }
            });
         }
      });
   }

   // SET SUPPLIER
   $('#fromSupplier').submit(function (ev) {
      ev.preventDefault();
      var data = $(this).serialize();

      $.ajax({
         url: host + "/api/setsupplier",
         method: "POST",
         data: data,
         headers: headers,
         success: function (data) {
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
         error: function (data) {
            setError(data);
         }
      });
   });

   // PUT SUPPLIER
   $('#fromEdtSupplier').submit(function (ev) {
      ev.preventDefault();
      var data = $(this).serialize();
      var id = $('#id').val();

      $.ajax({
         url: host + "/api/editsupplier/" + id,
         method: "PUT",
         data: data,
         headers: headers,
         success: function (data) {
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
         error: function (data) {
            setError(data);
         }
      });
   });

   // DELETE SUPPLIER
   $('#delete-supplier').click(function () {
      var id = $(this).attr('data-id');

      $.ajax({
         url: host + "/api/deletesupplier/" + id,
         method: "DELETE",
         headers: headers,
         success: function (data) {
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
         error: function (data) {
            setError(data);
         }
      });
   });

   // GET PAKET
   function getPaket() {
      $.ajax({
       url: host + "/configuration",
       method: "POST",
       headers: headers,
       data: { req: 'getPaket'},
       success: function(data) {
         $('#setPaket').html(data);
      }
   });
   }

   // ADD PAKET
   $('#fromPaket').submit(function (e) {
      e.preventDefault();
      var data = new FormData($(this)[0]);

      $.ajax({
         url: host + "/api/kelolamenu/setpaket",
         enctype: "multipart/form-data",
         method: "POST",
         data: data,
         headers: headers,
         xhr: function () {
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
         success: function (data) {
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
         error: function (data) {
            $('#viewProgress').attr('hidden', '');
            $('#upload').removeAttr('disabled');
            $('#batal').removeAttr('disabled');
            $('#progress').text('0%');

            setError(data);
         }
      });
   });

   // EDIT PAKET
   $('#fromEditPaket').submit(function (e) {
      e.preventDefault();
      var data = new FormData(this);
      var id = $('form').find('#id').val();

      $.ajax({
         url: host + "/api/kelolamenu/editpaket/" + id,
         enctype: "multipart/form-data",
         method: "POST",
         data: data,
         headers: headers,
         xhr: function () {
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
         success: function (data) {
            getPaket();
            $('#viewProgress').attr('hidden', '');
            $('#upload').removeAttr('disabled');
            $('#batal').removeAttr('disabled');
            $('#progress').text('0%');
            $('#fromEditPaket')[0].reset();

            Swal.fire({
               title: 'Berhasil Diproses',
               text: 'Data paket berhasil diupdate',
               type: 'success',
               onClose: () => {
                  $('.modal').modal('hide');
               }
            });
         },
         error: function (data) {
            $('#viewProgress').attr('hidden', '');
            $('#upload').removeAttr('disabled');
            $('#batal').removeAttr('disabled');
            $('#progress').text('0%');

            setError(data);
         }
      });
   });

   // DELETE PAKET
   $('#delete-paket').click(function () {
      var id = $(this).attr('data-id');

      $.ajax({
         url: host + "/api/kelolamenu/deletepaket/" + id,
         method: "DELETE",
         headers: headers,
         success: function (data) {
            getPaket();

            Swal.fire({
               title: 'Berhasil Diproses',
               text: 'Data berhasil dihapus',
               type: 'success',
               onClose: () => {
                  $('.modal').modal('hide');
               }
            });
         },
         error: function (data) {
            setError(data);
         }
      });
   });

   // GET DRIVER
   function getDriver() {
      $("#tableDriver").dataTable().fnDestroy();
      $('#tableDriver').DataTable({
         processing: true,
         serverSide: true,
         ajax: host + '/datatable?req=dtDriver',
         columns: [{
            data: 'no',
            name: 'no'
         },
         {
            data: 'foto',
            name: 'foto',
            orderable: false,
            searchable: false
         },
         {
            data: 'nama',
            name: 'nama'
         },
         {
            data: 'alamat',
            name: 'alamat'
         },
         {
            data: 'email',
            name: 'email'
         },
         {
            data: 'telepon',
            name: 'telepon'
         },
         {
            data: 'username',
            name: 'username'
         },
         {
            data: 'status',
            name: 'status',
            orderable: false,
            searchable: false
         },
         {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
         },
         ],
      });
   }

   // SET DRIVER
   $('#fromDriver').submit(function (ev) {
      ev.preventDefault();
      var data = $(this).serialize();

      $.ajax({
         url: host + "/api/setdriver",
         method: "POST",
         data: data,
         headers: headers,
         success: function (data) {
            getDriver();
            $('#fromDriver')[0].reset();

            Swal.fire({
               title: 'Berhasil Diproses',
               text: 'Data driver baru berhasil ditambah',
               type: 'success',
               onClose: () => {
                  $('.modal-add').modal('hide');
               }
            });
         },
         error: function (data) {
            setError(data);
         }
      });
   });

   // PUT DRIVER
   $('#fromEdtDriver').submit(function (ev) {
      ev.preventDefault();
      var data = $(this).serialize();
      var id = $('#edt_id').val();

      $.ajax({
         url: host + "/api/editdriver/" + id,
         method: "POST",
         data: data,
         headers: headers,
         success: function (data) {
            getDriver();
            $('#fromEdtDriver')[0].reset();

            Swal.fire({
               title: 'Berhasil Diproses',
               text: 'Data driver berhasil diupdate',
               type: 'success',
               onClose: () => {
                  $('.modal-edit').modal('hide');
               }
            });
         },
         error: function (data) {
            setError(data);
         }
      });
   });

   // DELETE DRIVER
   $('#delete-driver').click(function () {
      var id = $(this).attr('dta-id');

      $.ajax({
         url: host + "/api/deletedriver/" + id,
         method: "DELETE",
         headers: headers,
         success: function (data) {
            getDriver();

            Swal.fire({
               title: 'Berhasil Diproses',
               text: 'Data berhasil dihapus',
               type: 'success',
               onClose: () => {
                  $('.modal-delete').modal('hide');
               }
            });
         },
         error: function (data) {
            setError(data);
         }
      });
   });

   // GET ADDITIONAL
   function getAdditional() {
      $("#dataTableAdditional").dataTable().fnDestroy();
      $('#dataTableAdditional').DataTable({
         processing: true,
         serverSide: true,
         ajax: host+'/datatable?req=dtGetAdditional',
         columns: [
         { data: 'no', name: 'no' },
         { data: 'nama_daging', name: 'nama_daging' },
         { data: 'berat', name: 'berat' },
         { data: 'harga', name: 'harga' },
         { data: 'keterangan', name: 'keterangan' },
         { data: 'action', name: 'action', orderable: false, searchable: false },
         ]
      });
   }

   // SET ADDITIONAL 
   $('#fromAdditional').submit(function (ev) {
      ev.preventDefault();
      var data = $(this).serialize();

      $.ajax({
         url: host + "/configuration",
         method: "POST",
         data: data + '&req=setAdditional',
         headers: headers,
         success: function (data) {
            $('#fromAdditional')[0].reset();
            getAdditional();

            Swal.fire({
               title: 'Berhasil Diproses',
               text: 'Data additional baru berhasil ditambah',
               type: 'success',
               onClose: () => {
                  $('.modal').modal('hide');
               }
            });
         },
         error: function (data) {
            setError(data);
         }
      });
   });

   // PUT ADDITIONAL
   $('#fromEditAdditional').submit(function (ev) {
      ev.preventDefault();
      var data = $(this).serialize();

      $.ajax({
         url: host + "/configuration",
         method: "POST",
         data: data + '&req=putAdditional',
         headers: headers,
         success: function (data) {
            getAdditional();
            $('#fromEditAdditional')[0].reset();

            Swal.fire({
               title: 'Berhasil Diproses',
               text: 'Data additional berhasil diupdate',
               type: 'success',
               onClose: () => {
                  $('.modal').modal('hide');
               }
            });
         },
         error: function (data) {
            setError(data);
         }
      });
   });

   // DELETE ADDITIONAL
   $('#delete-additional').click(function () {
      var id = $(this).attr('data-id');

      $.ajax({
         url: host + "/configuration",
         method: "POST",
         data: { id: id, req: 'deleteAdditional' },
         headers: headers,
         success: function (data) {
            getAdditional();

            Swal.fire({
               title: 'Berhasil Diproses',
               text: 'Data berhasil dihapus',
               type: 'success',
               onClose: () => {
                  $('.modal').modal('hide');
               }
            });
         },
         error: function (data) {
            setError(data);
         }
      });
   });

   // PILIH ALAT PESANAN
   $('#formPilihAlat').submit(function(event) {
      event.preventDefault();

      var data = $('#formPilihAlat').serialize();
      $.ajax({
         url     : host+"/api/datapesanan/setalatpesanan",
         method  : "POST",
         headers  : headers,
         data  : data,
         success : function(data) {
            Swal.fire({
               title: 'Berhasil Diproses',
               text: data.message,
               type: 'success',
               onClose: () => {
                  $('.modal').modal('hide');
               }
            });
         },
         error: function (data) {
            setError(data);
         }
      });
   });

});