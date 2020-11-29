@extends('headfood.page')
@section('konten')
<section class="banner_order">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="box">
                    <nav class="nav-order">
                        <div class="nav" id="nav-tab" role="tablist">
                            <a class="tabs-order" data-toggle="tab" href="#yakiniku" role="tab" aria-controls="yakiniku"
                                aria-selected="false">Yakiniku</a>
                            <a class="tabs-order" data-toggle="tab" href="#shabu1" role="tab" aria-controls="shabu1"
                                aria-selected="false">Shabu 1</a>
                            <a class="tabs-order" data-toggle="tab" href="#shabu2" role="tab" aria-controls="shabu2"
                                aria-selected="false"> Shabu 2</a>
                            <div class="animation start-home"></div>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="yakiniku" role="tabpanel"
                            aria-labelledby="yakiniku-tab">
                            @include('page.order.yakiniku')
                        </div>
                        <div class="tab-pane fade" id="shabu1" role="tabpanel" aria-labelledby="shabu1-tab">
                            @include('page.order.shabu')
                        </div>
                        <div class="tab-pane fade" id="shabu2" role="tabpanel" aria-labelledby="shabu2-tab">
                            @include('page.order.shabuhh')
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
                                    <div class="col-sm-3 grid_element">
                                        <div class="card_additional">
                                            <img src="{{ asset('page/assets/images/product/additional/additional.png') }}"
                                                class="image_additonal" alt="">
                                            <div class="text-image">
                                                Sirlon US 200 g
                                            </div>
                                            <input type="checkbox" class="checbox_image" />
                                            <div class="card_additional_body">
                                                {{-- form_card_additonal_product --}}
                                                <div class="row form_card_additonal_product">
                                                   <div class="col-sm-12">
                                                        <div class="card_additional_text">Rp. 100.000</div>
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="tombol_additional btn-number"
                                                                disabled="disabled" data-type="minus"
                                                                data-field="quant[1]">
                                                                <i class="icofont-minus icon-number_additional"></i>
                                                            </button>
                                                        </span>
                                                        <input type="text" name="quant[1]"
                                                            class="form-nedd_additional input-number" value="1" min="1" max="1000">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="tombol_additional btn-number"
                                                                data-type="plus" data-field="quant[1]">
                                                                <i class="icofont-plus icon-number_additional"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                     </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 grid_element">
                                        <div class="card_additional">
                                            <img src="{{ asset('page/assets/images/product/additional/additional.png') }}"
                                                class="image_additonal" alt="">
                                            <div class="text-image">
                                                Sirlon US 200 g
                                            </div>
                                            <input type="checkbox" class="checbox_image" />
                                            <div class="card_additional_body">
                                                {{-- form_card_additonal_product --}}
                                                <div class="row form_card_additonal_product">
                                                   <div class="col-sm-12">
                                                        <div class="card_additional_text">Rp. 100.000</div>
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="tombol_additional btn-number"
                                                                disabled="disabled" data-type="minus"
                                                                data-field="quant[1]">
                                                                <i class="icofont-minus icon-number_additional"></i>
                                                            </button>
                                                        </span>
                                                        <input type="text" name="quant[1]"
                                                            class="form-nedd_additional input-number" value="1" min="1" max="1000">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="tombol_additional btn-number"
                                                                data-type="plus" data-field="quant[1]">
                                                                <i class="icofont-plus icon-number_additional"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                     </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 grid_element">
                                        <div class="card_additional">
                                            <img src="{{ asset('page/assets/images/product/additional/additional.png') }}"
                                                class="image_additonal" alt="">
                                            <div class="text-image">
                                                Sirlon US 200 g
                                            </div>
                                            <input type="checkbox" class="checbox_image" />
                                            <div class="card_additional_body">
                                                {{-- form_card_additonal_product --}}
                                                <div class="row form_card_additonal_product">
                                                   <div class="col-sm-12">
                                                        <div class="card_additional_text">Rp. 100.000</div>
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="tombol_additional btn-number"
                                                                disabled="disabled" data-type="minus"
                                                                data-field="quant[1]">
                                                                <i class="icofont-minus icon-number_additional"></i>
                                                            </button>
                                                        </span>
                                                        <input type="text" name="quant[1]"
                                                            class="form-nedd_additional input-number" value="1" min="1" max="1000">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="tombol_additional btn-number"
                                                                data-type="plus" data-field="quant[1]">
                                                                <i class="icofont-plus icon-number_additional"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                     </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row additional_content_box">
                                    <div class="col-sm-3 grid_element">
                                        <div class="card_additional">
                                            <img src="{{ asset('page/assets/images/product/additional/additional.png') }}"
                                                class="image_additonal" alt="">
                                            <div class="text-image">
                                                Sirlon US 200 g
                                            </div>
                                            <input type="checkbox" class="checbox_image" />
                                            <div class="card_additional_body">
                                                {{-- form_card_additonal_product --}}
                                                <div class="row form_card_additonal_product">
                                                   <div class="col-sm-12">
                                                        <div class="card_additional_text">Rp. 100.000</div>
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="tombol_additional btn-number"
                                                                disabled="disabled" data-type="minus"
                                                                data-field="quant[1]">
                                                                <i class="icofont-minus icon-number_additional"></i>
                                                            </button>
                                                        </span>
                                                        <input type="text" name="quant[1]"
                                                            class="form-nedd_additional input-number" value="1" min="1" max="1000">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="tombol_additional btn-number"
                                                                data-type="plus" data-field="quant[1]">
                                                                <i class="icofont-plus icon-number_additional"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                     </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 grid_element">
                                        <div class="card_additional">
                                            <img src="{{ asset('page/assets/images/product/additional/additional.png') }}"
                                                class="image_additonal" alt="">
                                            <div class="text-image">
                                                Sirlon US 200 g
                                            </div>
                                            <input type="checkbox" class="checbox_image" />
                                            <div class="card_additional_body">
                                                {{-- form_card_additonal_product --}}
                                                <div class="row form_card_additonal_product">
                                                   <div class="col-sm-12">
                                                        <div class="card_additional_text">Rp. 100.000</div>
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="tombol_additional btn-number"
                                                                disabled="disabled" data-type="minus"
                                                                data-field="quant[1]">
                                                                <i class="icofont-minus icon-number_additional"></i>
                                                            </button>
                                                        </span>
                                                        <input type="text" name="quant[1]"
                                                            class="form-nedd_additional input-number" value="1" min="1" max="1000">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="tombol_additional btn-number"
                                                                data-type="plus" data-field="quant[1]">
                                                                <i class="icofont-plus icon-number_additional"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                     </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 grid_element">
                                        <div class="card_additional">
                                            <img src="{{ asset('page/assets/images/product/additional/additional.png') }}"
                                                class="image_additonal" alt="">
                                            <div class="text-image">
                                                Sirlon US 200 g
                                            </div>
                                            <input type="checkbox" class="checbox_image" />
                                            <div class="card_additional_body">
                                                {{-- form_card_additonal_product --}}
                                                <div class="row form_card_additonal_product">
                                                   <div class="col-sm-12">
                                                        <div class="card_additional_text">Rp. 100.000</div>
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="tombol_additional btn-number"
                                                                disabled="disabled" data-type="minus"
                                                                data-field="quant[1]">
                                                                <i class="icofont-minus icon-number_additional"></i>
                                                            </button>
                                                        </span>
                                                        <input type="text" name="quant[1]"
                                                            class="form-nedd_additional input-number" value="1" min="1" max="1000">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="tombol_additional btn-number"
                                                                data-type="plus" data-field="quant[1]">
                                                                <i class="icofont-plus icon-number_additional"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                     </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
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
                                        <button class="tombol-custom tombol-keranjang">Masukkan Keranjang</button>
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