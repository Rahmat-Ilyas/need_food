@extends('headfood.pagelanding')
@section('homes')

<section>
    <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active courosel-custom-banner" data-interval="2000">
                <div class="overlay-image" style="background-image:url('page/assets/images/slide2.png')"></div>
                <div class="container">     
                    <div class="sub_banner_text">Good meat makes great experience</div>
                     <div class="banner-text">Need Food Container <br> Solusinya</div>
                     <div class="tombol_jumbroton">
                         <button class="tombol-lg tombol-order_header">Pesan Sekarang</button>
                       </div>
                      <div class="text_time_header"> Setiap hari 10:00 - 20:00 WITA </div>
                  </div>
            </div>
            <div class="carousel-item courosel-custom-banner" data-interval="1000">
                <div class="overlay-image" style="background-image:url('page/assets/images/image_jumbroton.png')"></div>
                <div class="container"> 
                    <div class="sub_banner_text">Good meat makes great experience</div>
                     <div class="banner-text">Need Food Container <br> Solusinya</div>
                     <div class="tombol_jumbroton">
                         <button class="tombol-lg tombol-order_header">Pesan Sekarang</button>
                       </div>
                      <div class="text_time_header"> Setiap hari 10:00 - 20:00 WITA </div>
                  </div>
            </div>
            <div class="carousel-item courosel-custom-banner" data-interval="500">
                <div class="container"> 
                    <div class="overlay-image" style="background-image:url('page/assets/images/slide3.png')"></div>
                    {{-- <div class="sub_banner_text">Good meat makes great experience</div>
                     <div class="banner-text">Need Food Container <br> Solusinya</div>
                     <div class="tombol_jumbroton">
                         <button class="tombol-lg tombol-order_header">Pesan Sekarang</button>
                       </div>
                      <div class="text_time_header"> Setiap hari 10:00 - 20:00 WITA </div> --}}
                  </div>
            </div>
        </div>
        {{-- <a href="#myCarousel" class="carousel-control-prev" role="button" data-slide="prev">
            <span class="sr-only">Previous</span>
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </a>
        <a href="#myCarousel" class="carousel-control-next" role="button" data-slide="next">
            <span class="sr-only">Previous</span>
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </a> --}}
    </div>
</section>

{{-- <header>
    <div class="single-banner">
        <div class="banner-img">
            <img src="{{ asset('page/assets/images/image_jumbroton.png') }}" alt="" srcset="">
        </div>
        <div class="container"> 
                <div class="sub_banner_text">Good meat makes great experience</div>
                 <div class="banner-text">Need Food Container <br> Solusinya</div>
                 <div class="tombol_jumbroton">
                     <button class="tombol-lg tombol-order_header">Pesan Sekarang</button>
                   </div>
                  <div class="text_time_header"> Setiap hari 10:00 - 20:00 WITA </div>
        </div>
    </div>
</header> --}}

<section id="tentang">
    <div class="container">
        <div class="row">
            <div class="col-md-6 content-first">
                <div class="title_tentang"> Tentang Kami </div>
              <div class="col-md-11">
                <p class="text_tentang">Shabu-Yakiniku's favorite food is just tasty & fun 
                    shabu adalah makanan jepang jenis nabemono berupa irisan daging sapi yang tipis & dicelup kedalam panci berisi kuah & dan kini penyajiannya dilengkapi suki, sayuran, udon atau mie.</p>
                <div id="readMore">
                    <p class="text_tentang">yakiniku adalah istilah bahasa jepang untuk daging dipanggang atau dibakar di atas api</p>
                    <p class="text_tentang">Berbicara tentang makanan
                        siapa yang bisa menolak daging berkualitas tinggi dipadu dengan saus yakiniku (tare) buatan sendiri juga kuah shabu yang diolah secara homemade dengan resep rahasia.
                        dan ini tentu saja menjamin bahan2 sehat tanpa pengawet & MSG untuk menjaga kualitas & cita rasanya dan yang terpenting adalah halal.
                        kami adalah sebuah brand kuliner yang mengosong Japanese Food yaitu Shabu-Yakiniku sebagai product utama kami, dimana kami datang memberikan solusi untuk layanan pesan antar (Homey Shabu-Yakiniku) dan layanan pondokan (Foodstall Shabu-Yakiniku)</p>
                </div>
              </div>
                <a href="javascript:void();" class="readmore-btn">Lihat lainnya <i class="icofont-long-arrow-right"></i></a>
            </div>
            <div class="col-md-6">
                <iframe src="https://www.youtube.com/embed/TUhw_l4jCUU" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen class="video_youtube"></iframe>
                <img src="{{ asset('page/assets/images/background_titik.png') }}" alt="" srcset=""
                    class="image_background_tentang">
            </div>

        </div>
    </div>
