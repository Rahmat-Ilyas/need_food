@extends('admin.layout')
@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Kelola Debit-Kredit</h4>
                <ol class="breadcrumb">
                    <li>
                        <a href="#">Kesiniku</a>
                    </li>
                    <li>
                        <a href="#">Keuangan</a>
                    </li>
                    <li class="active">
                        Kelola Debit-Kredit
                    </li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <h4 class="m-t-0 header-title"><b>Tambah Debit/Kredit</b></h4>
                    <form role="form" class="m-t-20" id="formAddKeuangan">
                        <div class="row">                            
                            <div class="form-group col-md-5">
                                <label>Uraian</label>
                                <input type="text" class="form-control" placeholder="Input Uraian..." name="uraian" required="" autocomplete="off">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputPassword1">Nominal</label>
                                <div class="input-group">
                                    <span class="input-group-addon">Rp.</i></span>
                                    <input type="number" class="form-control" placeholder="Input Nominal..." name="nominal" required="">
                                    <span class="input-group-addon">.00</span>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Jenis</label>
                                <select class="form-control" name="jenis" required="">
                                    <option value="">--Pilih Jenis--</option>
                                    <option value="Debit">Debit</option>
                                    <option value="Kredit">Kredit</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}" required="">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary waves-effect waves-light"><i class="fa fa-save"></i> Simpan Uraian</button>
                    </form>

                    <hr>

                    <h4 class="m-t-0 header-title"><b>Data Debit/Kredit</b></h4>
                    <div class="row m-t-20">                            
                        <div class="form-group col-md-3" style="border-right: 1px solid; height: 65px;">
                            <h4 class="m-t-20"><b><i>Tampilkan Data Bersasarkan:</i></b></h4>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Jenis</label>
                            <select class="form-control" name="jenis" id="jenis">
                                <option value="All">Semua</option>
                                <option value="Debit">Debit</option>
                                <option value="Kredit">Kredit</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Rentang Waktu</label>
                            <select class="form-control" id="rentang-waktu">
                                <option value="tahun">/Tahun</option>
                                <option value="bulan">/Bulan</option>
                                <option value="hari">/Hari</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2" id="waktu">
                            <label>Tahun</label>
                            <select class="form-control waktu" id="year" name="waktu">
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary waves-effect waves-light" style="margin-top: 28px;" id="view-data"><i class="fa fa-search"></i> Tampilkan Data</button>
                        </div>
                    </div>
                    <table class="table table-bordered" id="tableDebitKredit">
                        <thead>
                            <tr>
                                <th width="20">No</th>
                                <th>Uraian</th>
                                <th>Nominal</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="alat-hilang">

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" class="text-center">Total Debit</th>
                                <td colspan="4" id="total_debit" class="text-center"></td>
                            </tr>
                            <tr>
                                <th colspan="2" class="text-center">Total Kredit</th>
                                <td colspan="4" id="total_kredit" class="text-center"></td>
                            </tr>
                            <tr>
                                <th colspan="2" class="text-center">Uang Kas</th>
                                <td colspan="4" id="uang_kas" class="text-center"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div> 
    </div>
</div>

