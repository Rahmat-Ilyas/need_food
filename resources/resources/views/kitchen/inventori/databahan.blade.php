@extends('kitchen.layout')
@section('content')')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Data Bahan</h4>
                <ol class="breadcrumb">
                    <li>
                        <a href="#">Kesiniku</a>
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
                    <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light m-t-10 m-b-20" data-toggle="modal" data-target=".modal-add-stok"><i class="fa fa-shopping-basket"></i> &nbsp;Tambah Stok</button>
                    <table id="dataTableBahan" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Kode Bahan</th>
                                <th>Nama Bahan</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th style="width: 120px;" class="text-center">Aksi</th>
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

<!-- MODAL TAMBAH BAHAN-->
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
                            <select name="kategori_id" id="kategori" class="form-control">

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jumlah Beli</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" required="" placeholder="Jumlah Beli" name="jumlah_bahan" id="jumlah_bahan">
                        </div>
                        <div class="col-sm-2">
                            <select name="satuan" id="satuan" class="form-control">
                                <option value="pcs">Pieces (pcs)</option>
                                <option value="g">Gram (g)</option>
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

<!-- MODAL TAMBAH STOK-->
<div class="modal modal-add-stok" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Tambah Stok Bahan</h4>
            </div>
            <div class="modal-body" style="padding: 20px 50px 0 50px">
                <form id="fromStokBahan" action="#" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Bahan</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" name="bahan_id" id="nama_bahan" required="">
                                <option value="">Pilih Bahan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jumlah Beli</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" required="" placeholder="Jumlah Beli" name="jumlah_beli">
                        </div>
                        <div class="col-sm-2">
                            <input type="text" id="satuan_" class="form-control" readonly="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Total Harga Beli</label>
                        <div class="input-group col-sm-9">
                            <span class="input-group-addon">Rp.</i></span>
                            <input type="number" class="form-control" required="" placeholder="Total Harga" name="total_harga">
                            <span class="input-group-addon">.00</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Supplier</label>
                        <div class="col-sm-9">
                            <select name="supplier_id" id="supplier_" class="form-control">

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-default">Simpan</button>
                            <button type="" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT BAHAN-->
<div class="modal modal-edit-bahan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Tambah Inventori Bahan</h4>
            </div>
            <div class="modal-body" style="padding: 20px 50px 0 50px">
                <form id="fromEditBahan" action="#" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kode Bahan</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="id" id="edt_id">
                            <input type="text" class="nb-edt form-control" autocomplete="off" placeholder="Kode Bahan" name="kd_bahan" id="edt_kd_bahan" readonly="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Bahan</label>
                        <div class="col-sm-9">
                            <input type="text" class="nb-edt form-control" required="" autocomplete="off" placeholder="Nama Bahan" name="nama" id="edt_nama_bahan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Foto</label>
                        <div class="col-sm-9 bootstrap-filestyle">
                            <input type="file" name="foto" id="edt_foto">
                            <div class="row text-info" id="viewProgress" hidden="">
                                <span class="col-sm-5">Sedang mengapload foto... <b><i id="progress">0%</i></b></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Kategori</label>
                        <div class="col-sm-9">
                            <select name="kategori_id" id="edt_kategori" class="form-control">

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Satuan (Ukuran)</label>
                        <div class="col-sm-9">
                            <select name="satuan" id="edt_satuan" class="form-control">
                                <option value="pcs">Pieces (pcs)</option>
                                <option value="g">Gram (g)</option>
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

