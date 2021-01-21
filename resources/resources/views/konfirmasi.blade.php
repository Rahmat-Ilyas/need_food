<b>Kode Pemesan: {{ $pesanan->kd_pemesanan }}</b><br>
<b>Nama Pemesan: {{ $pesanan->nama }}</b><br>
<b>Alamat: {{ $pesanan->deskripsi_lokasi }}</b><br>
<hr>
<br>
<h1>Upload Bukti Pembayaran</h1>
<form method="POST">
	<label>Bukti Pembayaran</label>
	<input type="hidden" name="id">
	<input type="file" name="foto_bukti"><br>
	<button type="submit">Kirim</button>
</form>