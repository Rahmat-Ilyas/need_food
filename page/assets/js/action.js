var formData = new FormData();
    Dropzone.options.myAwesomeDropzone = {
    init: function() {
        this.on("addedfile", function(file) {
        formData.append('foto', file);
        });
    }
};
$(function () {
    var url = $('meta[name="host_url"]').attr('content');
    $(document).on('click','#upload_submit',function (e) {
        e.preventDefault();
        var pemesanan_id = $('#pemesanan_id').val();
       formData.append('pemesanan_id',pemesanan_id);
       $.ajax({
            url:  url+'/api/datapesanan/konfirmasi',
            enctype: "multipart/form-data",
            method  : "POST",
            headers : headers(),
            data: formData,
            contentType: false,
            processData: false,
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (evt) {
                    if (evt.lengthComputable) {
                        $("#loading, .loader").removeAttr('hidden');
                    }
                }, false);
                return xhr;
            },
           success: function (response) {
            $("#loading, .loader").attr('hidden', '');
            Swal.fire({
                title: 'Berhasil Diproses',
                text: 'Terima Kasih Telah Melakukan Konfirmasi Pembayaran, Pesanan anda akan segera di proses',
                type: 'success',
                onClose: () => { location.href = url; }
            });
           }
       });
       
    })
})