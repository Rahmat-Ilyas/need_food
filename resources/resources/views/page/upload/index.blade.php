@extends('headfood.page')
@section('konten')

<section class="banner_order">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="title_upload">Upload bukti pembayaran</div>
                    
                                              <b>Kode Pemesan: {{ $pesanan->kd_pemesanan }}</b><br>
<b>Nama Pemesan: {{ $pesanan->nama }}</b><br>
<b>Alamat: {{ $pesanan->deskripsi_lokasi }}</b><br>
<hr>
<br>

                    <div class="container">
                        <div class="sub_box">
                        <input type="hidden" id="pemesanan_id" value="{{$pesanan->id}}">
                            <form action="{{ url('/upload_dropzone') }}" class="dropzone" id="myAwesomeDropzone" style="border: none;">
                              @csrf
                            </form>
                          </div>
                          <div class="notes_upload_title">Keterangan</div>
                          <div class="col-lg-8">
                            <div class="notes_upload_text"><strong>Penting !!!</strong> Mohon Konfirmasi Pembayaran ini hanya di lakukan <strong>setelah</strong> Anda melakukan pembayaran. Isi data dengan benar untuk memudahkan kami memverifikasi konfirmasi anda </div>
                          </div>
                          <div class="col-lg-6">
                            <button id="upload_submit" class="tombol-custom tombol-keranjang text-button grid_upload">UPLOAD</button>
                          </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<div id="loading" hidden="">
  <span class="loader" hidden=""></span>
  <div class="textLoader">
      <center>
          <b>Please Wait ... </b>
      </center>
  </div>
</div>

@endsection