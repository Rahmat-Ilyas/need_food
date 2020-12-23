$(document).ready(function () {
    var count_additional = '';
    var tampung = [];
    var tampung_qty_paket = [];
    var body = [];
    var url = $('meta[name="host_url"]').attr('content');
    var token = $('meta[name="csrf-token"]').attr('content');
    var headers = {
        "Accept"		: "application/json",
        "Access-Control-Allow-Origin" : "*",
        "Authorization" : "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjA3YWE1Y2M3MDA1YTdjMDA2YzgwZWNjNjIxN2E4Y2VhOTUwMTEzMWNmM2MxOTVmMDk2YjJmZTAwY2I2MGI4ODAxNzE1ZGJmYjQ1YTYzMmIwIn0.eyJhdWQiOiIxIiwianRpIjoiMDdhYTVjYzcwMDVhN2MwMDZjODBlY2M2MjE3YThjZWE5NTAxMTMxY2YzYzE5NWYwOTZiMmZlMDBjYjYwYjg4MDE3MTVkYmZiNDVhNjMyYjAiLCJpYXQiOjE2MDA1MTI5NTEsIm5iZiI6MTYwMDUxMjk1MSwiZXhwIjoxNjMyMDQ4OTUwLCJzdWIiOiIxMyIsInNjb3BlcyI6W119.oHghL81Jc0xq-vvDVFde3QeqYs3s0Me6XukZtGy8G8HegV4LV2ImqKlpw_wdwxBOtKhBfodMFICi0YmNcPov7A",
        'X-CSRF-TOKEN'	: token
    }

    $.ajax({
        url     : url+'/api/kelolamenu/getpaket',
        method  : "GET",
        headers	: headers,
        success : function(data) {
            var datapaket = '';
            if (data['success'] == true) {
                $.each(data['result'], function (indexInArray, valueOfElement) { 
                     datapaket += '<div class="list_menu_paket" data-id="'+valueOfElement.id+'">'+valueOfElement.nama+'</div>';
                });
                $('#item_paket').append(datapaket);
            }
        }
    });

    $(document).on('click','.list_menu_paket', function () {
        var id = $(this).data('id');

        $.ajax({
            url     : url+'/api/kelolamenu/getpaket/'+id,
            method  : "GET",
            headers	: headers,
            success : function(data) {
                var path_asset = url+'/assets/images/paket';
                var value = data['result'];
                if (data['success'] == true) {
                    $('.img-paket').html('<img src="'+path_asset+'/'+value.foto+'" class="imageproduct">');
                    $('.group_text_order').html('<p class="text-card-order">'+value.keterangan+'</p>');
                    $('.tampung_value').html('<input type="hidden" id="get_paket_id" value="'+value.id+'">');
                    $('#nominals').html('<span class="currency-general">'+value.harga+'</span><span class="sub-currency">/ Paket</span>');
                }
            }
        });
    });

    $.ajax({
        url     : url+'/api/kelolamenu/getadditional',
        method  : "GET",
        headers	: headers,
        success : function(data) {
            var additional = '';
            count_additional = data['result']['length'];
            var index = 1;
            var path_asset_bahan = url+'/assets/images/bahan';
            if (data['success'] == true) {
                $.each(data['result'], function (indexInArray, valueOfElement) { 
                     additional += '<div class="col-sm-3 grid_element">';
                     additional += '<div class="card_additional">';
                     additional += '<img src="'+path_asset_bahan+'/'+valueOfElement.foto+'" class="image_additonal">'; 
                     additional += '<div class="text-image">'+valueOfElement.nama_daging+'</div>';
                     additional += '<input type="checkbox" class="checbox_image" name="id_additional" value="'+valueOfElement.id+'"/>';
                     additional += '<div class="card_additional_body">';
                     additional += '<div class="row form_card_additonal_product">';
                     additional += '<div class="col-sm-12">';
                     additional += '<div class="card_additional_text">Rp. '+valueOfElement.harga+'</div>';
                     additional += '<div class="input-group"><span class="input-group-btn"><button type="button" class="tombol_additional btn-number'+index+'" disabled="disabled" data-type="minus" data-field="quant['+index+']"><i class="icofont-minus icon-number_additional"></i></button></span><input type="text" name="quant['+index+']" class="form-nedd_additional input-number" value="1" min="1" max="1000"><span class="input-group-btn"><button type="button" class="tombol_additional btn-number'+index+'" data-type="plus" data-field="quant['+index+']"><i class="icofont-plus icon-number_additional"></i></button></span></div>';
                     additional += '</div>';
                     additional += '</div>';
                     additional += '</div>';
                     additional += '</div>';
                     additional += '</div>';
                    index++;
                });
                $('.additional_content_box').append(additional);
            }
        }
    });

$('.btn-number').click(function(e){
    e.preventDefault();
    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            } 
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});

$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {
    
    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());
    
    name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    
    
});
$(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    show_modal_detail = (title,sub_url) => {
        var host = $('meta[name="host_url"]').attr('content');
        $('#modal-title').text(title);

        $.ajax({
            url : host+sub_url,
            dataType : 'html',
            success : function (response) {
                $('#modal-body').html(response);
            },error : function () {
                alert("gagal tampilkan modal");
            }
        })
        $('#exampleModalCenter').modal('show');
    }

    $('.box_toogle_menu').click(function () {
        $('.item-toogle').toggleClass('active-toogle');
    })

    $('#send_to_card_paket').on('click',function () {
        var id_paket = $('#get_paket_id').val();
        var type = 'paket';
        var get_qty_paket = $('#get_qty_paket').val();
        $('#get_qty_paket').val(1);
        var params = '';
        
        $.ajax({
            url     : url+'/api/kelolamenu/getpaket/'+id_paket,
            method  : "GET",
            headers	: headers,
            success : function(data) {
                  params = {  
                    'foto' : data.result['foto'],
                    'nama' : data.result['nama'],
                    'harga' : data.result['harga'], 
                    'kuantitas':get_qty_paket,
                    'type' : type, 
                  };      

                  grouop_value(params);    

            }
        });
         
        $('.pill_number').html(tampung['length']+1);
        toastr_notice('success','Berhasil Masukkan Ke Keranjang');
    })

    $('#additional_get').click(function (event) {
        event.preventDefault();
        var get_id_addtional = [];
        $('input:checkbox[name=id_additional]:checked').each(function () {
            get_id_addtional.push($(this).val());
        });
       
        // $.each(get_id_addtional,function(index,value){
        //     $.ajax({
        //         url     : url+'/api/kelolamenu/getadditional/'+value,
        //         method  : "GET",
        //         headers : headers,
        //         success : function(data) {
                       
        //         }
        //     });
        // });

    })

    grouop_value = (params) =>{
        tampung.push(params);
    }

    $('.grid_button_flag').click(function () {
        var content_cart_modal = '';
        var path_asset_image =  url+'/assets/images/paket';
        console.log(tampung);
        if (tampung.length != 0) {
                
               $('.box-keranjang-modal').remove();
               $.each(tampung, function (key, values) { 
                content_cart_modal += '<div class="box-keranjang-modal mt-2">';
                content_cart_modal += '<div class="row content-modal-cart">';
                content_cart_modal += '<div class="col-lg-8">';
                content_cart_modal += '<div class="row">';
                content_cart_modal += '<div class="col-lg-6">';
                content_cart_modal += '<img src="'+path_asset_image+'/'+values.foto+'" class="img-keranjang-modal">';
                content_cart_modal += '</div>';
                content_cart_modal += '<div class="col-lg-6 group-text-keranjang">';
                content_cart_modal += '<div class="text-image-keranjang-modal">'+values.nama+'</div>';
                content_cart_modal += '<div class="text-currency-keranjang">'+values.harga+'</div>';
                content_cart_modal += '</div>';
                content_cart_modal += '</div>';
                content_cart_modal += '</div>';
                content_cart_modal += '<div class="col-lg-4">';
                content_cart_modal += '<div class="row grid-form-modal">';
                content_cart_modal += '<button type="button" class="tombol_keranjang_number btn-number"><i class="icofont-minus icon-number_additional"></i> </button>';
                content_cart_modal += '<input type="text" name="quant[1]" class="form-nedd-keranjang input-number" value="'+values.kuantitas+'" min="1" max="1000">';
                content_cart_modal += '<button type="button" class="tombol_keranjang_number btn-number">   <i class="icofont-plus icon-number_additional"></i></button>';
                content_cart_modal += '<div class="icon-delete"><i class="icofont-ui-delete"></i></div>';
                content_cart_modal += '</div>';
                content_cart_modal += '</div>';
                content_cart_modal += '</div>';
             });

             $('#modal-body-cart').append(content_cart_modal);
             $('#cartmodal').modal('show');
        }else{
            toastr_notice('error','keranjang Kosong');
        }
    })

    toastr_notice = (type,message) =>{
        Command: toastr[`${type}`](`${message}`);

        toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "200",
        "hideDuration": "1000",
        "timeOut": "500",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
        }
    }
  
});