</section>

<section class="service">
    <div class="title_service text-center"> Service </div>
    <div class="container">
        <div class="row box_card">
            <div class="col-md-6">
                <img src="{{ asset('page/assets/images/home_service.png') }}" class="img_service" alt="">   
                <img src="{{ asset('page/assets/images/home_service_mini.png') }}" class="img_service_mini" alt="" srcset="">
                <div class="row">
                    <div class="col-md-11">
                        <p class="text_service mt-5">Jika kamu penggemar berat barbeque/yakiniku kamu tetap bisa menikmatinya walaupun tidak menyantapnya di resto & jika kamu tertarik berkumpul untuk acara khusus dirumah kamu dapat membuatnya menyenangkan dengan memesan layanan homey shabu yakiniku, karena kamu akan mendapatkan kesenangan dengan memanggang makanan sambil bercengkrama dan mengobrol dengan keluarga dengan seorang teman </p>  
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <img src="{{ asset('page/assets/images/food_stall.png') }}" class="img_service" alt="">
                <img src="{{ asset('page/assets/images/food_stall_mini.png') }}" class="img_service_mini" alt="">
                <div class="row">
                    <div class="col-md-11">
                        <p class="text_service mt-5">
                         layanan foodstall shabu-yakiniku siap untuk memenuhi kebutuhan Barbeque Service & memastikan bahwa bahan & masakan segar, dimana layanan ini semua akan diolah secara live cooking dengan kru memasak yang berpengalaman, staf yang berpengalaman & ramah, difasilitasi peralatan BBQ yang berkualitas, meja dan peralatan makan. dan hal ini tentunya akan meninggalkan perasaan yang sangat menyenangkan & kesan yang sangat baik untu para tamu undangan </p>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="menu">
    <div class="box_menu">
       <div class="container">
           <div class="row content_first_menu">
                <div class="col-lg-3">
                    <div class="title_tentang grid_menu_title"> Menu </div>
                    <div class="text_menu">Tersedia pilihan paket menu unggulan dengan kombinasi daging</div>
                </div>
                <div class="col-lg-9">
                        <div class="row card_grid">
                            <div class="col-lg-4">
                             <div class="card_menu">
                                <div class="title_card_menu">YAKINIKU</div>
                                <div class="card_menu_currency">100.000</div>
                                <hr class="line_menu">
                                <ul class="list_sub_menu">
                                    <li>Gresca</li>
                                    <li>Mayura</li>
                                    <li>Disfrutar</li>
                                    <li>Foc i oil</li>
                                </ul>
                                <div class="row justify-content-center">
                                    <button class="tombol_menu_card tombol-order_header">Lihat</button>
                                </div>
                             </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card_menu">
                                   <div class="title_card_menu">SHABU 1</div>
                                   <div class="card_menu_currency">100.000</div>
                                   <hr class="line_menu">
                                   <ul class="list_sub_menu">
                                       <li>Gresca</li>
                                       <li>Mayura</li>
                                       <li>Disfrutar</li>
                                       <li>Foc i oil</li>
                                   </ul>
                                   <div class="row justify-content-center">
                                    <button class="tombol_menu_card tombol-order_header">Lihat</button>
                                </div>
                                </div>
                               </div>
                               <div class="col-lg-4">
                                <div class="card_menu">
                                   <div class="title_card_menu">SHABI 2</div>
                                   <div class="card_menu_currency">100.000</div>
                                   <hr class="line_menu">
                                   <ul class="list_sub_menu">
                                       <li>Gresca</li>
                                       <li>Mayura</li>
                                       <li>Disfrutar</li>
                                       <li>Foc i oil</li>
                                   </ul>
                                   <div class="row justify-content-center">
                                    <button class="tombol_menu_card tombol-order_header">Lihat</button>
                                </div>
                                </div>
                               </div>
                        </div>
                </div>
           </div>
       </div>
    </div>
</section>

