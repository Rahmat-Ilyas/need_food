@extends('headfood.page')
@section('konten')
<section class="banner_order">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="box paket_skelton"></div>
                <div class="box paket_content">
                    <div class="row grid_order">
                        <div class="col-md-3">
                            <div class="titleCard grid_title_paket">Menu</div>
                            <div id="category_paket_area_mobile">
                                <nav id="menuMobileCategory">
                                    <label for=""><span id="labelKategori">Pilih Kategori</span>
                                       <i class="icofont-caret-down" id="icon_caret_mb"></i>
                                    </label>
                                    <ul class="menu_dp_mobile">
                                        <li> <a href="javascript:void(0)" class="menu_paketMobile" data-text="Home Service" data-action="1"> Home Service</a> </li>
                                        <li> <a  href="javascript:void(0)" class="menu_paketMobile" data-text="Bahan Saja" data-action="2">Bahan Saja</a> </li>
                                        <li> <a href="javascript:void(0)" class="menu_paketMobile" data-text="Food Stall" data-action="3">Food Stall</a> </li>
                                    </ul>
                                </nav>
                            </div>
                            <div id="category_paket_area">
                                <div id="firstMenuPaket" class="menu_paket text-center" data-action="1">
                                    HOME SERVICE
                                </div>
                                <div class="menu_paket text-center" data-action="2">
                                    BAHAN SAJA
                                </div>
                                <div class="menu_paket text-center" data-action="3">
                                    FOOD STALL
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="info_ketentuan">
                               
                             </div>   
                            <div class="row contentMenu">

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

                    <div class="makeleton_additonal"></div>

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

                                    </ul>
                                    <div class="col-sm-12">
                                        <button id="additional_get"
                                            class="tombol-custom tombol-keranjang text-button">Masukkan
                                            Keranjang</button>
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

<div class="modal fade bd-example-modal-lg" id="cartmodal" tabindex="-1" role="dialog" aria-labelledby="cartmodalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="modal-header">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"><i class="icofont-cart"></i> Keranjang </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body-cart">
                <div class="totalGroup"></div>
            </div>
            <div class="modal-footer" id="modal-footer">
                <button class="tombol-lg-modal tombol-keranjang text-button">Checkout Keranjang <i
                        class="icofont-arrow-right"></i></button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('skript')
<script>
    $(document).ready(function () {
        $('.MenuForOrder').css('font-weight', 'bold');
        $('.paket_content').hide();
        $('.box-element').hide();
        // $('.paket_skelton').html(makeleton_paket());
        // $('.makeleton_additonal').html(makeleton_additional());

         $('#category_paket_area_mobile').on('click',function () {
                 $(this).parent().toggleClass('showContent');
                 $('.menu_dp_mobile').slideToggle();
             })

    });
</script>
@endpush