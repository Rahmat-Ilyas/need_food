@extends('admin.layout')
@section('content')')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Set Kategori</h4>
                <ol class="breadcrumb">
                    <li>
                        <a href="#">NeedFood</a>
                    </li>
                    <li>
                        <a href="#">Inventori</a>
                    </li>
                    <li class="active">
                        Set Kategori
                    </li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <h4 class="m-t-0 header-title"><b>Data Kategori</b></h4>
                    <button type="button" class="btn btn-default btn-rounded waves-effect waves-light m-t-10 m-b-20" data-toggle="modal" data-target=".modal-add"><i class="fa fa-plus-circle"></i> &nbsp;Tambah Kategori</button>
                    <table id="tableKategori" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px;">No</th>
                                <th>Foto</th>
                                <th>Nama Kategori</th>
                                <th>Jenis Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> 
</div>

<!-- MODAL TAMBAH ALAT-->
<div class="modal modal-add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Tambah Kategori</h4>
            </div>
            <div class="modal-body" style="padding: 20px 50px 0 50px">
                <form id="fromKategori" action="#">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nama Kategori</label>
                        <div class="col-sm-8">
                            <input type="text" class="nb-edt form-control" required="" autocomplete="off" placeholder="Nama Kategori" name="kategori">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Jenis Kategori</label>
                        <div class="col-sm-8">
                            <select name="jenis" class="form-control">
                                <option>Kategori Alat</option>
                                <option>Kategori Bahan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Foto</label>
                        <div class="col-sm-8 bootstrap-filestyle">
                            <input type="file" class="filestyle" data-placeholder="Belum ada foto" name="foto" id="foto" required="">
                            <div class="row text-info" id="viewProgress" hidden="">
                                <span class="col-sm-12">Mengapload... <b><i id="progress">0%</i></b></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <button type="submit" name="simpan" class="btn btn-default" id="upload">Simpan</button>
                            <button type="" class="btn btn-primary" id="batal" data-dismiss="modal" aria-hidden="true">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT ALAT-->
<div class="modal modal-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Edit Kategori</h4>
            </div>
            <div class="modal-body" style="padding: 20px 50px 0 50px">
                <form id="fromEdtKategori" action="#">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nama Kategori</label>
                        <div class="col-sm-8">
                            <input type="hidden" name="id" id="edt_id">
                            <input type="text" class="nb-edt form-control" required="" autocomplete="off" placeholder="Nama Kategori" name="kategori" id="edt_namaKtgr">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Jenis Kategori</label>
                        <div class="col-sm-8">
                            <select name="jenis" class="form-control" id="edt_jenisKtgr">
                                <option>Kategori Alat</option>
                                <option>Kategori Bahan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Foto</label>
                        <div class="col-sm-8 bootstrap-filestyle">
                            <input type="file" name="foto" id="edt_foto">
                            <div class="row text-info" id="viewProgress" hidden="">
                                <span class="col-sm-12">Mengapload... <b><i id="progress">0%</i></b></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <button type="submit" name="simpan" class="btn btn-default" id="upload">Simpan</button>
                            <button type="" class="btn btn-primary" id="batal" data-dismiss="modal" aria-hidden="true">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL HAPUS -->
<div class="modal modal-delete" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticModalLabel">Hapus Data</h5>
            </div>
            <div class="modal-body">
                <p>Semua data Alat atau Bahan dengan kategori ini akan terhapus!</p>
            </div>
            <div class="modal-footer form-inline">
                <button type="button" class="btn btn-danger" id="delete-kategori">Hapus</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL VIEW GAMBAR -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-gambar-kategori">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content p-0 text-right">
            <div style="margin-right: -25px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
            </div>
            <div class="modal-body">
                <img id="setImage" src="" style="width: 100%;margin: -20px 0px -20px 0px;">
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
            "Accept"        : "application/json",
            "Authorization" : "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjA3YWE1Y2M3MDA1YTdjMDA2YzgwZWNjNjIxN2E4Y2VhOTUwMTEzMWNmM2MxOTVmMDk2YjJmZTAwY2I2MGI4ODAxNzE1ZGJmYjQ1YTYzMmIwIn0.eyJhdWQiOiIxIiwianRpIjoiMDdhYTVjYzcwMDVhN2MwMDZjODBlY2M2MjE3YThjZWE5NTAxMTMxY2YzYzE5NWYwOTZiMmZlMDBjYjYwYjg4MDE3MTVkYmZiNDVhNjMyYjAiLCJpYXQiOjE2MDA1MTI5NTEsIm5iZiI6MTYwMDUxMjk1MSwiZXhwIjoxNjMyMDQ4OTUwLCJzdWIiOiIxMyIsInNjb3BlcyI6W119.oHghL81Jc0xq-vvDVFde3QeqYs3s0Me6XukZtGy8G8HegV4LV2ImqKlpw_wdwxBOtKhBfodMFICi0YmNcPov7A",
            'X-CSRF-TOKEN'  : $('meta[name="csrf-token"]').attr('content')
        }

        //EDIT KATEGORI
        $(document).on('click', '#edit-kategori', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url     : host+"/api/inventori/getkategori/"+id,
                method  : "GET",
                headers : headers,
                success : function(data) {
                    $('#fromEdtKategori')[0].reset();
                    $('#edt_id').val(data.result.id);
                    $('#edt_namaKtgr').val(data.result.kategori);
                    $('#edt_jenisKtgr').val(data.result.jenis);
                    $('#edt_foto').filestyle({placeholder: data.result.foto, buttonText: 'Pilih Foto'});
                }
            });
        });

        // VIEW GAMBAR ALAT
        $(document).on('click', '#view-gambar-kategori', function() {
            var id = $(this).attr('data-id');
            $('#setImage').attr('src', '');

            $.ajax({
                url     : host+"/api/inventori/getkategori/"+id,
                method  : "GET",
                headers : headers,
                success : function(data) {
                    $('#setImage').attr('src', host + '/assets/images/kategori/' + data.result.foto);
                }
            });
        });

        //HAPUS KATEGORI
        $(document).on('click', '#hapus-kategori', function() {
            var id = $(this).attr('data-id');

            $('#delete-kategori').attr('data-id', id);
        });

        // GET KATEGORI
        $('#tableKategori').DataTable({
            processing: true,
            serverSide: true,
            ajax: host+'/datatable?req=dtKategori',
            columns: [
                { data: 'no', name: 'no' },
                { data: 'foto', name: 'foto', orderable: false, searchable: false },
                { data: 'kategori', name: 'kategori' },
                { data: 'jenis', name: 'jenis' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

    });
</script>
@endsection