<!-- MODAL DETAIL -->
<div class="modal detail-bahan" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Detail Bahan</h4>
            </div>
            <div class="modal-body" style="padding: 20px 40px 20px 40px">
                <dl class="row mb-0">
                    <div class="col-sm-6 row">
                        <dt class="col-sm-5">Kode Bahan:</dt>
                        <dd class="col-sm-7" id="dtl_kd_bahan"></dd> 
                    </div>
                    <div class="col-sm-6 row">
                        <dt class="col-sm-5">Jumlah Bahan:</dt>
                        <dd class="col-sm-7"><span id="dtl_jumlah_bahan"></span> <span id="dtl_satuan"></span></dd>
                    </div>
                    <div class="col-sm-6 row">
                        <dt class="col-sm-5">Nama Bahan:</dt>
                        <dd class="col-sm-7" id="dtl_nama"></dd>
                    </div>
                    <div class="col-sm-6 row">
                        <dt class="col-sm-5">Kategori:</dt>
                        <dd class="col-sm-7" id="dtl_kategori"></dd>
                    </div>
                </dl>
                <hr>
                <div class="panel-group" id="accordion-test-2"> 
                    <div class="panel panel-default"> 
                        <div class="panel-heading"> 
                            <h4 class="panel-title"> 
                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapseOne-2" aria-expanded="false" class="collapsed">
                                    Riwayat Pembelian Bahan
                                </a> 
                            </h4> 
                        </div> 
                        <div id="collapseOne-2" class="panel-collapse collapse"> 
                            <div class="panel-body">
                                <table class="table table-bordered" id="tableDetail" style="margin-top: -15px; font-size: 13px;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>KD Pembelian</th>
                                            <th>Tggl Pembelian</th>
                                            <th>Jumlah Beli</th>
                                            <th>Total Harga</th>
                                            <th>Supplier</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="riwayat-beli">

                                    </tbody>
                                </table>
                            </div> 
                        </div> 
                    </div>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Tutup</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
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
                <button type="button" class="btn btn-danger" id="delete-bahan">Hapus</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL VIEW GAMBAR -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-gambar-bahan">
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

        //GET KATEGORI
        $.ajax({
            url     : host+"/api/inventori/getkategori",
            method  : "GET",
            headers : headers,
            data    : { kategori: 'bahan' },
            success : function(data) {
                $.each(data.result, function(key, val) {
                    $('#kategori').append('<option value="'+ val.id +'">' + val.kategori + '</option>');
                    $('#edt_kategori').append('<option value="'+ val.id +'">' + val.kategori + '</option>');
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

        //GET BAHAN
        getDataBahan();
        function getDataBahan() {
            $('#nama_bahan').html('<option value="">Pilih Bahan</option>');
            $.ajax({
                url     : host+"/api/inventori/getbahan",
                method  : "GET",
                headers : headers,
                success : function(data) {
                    $.each(data.result, function(key, val) {
                        $('#nama_bahan').append('<option value="'+ val.id +'">'+ val.kd_bahan +'/'+ val.nama +'</option>');
                    });
                }
            });
        }

        $('.modal-add-stok').on('shown.bs.modal', function() {
            getDataBahan();
        });

        // SET SATUAN 
        $('#nama_bahan').change(function() {
            var id = $(this).val();
            $.ajax({
                url     : host+"/api/inventori/getbahan/"+id,
                method  : "GET",
                headers : headers,
                success : function(data) {
                    $('#satuan_').val(data.result.satuan);
                }
            });
        });

        // GET BAHAN
        $('#dataTableBahan').DataTable({
            processing: true,
            serverSide: true,
            ajax: host+'/datatable?req=dtGetBahan',
            columns: [
            { data: 'no', name: 'no' },
            { data: 'foto', name: 'foto', orderable: false, searchable: false },
            { data: 'kd_bahan', name: 'kd_bahan' },
            { data: 'nama', name: 'nama' },
            { data: 'kategori', name: 'kategori' },
            { data: 'jumlah_bahan', name: 'jumlah_bahan' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        //EDIT DATA ALAT
        $(document).on('click', '#edit-bahan', function() {
            var id = $(this).attr('dta-id');
            $.ajax({
                url     : host+"/configuration",
                method  : "POST",
                headers : headers,
                data    : { req: 'geteditbahan', id: id },
                success : function(data) {
                    $('#edt_id').val(data.id);
                    $('#edt_kd_bahan').val(data.kd_bahan);
                    $('#edt_nama_bahan').val(data.nama);
                    $('#edt_foto').filestyle({placeholder: data.foto, buttonText: 'Pilih Foto'});
                    $('#edt_kategori').val(data.kategori_id);
                    $('#edt_satuan').val(data.satuan);
                }
            });
        });

        //HAPUS DATA BAHAN
        $(document).on('click', '#hapus-bahan', function() {
            var id = $(this).attr('dta-id');
            $('#delete-bahan').attr('data-id', id);
        });

        // Detail Supplier
        $(document).on('click', '#detail-supplier', function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            $.ajax({
                url     : host+"/configuration",
                method  : "POST",
                headers : headers,
                data    : { req: 'detailsupplier', id: id },
                success : function(data) {
                    swal({
                        title: "Detail Supplier",
                        html: data,
                    });
                }
            });
        });
    });
</script>
@endsection