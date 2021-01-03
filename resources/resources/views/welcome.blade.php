<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <link rel="shortcut icon" href="{{ asset('assets/images/fav.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Try Pemesana Kesiniku</title>

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/components.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/pages.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />

    <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>

</head>
<body>

    <!-- <div class="account-pages"></div> -->
    <!-- <div class="clearfix"></div> -->
    <div class="wrapper-page" style="width: 1000px; margin-top: 20px;">
        <div class=" card-box">
            <div class="panel-heading" style="margin-bottom: -20px;">
                <h3 class="text-center">Pemesanan <strong class="text-custom">KESINIKU</strong> </h3>
            </div>
            <hr>

            <form id="formInput">
                <div class="panel-body row">
                    <div class="col-md-6" style="border-right: solid 1px;">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" required="" placeholder="Nama Lengkap..." class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label>Nomor Telepon</label>
                            <input type="number" name="no_telepon" required="" placeholder="Nomor Telepon..." class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label>Nomor WhatsApp</label>
                            <input type="number" name="no_wa" required="" placeholder="Nomor WhatsApp..." class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Antar</label>
                            <input type="date" name="tanggal_antar" required="" placeholder="Tanggal Antar..." class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label>Waktu Antar</label>
                            <select class="form-control" name="waktu_antar" required="">
                                <option value="">-- Waktu Antar --</option>
                                <option value="pagi">Pagi</option>
                                <option value="malam">Malam</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Catatan Pesanan</label>
                            <textarea class="form-control" name="catatan" rows="3" placeholder="Catatan Pesanan..."></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pilih Lokasi Pengantaran</label>
                            <div id="mapView" class="gmaps" style="height: 200px;"></div>
                            <input type="hidden" name="latitude" value="-5.146512141348986" id="setLatitude">
                            <input type="hidden" name="longitude" value="119.43296873064695" id="setLongitude">
                            <input type="hidden" id="biaya_pengiriman" name="biaya_pengiriman" value="10000">
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Lokasi</label>
                            <textarea class="form-control" rows="3" name="deskripsi_lokasi" placeholder="Deskripsi Lokasi..." required=""></textarea>
                        </div>
                        <div class="form-group">
                            <label>Pilih Paket Menu</label>
                            <a href="#" class="btn btn-link btn-sm" data-toggle="modal" data-target=".paket-menu">Pilih Paket Disini..</a>
                        </div>
                        <div class="form-group">
                            <label>Pilih Additional Daging</label>
                            <a href="#" class="btn btn-link btn-sm" data-toggle="modal" data-target=".md-adt">Pilih Additional Disini..</a>
                        </div>
                    </div>

                </div>

                <!-- MODAL PAKET -->
                <div class="modal paket-menu" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myModalLabel">Pilih Paket Pesanan</h4>
                            </div>
                            <div class="modal-body" id="this-paket">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Selesai</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>

                <!-- MODAL ADDITIONAL -->
                <div class="modal md-adt" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myModalLabel">Pilih Additional Daging</h4>
                            </div>
                            <div class="modal-body row" id="this-adt">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Selesai</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
                <div class="form-group text-right m-b-0">
                    <button class="btn btn-default btn-block btn-lg waves-effect waves-light" type="submit">
                        Pesan Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="html-paket" hidden="">
        <div class="card-box">
            <div class="card-body">
                <input class="check" id="checkbox" name="paket_id[]" type="checkbox" style="position: absolute; right: 10px; margin-top: 5px; transform: scale(2);">
                <div class="media" style="margin: -15px;">
                    <div class="media-left">
                        <img class="media-object" id="foto" src="{{ asset('assets/images/paket/img_paket_1607960859.jpg') }}" alt="Card image cap" height="150">
                    </div>
                    <div class="media-body">
                        <h3><b id="nama"></b> <span id="harga"></span></h3>
                        <span id="keterangan"></span>
                        <ul id="item_paket">

                        </ul>
                        <div class="form-group row">
                            <label class="col-md-3">Jumlah:</label>
                            <div class="col-md-7">
                               <input class="demo3" type="number" value="0" name="jumlah_paket[]" autocomplete="off" disabled="">
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>

   <div id="html-adt" hidden="">
       <div class="col-md-4">
        <input class="check" id="adt_checkbox" name="additional_id[]" type="checkbox" style="position: absolute; right: 20px; margin-top: 10px; transform: scale(1.8);">
        <div class="thumbnail">
            <img id="adt_foto" src="assets/images/big/img3.jpg" class="img-responsive" style="max-height: 180px; min-height: 180px; width: 100%;">
            <div class="caption">
                <h3 id="adt_nama_daging"></h3>
                <h5><b id="adt_harga"></b>/<span id="adt_berat"></span></h5>
                <p>
                    <input class="demo4" type="number" value="0" name="jumlah_adt[]" autocomplete="off" disabled="">
                </p>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="configurl" value="{{ url('/configuration') }}">
