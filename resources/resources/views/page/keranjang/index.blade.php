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

                            <form id="cek_paket_cart">
                                @csrf
                                <div class="content-keranjang-first">

                                </div>
                                <div class="container mt-3 content-keranjang-list">
                                    
                                </div>
                            </form>
                               
                               <hr class="line_cart">
                               <div class="footer_box_cart">
                                    <a href="javascript:;" onclick="show_modal_detail('Detail Alat','/keranjang/detail_alat')" class="link_alat_cart">Lihat alat  <i class="icofont-long-arrow-right"></i></a>
                                    <div class="text_keterangan_cart">* include alat jika Minimum 5 pcs yakiniku atau mix 4 yakiniku + 3 shabu</div>
                                </div>
                           </div>
                           <div class="col-lg-4">
                                <div class="box-harga">
                                    <div class="konten_first"></div>
                                    <div class="konten_box_harga">
                                        <div class="text_title_box_harga">TOTAL HARGA</div>      
                                        <div class="box_total_keranjang"></div>
                                    </div> 
                                </div>
                                    <button class="tombol-custom tombol-keranjang text-button grid_button_cart" id="send_to_delivery">PROSES</button>
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
        var no = 0;
        var data_array_paket = '';
        var hargaGroup = [];
        var qtyGroup = [];
        var totalQty = 0;
        var resultHarga = 0;
        var paket_id = [], jumlah = [];
        var token = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function () {
            $('.MenuForCart').css('font-weight','bold');
            $('.content-keranjang-list').hide();
            $('.konten_box_harga').hide();
            $('.content-keranjang-first').html(makeleton_cart());   
            $('.konten_first').html(makeleton_currency());           

            $.ajax({
            url     : url+'/getpaket',
            method  : "GET",
            success : function(data) {
                data_array_paket = data;
                console.log(data_array_paket);
            
                if (data_array_paket != 'Tidak ada session') {
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
                      html += '<button type="button" onclick="numberKeranjang(`'+valueOfElement.harga+'`,`input_page_keranjang'+no+'`,`mines`)" class="tombol_keranjang_number btn-number"><i class="icofont-minus icon-number_additional"></i> </button>';    
                      html += ' <input type="text" name="quant[1]" id="input_page_keranjang'+no+'" class="form-nedd-keranjang input-number valueKeranjangInput'+valueOfElement.id+'" value="'+valueOfElement.kuantitas+'" min="1" max="1000">';
                      html += '<button type="button" onclick="numberKeranjang(`'+valueOfElement.harga+'`,`input_page_keranjang'+no+'`,`add`)" class="tombol_keranjang_number btn-number"><i class="icofont-plus icon-number_additional"></i></button>';
                      html += ' <div class="icon-delete"><i class="icofont-ui-delete delete_item_keranjang" data-action="'+indexInArray+'"></i></div>';  
                      html += '</div>';
                      html += '</div>';
                      html += '</div>';
                     html += '</div>';
                     html += '<input type="hidden" value="'+valueOfElement.id+'" name="paket_id[]">';
                     html += '<input type="hidden" value="'+valueOfElement.kuantitas+'" name="jumlah[]">';
  
                     no++;

                    hargaGroup.push(parseInt(valueOfElement.harga))
                    qtyGroup.push(parseInt(valueOfElement.kuantitas))

                    // resultHarga =  total_harga+=parseInt(valueOfElement.harga * valueOfElement.kuantitas);
                    appendToHargaContent(hargaGroup,qtyGroup,null,null);
                    
                    
                });
                } else {
                    html += ' <div class="text_title_box_harga">Maaf, Tidak Ada Produk yang di Tambahkan</div>';
                }


              numberKeranjang = (harga,elemen,type) => {
                var lastChar = elemen.substr(elemen.length - 1);
                var getEle = 0;
                var val = $(`#${elemen}`).val();
                if (type == 'add') {
                    val++;
                    $(`#${elemen}`).val(val);
                    getEle = val;
                    appendToHargaContent(hargaGroup,qtyGroup,lastChar,getEle);
                }else{
                    val--;
                    $(`#${elemen}`).val(val);
                    getEle = val;
                    appendToHargaContent(hargaGroup,qtyGroup,lastChar,getEle);
                }         
            }
             
             function appendToHargaContent(harga,qty,ele,valQtyAdd) {
                 resultHarga = 0;
                if (ele == null) {
                    for (let index = 0; index < qty.length; index++) {
                        resultHarga += harga[index] * qty[index];                   
                     } 
                }else{
                   qty[ele] = valQtyAdd;
                   for (let index = 0; index < qty.length; index++) {
                        resultHarga += harga[index] * qty[index];                   
                     } 
                     data_array_paket[ele]['kuantitas'] = valQtyAdd;
                }

                resultFix(resultHarga);                 

             }  
             
              $('.content-keranjang-list').append(html);
            }
        });

       $('.content-keranjang-list').on('click','.delete_item_keranjang',function () {
            resultHarga = 0;
            console.log(data_array_paket);
            var params_row = $(this).data('action');
            data_array_paket.splice(params_row,1);
            $(`.row_index_cart_page_${params_row}`).remove();
            toastr_notice('info','Paket Berhasil di Hapus');
            console.log(data_array_paket);
            $.each(data_array_paket, function (keyss, valuess) { 
                resultHarga +=  parseInt(valuess.harga) * valuess.kuantitas;
            }); 
            console.log(resultHarga);
            resultFix(resultHarga);
       })

       resultFix = (params) => {
         $('.box_total_keranjang').html('Rp. '+params.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
       }

       show_modal_detail = (title,sub_url) => {
        console.log($('#cek_paket_cart').serialize());
        $.ajax({
            url  : url+'/api/getalatpaket',
            type : 'POST',
            headers : headers(),
            data: $('#cek_paket_cart').serialize(),
            success: function (response) {
              console.log(response)
               var path_asset_image =  url+'/assets/images/kategori';
                console.log(response);
                $('#modal-title').text(title);
                if (response.message == 'Success get data') {
                    $('#modal-body').html('');
                    $.each(response.result, function (index, val) { 
                        $('#modal-body').append('<table class="table_detail_alat"><thead class="head_row"><tr><th style="width:350px">Item alat</th><th>Jumlah</th></tr></thead><tbody class="body_row"><tr><td><div class="row alat_item"><img src="'+path_asset_image+'/'+val.foto+'" class="img-alat"><div class="text_alat_list">'+val.kategori_alat+'</div></div></td><td><div class="text_alat_jumlah">'+val.jumlah_alat+'</div> </td></tr></tbody></table>');
                    });
                }else{
                    $('modal-body').html('<div class="text_title_box_harga"> Alat Tidak Tersedia </div>');
                }
                $('#exampleModalCenter').modal('show');               
            }
        })
    }


      $('#send_to_delivery').on('click',function (e) {
          e.preventDefault();  
          totalQty = 0;
          console.log(data_array_paket);
            $.each(data_array_paket, function (indexInArray, valueOfElement) { 
                if (valueOfElement.type == 'paket') {
                    totalQty += valueOfElement.kuantitas;
                }
            });
            if (totalQty > 1) {
                   send_to_delivery(data_array_paket);
            }else{
                Swal.fire({
                    title: 'Gagal Diproses ke Pengantaran !!',
                    text: 'Kuantitas Pesanan untuk Menu Paket Utama harus lebih dari 2 pack',
                    type: 'error'
                });
            }

       
      })

        });
    </script>
@endpush