@extends('admin.layout')
@section('content')')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title">Paket Menu</h4>
                    <ol class="breadcrumb">
                        <li>
                            <a href="#">NeedFood</a>
                        </li>
                        <li>
                            <a href="#">Kelola Menu</a>
                        </li>
                        <li class="active">
                            Paket Menu
                        </li>
                    </ol>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card-box">
                    <h4 class="header-title m-t-0"><b>Data Paket Menu</b></h4>
                    <button type="button" class="btn btn-default btn-rounded waves-effect waves-light m-t-10"
                        data-toggle="modal" data-target=".modal-add-paket"><i class="fa fa-plus-circle"></i> &nbsp;Tambah
                        Paket</button>
                    <div class="row m-t-20">
                        <div class="col-md-4">
                            <div class="price_card text-center">
                                <div class="pricing-header bg-primary">
                                    <span class="price">100K/pax</span>
                                    <span class="name">Paket Yakiniku</span>
                                </div>
                                <ul class="price-features">
                                    <li>Tasty Beef</li>
                                    <li>Low Fat Beef</li>
                                    <li>Sosis (250 gr)</li>
                                </ul>
                                <hr class="m-b-0">
                                <div class="row" style="padding: 0 10px 0 10px;">
                                    <div class="col-md-4 m-l-20" style="padding: 5px;">
                                        <button class="btn btn-block btn-inverse btn-sm waves-effect waves-light"
                                            data-toggle="modal" data-target=".modal-set-bahan"><i
                                                class="md-shopping-basket"></i> Set Bahan</button>
                                    </div>
                                    <div class="col-md-4" style="padding: 5px;">
                                        <button class="btn btn-block btn-purple btn-sm waves-effect waves-light"><i
                                                class="md-restaurant-menu"></i> Set Alat</button>
                                    </div>
                                    <div class="col-md-4" style="padding: 5px;">
                                        <button class="btn btn-block btn-info btn-sm waves-effect waves-light"><i
                                                class="fa fa-edit"></i> Edit</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="price_card text-center">
                                <div class="pricing-header bg-primary">
                                    <span class="price">100K/pax</span>
                                    <span class="name">Paket Shabu</span>
                                </div>
                                <ul class="price-features">
                                    <li>Suki</li>
                                    <li>Daging</li>
                                    <li>&nbsp;</li>
                                </ul>
                                <hr class="m-b-0">
                                <div class="row" style="padding: 0 10px 0 10px;">
                                    <div class="col-md-4 m-l-20" style="padding: 5px;">
                                        <button class="btn btn-block btn-inverse btn-sm waves-effect waves-light"><i
                                                class="md-shopping-basket"></i> Set Bahan</button>
                                    </div>
                                    <div class="col-md-4" style="padding: 5px;">
                                        <button class="btn btn-block btn-purple btn-sm waves-effect waves-light"><i
                                                class="md-restaurant-menu"></i> Set Alat</button>
                                    </div>
                                    <div class="col-md-4" style="padding: 5px;">
                                        <button class="btn btn-block btn-info btn-sm waves-effect waves-light"><i
                                                class="fa fa-edit"></i> Edit</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="price_card text-center">
                                <div class="pricing-header bg-primary">
                                    <span class="price">60K/pax</span>
                                    <span class="name">Paket Shabu 2</span>
                                </div>
                                <ul class="price-features">
                                    <li>Suki</li>
                                    <li>&nbsp;</li>
                                    <li>&nbsp;</li>
                                </ul>
                                <hr class="m-b-0">
                                <div class="row" style="padding: 0 10px 0 10px;">
                                    <div class="col-md-4 m-l-20" style="padding: 5px;">
                                        <button class="btn btn-block btn-inverse btn-sm waves-effect waves-light"><i
                                                class="md-shopping-basket"></i> Set Bahan</button>
                                    </div>
                                    <div class="col-md-4" style="padding: 5px;">
                                        <button class="btn btn-block btn-purple btn-sm waves-effect waves-light"><i
                                                class="md-restaurant-menu"></i> Set Alat</button>
                                    </div>
                                    <div class="col-md-4" style="padding: 5px;">
                                        <button class="btn btn-block btn-info btn-sm waves-effect waves-light"><i
                                                class="fa fa-edit"></i> Edit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Paket -->
    <div class="modal modal-add-paket" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myLargeModalLabel">Tambah Paket</h4>
                </div>
                <div class="modal-body" style="padding: 20px 50px 0 50px">
                    <form id="fromPaket" action="#">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Nama Paket</label>
                            <div class="col-sm-8">
                                <input type="text" class="nb-edt form-control" required="" autocomplete="off"
                                    placeholder="Nama Paket" name="nama">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Harga Paket</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" required="" autocomplete="off"
                                    placeholder="Harga Paket" name="harga">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Foto Paket</label>
                            <div class="col-sm-8 bootstrap-filestyle">
                                <input type="file" class="filestyle" data-placeholder="Belum ada foto" name="foto" id="foto"
                                    required="">
                                <div class="row text-info" id="viewProgress" hidden="">
                                    <span class="col-sm-5">Sedang mengapload foto... <b><i id="progress">0%</i></b></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Item Paket</label>
                            <div class="col-sm-8">
                                <select class="form-control select2 m-b-20" name="item[]" id="val-item" required="">
                                    <option value="">Pilih Bahan</option>
                                </select>
                                <div class="m-t-5" id="item">
                                </div>
                            </div>
                            <div class="col-sm-12 text-right">
                                <a href="#" class="btn btn-danger btn-sm" id="reset" style="display: none;"><i
                                        class="fa fa-refresh"></i> Reset Pilihan</a>
                                <a href="#" class="btn btn-default btn-sm" id="tambah-item"><i
                                        class="fa fa-plus-circle"></i> Tambah Item</a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Keterangan</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" required="" placeholder="Keterangan"
                                    name="keterangan"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-8">
                                <button type="submit" name="simpan" class="btn btn-default" id="upload">Simpan</button>
                                <button type="" class="btn btn-primary" id="batal" data-dismiss="modal"
                                    aria-hidden="true">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Set Alat -->

    <!-- Modal Set Bahan -->
    <div class="modal modal-set-bahan" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myLargeModalLabel">Set Bahan Paket</h4>
                </div>
                <div class="modal-body" style="padding: 20px 50px 0 50px;">
                    <div class="form-group row">
                        <form id="fromPaket" action="#">
                            <div class="col-sm-6">
                                <select class="form-control select2" name="item[]" id="val-set-item" required="">
                                    <option value="">Pilih Bahan</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <a href="#" class="btn btn-default"><i class="fa fa-plus-circle"></i> Tambah</a>
                            </div>
                        </form>
                    </div>
                    <hr class="m-t-0">
                    <h4>List Bahan</h4>
                    <form id="fromPaket" action="#">
                        <table class="table table-bordered m-0">
                            <thead>
                                <tr>
                                    <th style="width: 20px;">#</th>
                                    <th>Nama Bahan</th>
                                    <th style="width: 230px;">Atur Jumlah</th>
                                    <th style="width: 140px;">Jumlah Maksimal</th>
                                    <th style="width: 140px;">Bahan Utama</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td class="form-inline text-center">
                                        <input type="number" class="form-control" style="height: 30px; width: 60px;"
                                            name="">
                                        <span><b>pcs</b> /</span>
                                        <input type="number" class="form-control" style="height: 30px; width: 60px;" name=""
                                            value="1">
                                        <span><b>pax</b></span>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" style="height: 30px; width: 60px;" name=""
                                            value="1">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group row m-t-20">
                            <div class="col-sm-12">
                                <button type="submit" name="simpan" class="btn btn-default" id="upload">Atur</button>
                                <button type="" class="btn btn-primary" id="batal" data-dismiss="modal"
                                    aria-hidden="true">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->

    <div hidden="" id="content-item">
        <div class="m-b-5">
            <select class="form-control select2-add" name="item[]" id="val-item" required="">
                <option value="">Pilih Bahan</option>
            </select>
        </div>
    </div>