<!-- MODAL EDIT KEUANGAN-->
<div class="modal modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Tambah Paket</h4>
            </div>
            <div class="modal-body" style="padding: 20px 50px 0 50px">
                <form id="fromEditKeuangan" action="#">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Uraian</label>
                        <div class="col-sm-8">
                            <input type="hidden" name="id" id="edt_id">
                            <input type="text" class="form-control" name="uraian" id="edt_uraian" required="" placeholder="Uraian..." autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nominal</label>
                        <div class="input-group col-sm-8">
                            <span class="input-group-addon">Rp.</i></span>
                            <input type="number" class="form-control" name="nominal" id="edt_nominal" required="" placeholder="Nominal..."
                            name="harga" id="harga">
                            <span class="input-group-addon">.00</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Jenis</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="jenis" id="edt_jenis">
                                <option value="Debit">Debit</option>
                                <option value="Kredit">Kredit</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Tanggal</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" name="tanggal" id="edt_tanggal" required="">
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
<!-- MODAL HAPUS KEUANGAN -->
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
                <button type="button" class="btn btn-danger" id="delete-keuangan">Hapus</button>
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

        function setError(data) {
            var error = '';
            result = data.responseJSON.message;
            if (jQuery.type(result) == 'object') {
                $.each(result, function (key, val) {
                    error = error + ' ' + val[0];
                });
            } else {
                error = data.responseJSON.message;
            }

            Swal.fire({
             title: 'Gagal Diproses',
             text: error,
             type: 'error'
         });
        }

        getyear();
        function getyear() {
            $.ajax({
                url     : host+"/configuration",
                method  : "POST",
                headers : headers,
                data    : { req: 'getyears' },
                success : function(data) {
                    $(document).find('#year').html(data);
                }
            });
        }

        $('#rentang-waktu').change(function() {
            var value = $(this).val();
            if (value == 'tahun') {
                $('#waktu').html(`<label>Tahun</label>
                    <select class="form-control waktu" id="year" name="waktu">
                    </select>`);
                getyear();
            } else if (value == 'bulan') {
                $('#waktu').html(`<label>Bulan</label>
                    <input type="month" class="form-control waktu" name="waktu" value="{{ date('Y-m') }}">`);
            } else if (value == 'hari') {
                $('#waktu').html(`<label>Tanggal</label>
                    <input type="date" class="form-control waktu" name="waktu" value="{{ date('Y-m-d') }}">`);
            }
        });

        getData('All', {{ date('Y') }});
        function getData(jenis, waktu) {
            $.ajax({
                url: host + "/api/keuangan/getdata",
                method: "GET",
                data: { jenis: jenis, waktu: waktu, order: 'desc' },
                headers: headers,
                success: function (data) {
                    var tableDebitKredit = $('#tableDebitKredit').DataTable();
                    tableDebitKredit.clear().draw();
                    if (data.success == true) {
                        $.each(data.data_kas, function (key, vl) {
                            $('#'+key).text('Rp. '+vl);
                        });

                        var no = 1;
                        $.each(data.result, function (key, vl) {
                            var dt = new Date(vl.tanggal);
                            var month = dt.getMonth()+1;
                            var date = dt.getDate();
                            if (month < 10) month = '0'+month;
                            if (dt.getDate() < 10) date = '0'+dt.getDate();
                            tableDebitKredit.row.add([
                                no,
                                vl.uraian,
                                'Rp. '+vl.nominal,
                                vl.jenis,
                                date+'/'+month+'/'+dt.getFullYear(),
                                `<td class="text-center">
                                <a href="#" role="button" class="btn btn-primary btn-sm waves-effect waves-light" id="edit-keuangan" dta-id="`+vl.id+`" data-toggle1="tooltip" title="Edit" data-toggle="modal" data-target=".modal-edit"><i class="fa fa-edit"></i> Edit</a>
                                <a href="#" role="button" class="btn btn-danger btn-sm waves-effect waves-light" id="hapus-keuangan" dta-id="`+vl.id+`" data-toggle1="tooltip" title="Hapus" data-toggle="modal" data-target=".modal-delete"><i class="fa fa-trash"></i> Hapus</a>
                                </td>`
                                ]).draw(false);
                            no = no + 1;
                        });
                    } else {
                        $('#uang_kas').text('Rp. 0');
                        $('#total_debit').text('Rp. 0');
                        $('#total_kredit').text('Rp. 0');
                    }
                }
            });
        }

        $('#view-data').click(function(e) {
            e.preventDefault();
            var jenis = $('#jenis').val();
            var waktu = $('.waktu').val();
            getData(jenis, waktu);
        });

        // ADD KEUANGAN
        $('#formAddKeuangan').submit(function (ev) {
            ev.preventDefault();
            var data = $(this).serialize();

            $.ajax({
                url: host + "/api/keuangan/create",
                method: "POST",
                data: data,
                headers: headers,
                success: function (data) {
                    $('#formAddKeuangan')[0].reset();
                    getData('All', {{ date('Y') }});

                    Swal.fire({
                        title: 'Berhasil Diproses',
                        text: 'Data keuangan baru berhasil ditambah',
                        type: 'success'
                    });
                },
                error: function (data) {
                    setError(data);
                }
            });
        });

        //EDIT KEUANGAN
        $(document).on('click', '#edit-keuangan', function() {
            var id = $(this).attr('dta-id');
            $.ajax({
                url     : host+"/api/keuangan/getdata/"+id,
                method  : "GET",
                headers : headers,
                success : function(data) {
                    var dt = new Date(data.result.tanggal);
                    var month = dt.getMonth()+1;
                    var date = dt.getDate();
                    if (month < 10) month = '0'+month;
                    if (dt.getDate() < 10) date = '0'+dt.getDate();
                    data.result.tanggal = dt.getFullYear()+'-'+month+'-'+date;
                    $.each(data.result, function(key, val) {
                        $('#edt_'+key).val(val);
                    });
                }
            });
        });

        $('#fromEditKeuangan').submit(function (ev) {
            ev.preventDefault();
            var data = $(this).serialize();
            var id = $('#edt_id').val();

            $.ajax({
                url: host + "/api/keuangan/edit/"+id,
                method: "PUT",
                data: data,
                headers: headers,
                success: function (data) {
                    $('#fromEditKeuangan')[0].reset();
                    getData('All', {{ date('Y') }});

                    Swal.fire({
                        title: 'Berhasil Diproses',
                        text: 'Data berhasil diupdate',
                        type: 'success',
                        onClose: () => {
                            $('.modal-edit').modal('hide');
                        }
                    });
                },
                error: function (data) {
                    setError(data);
                }
            });
        });

        // DELETE KEUANGAN
        $(document).on('click', '#hapus-keuangan', function() {
            var id = $(this).attr('dta-id');
            $('#delete-keuangan').attr('data-id', id);
        });

        $('#delete-keuangan').click(function () {
            var id = $(this).attr('data-id');

            $.ajax({
                url: host + "/api/keuangan/delete/"+id,
                method: "DELETE",
                headers: headers,
                success: function (data) {
                    getData('All', {{ date('Y') }});

                    Swal.fire({
                        title: 'Berhasil Diproses',
                        text: 'Data berhasil dihapus',
                        type: 'success',
                        onClose: () => {
                            $('.modal').modal('hide');
                        }
                    });
                },
                error: function (data) {
                    setError(data);
                }
            });
        });
    });
</script>
@endsection