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
                            <div class="col-sm-6">
                                <select class="form-control select2" name="bahan_id" id="val-set-item" required="">
                                    <option value="">Pilih Bahan</option>
                                </select>
                            </div>
                            <div id="set-exits">
                            </div>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-default"><i class="fa fa-plus-circle"></i>
                                    Tambah</button>
                            </div>
                        </form>
                    </div>
                    <hr class="m-t-0">
                    <h4>List Bahan</h4>
                    <form id="fromPaket" action="#">
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
                                <tr class="text-center" id="empty">
                                    <td colspan="5"><i>Beluam ada data yang ditambah</i></td>
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

            getBahanExcept();
            function getBahanExcept(exceptId = null) {
                $.ajax({
                    url: host + "/configuration",
                    method: "POST",
                    headers: headers,
                    data: exceptId + '&req=getBahanExcept',
                    success: function(data) {
                        $.each(data.result, function(key, val) {
                            $('#val-set-item').append('<option value="' + val.id + '">' + val
                                .nama +
                                '</option>');
                        });

                        console.log(data.request);
                    }
                });
            }

            $('#addSetBahan').submit(function(e) {
                e.preventDefault();
                var data = $(this).serialize();

                $.ajax({
                    url: host + "/configuration",
                    method: "POST",
                    headers: headers,
                    data: data + '&req=addSetBahan',
                    success: function(result) {
                        $('#added').append(result.added);
                        $('#empty').attr('hidden', '');
                        getBahanExcept(data);
                    }
                });
            });

            $(document).on('click', '#set-bahan', function() {
               var id = $(this).attr('data-id');
               
               $.ajax({
                    url: host + "/configuration",
                    method: "POST",
                    headers: headers,
                    data: { paket_id: id, req: 'setAlatClick' },
                    success: function(result) {
                        $('#added').append(result.added);
                        $('#empty').attr('hidden', '');
                        getBahanExcept(data);
                    }
                });
            });
        });

    </script>
@endsection
