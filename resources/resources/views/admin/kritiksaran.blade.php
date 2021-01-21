@extends('admin.layout')
@section('content')')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Kritik & Saran</h4>
                <ol class="breadcrumb">
                    <li>
                        <a href="#">Kesiniku</a>
                    </li>
                    <li class="active">
                        Kritik & Saran
                    </li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <h4 class="m-t-0 header-title"><b>Kritik & Saran</b></h4>
                    <table id="dataTableKritiksaran" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="10">No</th>
                                <th width="20">Tanggal</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Kritik & Saran</th>
                                <th width="20">Status</th>
                                <th width="50">Aksi</th>
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

<!-- MODAL DETAIL KRITIK & SARAN -->
<div class="modal modal-detail" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Detail Pesan</h4>
            </div>
            <div class="modal-body" style="padding: 20px 50px 0 50px">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item row">
                        <b class="col-sm-4 p-0">Nama: </b>
                        <span class="col-sm-8 p-0" id="dtl_nama"></span>
                    </li>
                    <li class="list-group-item row">
                        <b class="col-sm-4 p-0">Email: </b>
                        <span class="col-sm-8 p-0" id="dtl_email"></span>
                    </li>
                    <li class="list-group-item row">
                        <b class="col-sm-4 p-0">Tanggal Masuk: </b>
                        <span class="col-sm-8 p-0" id="dtl_tanggal"></span>
                    </li>
                    <li class="list-group-item row" style="min-height: 80px;">
                        <b class="col-sm-4 p-0">Pesan: </b>
                        <span class="col-sm-8 p-0" id="dtl_pesan"></span>
                    </li>
                </ul>
            </div>
            <div class="modal-footer form-inline">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL HAPUS KRITIK & SARAN  -->
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
                <button type="button" class="btn btn-danger" id="delete-kritiksaran">Hapus</button>
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

        // GET DATA
        getData();
        function getData() {
            $("#dataTableKritiksaran").dataTable().fnDestroy();
            $('#dataTableKritiksaran').DataTable({
                processing: true,
                serverSide: true,
                ajax: host+'/datatable?req=dtGetKritiksaran',
                columns: [
                { data: 'no', name: 'no' },
                { data: 'tanggal', name: 'tanggal' },
                { data: 'nama', name: 'nama' },
                { data: 'email', name: 'email' },
                { data: 'pesan', name: 'pesan' },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });

            // UPDATE STATUS
            $.ajax({
                url: host + "/configuration",
                method: "POST",
                headers: headers,
                data: { req: 'updateKrisar', status: 'view' },
                success: function (data) {
                    notifCountView();
                }
            });
        }

        //HAPUS KRITIK & SARAN
        $(document).on('click', '#hapus-kritiksaran', function() {
            var id = $(this).attr('dta-id');
            $('#delete-kritiksaran').attr('data-id', id);
        });

        $('#delete-kritiksaran').click(function () {
            var id = $(this).attr('data-id');

            $.ajax({
                url: host + "/api/kritiksaran/delete/"+id,
                method: "DELETE",
                headers: headers,
                success: function (data) {
                    getData();

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

        // DETAIL KERITIK & SARAN
        $(document).on('click', '#detail-kritiksaran', function() {
            var id = $(this).attr('dta-id');
            $.ajax({
                url     : host+"/api/kritiksaran/getdata/"+id,
                method  : "GET",
                headers : headers,
                success : function(data) {
                    $.each(data.result, function(key, val) {
                        $('#dtl_'+key).text(val);
                        if (key == 'created_at') {
                            var dt = new Date(val);
                            var month = dt.getMonth()+1;
                            var date = dt.getDate();
                            if (month < 10) month = '0'+month;
                            if (dt.getDate() < 10) date = '0'+dt.getDate();
                            var tanggal = date+'/'+month+'/'+dt.getFullYear();
                            $('#dtl_tanggal').text(tanggal);
                        }
                    });
                }
            });
        });

        // NOTIF FIRBASE
        const messaging = firebase.messaging();

        messaging.onMessage((payload) => {
            console.log('Notification ', payload);
            getData();
            notifCountView();
        });
    });
</script>
@endsection