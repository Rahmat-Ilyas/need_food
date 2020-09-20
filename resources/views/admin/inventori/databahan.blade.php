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
                    <button type="button" class="btn btn-default btn-rounded waves-effect waves-light m-t-10 m-b-20"><i class="fa fa-plus-circle"></i> &nbsp;Bahan Baru</button>
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
@endsection