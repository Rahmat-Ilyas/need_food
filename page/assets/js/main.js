$(document).ready(function () {

    var url = $('meta[name="host_url"]').attr('content');
    var headers = {
        "Accept"		: "application/json",
        "Access-Control-Allow-Origin" : "*",
        "Authorization" : "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjA3YWE1Y2M3MDA1YTdjMDA2YzgwZWNjNjIxN2E4Y2VhOTUwMTEzMWNmM2MxOTVmMDk2YjJmZTAwY2I2MGI4ODAxNzE1ZGJmYjQ1YTYzMmIwIn0.eyJhdWQiOiIxIiwianRpIjoiMDdhYTVjYzcwMDVhN2MwMDZjODBlY2M2MjE3YThjZWE5NTAxMTMxY2YzYzE5NWYwOTZiMmZlMDBjYjYwYjg4MDE3MTVkYmZiNDVhNjMyYjAiLCJpYXQiOjE2MDA1MTI5NTEsIm5iZiI6MTYwMDUxMjk1MSwiZXhwIjoxNjMyMDQ4OTUwLCJzdWIiOiIxMyIsInNjb3BlcyI6W119.oHghL81Jc0xq-vvDVFde3QeqYs3s0Me6XukZtGy8G8HegV4LV2ImqKlpw_wdwxBOtKhBfodMFICi0YmNcPov7A",
        'X-CSRF-TOKEN'	: $('meta[name="csrf-token"]').attr('content')
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
                    $('#nominals').html('<span class="currency-general">'+value.harga+'</span><span class="sub-currency">/ Paket</span>')
                }
            }
        });
    });

    $.ajax({
        url     : url+'/api/kelolamenu/getadditional',
        method  : "GET",
        headers	: headers,
        success : function(data) {
            var path_asset_bahan = url+'/assets/images/bahan';
            var additional = '';
            if (data['success'] == true) {
                $.each(data['result'], function (indexInArray, valueOfElement) { 
                     additional += '<div class="col-sm-3 grid_element">';
                     additional += '<div class="card_additional">';
                     additional += '<img src="'+path_asset_bahan+'/'+valueOfElement.foto+'" class="image_additonal">'; 
                     additional += '<div class="text-image">'+valueOfElement.nama_daging+'</div>';
                     additional += '<input type="checkbox" class="checbox_image" />';
                     additional += '<div class="card_additional_body">';
                     additional += '<div class="row form_card_additonal_product">';
                     additional += '<div class="col-sm-12">';
                     additional += '<div class="card_additional_text">Rp. '+valueOfElement.harga+'</div>';
                     additional += '<div class="input-group"><span class="input-group-btn"><button type="button" class="tombol_additional btn-number" disabled="disabled" data-type="minus" data-field="quant[1]"><i class="icofont-minus icon-number_additional"></i></button></span><input type="text" name="quant[1]" class="form-nedd_additional input-number" value="1" min="1" max="1000"><span class="input-group-btn"><button type="button" class="tombol_additional btn-number" data-type="plus" data-field="quant[1]"><i class="icofont-plus icon-number_additional"></i></button></span></div>';
                     additional += '</div>';
                     additional += '</div>';
                     additional += '</div>';
                     additional += '</div>';
                     additional += '</div>';

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

    // $('.list_menu_paket').mouseenter(function () { 
    //     $(this).css('box-shadow', '0px 2px 11px rgba(0, 0, 0, 0.25)');
    // });

    // $('.list_menu_paket').mouseleave(function () { 
    //     $(this).css('box-shadow', 'none');
    // });

    $('.box_toogle_menu').click(function () {
        $('.item-toogle').toggleClass('active-toogle');
    })
  
});