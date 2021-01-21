@extends('kitchen.layout')
@section('content')')
<!-- Start content -->
<div class="content">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Dashboard</h4>
                <ol class="breadcrumb">
                    <li>
                        <a href="#">Kesiniku</a>
                    </li>
                    <li class="active">
                        Dashboard
                    </li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="widget-bg-color-icon card-box fadeInDown animated">
                    <div class="bg-icon bg-icon-success pull-left">
                        <i class="md md-trending-up text-success"></i>
                    </div>
                    <div class="text-right">
                        <h3 class="text-dark" style="font-size: 20px;"><b>Rp. </b><b class="counter" id="total_debit"></b></h3>
                        <p class="text-muted">Total Debit Hari Ini</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="widget-bg-color-icon card-box">
                    <div class="bg-icon bg-icon-danger pull-left">
                        <i class="md md-trending-down text-danger"></i>
                    </div>
                    <div class="text-right">
                        <h3 class="text-dark" style="font-size: 20px;"><b>Rp. </b><b class="counter" id="total_kredit">0</b></h3>
                        <p class="text-muted">Total Kredit Hari Ini</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="widget-bg-color-icon card-box">
                    <div class="bg-icon bg-icon-info pull-left">
                        <i class="md md-add-shopping-cart text-info"></i>
                    </div>
                    <div class="text-right">
                        <h3 class="text-dark"><b class="counter" id="total_order">0</b><span> Order</span></h3>
                        <p class="text-muted">Pesanan Hari Ini</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="widget-bg-color-icon card-box">
                    <div class="bg-icon bg-icon-purple pull-left">
                        <i class="md-restaurant-menu text-purple"></i>
                    </div>
                    <div class="text-right">
                        <h3 class="text-dark"><b class="counter" id="alat_keluar">0</b><span> pcs</span></h3>
                        <p class="text-muted">Total Alat Keluar</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="portlet"><!-- /primary heading -->
                    <div class="portlet-heading">
                        <h3 class="portlet-title text-dark">
                            Data Keuangan ({{ date('d/m/Y', strtotime(date('dmy')) - (86400*8)).' - '.date('d/m/Y') }})
                        </h3>
                        <div class="portlet-widgets">
                            <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                            <span class="divider"></span>
                            <a data-toggle="collapse" data-parent="#accordion1" href="#portlet7"><i class="ion-minus-round"></i></a>
                            <span class="divider"></span>
                            <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div id="portlet7" class="panel-collapse collapse in">
                        <div class="portlet-body">
                            <div id="keuangan-chart" style="height: 320px;">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="portlet"><!-- /primary heading -->
                    <div class="portlet-heading">
                        <h3 class="portlet-title text-dark">
                            Data Pesanan ({{ date('d/m/Y', strtotime(date('dmy')) - (86400*8)).' - '.date('d/m/Y') }})
                        </h3>
                        <div class="portlet-widgets">
                            <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                            <span class="divider"></span>
                            <a data-toggle="collapse" data-parent="#accordion1" href="#portlet3"><i class="ion-minus-round"></i></a>
                            <span class="divider"></span>
                            <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div id="portlet1" class="panel-collapse collapse in">
                        <div class="portlet-body">
                            <div id="pesanan-cart" style="height: 320px;" class="flot-chart"></div>
                        </div>
                    </div>
                </div>
            </div>

             <div class="col-lg-6">
                <div class="portlet"><!-- /primary heading -->
                    <div class="portlet-heading">
                        <h3 class="portlet-title text-dark">
                            Data Penjualan Paket Pertahun {{ date('Y') }}
                        </h3>
                        <div class="portlet-widgets">
                            <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                            <span class="divider"></span>
                            <a data-toggle="collapse" data-parent="#accordion1" href="#portlet3"><i class="ion-minus-round"></i></a>
                            <span class="divider"></span>
                            <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div id="portlet3" class="panel-collapse collapse in">
                        <div class="portlet-body">
                            <div id="donut-chart">
                                <div id="paket-terjual-cart" class="flot-chart" style="height: 320px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div> 
</div>
@endsection

