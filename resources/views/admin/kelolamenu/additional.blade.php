@extends('admin.layout')
@section('content')')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Additional Daging</h4>
                <ol class="breadcrumb">
                    <li>
                        <a href="#">NeedFood</a>
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
                    <button type="button" class="btn btn-default btn-rounded waves-effect waves-light m-t-10 m-b-20"><i class="fa fa-plus-circle"></i> &nbsp;Tambah Additional</button>
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Daging</th>
                                <th>Berat (gr)</th>
                                <th>Harga</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td style="width: 10px;">1</td>
                                <td>System Architect</td>
                                <td>200gr</td>
                                <td>Rp. 120.000</td>
                                <td>Drag & drop hierarchical list with mouse</td>
                                <td style="width: 150px;" class="text-center">
                                    <button type="button" class="btn btn-info btn-sm waves-effect waves-light"><i class="fa fa-edit"></i> Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm waves-effect waves-light"><i class="fa fa-trash"></i> Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> 
</div>
@endsection