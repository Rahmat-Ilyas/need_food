<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="host_url" content="{{ url('/') }}">
    <title>KESINIKU | GOOD MEAT MAKES GREAT EXPERIENCE</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/fav.png') }}">
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
    <link rel="stylesheet" href="{{ asset('assets/js/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('page/assets/vendor/dropzone/min/basic.min.css') }}">
    <link rel="stylesheet" href="{{ asset('page/assets/vendor/dropzone/min/dropzone.min.css') }}">
</head>

<body>

    <div class="main" id="jumbroton">

        <nav class="navbar navbar-expand-lg navbar-light bg-light" id="header">

            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('page/assets/images/logo.png') }}" id="logos">
                    <img src="{{ asset('page/assets/images/logo.png') }}" id="gramLogo">
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="btn_toogler_icon"></span>
                <span class="btn_toogler_icon"></span>
                <span class="btn_toogler_icon"></span>
            </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link home" href="{{ route('page.index') }}">Home <span
                                class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link kontak scroll MenuForOrder" href="{{route('page.order.index')}}">Order</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link kontak scroll MenuForCart" href="{{route('page.keranjang')}}">Keranjang</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link kontak scroll MenuForDelivery" href="{{route('page.pengantaran')}}">Pengantaran</a>
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
                                <li class="sub-list-footer">No Telepon : 082-293-887-789</li>
                                <li class="sub-list-footer">E-mail : kesiniku@gmail.com</li>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAISwXwMy9RIBS6qnrxkC3fPRL3hfSrJSg&callback=initMap&libraries=&v=weekly" defer></script>
    <script>
       var marker;

       function initMap() {
        const center = { lat: -5.146512141348986, lng: 119.43296873064695 };

        const map = new google.maps.Map(document.getElementById("mapView"), {
            zoom: 14,
            center: center,
            fullscreenControl: false,
            mapTypeControl: false,
            streetViewControl: false,
            gestureHandling: "greedy"
        });

        marker = new google.maps.Marker({
            position: center,
            map,
        });

        google.maps.event.addListener(map, 'click', function(event) {
            setMarker(this, event.latLng);
            document.getElementById("location_input").value = "";
        });

        google.maps.event.addListener(map, 'drag', function(event) {
            marker.setPosition(map.getCenter());
        });

        google.maps.event.addListener(map, 'dragend', function(event) {
            setMarker(this, map.getCenter());
            document.getElementById("location_input").value = "";
        });

        const geocoder = new google.maps.Geocoder();
        document.getElementById("find_location").addEventListener("click", (event) => {
            event.preventDefault();
            if (document.getElementById("location_input").value == "")
                document.getElementById("location_input").focus();
            else
                geocodeAddress(geocoder, map);
        });

        document.getElementById("this_location").addEventListener("click", (event) => {
            event.preventDefault();
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var thisLocation = { lat: position.coords.latitude, lng: position.coords.longitude };

                    if( marker ){
                        marker.setPosition(thisLocation);
                    } else {
                        marker = new google.maps.Marker({
                            position: thisLocation,
                            map: map
                        });
                    }
                    map.setZoom(16);
                    map.setCenter(thisLocation);

                    // isi nilai koordinat ke form
                    document.getElementById("setLongitude").value = position.coords.longitude;
                    document.getElementById("setLatitude").value = position.coords.latitude;
                    document.getElementById("location_input").value = "";

                    setGeocoder(thisLocation);
                }, function() {
                    alert('Anda harus memberi izin untuk mengakses lokasi anda!');
                });
            } else {
                alert('geolocation failure!');
            }
        });
    }

    function geocodeAddress(geocoder, resultsMap) {
        const address = document.getElementById("location_input").value;
        geocoder.geocode({ address: address }, (results, status) => {
            if (status === "OK") {
                resultsMap.setCenter(results[0].geometry.location);
                setMarker(resultsMap, results[0].geometry.location);
            } else {
              alert("Geocode was not successful for the following reason: " + status);
          }
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
        if (map.getZoom() <= 14)
            map.setZoom(16);
        else
            map.setZoom(map.getZoom());

        map.setCenter(markerPosition);

        // isi nilai koordinat ke form
        document.getElementById("setLongitude").value = markerPosition.lng();
        document.getElementById("setLatitude").value = markerPosition.lat();

        setGeocoder(markerPosition);
    }

    function setGeocoder(markerPosition) {
        // Get Lokasi
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'latLng': markerPosition}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                var lokasi = results[1].formatted_address;
                document.getElementsByClassName("deskripsi_lokasi")[0].value = lokasi;

                var subTotal = document.getElementById("subtotal").textContent;
                subTotal = subTotal.match(/\d/g).join("")
                var ongkir;
                if (lokasi.includes("Kota Makassar")) {
                    document.getElementById("biaya_pengiriman").value = '0';
                    document.getElementById("ongkir").innerHTML = 'Rp 0';
                    ongkir = 0;
                } else {
                    document.getElementById("biaya_pengiriman").value = '50000';
                    document.getElementById("ongkir").innerHTML = 'Rp 50,000';
                    ongkir = 50000;
                }
                var setTotal = parseInt(subTotal)+ongkir;
                document.getElementById("setTotal").innerHTML = setTotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            } else {
                console.log("Geocoder failed due to: " + status);
            }
        });
    }

</script>  
<script src="{{ asset('page/assets/js/highlight.js') }}"></script>
<script src="{{ asset('page/assets/vendor/dropzone/min/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('page/assets/js/action.js') }}"></script>
@stack('skript')

</html>
