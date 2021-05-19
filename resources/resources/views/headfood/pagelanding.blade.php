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
    <link rel="stylesheet" href="{{ asset('page/assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('page/assets/css/landings.css') }}">
<link rel="stylesheet" href="{{ asset('page/assets/css/slick.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('page/assets/vendor/icofont/icofont.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">

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
                            <li class="nav-item current-home">
                                <a class="nav-link tentang scroll" href="#tentang">Tentang</a>
                            </li>
                            <li class="nav-item current-home">
                                <a class="nav-link portfolio scroll" href="#menu">Menu</a>
                            </li>
                            <li class="nav-item current-home">
                                <a class="nav-link testimoni scroll" href="#testimoni">Testimoni</a>
                            </li>
                            <li class="nav-item current-home">
                                <a class="nav-link kontak scroll" href="#kontak">Kontak</a>
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
                            <li class="sub-list-footer">No Telepon : <span class="noteFooter">082-293-887-789</span> </li>
                            <li class="sub-list-footer">E-mail : <span class="noteFooter">kesiniku@gmail.com</span> </li>
                            <li class="sub-list-footer">
                                <i onclick="redirectMedsos('https://wa.me/082293887789')" class="icofont-brand-whatsapp" style="cursor: pointer"></i>
                                &nbsp;&nbsp;&nbsp;
                                <i onclick="redirectMedsos('https://www.instagram.com/needfoodcontainer/')" class="icofont-instagram" style="cursor: pointer"></i>
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
<script src="{{ asset('page/assets/js/toastr.min.js') }}"></script>
<script src="{{ asset('page/assets/js/main.js') }}"></script>
<script src="{{ asset('page/assets/js/landing.js') }}"></script>
<script src="{{ asset('page/assets/js/slick.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script>
@stack('skriptHome')
<script>
    
   $(document).ready(function () {
       scrollingpage();
       changenavbar();
       $('.carousel').carousel({
        interval: 4000
        })
   });

    function scrollingpage() {
        var scrollink = $('.scroll');

        scrollink.click(function (e) {
            e.preventDefault();
            $('body,html').animate({
            scrollTop: $(this.hash).offset().top
            }, 1000 );
        });

        $(window).scroll(function() {
        var scrollbarLocation = $(this).scrollTop();

        scrollink.each(function() {
            
            var sectionOffset = $(this.hash).offset().top - 20;
            
            if ( sectionOffset <= scrollbarLocation ) {
                $(this).parent().addClass('active');
                $(this).parent().siblings().removeClass('active');
            }
            })
            
        })
    }

    function redirectMedsos(data) {
        window.open(''+data+'', '_blank');
    }

    function changenavbar() {
        const header = document.querySelector(".navbar");
        const sectionOne = document.querySelector(".text_time_header");

        const sectionOneOptions = {
        rootMargin: "-200px 0px 0px 0px"
        };

        const sectionOneObserver = new IntersectionObserver(function(
        entries,
        sectionOneObserver
        ) {
        entries.forEach(entry => {
            if (!entry.isIntersecting) {
            header.classList.add("nav-scrolled");
            } else {
            header.classList.remove("nav-scrolled");
            }
        });
        },
        sectionOneOptions);

        sectionOneObserver.observe(sectionOne);
    }

</script>
@stack('skript')

</html>
