$(document).ready(function () {
    var url = $('meta[name="host_url"]').attr('content');
     $('.tombol-order_header').on('click',function () {
         window.location.href=url+'/order';
        
     })
});