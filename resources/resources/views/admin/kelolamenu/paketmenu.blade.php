@extends('admin.layout')
@section('content')')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title">Paket Menu</h4>
                    <ol class="breadcrumb">
                        <li>
                            <a href="#">Kesiniku</a>
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
                    <div class="row m-t-20" id="setPaket">
                        
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
                            <div class="input-group col-sm-8">
                                <span class="input-group-addon">Rp.</i></span>
                                <input type="number" class="form-control" required="" placeholder="Harga Paket"
                                    name="harga">
                                <span class="input-group-addon">.00</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Foto Paket</label>
                            <div class="col-sm-8 bootstrap-filestyle">
                                <input type="file" class="filestyle" data-placeholder="Belum ada foto" name="foto" id="foto"
                                    required="">
                                <div class="row text-info" id="viewProgress" hidden="">
                                    <span class="col-sm-12">Mengapload... <b><i id="progress">0%</i></b></span>
                                </div>
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
    <div class="modal modal-set-alat" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myLargeModalLabel">Set Alat Paket</h4>
                </div>
                <div class="modal-body" style="padding: 20px 50px 0 50px;">
                    <div class="form-group row">
                        <form id="addSetAlat" action="#">
                            <div class="col-sm-7">
                                <select class="form-control select2" name="alat_id" id="val-set-item1" required="">
                                    
                                </select>
                            </div>
                        </form>
                    </div>
                    <hr class="m-t-0">
                    <h4>List Alat</h4>
                    <form id="fromSetPaket1" action="#">
                        <table class="table table-bordered m-0">
                            <thead>
                                <tr>
                                    <th width="250">Nama Alat</th>
                                    <th style="width: 200px;">Atur Jumlah</th>
                                    <th style="width: 180px;">Jumlah Maksimal<i>(Isi jika ada)</i></th>
                                    <th style="width: 20px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="added1">
                                
                            </tbody>
                        </table>
                        <div class="form-group row m-t-20">
                            <div class="col-sm-12">
                                <input type="hidden" name="paket_id" id="paket_id1">
                                <button type="submit" name="simpan" class="btn btn-default">Atur</button>
                                <button type="" class="btn btn-primary" id="batal" data-dismiss="modal"
                                    aria-hidden="true">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                        <form id="addSetBahan" action="#">
                            <div class="col-sm-7">
                                <select class="form-control select2" name="bahan_id" id="val-set-item" required="">
                                    
                                </select>
                            </div>
                        </form>
                    </div>
                    <hr class="m-t-0">
                    <h4>List Bahan</h4>
                    <form id="fromSetPaket" action="#">
                        <table class="table table-bordered m-0">
                            <thead>
                                <tr>
                                    <th>Nama Bahan</th>
                                    <th style="width: 230px;">Atur Jumlah</th>
                                    <th style="width: 140px;">Jumlah Maksimal <i>(Isi jika ada)</i></th>
                                    <th style="width: 20px;">Bahan Utama</th>
                                    <th style="width: 20px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="added">
                                
                            </tbody>
                        </table>
                        <div class="form-group row m-t-20">
                            <div class="col-sm-12">
                                <input type="hidden" name="paket_id" id="paket_id">
                                <button type="submit" name="simpan" class="btn btn-default">Atur</button>
                                <button type="" class="btn btn-primary" id="batal" data-dismiss="modal"
                                    aria-hidden="true">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Paket-->
    <div class="modal modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myLargeModalLabel">Edit Paket</h4>
                </div>
                <div class="modal-body" style="padding: 20px 50px 0 50px">
                    <form id="fromEditPaket" action="#">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Nama Paket</label>
                            <div class="col-sm-8">
                                <input type="hidden" name="id" id="id">
                                <input type="text" class="form-control" required="" autocomplete="off"
                                    placeholder="Nama Paket" name="nama" id="nama">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Harga Paket</label>
                            <div class="input-group col-sm-8">
                                <span class="input-group-addon">Rp.</i></span>
                                <input type="number" class="form-control" required="" placeholder="Harga Paket"
                                    name="harga" id="harga">
                                <span class="input-group-addon">.00</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Foto Paket</label>
                            <div class="col-sm-8 bootstrap-filestyle">
                                <input type="file" name="foto" id="edt_foto">
                                <div class="row text-info" id="viewProgress" hidden="">
                                    <span class="col-sm-12">Mengapload... <b><i id="progress">0%</i></b></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Keterangan</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" required="" placeholder="Keterangan"
                                    name="keterangan" id="keterangan"></textarea>
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

    <!-- Modal Hapus Paket -->
    <div class="modal modal-hapus" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticModalLabel">Hapus Data</h5>
                </div>
                <div class="modal-body">
                    <p>Yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer form-inline">
                    <button type="button" class="btn btn-danger" id="delete-paket">Hapus</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                </div>
            </div>
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

            // GET PAKET
            getPaket();
            function getPaket() {
               $.ajax({
                    url: host + "/configuration",
                    method: "POST",
                    headers: headers,
                    data: { req: 'getPaket'},
                    success: function(data) {
                        $('#setPaket').html(data);
                    }
                });
            }

            //EDIT PAKET
            $(document).on('click', '#edit-paket', function(e) {
                e.preventDefault();

                var id = $(this).attr('data-id');
                $.ajax({
                    url     : host + "/configuration",
                    method  : "POST",
                    headers : headers,
                    data    : { req: 'geteditpaket', id: id },
                    success : function(data) {
                        $.each(data, function(key, val) {
                            if (key == 'foto') {
                                $('#edt_foto').filestyle({placeholder: val, buttonText: 'Pilih Foto'});
                            } else {
                                $('#'+key).val(val);
                            }
                        });
                    }
                });
            });

            //HAPUS PAKET
            $(document).on('click', '#hapus-paket', function() {
                var id = $(this).attr('data-id');
                $('#delete-paket').attr('data-id', id);
            });

            // SET ALAT DAN BAHAN
            getBahanExcept();
            function getBahanExcept() {
                var fromSetPaket = $('#fromSetPaket').serialize();
                $.ajax({
                    url: host + "/configuration",
                    method: "POST",
                    headers: headers,
                    data: fromSetPaket + '&req=getBahanExcept',
                    success: function(data) {
                        $('#val-set-item').html(data.result);
                    }
                });
            }

            getAlatExcept();
            function getAlatExcept() {
                var fromSetPaket = $('#fromSetPaket1').serialize();
                $.ajax({
                    url: host + "/configuration",
                    method: "POST",
                    headers: headers,
                    data: fromSetPaket + '&req=getAlatExcept',
                    success: function(data) {
                        $('#val-set-item1').html(data.result);
                    }
                });
            }

            $('#val-set-item').change(function(e) {
                e.preventDefault();
                var data = $('#addSetBahan').serialize();

                $.ajax({
                    url: host + "/configuration",
                    method: "POST",
                    headers: headers,
                    data: data + '&req=addSetBahan',
                    success: function(result) {
                        $('#empty').remove();
                        $('#added').append(result.added);
                        getBahanExcept();
                    }
                });
            });

            $('#val-set-item1').change(function(e) {
                e.preventDefault();
                var data = $('#addSetAlat').serialize();

                $.ajax({
                    url: host + "/configuration",
                    method: "POST",
                    headers: headers,
                    data: data + '&req=addSetAlat',
                    success: function(result) {
                        $('#empty1').remove();
                        $('#added1').append(result.added);
                        getAlatExcept();
                    }
                });
            });

            $(document).on('click', '#set-bahan', function() {
               var id = $(this).attr('data-id');
               $('#paket_id').val(id);
               
               $.ajax({
                    url: host + "/configuration",
                    method: "POST",
                    headers: headers,
                    data: { paket_id: id, req: 'setBahanClick' },
                    success: function(result) {
                        $('#added').html(result.added);
                        getBahanExcept();
                    }
                });
            });

            $(document).on('click', '#set-alat', function() {
               var id = $(this).attr('data-id');
               $('#paket_id1').val(id);
               
               $.ajax({
                    url: host + "/configuration",
                    method: "POST",
                    headers: headers,
                    data: { paket_id: id, req: 'setAlatClick' },
                    success: function(result) {
                        $('#added1').html(result.added);
                        getAlatExcept();
                    }
                });
            });

            $(document).on('click', '#remove-bahan', function(e) {
                e.preventDefault();
                $(this).parents('#this-form-added').remove();
                var fromSetPaket = $('#fromSetPaket').serialize();
                $.ajax({
                    url: host + "/configuration",
                    method: "POST",
                    headers: headers,
                    data: fromSetPaket + '&req=ifEmptyBahan',
                    success: function(data) {
                        if (data == 'empty') {
                            $('#added').html('<tr class="text-center" id="empty"><td colspan="5"><i>Beluam ada data yang ditambah</i></td></tr>');
                        }
                    }
                });
            });

            $(document).on('click', '#remove-alat', function(e) {
                e.preventDefault();
                $(this).parents('#this-form-added1').remove();
                var fromSetPaket = $('#fromSetPaket1').serialize();
                $.ajax({
                    url: host + "/configuration",
                    method: "POST",
                    headers: headers,
                    data: fromSetPaket + '&req=ifEmptyAlat',
                    success: function(data) {
                        if (data == 'empty') {
                            $('#added1').html('<tr class="text-center" id="empty1"><td colspan="4"><i>Beluam ada data yang ditambah</i></td></tr>');
                        }
                    }
                });
            });

            $('#fromSetPaket').submit(function(e) {
                e.preventDefault();

                var fromSetPaket = $('#fromSetPaket').serialize();
                $.ajax({
                    url: host + "/configuration",
                    method: "POST",
                    headers: headers,
                    data: fromSetPaket + '&req=setBahanPaket',
                    success: function(data) {
                        getPaket();
                        $('.modal').modal('hide');
                        $.Notification.notify(data.status,'top right', data.title, data.message);
                    }
                });
            });

            $('#fromSetPaket1').submit(function(e) {
                e.preventDefault();

                var fromSetPaket = $('#fromSetPaket1').serialize();
                $.ajax({
                    url: host + "/configuration",
                    method: "POST",
                    headers: headers,
                    data: fromSetPaket + '&req=setAlatPaket',
                    success: function(data) {
                        getPaket();
                        $('.modal').modal('hide');
                        $.Notification.notify(data.status,'top right', data.title, data.message);
                    }
                });
            });

        });

    </script>
@endsection
