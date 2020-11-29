<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/png" href="images/logo_rio.png" />
    <link rel="stylesheet" href="{{ asset('page/assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('page/assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('page/assets/css/landings.css') }}">
<link rel="stylesheet" href="{{ asset('page/assets/css/slick.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('page/assets/vendor/icofont/icofont.min.css') }}">

</head>

<body>

    <div class="main" id="jumbroton">
            <nav class="navbar navbar-expand-lg" id="header">
                <div class="container">
                    <a class="navbar-brand" href="#">
                        <img src="{{ asset('page/assets/images/logo.png') }}" id="logos">
                        <img src="{{ asset('page/assets/images/logo.png') }}" id="gramLogo">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
    
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
                                <a class="nav-link kontak">Testimonis</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link kontak">Kontak</a>
                            </li>
                        </ul>
    
                    </div>
                </div>
            </nav>
        @yield('homes')
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <img src="{{ asset('page/assets/images/logofooter.png') }}" alt="" srcset="">
                        <p class="sub-title-footer">Usefull Link</p>
                        <ul class="list-footer">
                            <li class="sub-list-footer">Tentang Need Food</li>
                            <li class="sub-list-footer">Tentang Produk Kami</li>
                            <li class="sub-list-footer">Belanja Aman</li>
                            <li class="sub-list-footer">Info Pemesanan</li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <ul class="list-footer_second">
                            <li class="sub-list-footer">Layanan Kami</li>
                            <li class="sub-list-footer">Kontak</li>
                            <li class="sub-list-footer">Inovasi</li>
                            <li class="sub-list-footer">Testimoni</li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <ul class="list-footer_second">
                            <li class="sub-list-footer">No Telepon 0059-4985-43</li>
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
<script src="{{ asset('page/assets/js/main.js') }}"></script>
<script src="{{ asset('page/assets/js/slick.min.js') }}"></script>
<script>
    
    window.addEventListener('scroll',function () {
        let header = document.querySelector('nav');
        let windowPosition = window.scrollY > 0;
        header.classList.toggle('scrolling-active', windowPosition);
    })
    
    $('.banner-area').slick({
        autoplay : true,
        autoplaySpeed: 2000,
        arrows : false,
        dots : true,
        fade : true
    });
</script>
@stack('skript')

</html>