<input type="hidden" id="host" value="{{ url('/') }}">

<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/detect.js') }}"></script>
<script src="{{ asset('assets/js/fastclick.js') }}"></script>
<script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('assets/js/jquery.blockUI.js') }}"></script>
<script src="{{ asset('assets/js/waves.js') }}"></script>
<script src="{{ asset('assets/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('assets/js/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('assets/plugins/notifyjs/js/notify.js') }}"></script>
<script src="{{ asset('assets/plugins/notifications/notify-metro.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert2/sweetalert2.all.js') }}"></script>


<script src="{{ asset('assets/js/jquery.core.js') }}"></script>
<script src="{{ asset('assets/js/jquery.app.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA5g4U_FtOK7LX789QyNyJe90DmnastiI8&callback=initMap&libraries=&v=weekly" defer></script>

<script>
    $(document).ready(function() {
        var url = $('#configurl').val();
        var host = $('#host').val();

        var headers = {
            "Accept": "application/json",
            "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjA3YWE1Y2M3MDA1YTdjMDA2YzgwZWNjNjIxN2E4Y2VhOTUwMTEzMWNmM2MxOTVmMDk2YjJmZTAwY2I2MGI4ODAxNzE1ZGJmYjQ1YTYzMmIwIn0.eyJhdWQiOiIxIiwianRpIjoiMDdhYTVjYzcwMDVhN2MwMDZjODBlY2M2MjE3YThjZWE5NTAxMTMxY2YzYzE5NWYwOTZiMmZlMDBjYjYwYjg4MDE3MTVkYmZiNDVhNjMyYjAiLCJpYXQiOjE2MDA1MTI5NTEsIm5iZiI6MTYwMDUxMjk1MSwiZXhwIjoxNjMyMDQ4OTUwLCJzdWIiOiIxMyIsInNjb3BlcyI6W119.oHghL81Jc0xq-vvDVFde3QeqYs3s0Me6XukZtGy8G8HegV4LV2ImqKlpw_wdwxBOtKhBfodMFICi0YmNcPov7A",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }


        $.ajax({
            url     : host+"/api/kelolamenu/getpaket",
            method  : "GET",
            headers : headers,
            success : function(data) {
                var htmlPaket = $('#html-paket').html();
                var no = 1;
                $.each(data.result, function(key, val) {
                    var re1 = htmlPaket.replace('id="foto"', 'id="foto'+no+'"');
                    var re2 = re1.replace('id="nama"', 'id="nama'+no+'"');
                    var re3 = re2.replace('id="harga"', 'id="harga'+no+'"');
                    var re4 = re3.replace('id="keterangan"', 'id="keterangan'+no+'"');
                    var re5 = re4.replace('id="item_paket"', 'id="item_paket'+no+'"');
                    var re6 = re5.replace('id="checkbox"', 'id="checkbox'+no+'"');

                    $('#this-paket').append(re6);
                    no = no + 1;
                });

                var nmr = 1
                $.each(data.result, function(key, val) {
                    $(document).find('#foto'+nmr).attr('src', 'assets/images/paket/'+val.foto);
                    $(document).find('#nama'+nmr).text(val.nama);
                    $(document).find('#harga'+nmr).text('(Rp. '+val.harga+'/Pax)');
                    $(document).find('#keterangan'+nmr).text(val.keterangan);
                    $(document).find('#checkbox'+nmr).val(val.id);
                    var item_paket = '';
                    $.each(val.item_paket, function(x, itm) {
                        item_paket += '<li>'+itm+'</li>';
                    });
                    $(document).find('#item_paket'+nmr).html(item_paket);
                    nmr = nmr + 1;
                });

                $('.demo3').TouchSpin({
                    min: 1,
                    max: 100,

                });
            }
        });

        $.ajax({
            url     : host+"/api/kelolamenu/getadditional",
            method  : "GET",
            headers : headers,
            success : function(data) {
                var htmlAdt = $('#html-adt').html();
                var no = 1;
                $.each(data.result, function(key, val) {
                    var re1 = htmlAdt.replace('id="adt_foto"', 'id="adt_foto'+no+'"');
                    var re2 = re1.replace('id="adt_nama_daging"', 'id="adt_nama_daging'+no+'"');
                    var re3 = re2.replace('id="adt_harga"', 'id="adt_harga'+no+'"');
                    var re4 = re3.replace('id="adt_berat"', 'id="adt_berat'+no+'"');
                    var re5 = re4.replace('id="adt_checkbox"', 'id="adt_checkbox'+no+'"');

                    $('#this-adt').append(re5);
                    no = no + 1;
                });

                var nmr = 1
                $.each(data.result, function(key, val) {
                    $(document).find('#adt_foto'+nmr).attr('src', 'assets/images/bahan/'+val.foto);
                    $(document).find('#adt_nama_daging'+nmr).text(val.nama_daging);
                    $(document).find('#adt_harga'+nmr).text('Rp. '+val.harga);
                    $(document).find('#adt_berat'+nmr).text(val.berat);
                    $(document).find('#adt_checkbox'+nmr).val(val.id);
                    nmr = nmr + 1;
                });

                $('.demo4').TouchSpin({
                    min: 1,
                    max: 100,
                });
            }
        });

        $('.paket-menu').on('shown.bs.modal', function() {
            $.Notification.notify('info','top right', 'Informasi', 'Ceklist paket yang ingin dipilih');
        });

        $('.md-adt').on('shown.bs.modal', function() {
            $.Notification.notify('info','top right', 'Informasi', 'Ceklist additional yang ingin dipilih');
        });

        $(document).on('click', '.check', function() {
            if ($(this).prop('checked')) {
                $(this).siblings().find('.demo3').removeAttr('disabled');
                $(this).siblings().find('.demo4').removeAttr('disabled');
            } else {
                $(this).siblings().find('.demo3').attr('disabled', '').val('1');
                $(this).siblings().find('.demo4').attr('disabled', '').val('1');
            }
        });

        $('#formInput').submit(function(event) {
            event.preventDefault()

            data = $(this).serialize();

            $.ajax({
                url     : host+"/api/datapesanan/store",
                method  : "POST",
                headers : headers,
                data    : data,
                success : function(data) {
                    Swal.fire({
                       title: 'Berhasil Diproses',
                       text: 'Pesanan sedang di proses, mohon segera lakukan pembayaran',
                       type: 'success',
                       onClose: () => { location.href = 'trypemesanan'; }
                   });
                },
                error: function (data) {
                    setError(data);
                }
            });

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

 });
</script>

<script>
    var marker;

    function initMap() {
        const center = { lat: -5.146512141348986, lng: 119.43296873064695 };

        const map = new google.maps.Map(document.getElementById("mapView"), {
            zoom: 14,
            center: center,
        });

        marker = new google.maps.Marker({
            position: center,
            map,
        });

        google.maps.event.addListener(map, 'click', function(event) {
            setMarker(this, event.latLng);
        });

    }

    function setMarker(map, markerPosition) {
        if( marker ){
            marker.setPosition(markerPosition);
        } else {
            marker = new google.maps.Marker({
                position: markerPosition,
                map: map
            });
        }
        map.setZoom(16);
        map.setCenter(markerPosition);

            // isi nilai koordinat ke form
            document.getElementById("setLongitude").value = markerPosition.lng();
            document.getElementById("setLatitude").value = markerPosition.lat();

            // Get Lokasi
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'latLng': markerPosition}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        infowindow.setContent(results[1].formatted_address);
                        infowindow.open(map, marker);
                    }
                } else {
                    console.log("Geocoder failed due to: " + status);
                }
            });
        }

    </script>
</body>
</html>