@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            var url = $('#configurl').val();
            var host = $('#host').val();

            var headers = {
                "Accept": "application/json",
                "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjA3YWE1Y2M3MDA1YTdjMDA2YzgwZWNjNjIxN2E4Y2VhOTUwMTEzMWNmM2MxOTVmMDk2YjJmZTAwY2I2MGI4ODAxNzE1ZGJmYjQ1YTYzMmIwIn0.eyJhdWQiOiIxIiwianRpIjoiMDdhYTVjYzcwMDVhN2MwMDZjODBlY2M2MjE3YThjZWE5NTAxMTMxY2YzYzE5NWYwOTZiMmZlMDBjYjYwYjg4MDE3MTVkYmZiNDVhNjMyYjAiLCJpYXQiOjE2MDA1MTI5NTEsIm5iZiI6MTYwMDUxMjk1MSwiZXhwIjoxNjMyMDQ4OTUwLCJzdWIiOiIxMyIsInNjb3BlcyI6W119.oHghL81Jc0xq-vvDVFde3QeqYs3s0Me6XukZtGy8G8HegV4LV2ImqKlpw_wdwxBOtKhBfodMFICi0YmNcPov7A",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }

            //GET BAHAN
            $.ajax({
                url: host + "/api/inventori/getbahan",
                method: "GET",
                headers: headers,
                success: function(data) {
                    $.each(data.result, function(key, val) {
                        $('#val-item').append('<option value="' + val.nama + '">' + val.nama +
                            '</option>');
                        $('#val-set-item').append('<option value="' + val.nama + '">' + val
                            .nama + '</option>');
                    });
                }
            });

            $('#tambah-item').click(function(e) {
                e.preventDefault();
                $('#reset').css('display', 'inline');
                if ($(this).hasClass('disabled')) return false;
                $(this).addClass('disabled');

                var content = $('#content-item').html();
                $('#item').append(content);
                $('#item .select2-add').select2();

                var data = $('#fromPaket').serialize();
                $.ajax({
                    url: host + "/configuration",
                    method: "POST",
                    headers: headers,
                    data: data + '&req=seleksibahanpaket',
                    success: function(data) {
                        $.each(data, function(key, val) {
                            $('#item').find('#val-item').last().append(
                                '<option value="' + val.nama + '">' + val.nama +
                                '</option>');
                        });
                    }
                });

            });

            $(document).on('click', '#reset', function() {
                $('#item').html('');
                $('#tambah-item').removeClass('disabled');
                $('#reset').css('display', 'none');
            });

            $(document).on('change', '#val-item', function() {
                $('#tambah-item').removeClass('disabled');
            });
        });

    </script>
@endsection
