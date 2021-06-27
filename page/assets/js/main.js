$(document).ready(function () {
    var count_additional = '';
    var tampung = [];
    var tampung_qty_paket = [];
    var body = [];
    var totalQty = 0;
    var url = $('meta[name="host_url"]').attr('content');
    var token = $('meta[name="csrf-token"]').attr('content');


    headers = () => {
        var headers = {
            "Accept": "application/json",
            "Access-Control-Allow-Origin": "*",
            "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjA3YWE1Y2M3MDA1YTdjMDA2YzgwZWNjNjIxN2E4Y2VhOTUwMTEzMWNmM2MxOTVmMDk2YjJmZTAwY2I2MGI4ODAxNzE1ZGJmYjQ1YTYzMmIwIn0.eyJhdWQiOiIxIiwianRpIjoiMDdhYTVjYzcwMDVhN2MwMDZjODBlY2M2MjE3YThjZWE5NTAxMTMxY2YzYzE5NWYwOTZiMmZlMDBjYjYwYjg4MDE3MTVkYmZiNDVhNjMyYjAiLCJpYXQiOjE2MDA1MTI5NTEsIm5iZiI6MTYwMDUxMjk1MSwiZXhwIjoxNjMyMDQ4OTUwLCJzdWIiOiIxMyIsInNjb3BlcyI6W119.oHghL81Jc0xq-vvDVFde3QeqYs3s0Me6XukZtGy8G8HegV4LV2ImqKlpw_wdwxBOtKhBfodMFICi0YmNcPov7A",
            'X-CSRF-TOKEN': token
        }

        return headers

    }

    makeleton_paket = () => {
        var output = '';
        output += '<div class="ph-item">';
        output += '<div class="ph-col-2">';
        output += '<div class="ph-row">';
        output += '<div class="ph-col-12 big"></div>';
        output += '<div class="ph-col-12"></div>';
        output += '<div class="ph-col-12"></div>'
        output += '<div class="ph-col-12"></div>';
        output += '<div class="ph-col-12"></div>';
        output += '</div>';
        output += '</div>';
        output += '<div class="ph-col-8">';
        output += '<div class="ph-picture"></div>';
        output += '<div class="ph-row">';
        output += '<div class="ph-col-6"></div>';
        output += '</div>';
        output += '<div class="ph-row">';
        output += '<div class="ph-col-6"></div>';
        output += '</div>';
        output += '</div>';
        output += '<div class="ph-col-2">';
        output += '<div class="ph-row">';
        output += '<div class="ph-col-12 big"></div>';
        output += '<div class="ph-col-12"></div>';
        output += '<div class="ph-col-12"></div>';
        output += '<div class="ph-col-12"></div>';
        output += '<div class="ph-col-12"></div>';
        output += '</div>';
        output += '</div>';
        output += '</div>';

        return output;

    }

    makeleton_additional = () => {
        var output = '';
        output += '<div class="ph-item"><div class="ph-col-4"><div class="ph-picture"></div> <div class="ph-row"><div class="ph-col-12 big"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div><div class="ph-col-4"><div class="ph-picture"></div><div class="ph-row"><div class="ph-col-12 big"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div><div class="ph-item"><div class="ph-col-4"><div class="ph-picture"></div> <div class="ph-row"><div class="ph-col-12 big"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div><div class="ph-col-4"><div class="ph-picture"></div><div class="ph-row"><div class="ph-col-12 big"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div>';

        return output;

    }

    makeleton_cart = () => {
        var output = '';
        output += '<div class="ph-item"><div class="ph-col-2"><div class="ph-row"><div class="ph-col-12 big"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div><div class="ph-col-10"><div class="ph-picture"></div><div class="ph-row"><div class="ph-col-6"></div></div><div class="ph-row"><div class="ph-col-6"></div>       </div></div></div>';

        return output;
    }

    makeleton_currency = () => {
        var output = '';
        output += '<div class="ph-item"><div class="ph-col-12"><div class="ph-row"><div class="ph-col-12 big"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div>';
        return output;
    }

    makeleton_form = () => {
        var output = '';
        output += '<div class="ph-item"><div class="ph-col-6"><div class="ph-picture"></div><div class="ph-row"> <div class="ph-col-12 big"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12 big"></div><div class="ph-col-12"></div><div class="ph-col-12 big"></div></div></div><div class="ph-col-6"><div class="ph-row"><div class="ph-col-12 big"></div><div class="ph-row"></div><div class="ph-row"></div><div class="ph-row"></div><div class="ph-col-12 big"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12 big"></div></div></div></div>';
        return output;
    }

    makeleton_list_price = () => {
        var output = '';
        output += '<div class="ph-item"><div class="ph-col-12"><div class="ph-picture"></div><div class="ph-row"><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div>';
        return output;
    }

    // Function Baru 
    $('#firstMenuPaket').addClass('active_category');
    $('.menu_paket').hover(function () {
        $('#firstMenuPaket').removeClass('active_category');
    })

    get_paket_primary = (params) => {
        var note = '';
        var kategori_menu = '';
        if (params == 1) {
            note += ' <div class="box_paket">';
            note += '<div class="header_paket_info">Ketentuan</div>';
            note += '<ul class="list_paket_info">';
            note += '<li>Shabu + daging : minimal pesanan 8 pax</li>';
            note += '<li>Shabu : minimal pesanan 8 pax</li>';
            note += '<li>Yakiniku : Minimal pesanan 5 pax</li>';
            note += '<li>Yakiniku + shabu ( Mix ) : minimal pesanan 4 pax yakiniku dan 3 pax shabu</li>';
            note += '</ul>';
            note += '</div>';
            note += '</div>';
            // note += '<div class="box_paket">';
            // note += '<div class="header_paket_info">Ketentuan Pemesanan Paket Home Service</div>';
            // note += '<p class="text_paket_info">Lorem ipsum dolor sit amet, consectetur adipiscing elit.Mauris a fermentum dui gravida id urna. Proin risus venenatis dui, vehicula.</p>';    
            // note += '</div>';                
        } else if (params == 2) {
            note += ' <div class="box_paket">';
            note += '<div class="header_paket_info">Ketentuan</div>';
            note += '<ul class="list_paket_info">';
            note += '<li>Shabu + daging : minimal pesanan 2 pax</li>';
            note += '<li>Shabu : minimal pesanan 2 pax</li>';
            note += '<li>Yakiniku : Minimal pesanan 2 pax</li>';
            note += '</ul>';
            note += '</div>';
            note += '</div>';
        } else {
            note += ' <div class="box_paket">';
            note += '<div class="header_paket_info">Ketentuan</div>';
            note += '<ul class="list_paket_info">';
            note += '<li>Minimal Total Pesanan sebesar Rp 3.500.00.00</li>';
            note += '</ul>';
            note += '</div>';
            note += '</div>';
        }

        $.ajax({
            url: url + '/api/kelolamenu/getpaket',
            method: "GET",
            headers: headers(),
            success: function (data) {
                var html = '';
                var path_asset = url + '/assets/images/paket';
                if (data['success'] == true) {
                    $.each(data['result'], function (indexInArray, valueOfElement) {
                        html += '<div class="col-md-6">';
                        html += '<div class="card_menu_paket">';
                        html += '<img src="' + path_asset + '/' + valueOfElement.foto + '" class="img_paket"></img>';
                        html += `<div class="name_paket">${valueOfElement.nama}</div>`;
                        html += `<div class="item_paket_info"><span class="price">Rp ${valueOfElement['harga'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</span><span class="sub_info_price">/ Paket</span>`;
                        html += '</div>';
                        html += '<div class="row btn-group-paket">';
                        html += "<button type='button' class='btn_qty_paket btn-number" + valueOfElement.id + "' data-type='minus' onclick='number(`paketUtama_input" + valueOfElement.id + "`,`mines`)' data-field='quant[" + valueOfElement.id + "]'><i class='icofont-minus icont-button-paket'></i></button>";
                        html += `<input type="text" class="form_paket input-number" id="paketUtama_input${valueOfElement.id}" value="1" min="1" max="1000">`;
                        html += "<button type='button' class='btn_qty_paket btn-number" + valueOfElement.id + "' data-type='add' onclick='number(`paketUtama_input" + valueOfElement.id + "`,`add`)' data-field='quant[" + valueOfElement.id + "]'><i class='icofont-plus icont-button-paket'></i></button>";
                        html += `<button class="tombol_custom_paket tombol-keranjang" onclick="saveToCart(${valueOfElement.id},${params})"><span class="text-button-paket">Tambah</span><iclass="icofont-cart icon_cart_paket"></i></button>`;
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                    });
                    $('.contentMenu').html(html);
                    $('.info_ketentuan').html(note);
                }
            }
        });
    }

    get_paket_primary(1);

    $('.menu_paket').on('click', function () {
        $('.menu_paket').removeClass('active_category');
        var data_action = $(this).attr('data-action');
        $('#firstMenuPaket').removeClass('active_category');
        $(this).addClass('active_category');

        get_paket_primary(data_action);

    })

    saveToCart = (id, kategori_menu) => {
        var qty = $(`#paketUtama_input${id}`).val();
        var type = 'paket';
        var params = '';
        $.ajax({
            url: url + '/api/kelolamenu/getpaket/' + id,
            method: "GET",
            headers: headers(),
            success: function (data) {
                console.log(data);
                params = {
                    'id': data.result['id'],
                    'foto': data.result['foto'],
                    'nama': data.result['nama'],
                    'harga': data.result['harga'],
                    'kuantitas': qty,
                    'type': type,
                    'kategori_menu': kategori_menu
                };
                grouop_value(params);
            }
        });

        $('.pill_number').html(tampung['length'] + 1);
    }

    // End Function Baru


    setTimeout(function () {
        $('.paket_content').show();
        $('.box-element').show();
        $('.content-keranjang-list').show();
        $('.konten_box_harga').show();
        $('.pengantaran-main').show();
        $('.paket_skelton').hide();
        $('.makeleton_additonal').hide();
        $('.content-keranjang-first').hide();
        $('.konten_first').hide();
        $('.form_first').hide();
        $('.list_currency_first').hide();
    }, 3000);

    // $.ajax({
    //     url: url + '/api/kelolamenu/getpaket',
    //     method: "GET",
    //     headers: headers(),
    //     success: function (data) {
    //         var html = '';
    //         if (data['success'] == true) {
    //             $.each(data.result, function (indexInArray, valueOfElement) {
    //                 html += '<div class="col-lg-4 mt-3">';
    //                 html += '<div class="card_menu">';
    //                 html += '<div class="title_card_menu">' + valueOfElement.nama + '</div>';
    //                 html += '<div class="card_menu_currency">' + valueOfElement.harga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</div>';
    //                 html += '<hr class="line_menu">';
    //                 html += '<ul class="list_sub_menu">';
    //                 $.each(valueOfElement.item_paket, function (index, value) {
    //                     html += '<li>' + value + '</li>';
    //                 });
    //                 html += '</ul>';
    //                 html += '<div class="row justify-content-center">';
    //                 html += '<button class="tombol_menu_card tombol-order_header">Lihat</button>';
    //                 html += '</div>';
    //                 html += '</div>';
    //                 html += '</div>';
    //             });
    //             $('.card_grid').html(html);
    //         }
    //     }
    // });

    $(document).on('click', '.tombol-order_header', function () {
        window.location.href = url + '/order';
    })


    // $(document).on('click', '.list_menu_paket', function () {
    //     var id = $(this).data('id');
    //     $('#item_paket .list_menu_paket').removeClass('active');
    //     $(this).addClass('active');
    //     ajax_name_menu(id);
    // });

    // $(document).on('click', '.value_toogle', function () {
    //     var id = $(this).data('id');
    //     $('.item-toogle .value_toogle').removeClass('active');
    //     $(this).addClass('active');
    //     ajax_name_menu(id);
    // });

    // ajax_name_menu = (id) => {
    //     $.ajax({
    //         url: url + '/api/kelolamenu/getpaket/' + id,
    //         method: "GET",
    //         headers: headers(),
    //         success: function (data) {
    //             var path_asset = url + '/assets/images/paket';
    //             var value = data['result'];
    //             console.log(value);
    //             if (data['success'] == true) {
    //                 $('.img-paket').html('<img src="' + path_asset + '/' + value.foto + '" class="imageproduct">');
    //                 $('.ratings').html('<div class="label_rating">9.0</div><div class="row valuerating"><div class="star-rating"><input type="radio" id="5-stars" name="rating" value="5" /><label for="5-stars" class="star">&#9733;</label><input type="radio" id="4-stars" name="rating" value="4"/><label for="4-stars" class="star">&#9733;</label><input type="radio" id="3-stars" name="rating" value="3" /><label for="3-stars" class="star">&#9733;</label><input type="radio" id="2-stars" name="rating" value="2" /><label for="2-stars" class="star">&#9733;</label><input type="radio" id="1-star" name="rating" value="1" /><label for="1-star" class="star">&#9733;</label></div></div>');
    //                 $('.group_text_order').html('<p class="text-card-order">' + value.keterangan + '</p>');
    //                 $('.tampung_value').html('<input type="hidden" id="get_paket_id" value="' + value.id + '">');
    //                 $('#nominals').html('<span class="currency-general">' + value.harga + '</span><span class="sub-currency">/ Paket</span>');
    //                 $('.form_qty').html("<div class='input-groups grid_calculate_order'><span class='input-group-btn'><button type='button' class='tombols btn-number' onclick='number(`paket_input`,`mines`)' data-type='minus' data-field='quant[1]'><i class='icofont-minus icon-number'></i></button></span><input type='text' name='quant[1]' class='form-nedd input-number' id='paket_input' value='1' min='1' max='1000'><span class='input-group-btn'><button type='button' class='tombols btn-number' data-type='plus' onclick='number(`paket_input`,`add`)' data-field='quant[1]'><i class='icofont-plus icon-number'></i></button></span></div>");
    //                 $('.action_data').html('<button class="tombol-lg tombol-keranjang text-button" id="send_to_card_paket">Masukkan Keranjang</button>');
    //             }
    //         }
    //     });
    // }

    $.ajax({
        url: url + '/api/kelolamenu/getadditional',
        method: "GET",
        headers: headers(),
        success: function (data) {
            var additional = '';
            count_additional = data['result']['length'];
            var index = 1;
            var path_asset_bahan = url + '/assets/images/bahan';
            if (data['success'] == true) {
                $.each(data['result'], function (indexInArray, valueOfElement) {
                    additional += '<div class="col-sm-3 grid_element">';
                    additional += '<div class="card_additional">';
                    additional += '<img src="' + path_asset_bahan + '/' + valueOfElement.foto + '" class="image_additonal">';
                    additional += '<div class="text-image">' + valueOfElement.nama_daging + '</div>';
                    additional += '<input type="checkbox" class="checbox_image" data-nama="' + valueOfElement.nama_daging + '" name="id_additional" value="' + valueOfElement.id + '"/>';
                    additional += '<div class="card_additional_body">';
                    additional += '<div class="row form_card_additonal_product">';
                    additional += '<div class="col-sm-12">';
                    additional += '<div class="card_additional_text">Rp. ' + valueOfElement.harga + '</div>';
                    additional += "<div class='input-group'><span class='input-group-btn'><button type='button' class='tombol_additional btn-number'+index+'' data-type='minus' onclick='number(`additional_input" + valueOfElement.id + "`,`mines`)' data-field='quant['+index+']'><i class='icofont-minus icon-number_additional'></i></button></span><input type='text' name='quant['+index+']' class='form-nedd_additional input-number' id='additional_input" + valueOfElement.id + "' value='1' min='1' max='1000'><span class='input-group-btn'><button type='button' class='tombol_additional btn-number'+index+'' data-type='plus' onclick='number(`additional_input" + valueOfElement.id + "`,`add`)' data-field='quant['+index+']'><i class='icofont-plus icon-number_additional'></i></button></span></div>";
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


    $('.btn-number').click(function (e) {
        e.preventDefault();
        fieldName = $(this).attr('data-field');
        type = $(this).attr('data-type');
        var input = $("input[name='" + fieldName + "']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if (type == 'minus') {

                if (currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                }
                if (parseInt(input.val()) == input.attr('min')) {
                    $(this).attr('disabled', true);
                }

            } else if (type == 'plus') {

                if (currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                }
                if (parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }

            }
        } else {
            input.val(0);
        }
    });

    $('#submit_saran_masukan').on('click', function (e) {
        e.preventDefault();

        $.ajax({
            url: url + "/api/kritiksaran/create",
            method: "POST",
            headers: headers(),
            data: $('.form_kontak').serialize(),
            success: function (data) {
                toastr_notice('success','Berhasil','Data Terkirim');
                $('.form_kontak').trigger('reset');
            },
            error: function (res) {
                var text = '';
                $('.validation_error').css('display', 'block');
                console.log(res.responseJSON);
                $.each(res.responseJSON.message, function (indexInArray, valueOfElement) {
                    text += '<li>' + valueOfElement + '</li>';
                });
                $('.list_error').append(text);
            }
        });

    })

    $('.input-number').focusin(function () {
        $(this).data('oldValue', $(this).val());
    });
    $('.input-number').change(function () {

        minValue = parseInt($(this).attr('min'));
        maxValue = parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());

        name = $(this).attr('name');
        if (valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if (valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
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

    $('.box_toogle_menu').click(function () {
        $('.item-toogle').toggleClass('active-toogle');
    })



    $(document).on('change', '.checbox_image', function () {
        $('.list_item_text_additional').html('');
        var html = '';
        var val_this = $(this).val();
        var valueTitle = '';
        var tampungVal = [];

        $('input:checkbox[name=id_additional]:checked').each(function () {
            var val_this = $(this).val();

            valueTitle = {
                'nama': $(this).data('nama'),
                'kuantitas': $(`#additional_input${val_this}`).val()
            }

            tampungVal.push(valueTitle);

        });

        $.each(tampungVal, function (indexInArray, valueOfElement) {
            html += `<li>- &nbsp; ${valueOfElement.kuantitas} ${valueOfElement.nama}</li>`;
        });
        $('.list_item_text_additional').append(html);

        // if (this.checked) {
        //     var val_this = $(this).val();
        //     var valueTitle = '';
        //     var tampungVal = [];

        //     $('input:checkbox[name=id_additional]:checked').each(function () {
        //         var val_this = $(this).val();

        //       valueTitle = {
        //         'nama' : $(this).data('nama'),
        //         'kuantitas' : $(`#additional_input${val_this}`).val()
        //      }

        //            tampungVal.push(valueTitle);

        //     });

        //     // valueTitle = {
        //     //     'nama' : $(this).data('nama'),
        //     //     'kuantitas' : $(`#additional_input${val_this}`).val()
        //     // }

        //     // tampungVal.push(valueTitle);
        //     // $.each(tampungVal, function (indexInArray, valueOfElement) { 
        //     //      html += `<li>- &nbsp; ${valueOfElement.kuantitas} ${valueOfElement.nama}</li>`;
        //     // });
        //     // $('.list_item_text_additional').append(html);
        // }
    })

    $('#additional_get').click(function (event) {
        event.preventDefault();
        var get_id_addtional = [];
        var params_additional = '';
        var id_additional_var = '';
        var value_x_checked = '';
        $('input:checkbox[name=id_additional]:checked').each(function () {
            var val_this = $(this).val();

            value_x_checked = {
                'id_daging': val_this,
                'kuantitas': $(`#additional_input${val_this}`).val()
            }

            get_id_addtional.push(value_x_checked)

        });

        console.log(get_id_addtional);

        if (get_id_addtional.length > 0) {
            if ($(this).data('info') == undefined) {
                id_additional_var = get_id_addtional;
            } else {
                id_additional_var = [get_id_addtional[get_id_addtional.length - 1]];
            }

            $.each(id_additional_var, function (index, value) {
                $.ajax({
                    url: url + '/api/kelolamenu/getadditional/' + value.id_daging,
                    method: "GET",
                    headers: headers(),
                    success: function (data) {
                        get_id_addtional = [];
                        params_additional = {
                            'id': data.result['id'],
                            'foto': data.result['foto'],
                            'nama': data.result['nama_daging'],
                            'harga': data.result['harga'],
                            'kuantitas': value.kuantitas,
                            'type': 'additional',
                        };
                        grouop_value(params_additional);
                    }
                });
            });
        } else {
            toastr_notice('warning','Peringatan','Anda belum memilih paket daging')
        }


        $(this).attr('data-info', '222');
        $('.pill_number').html(tampung['length'] + id_additional_var.length);
    })

    grouop_value = (params) => {
        var respon = true;
        console.log(params);
        console.log(tampung);
        $.each(tampung, function (indexInArray, valueOfElement) {
            var ParamsPaket = '';
            if (params.type == 'paket') {
                ParamsPaket = 'paket';
                if (params.id == valueOfElement.id && ParamsPaket == valueOfElement.type) {
                    respon = false;
                    return respon;
                }
            } else {
                respon = true;
                return respon;
            }
        });
        console.log(respon);
        if (respon == true) {
            tampung.push(params);
            toastr_notice('success','Berhasil' ,'Berhasil Masukkan Ke Keranjang');
        } else {
            Swal.fire({
                title: 'Gagal Diproses ke Keranjang !!',
                text: 'Paket Sudah ada di Keranjang',
                type: 'error'
            });
        }

    }

    $('.grid_button_flag').click(function () {
        var content_cart_modal = '';
        var path_asset_image = '';
        console.log(tampung);
        if (tampung.length != 0) {
            $('.box-keranjang-modal').remove();
            $.each(tampung, function (key, values) {

                if (values['type'] == 'paket') {
                    path_asset_image = url + '/assets/images/paket';
                } else {
                    path_asset_image = url + '/assets/images/bahan';
                }

                content_cart_modal += '<div class="box-keranjang-modal mt-2">';
                content_cart_modal += '<div class="row content-modal-cart row_index_' + key + '">';
                content_cart_modal += '<div class="col-lg-8">';
                content_cart_modal += '<div class="row">';
                content_cart_modal += '<div class="col-lg-6">';
                content_cart_modal += '<img src="' + path_asset_image + '/' + values.foto + '" class="img-keranjang-modal">';
                content_cart_modal += '</div>';
                content_cart_modal += '<div class="col-lg-6 group-text-keranjang">';
                content_cart_modal += '<div class="text-image-keranjang-modal">' + values.nama + '</div>';
                content_cart_modal += '<div class="text-currency-keranjang">Rp.' + values.harga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</div>';
                content_cart_modal += '</div>';
                content_cart_modal += '</div>';
                content_cart_modal += '</div>';
                content_cart_modal += '<div class="col-lg-4">';
                content_cart_modal += '<div class="row grid-form-modal">';
                content_cart_modal += "<button type='button' onclick='number(`form_keranjang_modal" + values.id + values.type + "`,`mines`)' class='tombol_keranjang_number btn-number'><i class='icofont-minus icon-number_additional'></i> </button>";
                content_cart_modal += "<input type='text' id='form_keranjang_modal" + values.id + values.type + "' name='quant[1]' class='form-nedd-keranjang input-number' value='" + values.kuantitas + "' min='1' max='1000'>";
                content_cart_modal += "<button type='button' onclick='number(`form_keranjang_modal" + values.id + values.type + "`,`add`)' class='tombol_keranjang_number btn-number'><i class='icofont-plus icon-number_additional'></i></button>";
                content_cart_modal += '<div class="icon-delete"><i class="icofont-ui-delete delete_paket_modal" data-action="' + key + '"></i></div>';
                content_cart_modal += '</div>';
                content_cart_modal += '</div>';
                content_cart_modal += '</div>';
            });
            $('#modal-body-cart').append(content_cart_modal);
            $('#cartmodal').modal('show');
        } else {
            toastr_notice('error', 'Gagal','keranjang Kosong');
        }
    })

    $('#modal-body-cart').on('click', '.delete_paket_modal', function () {
        var params_row = $(this).data('action');
        console.log(params_row)
        tampung.splice(params_row, 1);
        $(`.row_index_${params_row}`).remove();
        console.log(tampung);
        $('.pill_number').html(tampung['length']);
    })

    $('.tombol-lg-modal').click(function () {
        var params_list_modal = '';
        var list_pesanan_modal = [];
        totalQty = 0;
        console.log(tampung);
        $.each(tampung, function (indexInArray, valueOfElement) {
            params_list_modal = {
                'id': valueOfElement.id,
                'foto': valueOfElement.foto,
                'nama': valueOfElement.nama,
                'harga': valueOfElement.harga,
                'kuantitas': parseInt($("#form_keranjang_modal" + valueOfElement.id + valueOfElement.type + "").val()),
                'type': valueOfElement.type,
                'kategori_menu' : valueOfElement.kategori_menu
            }
            list_pesanan_modal.push(params_list_modal);
        });
  
        console.log(list_pesanan_modal)
        // Filter Paket untuk Checkout ke keranjang

        if (list_pesanan_modal.length > 0) {
            if (list_pesanan_modal[0]['kategori_menu'] == 1) {
                var status = true;
                alert('ini home service')
                if (list_pesanan_modal.length < 2) {
                    $.each(list_pesanan_modal, function (indexInArray, valueOfElement) {
                        if ( valueOfElement.nama == "Yakiniku") {
                           valueOfElement.kuantitas >= 5 ? postToCart(list_pesanan_modal) : status = false;   
                        } 

                        if ( valueOfElement.nama == "Shabu") {
                            valueOfElement.kuantitas >= 8 ? postToCart(list_pesanan_modal) : status = false;   
                        } 
                    });
                    alert(status);
                    if (status == false) {
                        toastr_notice('error', 'Gagal',`Paket Tidak Memenuhi Minimal Pemesanan`);
                    }
                }else{
                    var menu_A;
                    var menu_B;
                    $.each(list_pesanan_modal, function (indexIn, valueOfMix) {
                        if (valueOfMix.nama == 'Shabu') {
                            valueOfMix.kuantitas >= 3 ? menu_A = true : menu_A = false;
                        }
        
                        if (valueOfMix.nama == 'Yakiniku' ) {
                            valueOfMix.kuantitas >= 4 ? menu_B = true : menu_B = false;
                        }
                    });
                  
                    menu_A == true && menu_B == true ? postToCart(list_pesanan_modal) : toastr_notice('error', 'Gagal','Paket Mix Tidak Memenuhi Minimal Pemesanan');
                    
                }

            }else if (list_pesanan_modal[0]['kategori_menu'] == 2) {
                var status = '';
                var menu_A;
                var menu_B;
                var menu_C;
                $.each(list_pesanan_modal, function (indexInArray, valueOfElement) {
                    if ( valueOfElement.nama == 'Yakiniku' && valueOfElement.kuantitas >= 2) {
                        postToCart(list_pesanan_modal);
                        status = true;
                    }else if (valueOfElement.nama == 'Shabu' && valueOfElement.kuantitas >= 2) {
                        postToCart(list_pesanan_modal);
                        status = true;
                    }else{
                        status = false;
                    }
                });

                alert(status);
                if (status == false) {
                    toastr_notice('error', 'Gagal',`Paket Tidak Memenuhi Minimal Pemesanan`);
                }
                
            }else{
              var totalHarga = 0;
              $.each(list_pesanan_modal, function (indexInArray, valueOfElement) {
                    totalHarga += parseInt(valueOfElement.harga) * parseInt(valueOfElement.kuantitas);
              });

              totalHarga > 3500000 ? postToCart(list_pesanan_modal) : toastr_notice('error', 'Gagal',`Total Pesanan Minimal Rp. 3,500,000,00`);

              console.log(totalHarga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            } 
        }else{
            toastr_notice('warning', 'Perhatian','Keranjang Kosong');
        }

        // End Filter Paket

        // Function Kirim Data ke Halaman Keranjang utama

        // End Function

        // $.each(list_pesanan_modal, function (indexInArray, valueOfElement) {

        //     if (valueOfElement.type == 'paket') {
        //         console.log(valueOfElement)
        //         console.log(valueOfElement.kuantitas);
        //         totalQty += parseInt(valueOfElement.kuantitas);
        //     }
        // });

        // if (totalQty != 0) {
        //     if (totalQty > 1) {
        //         $.ajax({
        //             url: url + '/keranjang/paket_pesanan',
        //             type: 'POST',
        //             data: {
        //                 'tampung': JSON.stringify(list_pesanan_modal),
        //                 '_token': token
        //             },
        //             success: function (response) {
        //                 window.location.href = url + '/keranjang';
        //             }
        //         })
        //     } else {
        //         Swal.fire({
        //             title: 'Gagal Diproses ke Keranjang !!',
        //             text: 'Kuantitas Pesanan untuk Menu Paket Utama harus lebih dari 2 pack',
        //             type: 'error'
        //         });
        //         list_pesanan_modal = [];
        //     }
        // } else {
        //     Swal.fire({
        //         title: 'Gagal Diproses ke Keranjang !!',
        //         text: 'Anda Belum Memilih Paket Utama',
        //         type: 'error'
        //     });
        //     list_pesanan_modal = [];
        // }


    })

    send_to_delivery = (data) => {
        if (data == 'Tidak ada session') {
            toastr_notice('error', 'Gagal','Belum Ada Pesanan');
        } else {
            $.ajax({
                url: url + '/keranjang/paket_to_delivery',
                type: 'POST',
                data: {
                    'data': JSON.stringify(data),
                    '_token': token
                },
                success: function (response) {
                    window.location.href = url + '/pengantaran';
                }
            })
        }
    }

    number = (elemen, type) => {
        var val = $(`#${elemen}`).val();
        if (type == 'add') {
            val++;
            $(`#${elemen}`).val(val);
        } else {
            val--;
            $(`#${elemen}`).val(val);
        }
    }

    toastr_notice = (type, message,title) => {
        Command: toastr[`${type}`](`${title}`,`${message}`);

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "1000",
            "hideDuration": "1000",
            "timeOut": "2000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }

    postToCart = (data) => {
        $.ajax({
            url: url + '/keranjang/paket_pesanan',
            type: 'POST',
            data: {
                'tampung': JSON.stringify(data),
                '_token': token
            },
            success: function (response) {
                window.location.href = url + '/keranjang';
            }
        })
    }

});