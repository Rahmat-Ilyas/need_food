<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="A fully featured kitchen theme which can be used to build CRM, CMS, etc.">
  <meta name="author" content="Coderthemes">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="shortcut icon" href="{{ asset('assets/images/fav.png') }}">

  <title>Halaman Dapur - Kesiniku</title>

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
  <link href="{{ asset('assets/plugins/bootstrap-table/css/bootstrap-table.min.css') }}" rel="stylesheet" type="text/css" />

  {{-- Sweet Allert --}}
  <link href="{{ asset('assets/plugins/bootstrap-sweetalert/sweet-alert.css') }}" rel="stylesheet" type="text/css">

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
          {{-- <a href="{{ url('/kitchen') }}" class="logo">
            <b class="icon-c-logo"><strong class="text-custom"><b class="text-warning">N</b><b class="text-white">F</b></strong></b>
            <span><h3 class="text-center"><strong class="text-custom text-warning">NEED</strong><span class="text-white text-capitalize">Food</span></h3></span>
          </a> --}}
          <a href="{{ url('/admin') }}" class="logo">
            <i class="icon-c-logo"> <img src="{{ asset('assets/images/logo-sm.png') }}" height="40"/> </i>
            <span><img src="{{ asset('assets/images/logo-1.png') }}" height="40"/></span>
          </a>
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

            <ul class="nav navbar-nav navbar-right pull-right">
              <li class="dropdown top-menu-item-xs">
                <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                  <i class="icon-bell"></i> <span class="badge badge-xs badge-danger" id="notifViewCount">0</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg">
                  <li class="list-group slimscroll-noti notification-list" id="notifView">
                    <!-- list item-->
                    
                  </li>
                </ul>
              </li>
              <li class="dropdown top-menu-item-xs">
                <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                  <span style="font-size: 15px; margin-right: 2px;" class="namaView">{{ Auth::user()->nama }}</span>
                  <img src="{{ asset('assets/images/logo-sm.png') }}" alt="user-img" class="img-circle"> 
                </a>
                <ul class="dropdown-menu">
                  <li><h4 style="margin-left: 20px;" class="namaView">{{ Auth::user()->nama }}</h4></li>
                  <li><a href="#" data-toggle="modal" data-target="#editProfil"><i class="ti-user m-r-10 text-custom"></i> Account</a></li>
                  <li><a href="{{ route('kitchen.logout') }}"><i class="ti-power-off m-r-10 text-danger"></i> Logout</a></li>
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
              <a href="{{ url('kitchen/') }}" class="waves-effect"><i class="ti-home"></i> <span> Dashboard </span></a>
            </li>
            <li class="has_sub">
              <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-wpforms"></i> 
                <span> Data Pemesanan </span> 
                <span class="label label-danger pull-right" id="dataPesanan">0</span> 
              </a>
              <ul class="list-unstyled">
                <li><a href="{{ url('kitchen/datapesanan/pesanandiproses') }}">Pesanan Diproses <span class="badge badge-xs badge-danger" id="pesananProses">0</span></a></li>
                <li><a href="{{ url('kitchen/datapesanan/selesaidiproses') }}">Selesai Diproses <span class="badge badge-xs badge-danger" id="selesaiProsesCount">0</span></a></li>
              </ul>
            </li>
            <li class="has_sub">
              <a href="javascript:void(0);" class="waves-effect"><i class="ti-package"></i> <span> Inventori </span> <span class="menu-arrow"></span> </a>
              <ul class="list-unstyled">
                <li><a href="{{ url('kitchen/inventori/dataalat') }}">Data Alat</a></li>
                <li><a href="{{ url('kitchen/inventori/databahan') }}">Data Bahan</a></li>
                <li><a href="{{ url('kitchen/inventori/setkategori') }}">Set Kategori</a></li>
              </ul>
            </li>
            <li class="has_sub">
              <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-print"></i> <span> Print </span> <span class="menu-arrow"></span> </a>
              <ul class="list-unstyled">
                <li><a href="{{ url('kitchen/printlabel') }}">Label Pesanan</a></li>
                <li><a href="{{ url('kitchen/printalatpesan') }}">Alat Pesanan</a></li>
              </ul>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>

    <!-- Modal Edit Profil -->
    <div class="modal" role="dialog" id="editProfil" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Update Akun Login</h4>
          </div>
          <form method="POST" action="" id="updateProfile">
            <div class="modal-body" style="padding: 20px 50px 0 50px">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nama</label>
                <div class="col-sm-9">
                  <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                  <input type="text" class="form-control" id="nama" required="" placeholder="Nama..." name="nama" autocomplete="off" value="{{ Auth::user()->nama }}">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-9">
                  <input type="username" class="form-control" id="username" required="" placeholder="Username..." name="username" autocomplete="off" value="{{ Auth::user()->username }}">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control m-b-5" id="password" placeholder="Ganti Password..." name="password" autocomplete="off" value="">
                  <span class="text-info" style="font-size: 14px;">Note: Masukkan password baru untuk mengganti password</span>
                </div>
              </div>
            </div>
            <div class="modal-footer row">
              <div class="col-sm-4"></div>
              <div class="col-sm-8">
                <button type="submit" class="btn btn-default mr-2">Update</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="content-page">

      @yield('content')

    </div>

    <input type="hidden" id="configurl" value="{{ url('/configuration') }}">
    <input type="hidden" id="host" value="{{ url('/') }}">

    <footer class="footer text-right">
      © {{ date('Y') }}. Kesiniku - All rights reserved.
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
  <script src="{{ asset('assets/plugins/bootstrap-table/js/bootstrap-table.min.js') }}"></script>

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
  <script src="{{ asset('assets/js/jquery.PrintArea.js') }}"></script>

  <!-- Sweet-Alert  -->
  <script src="{{ asset('assets/plugins/bootstrap-sweetalert/sweet-alert.min.js') }}"></script>
  <script src="{{ asset('assets/pages/jquery.sweet-alert.init.js') }}"></script>

  <!-- The core Firebase JS SDK is always required and must be listed first -->
  <script src="https://www.gstatic.com/firebasejs/8.2.1/firebase-app.js"></script>

  <script src="https://www.gstatic.com/firebasejs/8.2.1/firebase-analytics.js"></script>

  <script src="https://www.gstatic.com/firebasejs/8.2.1/firebase-messaging.js"></script>

  <script src="https://www.gstatic.com/firebasejs/8.2.1/firebase-auth.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.2.1/firebase-database.js"></script>
  <script src="{{ asset('assets/js/kitchen.firebase.js') }}"></script>

  <script type="text/javascript">
    var url = $('#configurl').val();
    var host = $('#host').val();

    var headers = {
      "Accept"        : "application/json",
      "Authorization" : "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjA3YWE1Y2M3MDA1YTdjMDA2YzgwZWNjNjIxN2E4Y2VhOTUwMTEzMWNmM2MxOTVmMDk2YjJmZTAwY2I2MGI4ODAxNzE1ZGJmYjQ1YTYzMmIwIn0.eyJhdWQiOiIxIiwianRpIjoiMDdhYTVjYzcwMDVhN2MwMDZjODBlY2M2MjE3YThjZWE5NTAxMTMxY2YzYzE5NWYwOTZiMmZlMDBjYjYwYjg4MDE3MTVkYmZiNDVhNjMyYjAiLCJpYXQiOjE2MDA1MTI5NTEsIm5iZiI6MTYwMDUxMjk1MSwiZXhwIjoxNjMyMDQ4OTUwLCJzdWIiOiIxMyIsInNjb3BlcyI6W119.oHghL81Jc0xq-vvDVFde3QeqYs3s0Me6XukZtGy8G8HegV4LV2ImqKlpw_wdwxBOtKhBfodMFICi0YmNcPov7A",
      'X-CSRF-TOKEN'  : $('meta[name="csrf-token"]').attr('content')
    }

    $('#notifViewCount, #dataPesanan, #pesananProses, #selesaiProsesCount').hide();
    notifCountView();
    function notifCountView() {
      $.ajax({
        url: host + "/configuration",
        method: "POST",
        headers: headers,
        data: { req: 'notifCountViewKitchen' },
        success: function (data) {
          $('#notifView').html(data.notf_view);

          if (data.notf_view_count != 0) $('#notifViewCount').show().text(data.notf_view_count);
          else $('#notifViewCount').hide().text(data.notf_view_count);

          if (data.data_pesanan != 0) $('#dataPesanan').show().text(data.data_pesanan);
          else $('#dataPesanan').hide().text(data.data_pesanan);

          if (data.pesanan_proses != 0) $('#pesananProses').show().text(data.pesanan_proses);
          else $('#pesananProses').hide().text(data.pesanan_proses);

          if (data.selesai_proses != 0) $('#selesaiProsesCount').show().text(data.selesai_proses);
          else $('#selesaiProsesCount').hide().text(data.selesai_proses);
        }
      });
    }


    $(document).ready(function($) {
      // SET ERROR
      function setError(data) {
        var error = '';
        result = data.responseJSON.message;
        if (jQuery.type(result) == 'object') {
          $.each(result, function (key, val) {
            error = error + ' ' + val[0];
          });
        } else {
          error = data.responseJSON.message;
        }

        Swal.fire({
          title: 'Gagal Diproses',
          text: error,
          type: 'error'
        });
      }

      // UPDATE PROFILE
      $('#updateProfile').submit(function(e) {
        e.preventDefault();

        var data = $(this).serialize();
        $.ajax({
          url     : host+"/api/updateauth",
          method  : "POST",
          headers : headers,
          data    : data,
          success : function(data) {
            $('.namaView').text(data.result.nama);
            $('#nama').val(data.result.nama);
            $('#username').val(data.result.username);
            $('#password').val('');
            swal('Update Berhasil', 'Data akun login berhasil di update!', 'success');
            $('.modal').modal('hide');
          },
          error: function (data) {
            setError(data);
          }
        });
      });
      
      // NOTIF FIRBASE
      const messaging = firebase.messaging();

      messaging.onMessage((payload) => {
        console.log('Notification ', payload);
        notifCountView();
      });
    });
  </script>

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
    });
  </script>
</body>
</html>