@extends('headfood.page')
@section('konten')

<section class="banner_order">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="title_upload">Upload bukti pembayaran</div>
                    
                    <div class="container">
                        <div class="sub_box">
                            <form action="{{ url('/file-upload') }}" class="dropzone" id="my-awesome-dropzone" style="border: none;">
                              @csrf
                            </form>
                          </div>
                          <div class="notes_upload_title">Keterangan</div>
                          <div class="col-lg-8">
                            <div class="notes_upload_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.Fringilla sed tellus orci praesent sem eget. Amet eu, habitant id vel magna vitae</div>
                          </div>
                          <div class="col-lg-6">
                            <button id="additional_get"  class="tombol-custom tombol-keranjang text-button grid_upload">UPLOAD</button>
                          </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('stack')
<script>
  var formData = new FormData();
  var chek = 0

  Dropzone.options.myAwesomeDropzone = {
    init: function() {
      this.on("addedfile", function(file) {
        formData.append('file[]', file);
        chek = chek + 1;
      });
    }
  };

  $(document).ready(function($) {

    var headers = {
      "Accept": "application/json",
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
    }


    $('#formSubmit').submit(function(e) {
      e.preventDefault();

      var id = $('#id').val();
      var alamat = $('#alamat').val();
      var perihal = $('#perihal').val();

      if (id == '') {
        Swal.fire({
          title: 'Login Terlebih Dahulu',
          text: 'Anda harus login sebelum membuat laporan!',
          type: 'warning',
          onClose: () => {
            location.href = "{{ url('/login') }}";
          }
        });
        return
      }

      if (chek == 0) {
        Swal.fire({
          title: 'Lampirkan Foto!',
          text: 'Paastikan anda telah melampirkan foto',
          type: 'warning'
        });
        return
      }

      formData.append('id', id);
      formData.append('alamat', alamat);
      formData.append('perihal', perihal);

      $.ajax({
        url: "{{ url('/createlaporan') }}",
        enctype: "multipart/form-data",
        method: "POST",
        headers: headers,
        data: formData,
        success: function (data) {
          Swal.fire({
            title: 'Berhasil Diproses',
            text: 'Laporan berhasil dibuat',
            type: 'success',
            onClose: () => {
              location.href = "{{ url('/agent') }}";
            }
          });
        },
        contentType: false,
        processData: false,
      });

    });

  });
</script>
@endpush