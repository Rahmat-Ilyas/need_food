<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
  <meta name="author" content="Coderthemes">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="shortcut icon" href="{{ asset('assets/images/fav.png') }}">

  <title>Admin - NeedFood</title>

  <!--Morris Chart CSS -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/morris/morris.css') }}">

  <!--venobox lightbox-->
  <link rel="stylesheet" href="{{ asset('assets/plugins/magnific-popup/css/magnific-popup.css') }}"/>

  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/css/core.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/css/components.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/css/pages.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />

  <!-- DataTables -->
  <link href="{{ asset('assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('assets/plugins/datatables/fixedHeader.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('assets/plugins/datatables/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('assets/plugins/datatables/scroller.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('assets/plugins/datatables/dataTables.colVis.css') }}" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('assets/plugins/datatables/fixedColumns.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>

  {{-- Form Advance --}}
  <link href="{{ asset('assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/switchery/css/switchery.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/multiselect/css/multi-select.css') }}"  rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />

  <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
</head>


<body class="fixed-left">
  <!-- Begin page -->
  <div id="wrapper">
    <!-- Top Bar Start -->
    <div class="topbar">
      <!-- LOGO -->
      <div class="topbar-left">
        <div class="text-center">
          <a href="{{ url('/admin') }}" class="logo">
            <b class="icon-c-logo"><strong class="text-custom"><b class="text-warning">N</b><b class="text-white">F</b></strong></b>
            <span><h3 class="text-center"><strong class="text-custom text-warning">NEED</strong><span class="text-white text-capitalize">Food</span></h3></span>
          </a>
          {{-- <a href="{{ url('/admin') }}" class="logo">
            <i class="icon-c-logo"> <img src="{{ asset('assets/images/logo_sm.png') }}" height="42"/> </i>
            <span><img src="{{ asset('assets/images/logo_light.png') }}" height="20"/></span>
          </a> --}}
        </div>
      </div>

      <div class="navbar navbar-default" role="navigation">
        <div class="container">
          <div class="">
            <div class="pull-left">
              <button class="button-menu-mobile open-left waves-effect waves-light">
                <i class="md md-menu"></i>
              </button>
              <span class="clearfix"></span>
            </div>
            
            <form role="search" class="navbar-left app-search pull-left hidden-xs">
              <input type="text" placeholder="Search..." class="form-control">
              <a href=""><i class="fa fa-search"></i></a>
            </form>


            <ul class="nav navbar-nav navbar-right pull-right">
              <li class="dropdown top-menu-item-xs">
                <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                  <i class="icon-bell"></i> <span class="badge badge-xs badge-danger">3</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg">
                  <li class="list-group slimscroll-noti notification-list">
                    <!-- list item-->
                    <a href="javascript:void(0);" class="list-group-item">
                      <div class="media">
                        <div class="pull-left p-r-10">
                          <em class="fa fa-diamond noti-primary"></em>
                        </div>
                        <div class="media-body">
                          <h5 class="media-heading">A new order has been placed A new order has been placed</h5>
                          <p class="m-0">
                            <small>There are new settings available</small>
                          </p>
                        </div>
                      </div>
                    </a>

                    <a href="javascript:void(0);" class="list-group-item">
                      <div class="media">
                        <div class="pull-left p-r-10">
                          <em class="fa fa-cog noti-warning"></em>
                        </div>
                        <div class="media-body">
                          <h5 class="media-heading">New settings</h5>
                          <p class="m-0">
                            <small>There are new settings available</small>
                          </p>
                        </div>
                      </div>
                    </a>

                    <a href="javascript:void(0);" class="list-group-item">
                      <div class="media">
                        <div class="pull-left p-r-10">
                          <em class="fa fa-bell-o noti-custom"></em>
                        </div>
                        <div class="media-body">
                          <h5 class="media-heading">Updates</h5>
                          <p class="m-0">
                            <small>There are <span class="text-primary font-600">2</span> new updates available</small>
                          </p>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="javascript:void(0);" class="list-group-item text-right">
                      <small class="font-600">See all notifications</small>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="dropdown top-menu-item-xs">
                <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true"><img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="user-img" class="img-circle"> </a>
                <ul class="dropdown-menu">
                  <li><a href="javascript:void(0)"><i class="ti-user m-r-10 text-custom"></i> Profile</a></li>
                  <li><a href="javascript:void(0)"><i class="ti-settings m-r-10 text-custom"></i> Settings</a></li>
                  <li class="divider"></li>
                  <li><a href="{{ route('admin.logout') }}"><i class="ti-power-off m-r-10 text-danger"></i> Logout</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="left side-menu">
      <div class="sidebar-inner slimscrollleft">
        <div id="sidebar-menu">
          <ul>
            <li class="has_sub">
              <a href="{{ url('admin/') }}" class="waves-effect"><i class="ti-home"></i> <span> Dashboard </span></a>
            </li>
            <li class="has_sub">
              <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-wpforms"></i> <span> Data Pemesanan </span> <span class="menu-arrow"></span> </a>
              <ul class="list-unstyled">
                <li><a href="{{ url('admin/datapesanan/pesananbaru') }}">Pemesanan Baru</a></li>
                <li><a href="maudiubah">Pesanan Diproses</a></li>
                <li><a href="maudiubah">Riwayat Pemasanan</a></li>
              </ul>
            </li>
            <li class="has_sub">
              <a href="javascript:void(0);" class="waves-effect"><i class="ti-menu-alt"></i> <span> Kelola Menu </span> <span class="menu-arrow"></span> </a>
              <ul class="list-unstyled">
                <li><a href="{{ url('admin/kelolamenu/paketmenu') }}">Paket Menu</a></li>
                <li><a href="{{ url('admin/kelolamenu/additional') }}">Additional Daging</a></li>
                <li><a href="{{ url('admin/kelolamenu/bahantambahan') }}">Bahan Tambahan</a></li>
              </ul>
            </li>
            <li class="has_sub">
              <a href="javascript:void(0);" class="waves-effect"><i class="ti-package"></i> <span> Inventori </span> <span class="menu-arrow"></span> </a>
              <ul class="list-unstyled">
                <li><a href="{{ url('admin/inventori/dataalat') }}">Data Alat</a></li>
                <li><a href="{{ url('admin/inventori/databahan') }}">Data Bahan</a></li>
                <li><a href="{{ url('admin/inventori/setkategori') }}">Set Kategori</a></li>
              </ul>
            </li>
            <li class="has_sub">
              <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-money"></i> <span> Keuangan </span> <span class="menu-arrow"></span> </a>
              <ul class="list-unstyled">
                <li><a href="ui-buttons.html">Kelola Debit/Kredit</a></li>
                <li><a href="ui-buttons.html">Laporan Keuangan</a></li>
              </ul>
            </li>
            <li class="has_sub">
              <a href="{{ url('admin/datasupplier') }}" class="waves-effect"><i class="ti-truck"></i> <span> Data Supplier </span></a>
            </li>
            <li class="has_sub">
              <a href="{{ url('admin/datadriver') }}" class="waves-effect"><i class="ti-id-badge"></i> <span> Data Driver </span></a>
            </li>
            <li class="has_sub">
              <a href="javascript:void(0);" class="waves-effect"><i class="ti-image"></i> <span> Kelola Gallery </span></a>
            </li>
            <li class="has_sub">
              <a href="javascript:void(0);" class="waves-effect"><i class="ti-comment-alt"></i> <span> Keritik & Saran </span></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>

    <div class="content-page">

      @yield('content')

    </div>

    <input type="hidden" id="configurl" value="{{ url('/configuration') }}">
    <input type="hidden" id="host" value="{{ url('/') }}">

    <footer class="footer text-right">
      © 2016. All rights reserved.
    </footer>

  </div>



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

  <script src="{{ asset('assets/plugins/peity/jquery.peity.min.js') }}"></script>
  
  {{-- Form Advance --}}
  <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>

  <!-- DataTables -->
  <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.js') }}"></script>

  <script src="{{ asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables/buttons.bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables/jszip.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables/pdfmake.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables/buttons.print.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables/dataTables.fixedHeader.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables/dataTables.keyTable.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables/responsive.bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables/dataTables.scroller.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables/dataTables.colVis.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables/dataTables.fixedColumns.min.js') }}"></script>

  <!-- jQuery  -->
  <script src="{{ asset('assets/plugins/waypoints/lib/jquery.waypoints.js') }}"></script>
  <script src="{{ asset('assets/plugins/counterup/jquery.counterup.min.js') }}"></script>



  <script src="{{ asset('assets/plugins/morris/morris.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/raphael/raphael-min.js') }}"></script>

  <script src="{{ asset('assets/plugins/jquery-knob/jquery.knob.js') }}"></script>

  <script src="{{ asset('assets/pages/jquery.dashboard.js') }}"></script>

  <script src="{{ asset('assets/plugins/isotope/js/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/magnific-popup/js/jquery.magnific-popup.min.js') }}"></script>

  
  <script src="{{ asset('assets/js/sweetalert2/sweetalert2.all.js') }}"></script>

  <script src="{{ asset('assets/js/jquery.core.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.app.js') }}"></script>
  <script src="{{ asset('assets/js/config.js') }}"></script>

  @yield('javascript')


  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $(".select2").select2();
      $(document).tooltip({ selector: '[data-toggle1="tooltip"]' });

      $('.buttonText').text('Pilih Foto');

      $('.counter').counterUp({
        delay: 100,
        time: 1200
      });

      $(".knob").knob();

      // DataTables
      $('#datatable').dataTable();
      $('#datatable-keytable').DataTable({keys: true});
      $('#datatable-responsive').DataTable();
      $('#datatable-colvid').DataTable({
        "dom": 'C<"clear">lfrtip',
        "colVis": {
          "buttonText": "Change columns"
        }
      });
      $('#datatable-scroller').DataTable({
        ajax: "assets/plugins/datatables/json/scroller-demo.json",
        deferRender: true,
        scrollY: 380,
        scrollCollapse: true,
        scroller: true
      });
      var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
      var table = $('#datatable-fixed-col').DataTable({
        scrollY: "300px",
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        fixedColumns: {
          leftColumns: 1,
          rightColumns: 1
        }
      });

      TableManageButtons.init();
    });
  </script>
</body>
</html>