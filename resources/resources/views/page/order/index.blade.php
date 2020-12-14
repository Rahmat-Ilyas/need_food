@extends('headfood.page')
@section('konten')
<section class="banner_order">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="box">
                    <div class="row grid_order">
                        <div class="col-md-2">
                            <div class="box_menu_paket grid_box_paket">
                                <div class="box_title_paket">Menu</div>
                                <div id="item_paket"></div>
                            </div>

                            <div class="box_toogle_menu"> <span class="text_toogle">Menu</span> <i class="icofont-caret-down"></i></div>
                            <ul class="item-toogle">
                                <li class="value_toogle">YAKINIKU</li>
                                <li class="value_toogle">YAKINIKU</li>
                                <li class="value_toogle">YAKINIKU</li>
                            </ul>

                        </div>
                        <div class="col-lg-10">
                            @include('page.order.yakiniku')
                        </div>
                     </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>

<section class="banner_order_additional">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="container box-element">
                        <div class="row">
                            <div class="title-additional-order"> Tambahan Daging </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-9">
                                <div class="row additional_content_box">
                              
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row side-kontent-additional">
                                    <div class="text-info-product">Total Tambahan</div>
                                    <ul class="list_item_text_additional">
                                        <li>- &nbsp; 5 Sirlon US 200g</li>
                                        <li>- &nbsp; 5 Sirlon US 200g</li>
                                    </ul>
                                    <div class="col-sm-12">
                                        <button id="cekapi" class="tombol-custom tombol-keranjang text-button">Masukkan Keranjang</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
