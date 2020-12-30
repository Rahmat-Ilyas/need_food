@extends('admin.layout')
@section('content')')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Data Driver</h4>
                <ol class="breadcrumb">
                    <li>
                        <a href="#">Kesiniku</a>
                    </li>
                    <li class="active">
                        Data Driver
                    </li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <h4 class="m-t-0 header-title"><b>Data Driver</b></h4>
                    <button type="button" class="btn btn-default btn-rounded waves-effect waves-light m-t-10 m-b-20" data-toggle="modal" data-target=".modal-add"><i class="fa fa-plus-circle"></i> &nbsp;Tambah Driver</button>
                    <table id="tableDriver" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px;">No</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Username</th>
                                <th>Status</th>
                                <th style="width: 70px;">Aksi</th>
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

<!-- MODAL TAMBAH DRIVER-->
<div class="modal modal-add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Tambah Driver</h4>
            </div>
            <div class="modal-body" style="padding: 20px 50px 0 50px">
                <form id="fromDriver" action="#">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nama Driver</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" required="" autocomplete="off" placeholder="Nama Driver" name="nama">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" autocomplete="off" placeholder="Email" name="email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Telepon</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" required="" autocomplete="off" placeholder="Telepon" name="telepon">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Alamat</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" placeholder="Alamat" name="alamat"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Username</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control m-b-5" required="" autocomplete="off" placeholder="Username" name="username">
                            <span class="text-info"><i>Note: Password default <b>"driver_needfood"</b></i></span>
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
                <h4 class="modal-title" id="myLargeModalLabel">Edit Data Driver</h4>
            </div>
            <div class="modal-body" style="padding: 20px 50px 0 50px">
                <form id="fromEdtDriver" action="#">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nama Driver</label>
                        <div class="col-sm-8">
                            <input type="hidden" name="id" id="edt_id">
                            <input type="text" class="form-control" required="" autocomplete="off" placeholder="Nama Driver" name="nama" id="edt_nama">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" required="" autocomplete="off" placeholder="Email" name="email" id="edt_email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Telepon</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" required="" autocomplete="off" placeholder="Telepon" name="telepon" id="edt_telepon">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Alamat</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" placeholder="Alamat" name="alamat" id="edt_alamat"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Status</label>
                        <div class="col-sm-8">
                            <select name="status" class="form-control m-b-10" id="edt_status">
                                <option value="active">Active</option>
                                <option value="suspended">Suspended</option>
                            </select>
                            <a href="#" id="showhiden" style="font-size: 13px;"><i class="fa fa-user"></i> <span id="label">Update Akun Login</span></a>
                        </div>
                    </div>
                    <div id="update-login" hidden="">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Username</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" required="" autocomplete="off" placeholder="Username" name="username" id="edt_username">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" autocomplete="off" placeholder="Password" name="password">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <button type="submit" name="simpan" class="btn btn-default" id="upload">Update</button>
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
                <p>Yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer form-inline">
                <button type="button" class="btn btn-danger" id="delete-driver">Hapus</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL VIEW GAMBAR -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-gambar">
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

        //EDIT DRIVER
        $(document).on('click', '#edit-driver', function() {
            var id = $(this).attr('dta-id');
            $.ajax({
                url     : host+"/api/mobileauth/driver/"+id,
                method  : "GET",
                headers : headers,
                success : function(data) {
                    $('#fromEdtDriver')[0].reset();
                    $.each(data.result, function(key, val) {
                        $('#edt_'+key).val(val);
                    });
                }
            });
        });

        // VIEW GAMBAR DRIVER
        $(document).on('click', '#view-gambar-driver', function() {
            var id = $(this).attr('data-id');
            $('#setImage').attr('src', '');

            $.ajax({
                url     : host+"/api/mobileauth/driver/"+id,
                method  : "GET",
                headers : headers,
                success : function(data) {
                    $('#setImage').attr('src', host + '/assets/images/driver/' + data.result.foto);
                }
            });
        });

        //HAPUS DRIVER
        $(document).on('click', '#hapus-driver', function() {
            var id = $(this).attr('dta-id');

            $('#delete-driver').attr('dta-id', id);
        });

        // GET DRIVER
        $('#tableDriver').DataTable({
            processing: true,
            serverSide: true,
            ajax: host+'/datatable?req=dtDriver',
            columns: [
            { data: 'no', name: 'no' },
            { data: 'foto', name: 'foto', orderable: false, searchable: false },
            { data: 'nama', name: 'nama' },
            { data: 'alamat', name: 'alamat' },
            { data: 'email', name: 'email' },
            { data: 'telepon', name: 'telepon' },
            { data: 'username', name: 'username' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
        });

        $('#showhiden').click(function(e) {
            e.preventDefault();
            var view = $('#update-login').attr('hidden');
            if (view == 'hidden') {
                $('#update-login').removeAttr('hidden');
                $('#label').text('Batalkan Mengupdate');
            }
            else {
                $('#update-login').attr('hidden', '');
                $('#label').text('Update Akun Login');
            }
        });

        $(document).on('shown.bs.modal', function() {
            $('#update-login').attr('hidden', '');
            $('#label').text('Update Akun Login');
        });
    });
</script>
@endsection