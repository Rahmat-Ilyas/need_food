@extends('headfood.page')
@section('konten')

<section class="banner_order">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="box">
                    <div class="row pengantaran-main">
                        <div class="col-lg-6">
                            <div class="title_pengantaran">
                                Set Lokasi Pengantaran
                            </div>
                            <div id="maps_area">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3973.279510977135!2d119.53873641448448!3d-5.218711954025023!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dbee7340d6577f3%3A0xb616429b8ba3b9e0!2sPerumahan%20Benteng%20Mutiara!5e0!3m2!1sid!2sid!4v1603965584244!5m2!1sid!2sid" width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                            </div>

                            <div class="form_lokasi">
                                <button class="tombol-custom tombol_lokasi_pengantaran"><i class="icofont-location-pin"></i> Gunakan Lokasi Sekarang</button>
                                <textarea id="text-area" placeholder="Deskripsi Alamat"></textarea>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="title_pengantaran">
                                Detail Pemesan
                            </div>
                            <form class="form_detail_pemesan">
                                <div class="form-row">
                                    <div class="form-group col-lg-6">
                                        <label for="namalengkap">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="namalengkap">
                                      </div>
                                      <div class="form-group col-lg-6">
                                        <label for="no_wa">No WhatsApp</label>
                                        <input type="text" class="form-control" id="no_wa">
                                      </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-lg-6">
                                        <label for="tanggal">Tanggal</label>
                                        <input type="date" class="form-control" id="tanggal">
                                      </div>
                                      <div class="form-group col-lg-6">
                                        <label for="waktu">Waktu</label>
                                        <input type="time" class="form-control" id="waktu">
                                      </div>
                                </div>
                            </form>
                            <div class="text_small_detail_pesan">Pastikan anda memasukkan data dengan benar dan sesuai</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="box">
                    <div class="pengantaran-main">
                        <div class="title_pengantaran">
                            Rangkuman Pemesan
                        </div>
                        <div class="rangkuman_pesanan_content">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="sub_list_pemesanan">Subtotal (3 item) </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="sub_list_currency"> Rp 120.000 </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="sub_list_pemesanan">Ongkos Kirim </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="sub_list_currency"> Rp 120.000 </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="sub_list_pemesanan_total">Total </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="sub_list_currency_total"> Rp 120.000 </div>
                                </div>
                            </div>
                        </div>
                        <button class="tombol-custom tombol-keranjang text-button">Checkout</button>
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
 @endsection