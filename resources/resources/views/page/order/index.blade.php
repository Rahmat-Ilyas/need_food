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
                                        <button id="additional_get"  class="tombol-custom tombol-keranjang text-button">Masukkan Keranjang</button>
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

<div class="flat_button grid_button_flag">
    <i class="icofont-shopping-cart" id="icon_flat"></i>
    <span class="badge badge-danger pill_number">0</span>
</div>

<div class="modal fade bd-example-modal-lg" id="cartmodal" tabindex="-1" role="dialog" aria-labelledby="cartmodalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" id="modal-header">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-title"><i class="icofont-cart"></i> Keranjang </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal-body-cart">  

        </div>
        <div class="modal-footer" id="modal-footer">
            <button class="tombol-lg-modal tombol-keranjang text-button"> Checkout Keranjang</button>
          </div>
      </div>
    </div>
  </div>

@endsection