@section('javascript')
<script src="{{ asset('assets/plugins/flot-chart/jquery.flot.min.js') }}"></script>
<script src="{{ asset('assets/plugins/flot-chart/jquery.flot.pie.js') }}"></script>
{{-- <script src="{{ asset('assets/plugins/flot-chart/jquery.flot.time.js') }}"></script>
<script src="{{ asset('assets/plugins/flot-chart/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('assets/plugins/flot-chart/jquery.flot.selection.js') }}"></script>
<script src="{{ asset('assets/plugins/flot-chart/jquery.flot.stack.js') }}"></script> --}}
<script src="{{ asset('assets/plugins/flot-chart/jquery.flot.orderBars.min.js') }}"></script>
{{-- <script src="{{ asset('assets/plugins/flot-chart/jquery.flot.crosshair.js') }}"></script> --}}
<script src="{{ asset('assets/plugins/flot-chart/jquery.flot.tooltip.min.js') }}"></script>
{{-- <script src="{{ asset('assets/pages/jquery.flot.init.js') }}"></script> --}}
<script src="{{ asset('assets/plugins/counterup/jquery.counterup.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var url = $('#configurl').val();
        var host = $('#host').val();

        var headers = {
            "Accept"        : "application/json",
            "Authorization" : "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjA3YWE1Y2M3MDA1YTdjMDA2YzgwZWNjNjIxN2E4Y2VhOTUwMTEzMWNmM2MxOTVmMDk2YjJmZTAwY2I2MGI4ODAxNzE1ZGJmYjQ1YTYzMmIwIn0.eyJhdWQiOiIxIiwianRpIjoiMDdhYTVjYzcwMDVhN2MwMDZjODBlY2M2MjE3YThjZWE5NTAxMTMxY2YzYzE5NWYwOTZiMmZlMDBjYjYwYjg4MDE3MTVkYmZiNDVhNjMyYjAiLCJpYXQiOjE2MDA1MTI5NTEsIm5iZiI6MTYwMDUxMjk1MSwiZXhwIjoxNjMyMDQ4OTUwLCJzdWIiOiIxMyIsInNjb3BlcyI6W119.oHghL81Jc0xq-vvDVFde3QeqYs3s0Me6XukZtGy8G8HegV4LV2ImqKlpw_wdwxBOtKhBfodMFICi0YmNcPov7A",
            'X-CSRF-TOKEN'  : $('meta[name="csrf-token"]').attr('content')
        }

        // GET DATA
        getData();
        function getData() {
            $.ajax({
                url: host + "/configuration",
                method: "POST",
                headers: headers,
                data: { req: 'getDataDashboard' },
                success: function (data) {
                    $('#total_debit').text(data.total_debit);
                    $('#total_kredit').text(data.total_kredit);
                    $('#total_order').text(data.total_order);
                    $('#alat_keluar').text(data.alat_keluar);
                    $('.counter').counterUp({
                        delay: 100,
                        time: 1200
                    });
                }
            });
        }

        // CART KEUANGAN
        $.ajax({
            url: host + "/configuration",
            method: "POST",
            headers: headers,
            data: { req: 'cartKeuangan' },
            success : function(data) {
                cartKeuangan(data);
            },
        });

        function cartKeuangan(data) {
            var options = {
                bars : {
                    show : true,
                    barWidth : 0.2,
                    fill : 1
                },
                grid : {
                    show : true,
                    aboveData : false,
                    labelMargin : 5,
                    axisMargin : 0,
                    borderWidth : 1,
                    minBorderMargin : 5,
                    clickable : true,
                    hoverable : true,
                    autoHighlight : false,
                    mouseActiveRadius : 20,
                    borderColor : '#f5f5f5'
                },
                series : {
                    stack : 0
                },
                legend : {
                    position : "ne",
                    margin : [0, -24],
                    noColumns : 0,
                    labelBoxBorderColor : null,
                    labelFormatter : function(label, series) {
                        // just add some space to labes
                        return '' + label + '&nbsp;&nbsp;';
                    },
                    width : 30,
                    height : 2
                },
                yaxis : {
                    min: 0,
                    tickDecimals: 0,
                    tickColor : '#f5f5f5',
                    font : {
                        color : '#bdbdbd'
                    },
                },
                xaxis : {
                    tickColor : '#f5f5f5',
                    font : {
                        color : '#bdbdbd'
                    },
                    ticks: data.ticks
                },
                colors : ["#81c868", "#f05050", "#34d3eb"],
                tooltip : true, //activate tooltip
                tooltipOpts : {
                    content : "%s : Rp. %y",
                    shifts : {
                        x : -30,
                        y : -50
                    },
                    defaultTheme : false
                }
            };

            var data = [{
                label : "Debit",
                data : data.debit,
                bars : {
                    order : 1
                },
            }, {
                label : "Kredit",
                data : data.kredit,
                bars : {
                    order : 2
                }
            }, {
                label : "Uang Kas",
                data : data.uang_kas,
                bars : {
                    order : 3
                }
            }];

            $.plot($("#keuangan-chart"), data, options);
        }

        // CART PAKET TERJUAL
        $.ajax({
            url: host + "/configuration",
            method: "POST",
            headers: headers,
            data: { req: 'cartPaketTerjual' },
            success : function(data) {
                cartPaketTerjual(data);
            },
        });

        function cartPaketTerjual(data) {
            var data = data.data;
            var options = {
                series : {
                    pie : {
                        show : true,
                        innerRadius : 0.5
                    }
                },
                legend : {
                    show : true,
                    labelFormatter : function(label, series) {
                        return '<div style="font-size:15px;">&nbsp;' + label + '</div>'
                    },
                    labelBoxBorderColor : true,
                    margin : 20,
                    width : 20,
                    padding : 1
                },
                grid : {
                    hoverable : true,
                    clickable : true
                },
                colors : data.color,
                tooltip : true,
                tooltipOpts : {
                    content : function(label,x,y){
                        return label + ': ' + y + ' Pax';
                    },
                    defaultTheme : false
                }
            };

            var plot = $.plot($('#paket-terjual-cart'), data, options);

            if (isNaN(plot.getData()[0].percent)){
                var canvas = plot.getCanvas();
                var ctx = canvas.getContext("2d");  //canvas context
                var x = canvas.width / 3;
                var y = canvas.height / 2;
                ctx.font = '25pt Calibri';
                ctx.textAlign = 'center';
                ctx.fillText('Belum Ada Data!', x, y);
            }
        }

        // CART DATA PESANAN
        $.ajax({
            url: host + "/configuration",
            method: "POST",
            headers: headers,
            data: { req: 'cartDataPesanan' },
            success : function(data) {
                cartDataPesanan(data);
            },
        });

        function cartDataPesanan(data) {
            var options = {
                series : {
                    lines : {
                        show : true,
                        fill : true,
                        lineWidth : 1,
                        fillColor : {
                            colors : [{
                                opacity : 0.5
                            }, {
                                opacity : 0.5
                            }]
                        }
                    },
                    points : {
                        show : true
                    },
                    shadowSize : 0
                },

                grid : {
                    hoverable : true,
                    clickable : true,
                    borderColor : '#f5f5f5',
                    tickColor : "#f9f9f9",
                    borderWidth : 1,
                    labelMargin : 10,
                    backgroundColor : '#fff'
                },
                legend : {
                    position : "ne",
                    margin : [-25, -25],
                    noColumns : 0,
                    labelBoxBorderColor : null,
                    labelFormatter : function(label, series) {
                        // just add some space to labes
                        return label;
                    },
                    width : 30,
                    height : 2
                },
                yaxis : {
                    tickColor : '#f5f5f5',
                    font : {
                        color : '#bdbdbd'
                    }
                },
                xaxis : {
                    tickColor : '#f5f5f5',
                    font : {
                        color : '#bdbdbd'
                    },
                    ticks: data.ticks
                },
                tooltip : true,
                tooltipOpts : {
                    content : "%s : %y Order",
                    shifts : {
                        x : -30,
                        y : -50
                    },
                    defaultTheme : false
                }
            };

            var data = [{
                data : data.pesanan_masuk,
                label : "Pesanan Masuk",
                color : '#34d3eb'
            }, {
                data : data.pesanan_konfir,
                label : "Pesanan Dikonfirmasi",
                color : '#81c868'
            }, {
                data : data.pesanan_batal,
                label : "Pesanan Batal",
                color : '#ffbd4a'
            }, {
                data : data.pesanan_tolak,
                label : "Pesanan Ditolak",
                color : '#f05050'
            }];

            $.plot($('#pesanan-cart'), data, options);
        }

        // NOTIF FIRBASE
        const messaging = firebase.messaging();

        messaging.onMessage((payload) => {
            console.log('Notification ', payload);
            getData();
            notifCountView();
        });
    });
</script>
@endsection