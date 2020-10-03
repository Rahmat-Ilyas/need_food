@extends('admin.layout')
@section('content')')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Data Bahan</h4>
                <ol class="breadcrumb">
                    <li>
                        <a href="#">NeedFood</a>
                    </li>
                    <li>
                        <a href="#">Inventori</a>
                    </li>
                    <li class="active">
                        Data Bahan
                    </li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <h4 class="m-t-0 header-title"><b>Data Inventori Bahan</b></h4>
                    <button type="button" class="btn btn-default btn-rounded waves-effect waves-light m-t-10 m-b-20" data-toggle="modal" data-target=".modal-add-bahan"><i class="fa fa-plus-circle"></i> &nbsp;Bahan Baru</button>
                    <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light m-t-10 m-b-20"><i class="fa fa-shopping-basket"></i> &nbsp;Tambah Stok</button>
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Kode Bahan</th>
                                <th>Nama Bahan</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td style="width: 10px;">1</td>
                                <td>
                                    <img src="{{ asset('assets/images/small/img4.jpg') }}" alt="image" class="img-responsive thumb-md">
                                </td>
                                <td>NFB-0001</td>
                                <td>System Architect</td>
                                <td>Bumbu</td>
                                <td>1/1pax</td>
                                <td style="width: 150px;" class="text-center">
                                    <button type="button" class="btn btn-info btn-sm waves-effect waves-light" data-toggle1="tooltip" title="Detail" data-toggle="modal" data-target=".detail-barang"><i class="fa fa-eye"></i></button>
                                    <button type="button" class="btn btn-success btn-sm waves-effect waves-light" data-toggle1="tooltip" title="Edit" data-toggle="modal" data-target=".detail-barang"><i class="fa fa-edit"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-toggle1="tooltip" title="Hapus" data-toggle="modal" data-target=".detail-barang"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 10px;">2</td>
                                <td>
                                    <img src="{{ asset('assets/images/small/img4.jpg') }}" alt="image" class="img-responsive thumb-md">
                                </td>
                                <td>NFB-0002</td>
                                <td>Kuah</td>
                                <td>Kuah Kacang</td>
                                <td>1/5pax</td>
                                <td style="width: 150px;" class="text-center">
                                    <button type="button" class="btn btn-info btn-sm waves-effect waves-light"><i class="fa fa-eye"></i></button>
                                    <button type="button" class="btn btn-success btn-sm waves-effect waves-light"><i class="fa fa-edit"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm waves-effect waves-light"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> 
</div>

<!-- MODAL TAMBAH ALAT-->
<div class="modal modal-add-bahan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Tambah Inventori Bahan</h4>
            </div>
            <div class="modal-body" style="padding: 20px 50px 0 50px">
                <form id="fromBahan" action="#" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Bahan</label>
                        <div class="col-sm-9">
                            <input type="text" class="nb-edt form-control" required="" autocomplete="off" placeholder="Nama Bahan" name="nama" id="nama">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Foto</label>
                        <div class="col-sm-9 bootstrap-filestyle">
                            <input type="file" class="filestyle" data-placeholder="Belum ada foto" name="foto" id="foto" required="">
                            <div class="row text-info" id="viewProgress" hidden="">
                                <span class="col-sm-5">Sedang mengapload foto... <b><i id="progress">0%</i></b></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Kategori</label>
                        <div class="col-sm-9">
                            <select name="kategori" id="kategori" class="form-control">
                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jumlah Beli</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" required="" placeholder="Jumlah Beli" name="jumlah_alat" id="jumlah_alat">
                        </div>
                        <div class="col-sm-2">
                            <select name="kategori" id="kategori" class="form-control">
                                <option>Pieces (pcs)</option>
                                <option>Kilogram (kg)</option>
                                <option>Gram (g)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Total Harga Beli</label>
                        <div class="input-group col-sm-9">
                            <span class="input-group-addon">Rp.</i></span>
                            <input type="number" class="form-control" required="" placeholder="Total Harga" name="total_harga" id="total_harga">
                            <span class="input-group-addon">.00</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Supplier</label>
                        <div class="col-sm-9">
                            <select name="supplier_id" id="supplier" class="form-control">

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9">
                            <button type="submit" name="simpanBahan" class="btn btn-default" id="upload">Simpan</button>
                            <button type="" class="btn btn-primary" id="batal" data-dismiss="modal" aria-hidden="true">Batal</button>
                        </div>
                    </div>
                </form>
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
        }

        //GET KATEGORI
        $.ajax({
            url     : host+"/api/inventori/getkategori",
            method  : "GET",
            headers : headers,
            data    : { kategori: 'bahan' },
            success : function(data) {
                $.each(data.result, function(key, val) {
                    $('#kategori').append('<option>' + val.kategori + '</option>');
                });
            }
        });

        //GET SUPPLIER
        $.ajax({
            url     : host+"/api/getsupplier",
            method  : "GET",
            headers : headers,
            data    : { kategori: 'bahan' },
            success : function(data) {
                $.each(data.result, function(key, val) {
                    $('#supplier').append('<option value="' + val.id + '">' + val.nama_supplier + '</option>');
                    $('#supplier_').append('<option value="' + val.id + '">' + val.nama_supplier + '</option>');
                });
            }
        });

        //GET ALAT
        $.ajax({
            url     : host+"/api/inventori/getalat",
            method  : "GET",
            headers : headers,
            success : function(data) {
                $.each(data.result, function(key, val) {
                    $('#nama_alat').append('<option value="'+ val.id +'">'+ val.kd_alat +'/'+ val.nama +'</option>');
                });
            }
        });
    });
</script>
@endsection