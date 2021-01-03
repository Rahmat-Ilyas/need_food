@extends('admin.layout')
@section('content')')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Additional Daging</h4>
                <ol class="breadcrumb">
                    <li>
                        <a href="#">Kesiniku</a>
                    </li>
                    <li>
                        <a href="#">Kelola Menu</a>
                    </li>
                    <li class="active">
                        Additional Daging
                    </li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <h4 class="m-t-0 header-title"><b>Data Additional Daging</b></h4>
                    <button type="button" class="btn btn-default btn-rounded waves-effect waves-light m-t-10 m-b-20" data-toggle="modal" data-target=".modal-add"><i class="fa fa-plus-circle"></i> &nbsp;Tambah Additional</button>
                    <table id="dataTableAdditional" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Daging</th>
                                <th>Berat</th>
                                <th>Harga</th>
                                <th>Keterangan</th>
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

<!-- MODAL TAMBAH ADDITIONAL-->
<div class="modal modal-add" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
        style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Tambah Paket</h4>
            </div>
            <div class="modal-body" style="padding: 20px 50px 0 50px">
                <form id="fromAdditional" action="#">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nama Daging</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="bahan_id" id="daging" required="">
                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Berat Daging</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" required="" placeholder="Berat Daging" name="berat">
                        </div>
                        <div class="col-sm-2">
                            <input type="text" id="satuan" class="form-control" readonly="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Harga Additional</label>
                        <div class="input-group col-sm-8">
                            <span class="input-group-addon">Rp.</i></span>
                            <input type="number" class="form-control" required="" placeholder="Harga Additional"
                                name="harga">
                            <span class="input-group-addon">.00</span>
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

<!-- MODAL EDIT ADDITIONAL-->
<div class="modal modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
        style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Tambah Paket</h4>
            </div>
            <div class="modal-body" style="padding: 20px 50px 0 50px">
                <form id="fromEditAdditional" action="#">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nama Daging</label>
                        <div class="col-sm-8">
                            <input type="hidden" name="id" id="id">
                            <select class="form-control select2" name="bahan_id" id="daging_edt" required="">
                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Berat Daging</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" required="" placeholder="Berat Daging" name="berat" id="berat">
                        </div>
                        <div class="col-sm-2">
                            <input type="text" id="satuan_edt" class="form-control" readonly="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Harga Additional</label>
                        <div class="input-group col-sm-8">
                            <span class="input-group-addon">Rp.</i></span>
                            <input type="number" class="form-control" required="" placeholder="Harga Additional"
                                name="harga" id="harga">
                            <span class="input-group-addon">.00</span>
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
<!-- MODAL HAPUS ADDITIONAL -->
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
                <button type="button" class="btn btn-danger" id="delete-additional">Hapus</button>
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
            "Accept"        : "application/json",
            "Authorization" : "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjA3YWE1Y2M3MDA1YTdjMDA2YzgwZWNjNjIxN2E4Y2VhOTUwMTEzMWNmM2MxOTVmMDk2YjJmZTAwY2I2MGI4ODAxNzE1ZGJmYjQ1YTYzMmIwIn0.eyJhdWQiOiIxIiwianRpIjoiMDdhYTVjYzcwMDVhN2MwMDZjODBlY2M2MjE3YThjZWE5NTAxMTMxY2YzYzE5NWYwOTZiMmZlMDBjYjYwYjg4MDE3MTVkYmZiNDVhNjMyYjAiLCJpYXQiOjE2MDA1MTI5NTEsIm5iZiI6MTYwMDUxMjk1MSwiZXhwIjoxNjMyMDQ4OTUwLCJzdWIiOiIxMyIsInNjb3BlcyI6W119.oHghL81Jc0xq-vvDVFde3QeqYs3s0Me6XukZtGy8G8HegV4LV2ImqKlpw_wdwxBOtKhBfodMFICi0YmNcPov7A",
            'X-CSRF-TOKEN'  : $('meta[name="csrf-token"]').attr('content')
        }

        //GET BAHAN
        getDaging();
        function getDaging(this_adt = null) {
           $.ajax({
                url: host + "/configuration",
                method: "POST",
                headers: headers,
                data: { req: 'getDaging', this_adt: this_adt },
                success: function(data) {
                    $('#daging').html(data.result);
                    $('#daging_edt').html(data.result);
                }
            });
        }

        $('.modal').on('shown.bs.modal', function() {
            getDaging();
        });

        // SET SATUAN
        $('#daging, #daging_edt').change(function(e) {
            var bahan_id = $(this).val();
            $.ajax({
                url: host + "/configuration",
                method: "POST",
                headers: headers,
                data: { req: 'setSatuan', bahan_id: bahan_id },
                success: function(data) {
                    $('#satuan').val(data.result);
                    $('#satuan_edt').val(data.result);
                }
            });
        });

        $('#dataTableAdditional').DataTable({
            processing: true,
            serverSide: true,
            ajax: host+'/datatable?req=dtGetAdditional',
            columns: [
            { data: 'no', name: 'no' },
            { data: 'nama_daging', name: 'nama_daging' },
            { data: 'berat', name: 'berat' },
            { data: 'harga', name: 'harga' },
            { data: 'keterangan', name: 'keterangan' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        //EDIT DATA ALAT
        $(document).on('click', '#edit-additional', function() {
            var id = $(this).attr('dta-id');
            $.ajax({
                url     : host+"/configuration",
                method  : "POST",
                headers : headers,
                data    : { req: 'geteditadditional', id: id },
                success : function(data) {
                    getDaging(data.bahan_id);
                    $.each(data, function(key, val) {
                        $('#'+key).val(val);
                    });
                }
            });
        });

        //HAPUS DATA ALAT
        $(document).on('click', '#hapus-additional', function() {
            var id = $(this).attr('dta-id');
            $('#delete-additional').attr('data-id', id);
        });
    });
</script>
@endsection