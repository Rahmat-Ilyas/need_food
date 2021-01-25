@extends('headfood.page')
@section('konten')
<form class="form_pengantaran ">
<section class="banner_order">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">

                <div class="form_first">

                </div>

                <div class="box">
                    <div class="row pengantaran-main">  
                        <div class="col-lg-6">
                            <div class="title_pengantaran">
                                Set Lokasi Pengantaran
                            </div>
                            <div id="mapView" class="maps_area"></div>
                            <input type="hidden" name="latitude" value="-5.146512141348986" id="setLatitude">
                            <input type="hidden" name="longitude" value="119.43296873064695" id="setLongitude">
                            <input type="hidden" id="biaya_pengiriman" name="biaya_pengiriman" value="10000">
                            <div class="form_lokasi">
                                <button class="tombol-custom tombol_lokasi_pengantaran"><i class="icofont-location-pin"></i> Gunakan Lokasi Sekarang</button>
                                <textarea id="text-area" name="deskripsi_lokasi" class="grid_deskripsi" placeholder="Deskripsi Alamat"></textarea>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="title_pengantaran">
                                Detail Pemesan
                            </div>
                           
                                <div class="form-row">
                                    <div class="form-group col-lg-12">
                                        <label for="namalengkap">Nama Lengkap</label>
                                        <input type="text" name="nama" class="form-control" id="namalengkap">
                                      </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-lg-6">
                                        <label for="no_telepon">No Telepon</label>
                                        <input type="number" name="no_telepon" class="form-control" id="no_telepon">
                                      </div>
                                      <div class="form-group col-lg-6">
                                        <label for="no_wa">No WhatsApp</label>
                                        <input type="number" name="no_wa" class="form-control" id="no_wa">
                                      </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-lg-6">
                                        <label for="tanggal_antar">Tanggal</label>
                                        <input type="date" name="tanggal_antar" class="form-control" id="tanggal_antar">
                                      </div>
                                      <div class="form-group col-lg-6">
                                        <label for="waktu_antar">Waktu</label>
                                        <select class="form-control selectpicker" name="waktu_antar" title="Pilih Waktu Antar">
                                            <option value="Pagi">Pagi</option>
                                            <option value="Malam">Malam</option>
                                          </select>
            
                                      </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-lg-12">
                                        <label for="catatan">Catatan</label>
                                        <textarea id="text-area" name="catatan" placeholder="Catatan"></textarea>
                                    </div>
                                </div>

                                <div class="form-row" id="paket_data">
                                    
                                </div>
                         
                            <div class="text_small_detail_pesan">Pastikan anda memasukkan data dengan benar dan sesuai</div>
                        </div>
                    
                        <div class="container">
                            <div class="row validation_error">
                                <div class="col-lg-6 offset-lg-3 mt-2">
                                    <div class="alert">
                                        <span class="closebtn">&times;</span> 
                                        <strong>Form Belum Lengkap !!!</strong> 
                                        <ul class="list_error">
                                          
                                        </ul>
                                      </div>

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="col-lg-4">
               
                <div class="list_currency_first">

                </div>

                <div class="box">
                    <div class="pengantaran-main">
                        <div class="title_pengantaran">
                            Rangkuman Pemesan
                        </div>
                        <div class="rangkuman_pesanan_content">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="sub_list_pemesanan" id="label_subtotal"></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="sub_list_currency" id="subtotal"> Rp  </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="sub_list_pemesanan">Ongkos Kirim </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="sub_list_currency"> Rp. 50,000 </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="sub_list_pemesanan_total">Total </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="sub_list_currency_total">  </div>
                                </div>
                            </div>
                        </div>
                        <button id="submit_pengantaran" class="tombol-custom tombol-keranjang text-button">Checkout</button>
                        <hr class="line_cart_pemesanan">
                        <div class="ongkos_kirim">
                            <div class="title_ongkos">Tarif Ongkos Kirim</div>
                            <div class="row ongkos_content">
                                <div class="place_pricing">Makassar</div>
                                <i class="icofont-long-arrow-right icont-ongkos-1"></i>
                                <div class="side_pricing">Free</div>
                            </div>
                            <div class="row ongkos_content">
                                <div class="place_pricing">Gowa</div>
                                <i class="icofont-long-arrow-right icont-ongkos-2"></i>
                                <div class="side_pricing">Rp 50.000</div>
                            </div>
                            <div class="row ongkos_content">
                                <div class="place_pricing">Maros</div>
                                <i class="icofont-long-arrow-right icont-ongkos-3"></i>
                                <div class="side_pricing">Rp 50.000</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</section>   
</form>       

<div id="loading" hidden="">
    <span class="loader" hidden=""></span>
    <div class="textLoader">
        <center>
            <b>Please Wait ... </b>
        </center>
    </div>
</div>

 @endsection
 @push('skript')
     <script>
          var url = $('meta[name="host_url"]').attr('content');
          var sub_total = 0;
          var total = 0;
         $(document).ready(function () {
            $('.validation_error').css('display','none');
            $('.pengantaran-main').hide();
            $('.form_first').html(makeleton_form());   
            $('.list_currency_first').html(makeleton_list_price());

            $.ajax({
            url     : url+'/getpaket_to_delivery',
            method  : "GET",
            success : function(data) {
                console.log(data);
                var html = '';
                $.each(data, function (indexInArray, valueOfElement) { 
                    if (valueOfElement.type == 'paket') {
                        html+='<input type="hidden" value="'+valueOfElement.id+'" name="paket_id[]">';
                        html+='<input type="hidden" value="'+valueOfElement.kuantitas+'" name="jumlah_paket[]">';
                    }else{
                        html+='<input type="hidden" value="'+valueOfElement.id+'" name="additional_id[]">';
                        html+='<input type="hidden" value="'+valueOfElement.kuantitas+'" name="jumlah_adt[]">';
                    }
                    sub_total+=parseInt(valueOfElement.harga * valueOfElement.kuantitas);
                });
                $('#subtotal').html('Rp '+sub_total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#paket_data').append(html);
                $('#label_subtotal').html(`Sub Total (${data.length} Item)`);
                total = sub_total+50000;
                $('.sub_list_currency_total').html(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            }
             });

             $('#submit_pengantaran').on('click', function (event) {
                 event.preventDefault();
                $.ajax({
                    url     : url+"/api/datapesanan/store",
                    method  : "POST",
                    headers : headers(),
                    data    :$('.form_pengantaran').serialize(),
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function (evt) {
                            if (evt.lengthComputable) {
                                $("#loading, .loader").removeAttr('hidden');
                            }
                        }, false);
                        return xhr;
                    },
                    success : function(data) {
                        $("#loading, .loader").attr('hidden', '');
                        Swal.fire({
                        title: 'Berhasil Diproses',
                        text: 'Pesanan sedang di proses, mohon segera lakukan pembayaran',
                        type: 'success',
                        onClose: () => { location.href = url; }
                    });
                    },
                    error: function (res) {
                        var text = '';
                        $("#loading, .loader").attr('hidden', '');
                        $('.validation_error').css('display','block');
                        $('html, body').animate({
                            scrollTop: $(".validation_error").offset().top
                        }, 1500);
                        console.log(res.responseJSON.message);
                        $.each(res.responseJSON.message, function (indexInArray, valueOfElement) { 
                            text += '<li>'+valueOfElement+'</li>';
                        });
                        $('.list_error').append(text);
                    }
                });
             })

             $('.closebtn').on('click', function () {
                $('.validation_error').css('display','none');
                $('html, body').animate({
                    scrollTop: $(".banner_order").offset().top
                }, 1500);
             })

         });
     </script>
 @endpush