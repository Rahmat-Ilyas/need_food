@extends('headfood.pagelanding')
@section('homes')
<header>
    <div class="single-banner">
        <div class="banner-img">
            <img src="{{ asset('page/assets/images/image_jumbroton.png') }}" alt="" srcset="">
        </div>
        <div class="container">
            {{-- <div class="row"> --}}
             
                <div class="sub_banner_text">NGUMPUL BARENG TEMAN BINGUNG MAU MAKAN APA ?</div>
                 <div class="banner-text">Need Food Container <br> Solusinya</div>
                 <div class="tombol_jumbroton">
                     <button class="tombol-lg tombol-order_header">Pesan Sekarang</button>
                   </div>
                  <div class="text_time_header"> Setiap hari 08:30 am - 23:00 pm </div>
             
            {{-- </div> --}}
        </div>
    </div>
</header>

<section class="tentang">
    <div class="container">
        <div class="row">
            <div class="col-md-6 content-first">
                <div class="title_tentang"> Tentang Kami </div>
                <p class="text_tentang">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Commodo mattis viverra
                    arcu ac cras donec quam ut mauris. Faucibus cursus accumsan quis lorem quis adipiscing non odio
                    elementum.</p>
                <button class="tombol-custom tombol_tentang grid_button_tentang">LIHAT SEMUA</button>
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
               <p class="text_service mt-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse tellus consectetur nulla turpis at justo, </p>  
            </div>
            <div class="col-md-6">
                <img src="{{ asset('page/assets/images/food_stall.png') }}" class="img_service" alt="">
                <img src="{{ asset('page/assets/images/food_stall_mini.png') }}" class="img_service_mini" alt="">
               <p class="text_service mt-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse tellus consectetur nulla turpis at justo, </p>  
            </div>
        </div>
    </div>
</section>

<section class="menu">
    <div class="box_menu">
       <div class="container">
           <div class="row content_first_menu">
                <div class="col-lg-3">
                    <div class="title_tentang grid_menu_title"> Menu </div>
                    <div class="text_menu">Tersedia pilihan paket menu unggulan dengan kombinasi daging</div>
                    <button class="tombol-custom tombol_menu grid_button_tentang">LIHAT SEMUA</button>
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
                <p class="text_keunggulan">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Id commodo commodo, massa sit ipsum proin sed sollicitudin. Urna nibh adipiscing parturient sem et porttitor aliquet eget. Convallis sit phasellus mattis integer eget felis. In tortor pharetra maecenas </p>
            </div>
        </div>
    </div>
</section>

<section class="layouts_area">
    <div class="container">
        <div class="title_tentang grid_testimoni_title"> Testimoni </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="box_testimoni">
               <p class="text_box_testi">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Id commodo commodo, massa sit ipsum proin sed sollicitudin. Urna nibh adipiscing parturient.</p>
               <div class="row footer_box_testi">
                    <div class="container">               
                        <img src="{{ asset('page/assets/images/user.png') }}" class="rounded-circle img_testi">
                            <div class="name_user">Arkam Maulana</div>
                            <div class="status_user">Mahasiswa/Pelajar</div>
                    </div>
               </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="box_testimoni">
               <p class="text_box_testi">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Id commodo commodo, massa sit ipsum proin sed sollicitudin. Urna nibh adipiscing parturient.</p>
               <div class="row footer_box_testi">
                <div class="container">               
                    <img src="{{ asset('page/assets/images/user.png') }}" class="rounded-circle img_testi">
                        <div class="name_user">Arkam Maulana</div>
                        <div class="status_user">Mahasiswa/Pelajar</div>
                </div>
           </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="box_testimoni">
               <p class="text_box_testi">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Id commodo commodo, massa sit ipsum proin sed sollicitudin. Urna nibh adipiscing parturient.</p>
               <div class="container">  
               <div class="row footer_box_testi">             
                    <img src="{{ asset('page/assets/images/user.png') }}" class="rounded-circle img_testi">
                        <div class="name_user">Arkam Maulana</div>
                        <div class="status_user">Mahasiswa/Pelajar</div>
                </div>
           </div>
            </div>
        </div>
    </div>
    </div>
</section>

<section class="saran_masukan">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="title_tentang"> Saran dan <br> <span class="note_text">Masukkan</span> </div>
                <p class="text_saran">Masukkan saran tentang produk <br> dan pelayanan kami</p>
            <img src="{{ asset('page/assets/images/background_titik.png') }}" class="img-saran" alt="">
            </div>
            <div class="col-md-6 section_title_group">
                <div class="box_kontak">
                        <form class="form_kontak">
                            <div class="form-group">
                                <input type="text" class="form-control-kontak" id="formGroupExampleInput" placeholder="Nama">
                              </div>
                              <div class="form-group">
                                <input type="text" class="form-control-kontak" id="formGroupExampleInput" placeholder="Nama Belakang">
                              </div>
                              <div class="form-group">
                                <input type="email" class="form-control-kontak" id="formGroupExampleInput" placeholder="E-Mail">
                              </div>
                              <div class="form-group">
                                <textarea id="textarea" placeholder="Tulis Pesan"></textarea>
                              </div>

                            
                                <button type="button" class="tombol_submit tombol-order_header">Submit</button>
                            

                        </form>
                </div>
            </div>
    </div>
    </div>
  
</section>

<div class="flat_button grid_button_flag">
    <i class="icofont-shopping-cart" id="icon_flat"></i>
    <span class="badge badge-danger pill_number">3</span>
</div>

<div class="flat_button grid_button_faq">
   <div class="faq_text">FAQ</div>
</div>

@endsection
