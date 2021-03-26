@extends('headfood.page')
@section('konten')
@endsection
@push('skript')
<script>
	$(document).ready(function($) {
		var url = $('meta[name="host_url"]').attr('content');
		var id = '{{ $pesanan->id }}';
		
		Swal.fire({
			title: 'Pesanan Telah Selesai',
			text: 'Psanan anda telah selesai. Terima kasih telah memesan di kesiniku. Semoga anda puas dengan layanan kami. Driver kami akan segera datang mengambil peralatan. Mohon untuk di siapkan. Terima kasih',
			type: 'success',
			onClose: () => {
				$.ajax({
					url     : url+"/api/datapesanan/updatestatus/"+id,
					method  : "PUT",
					data: { status: 'Taking' },
					headers : headers()
				});
				location.href = url;
			}
		});
	});
</script>
@endpush