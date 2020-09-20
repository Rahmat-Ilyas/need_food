@extends('admin.layout')
@section('content')')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Paket Menu</h4>
                <ol class="breadcrumb">
                    <li>
                        <a href="#">NeedFood</a>
                    </li>
                    <li>
                        <a href="#">Kelola Menu</a>
                    </li>
                    <li class="active">
                        Paket Menu
                    </li>
                </ol>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card-box">
                <h4 class="header-title m-t-0"><b>Data Paket Menu</b></h4>
                <button type="button" class="btn btn-default btn-rounded waves-effect waves-light m-t-10"><i class="fa fa-plus-circle"></i> &nbsp;Tambah Paket</button>
                <div class="row m-t-20">
                    <div class="col-md-4">
                        <div class="price_card text-center">
                            <div class="pricing-header bg-primary">
                                <span class="price">100K/pax</span>
                                <span class="name">Paket Yakiniku</span>
                            </div>
                            <ul class="price-features">
                                <li>Tasty Beef</li>
                                <li>Low Fat Beef</li>
                                <li>Sosis (250 gr)</li>
                            </ul>
                            <hr class="m-b-0">
                            <div class="row" style="padding: 0 10px 0 10px;">
                                <div class="col-md-4 m-l-20" style="padding: 5px;">
                                    <button class="btn btn-block btn-inverse btn-sm waves-effect waves-light"><i class="md-shopping-basket"></i> Set Bahan</button>
                                </div>
                                <div class="col-md-4" style="padding: 5px;">
                                    <button class="btn btn-block btn-purple btn-sm waves-effect waves-light"><i class="md-restaurant-menu"></i> Set Alat</button>
                                </div>
                                <div class="col-md-4" style="padding: 5px;">
                                    <button class="btn btn-block btn-info btn-sm waves-effect waves-light"><i class="fa fa-edit"></i> Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="price_card text-center">
                            <div class="pricing-header bg-primary">
                                <span class="price">100K/pax</span>
                                <span class="name">Paket Shabu</span>
                            </div>
                            <ul class="price-features">
                                <li>Suki</li>
                                <li>Daging</li>
                                <li>&nbsp;</li>
                            </ul>
                            <hr class="m-b-0">
                            <div class="row" style="padding: 0 10px 0 10px;">
                                <div class="col-md-4 m-l-20" style="padding: 5px;">
                                    <button class="btn btn-block btn-inverse btn-sm waves-effect waves-light"><i class="md-shopping-basket"></i> Set Bahan</button>
                                </div>
                                <div class="col-md-4" style="padding: 5px;">
                                    <button class="btn btn-block btn-purple btn-sm waves-effect waves-light"><i class="md-restaurant-menu"></i> Set Alat</button>
                                </div>
                                <div class="col-md-4" style="padding: 5px;">
                                    <button class="btn btn-block btn-info btn-sm waves-effect waves-light"><i class="fa fa-edit"></i> Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="price_card text-center">
                            <div class="pricing-header bg-primary">
                                <span class="price">60K/pax</span>
                                <span class="name">Paket Shabu 2</span>
                            </div>
                            <ul class="price-features">
                                <li>Suki</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                            </ul>
                            <hr class="m-b-0">
                            <div class="row" style="padding: 0 10px 0 10px;">
                                <div class="col-md-4 m-l-20" style="padding: 5px;">
                                    <button class="btn btn-block btn-inverse btn-sm waves-effect waves-light"><i class="md-shopping-basket"></i> Set Bahan</button>
                                </div>
                                <div class="col-md-4" style="padding: 5px;">
                                    <button class="btn btn-block btn-purple btn-sm waves-effect waves-light"><i class="md-restaurant-menu"></i> Set Alat</button>
                                </div>
                                <div class="col-md-4" style="padding: 5px;">
                                    <button class="btn btn-block btn-info btn-sm waves-effect waves-light"><i class="fa fa-edit"></i> Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
@endsection