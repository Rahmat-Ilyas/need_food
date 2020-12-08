@extends('headfood.page')
@section('konten')

<section class="banner_order">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="container box-element">
                        <div class="row">
                            <div class="title-keranjang-order"> Keranjang Belanja </div>
                        </div>

                       <div class="row">
                           <div class="col-lg-8">
                               <div class="container mt-3">
                                <div class="box-keranjang">
                                    <div class="row">
                                        <div class="col-lg-8">
                                              <div class="row">
                                                  <div class="col-lg-6">
                                                      <img src="{{ asset('page/assets/images/product/shabu.jpg') }}" class="img-keranjang">
                                                  </div>
                                                  <div class="col-lg-6 group-text-keranjang">
                                                      <div class="text-image-keranjang">
                                                          Sirlon US 200 g
                                                      </div>
                                                      <div class="text-currency-keranjang"> Rp. 100.000 </div>
                                                  </div>
                                              </div>
                                         </div>
                                         <div class="col-lg-4">
                                                <div class="row form-keranjang">
                                                    <button type="button" class="tombol_keranjang_number btn-number">   <i class="icofont-minus icon-number_additional"></i> </button>
                                                    <input type="text" name="quant[1]"
                                                    class="form-nedd-keranjang input-number" value="1" min="1" max="1000">
                                                    <button type="button" class="tombol_keranjang_number btn-number">   <i class="icofont-plus icon-number_additional"></i></button>
                                                    <div class="icon-delete">
                                                        <i class="icofont-ui-delete"></i>
                                                    </div>
                                                </div>
                                         </div>
                                    </div>
                                </div>
                               </div>
                               <div class="container mt-3">
                                <div class="box-keranjang">
                                    <div class="row">
                                        <div class="col-lg-8">
                                              <div class="row">
                                                  <div class="col-lg-6">
                                                      <img src="{{ asset('page/assets/images/product/shabu.jpg') }}" class="img-keranjang">
                                                  </div>
                                                  <div class="col-lg-6 group-text-keranjang">
                                                      <div class="text-image-keranjang">
                                                          Sirlon US 200 g
                                                      </div>
                                                      <div class="text-currency-keranjang"> Rp. 100.000 </div>
                                                  </div>
                                              </div>
                                         </div>
                                         <div class="col-lg-4">
                                                <div class="row form-keranjang">
                                                    <button type="button" class="tombol_keranjang_number btn-number">   <i class="icofont-minus icon-number_additional"></i> </button>
                                                    <input type="text" name="quant[1]"
                                                    class="form-nedd-keranjang input-number" value="1" min="1" max="1000">
                                                    <button type="button" class="tombol_keranjang_number btn-number">   <i class="icofont-plus icon-number_additional"></i></button>
                                                    <div class="icon-delete">
                                                        <i class="icofont-ui-delete"></i>
                                                    </div>
                                                </div>
                                         </div>
                                    </div>
                                </div>
                               </div>
                               <button class="tombol-custom tombol_pesanan_cart grid_button_cart">TAMBAH PESANAN</button>
                               <hr class="line_cart">
                               <div class="footer_box_cart">
                                    <a href="javascript:;" onclick="show_modal_detail('Detail Alat','/keranjang/detail_alat')" class="link_alat_cart">Lihat alat <i class="icofont-long-arrow-right"></i></a>
                                    <div class="text_keterangan_cart">* include alat jika Minimum 5 pcs yakiniku atau mix 4 yakiniku + 3 shabu</div>
                                </div>
                           </div>
                           <div class="col-lg-4">
                                <div class="box-harga">
                                    <div class="konten_box_harga">
                                        <div class="text_title_box_harga">TOTAL HARGA</div>      
                                        <div class="box_total_keranjang">Rp 120.000</div>
                                    </div> 
                                </div>
                                    <button class="tombol-custom tombol-keranjang text-button grid_button_cart">BUAT PESANAN</button>
                                    <div class="text_danger_info_cart">* Pesanan Minimum 2 pcs</div>
                           </div>
                       </div>
                       {{-- <div class="row">
                           <div class="col-lg-8">
                              <div class="container">
                                <div class="row keranjangcard">
                                    <div class="col-lg-4">
                                        <img src="{{ asset('page/assets/images/product/shabu.jpg') }}" class="img-keranjang">
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="text-image-keranjang">
                                            Sirlon US 200 g
                                        </div>
                                        <div class="text-currency-keranjang"> Rp. 100.000 </div>
                                    </div>
                                    <div class="col-lg-4">
                                       
                                    </div>
                                </div>
                              </div>
                           </div>
                           <div class="col-lg-4">

                           </div>
                       </div> --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection