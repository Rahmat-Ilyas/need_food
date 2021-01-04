@extends('admin.layout')
@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Laporan Keuangan</h4>
                <ol class="breadcrumb">
                    <li>
                        <a href="#">Kesiniku</a>
                    </li>
                    <li>
                        <a href="#">Keuangan</a>
                    </li>
                    <li class="active">
                        Laporan Keuangan
                    </li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <h4 class="m-t-0 header-title"><b>Data Keuangan</b></h4>
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
                                <th>Tanggal</th>
                                <th>Uraian</th>
                                <th>Debit</th>
                                <th>Kredit</th>
                                <th>Uang Kas</th>
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
                data: { jenis: jenis, waktu: waktu },
                headers: headers,
                success: function (data) {
                    var tableDebitKredit = $('#tableDebitKredit').DataTable();
                    tableDebitKredit.clear().draw();
                    if (data.success == true) {
                        var no = 1;
                        var uang_kas = 0;
                        $.each(data.result, function (key, vl) {
                            var debit = 0;
                            var kredit = 0;
                            var dt = new Date(vl.tanggal);
                            var month = dt.getMonth()+1;
                            var date = dt.getDate();
                            if (month < 10) month = '0'+month;
                            if (dt.getDate() < 10) date = '0'+dt.getDate();

                            if (vl.jenis == 'Debit') {
                                debit = 'Rp. '+vl.nominal;
                                kredit = 0;
                                uang_kas = uang_kas + vl.nominal;
                            } else if (vl.jenis == 'Kredit') {
                                kredit = 'Rp. '+vl.nominal;
                                debit = 0;
                                uang_kas = uang_kas - vl.nominal;
                            }

                            if (jenis == 'Debit' || jenis == 'Kredit') uang_kas = 0;
                            tableDebitKredit.row.add([
                                no,
                                date+'/'+month+'/'+dt.getFullYear(),
                                vl.uraian,
                                debit,
                                kredit,
                                'Rp. '+uang_kas,
                                ]).draw(false);
                            no = no + 1;
                        });
                        tableDebitKredit.row.add([
                            '&nbsp;',
                            '&nbsp;',
                            '<div class="text-center"><b>Jumlah</b></div>',
                            '<b>Rp. '+data.data_kas.total_debit+'</b>',
                            '<b>Rp. '+data.data_kas.total_kredit+'</b>',
                            '<b>Rp. '+data.data_kas.uang_kas+'</b>',
                            ]).draw(false);
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

        $("#tableDebitKredit").DataTable({
            dom: "Bfrtip",
            buttons: [{
                extend: "copy",
                className: "btn-sm"
            }, {
                extend: "csv",
                className: "btn-sm"
            }, {
                extend: "excel",
                className: "btn-sm"
            }, {
                extend: "pdf",
                className: "btn-sm"
            }, {
                extend: "print",
                className: "btn-sm"
            }],
            responsive: !0
        })
    });
</script>
@endsection