<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="host_url" content="{{ url('/') }}">

    <link rel="shortcut icon" type="image/png" href="images/logo_rio.png" />
    <link rel="stylesheet" href="{{ asset('page/assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('page/assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('page/assets/css/custom.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('page/assets/vendor/icofont/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('page/assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('page/assets/css/placeholder-loading.min.css') }}">
    <link rel="stylesheet" href="{{ asset('page/assets/vendor/owl-courosel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('page/assets/vendor/owl-courosel/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('page/assets/vendor/bootstrap-select/dist/css/bootstrap-select.css') }}">
<link rel="stylesheet" href="{{ asset('page/assets/vendor/dropzone/dropzone.css') }}">

</head>

<body>

    <div class="main" id="jumbroton">

        <nav class="navbar navbar-expand-lg navbar-light bg-light" id="header">

            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('page/assets/images/logo.png') }}" id="logos">
                    <img src="{{ asset('page/assets/images/logo.png') }}" id="gramLogo">
                </a>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link home" href="{{ route('page.index') }}">Home <span
                                    class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link portfolio">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link kontak">Tentang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link kontak">Testimoni</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link kontak">Kontak</a>
                        </li>
                    </ul>

                </div>
            </div>

        </nav>

        @yield('konten')
        @include('headfood.modal')

        <footer>
            <div class="container">
                <div class="row footer-group">
                    <div class="col-lg-4 col-xs-12">
                        <img src="{{ asset('page/assets/images/logofooter.png') }}" alt="" srcset="">
                        <p class="sub-title-footer">Usefull Link</p>
                        <ul class="list-footer">
                            <li class="sub-list-footer">Tentang Need Food</li>
                            <li class="sub-list-footer">Tentang Produk Kami</li>
                            <li class="sub-list-footer">Belanja Aman</li>
                            <li class="sub-list-footer">Info Pemesanan</li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-xs-12">
                        <ul class="list-footer_second">
                            <li class="sub-list-footer">Layanan Kami</li>
                            <li class="sub-list-footer">Kontak</li>
                            <li class="sub-list-footer">Inovasi</li>
                            <li class="sub-list-footer">Testimoni</li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-xs-12">
                        <ul class="list-footer_second">
                            <li class="sub-list-footer">No Telepon : 0059-4985-43</li>
                            <li class="sub-list-footer">E-mail : needfood@gmail.com</li>
                            <li class="sub-list-footer">
                                <i class="icofont-brand-whatsapp"></i>
                                &nbsp;&nbsp;&nbsp;
                                <i class="icofont-instagram"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

    </div>

</body>
<script src="{{ asset('page/assets/js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('page/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('page/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('page/assets/vendor/bootstrap-select/dist/js/bootstrap-select.js') }}"></script>
<script src="{{ asset('page/assets/vendor/owl-courosel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('page/assets/js/main.js') }}"></script>
<script src="{{ asset('page/assets/js/toastr.min.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA5g4U_FtOK7LX789QyNyJe90DmnastiI8&callback=initMap&libraries=&v=weekly" defer></script>
<script>
 var marker;

function initMap() {
    const center = { lat: -5.146512141348986, lng: 119.43296873064695 };

    const map = new google.maps.Map(document.getElementById("mapView"), {
        zoom: 14,
        center: center,
    });

    marker = new google.maps.Marker({
        position: center,
        map,
    });

    google.maps.event.addListener(map, 'click', function(event) {
        setMarker(this, event.latLng);
    });

}

function setMarker(map, markerPosition) {
    if( marker ){
        marker.setPosition(markerPosition);
    } else {
        marker = new google.maps.Marker({
            position: markerPosition,
            map: map
        });
    }
    map.setZoom(16);
    map.setCenter(markerPosition);

        // isi nilai koordinat ke form
        document.getElementById("setLongitude").value = markerPosition.lng();
        document.getElementById("setLatitude").value = markerPosition.lat();

        // Get Lokasi
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'latLng': markerPosition}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    infowindow.setContent(results[1].formatted_address);
                    infowindow.open(map, marker);
                }
            } else {
                console.log("Geocoder failed due to: " + status);
            }
        });
    }

</script>  
<script src="{{ asset('page/assets/js/highlight.js') }}"></script>
<script src="{{ asset('page/assets/vendor/dropzone/dropzone.js') }}"></script>
@stack('skript')

</html>