<section class="keunggulan">
    <div class="container">
    <div class="title_keunggulan"> keunggulan Bahan Kami </div>
        <div class="row">
            <div class="col-md-12">
                <ul style="list-style: none" class="text_keunggulan mt-4">
                    <li>Cara Belanja yang mudah</li>
                    <li class="mt-2">Harga Terjangkau</li>
                    <li class="mt-2">Hemat Waktu</li>
                    <li class="mt-2">Biaya & tenaga 100%</li>
                    <li class="mt-2">Halal % Hygiene pack</li>
                    <li class="mt-2">Daging sapi yang berkualitas</li>
                    <li class="mt-2">Selalu Menggunakan daging dengan grade terbaik</li>
                    <li class="mt-2">Bahan-bahan lain juga berkualitas</li>
                    <li class="mt-2">Free delivery untuk wilayah Makassar</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="layouts_area">
    <div id="testimoni" class="container">
        <div class="title_tentang grid_testimoni_title"> Testimoni </div>

        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="single-box">
                                <div class="img-area">
                                    <img src="{{ asset('page/assets/images/makassar.png') }}" class="rounded-circle img_testi">
                                </div>
                                <div class="img-text">
                                    <h2>Pemerintah Kota Makassar</h2>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single-box">
                                <div class="img-area">
                                    <img src="{{ asset('page/assets/images/makassar.png') }}" class="rounded-circle img_testi">
                                </div>
                                <div class="img-text">
                                    <h2>Pemerintah Kota Makassar</h2>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single-box">
                                <div class="img-area">
                                    <img src="{{ asset('page/assets/images/makassar.png') }}" class="rounded-circle img_testi">
                                </div>
                                <div class="img-text">
                                    <h2>Pemerintah Kota Makassar</h2>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="single-box">
                                <div class="img-area">
                                    <img src="{{ asset('page/assets/images/sulsel.png') }}" class="rounded-circle img_testi">
                                </div>
                                <div class="img-text">
                                    <h2>Pemerintah Provinsi Sulsel</h2>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single-box">
                                <div class="img-area">
                                    <img src="{{ asset('page/assets/images/sulsel.png') }}" class="rounded-circle img_testi">
                                </div>
                                <div class="img-text">
                                    <h2>Pemerintah Provinsi Sulsel</h2>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single-box">
                                <div class="img-area">
                                    <img src="{{ asset('page/assets/images/sulsel.png') }}" class="rounded-circle img_testi">
                                </div>
                                <div class="img-text">
                                    <h2>Pemerintah Provinsi Sulsel</h2>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
          </div>

    </div>
</section> 

<section class="saran_masukan">
    <div class="container">
        <div id="kontak" class="row">
            <div class="col-md-6">
                <div class="title_tentang"> Saran dan <br> <span class="note_text">Masukkan</span> </div>
                <p class="text_saran">Masukkan saran tentang produk <br> dan pelayanan kami</p>
            <img src="{{ asset('page/assets/images/background_titik.png') }}" class="img-saran" alt="">
            </div>
            <div class="col-md-6 section_title_group">
                <div class="box_kontak">
                        <form class="form_kontak">
                            <div class="form-group">
                                <input type="text" class="form-control-kontak" name="nama" id="formGroupExampleInput" placeholder="Nama">
                              </div>
                              <div class="form-group">
                                <input type="email" class="form-control-kontak" name="email" id="formGroupExampleInput" placeholder="E-Mail">
                              </div>
                              <div class="form-group">
                                <textarea id="textarea" placeholder="Tulis Pesan" name="pesan"></textarea>
                              </div>

                            
                                <button type="button" id="submit_saran_masukan" class="tombol_submit tombol_saran_masukan">Submit</button>
                                <div class="container">
                                    <div class="row validation_error">
                                        <div class="col-lg-12 offset-lg-12 mt-3">
                                            <div class="alert">
                                                <span class="closebtn">&times;</span> 
                                                <strong>Form Belum Lengkap !!!</strong> 
                                                <ul class="list_error">
                                                  
                                                </ul>
                                              </div>
                
                                        </div>
                                    </div>
                                </div>
                        </form>

                </div>
           
            </div>
    </div>
    </div>
  
</section>



{{-- <div class="flat_button grid_button_faq">
   <div class="faq_text">FAQ</div>
</div> --}}

@endsection
@push('skriptHome')
    <script>
        $(function () {
            $('#readMore').hide();
            $('.validation_error').css('display','none');
            $('.closebtn').on('click', function () {
                $('.validation_error').css('display','none');
             })

             $('.readmore-btn').on('click',function () {
                 $(this).parent().toggleClass('showContent');
                 $('#readMore').slideToggle();
             })
        })
    </script>
@endpush
