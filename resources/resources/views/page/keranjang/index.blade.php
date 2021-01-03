@extends('headfood.page')
@section('konten')

<section class="banner_order">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="container box-element">
                        <div class="row">
                            <div class="title-keranjang-order"> Keranjang Belanja </div>
                        </div>

                       <div class="row">
                           <div class="col-lg-8">
                               <div class="container mt-3 content-keranjang-list">
                                
                               </div>
                              
                               <button class="tombol-custom tombol_pesanan_cart grid_button_cart">TAMBAH PESANAN</button>
                               <hr class="line_cart">
                               <div class="footer_box_cart">
                                    <a href="javascript:;" onclick="show_modal_detail('Detail Alat','/keranjang/detail_alat')" class="link_alat_cart">Lihat alat <i class="icofont-long-arrow-right"></i></a>
                                    <div class="text_keterangan_cart">* include alat jika Minimum 5 pcs yakiniku atau mix 4 yakiniku + 3 shabu</div>
                                </div>
                           </div>
                           <div class="col-lg-4">
                                <div class="box-harga">
                                    <div class="konten_box_harga">
                                        <div class="text_title_box_harga">TOTAL HARGA</div>      
                                        <div class="box_total_keranjang"></div>
                                    </div> 
                                </div>
                                    <button class="tombol-custom tombol-keranjang text-button grid_button_cart">BUAT PESANAN</button>
                                    <div class="text_danger_info_cart">* Pesanan Minimum 2 pcs</div>
                           </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@push('skript')
    <script>
        var url = $('meta[name="host_url"]').attr('content');
        var path_asset_image = '';
        var html = '';
        var total_harga = 0;
        var data_array_paket = '';
        $(document).ready(function () {
            $.ajax({
            url     : url+'/getpaket',
            method  : "GET",
            success : function(data) {
                data_array_paket = data;
                console.log(data_array_paket);
              $.each(data_array_paket, function (indexInArray, valueOfElement) {
                if(valueOfElement['type'] == 'paket'){
                    path_asset_image =  url+'/assets/images/paket';
                   }else{
                       path_asset_image =  url+'/assets/images/bahan';
                   } 
                   html += '<div class="box-keranjang mt-3 row_index_cart_page_'+indexInArray+'">';
                   html += '<div class="row">'; 
                   html += '<div class="col-lg-8">';
                    html += '<div class="row">';
                   html += '<div class="col-lg-6">';
                    html += '<img src="'+path_asset_image+'/'+valueOfElement.foto+'" class="img-keranjang">';
                    html += '</div>';
                    html +='<div class="col-lg-6 group-text-keranjang-page">';
                    html += '<div class="text-image-keranjang">'+valueOfElement.nama+'</div>';
                    html += '<div class="text-currency-keranjang-page"> Rp. '+valueOfElement.harga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+' </div>'
                    html += '</div>';
                    html += '</div>';    
                    html += '</div>';
                    html += '<div class="col-lg-4">';
                    html += '<div class="row form-keranjang">';  
                    html += '<button type="button" class="tombol_keranjang_number btn-number"><i class="icofont-minus icon-number_additional"></i> </button>';    
                    html += ' <input type="text" name="quant[1]" class="form-nedd-keranjang input-number" value="'+valueOfElement.kuantitas+'" min="1" max="1000">';
                    html += '<button type="button" class="tombol_keranjang_number btn-number">   <i class="icofont-plus icon-number_additional"></i></button>';
                    html += ' <div class="icon-delete"><i class="icofont-ui-delete delete_item_keranjang" data-action="'+indexInArray+'"></i></div>';  
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                   html += '</div>';

                   total_harga+=parseInt(valueOfElement.harga);

              });
              
              $('.box_total_keranjang').append('Rp. '+total_harga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
              $('.content-keranjang-list').append(html);
            }
        });

       $('.content-keranjang-list').on('click','.delete_item_keranjang',function () {
            var params_row = $(this).data('action');
            data_array_paket.splice(params_row,1);
            $(`.row_index_cart_page_${params_row}`).remove();
            
       })

      

        });
    </script>
@endpush