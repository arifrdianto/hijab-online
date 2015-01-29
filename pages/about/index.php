<?php

switch ($_GET['act']) {
	case 'carabelanja':
		?>
		<div style="margin-top:90px; padding-top: 60px; padding-bottom: 50px;">
			<div class="container clear">
				<div class="cara">
					<h3 class="title">Cara Belanja</h3>					
					<br>
					<p>Sebelum berbelanja, pastikan bahwa Kamu sudah memiliki account Umil Charshaf. Jika Kamu belum memiliki account Umil Charshaf, silakan registrasi terlebih dahulu. Klik <a href="sign">Sign In</a> di bagian atas website lalu isi formnya.</p>
					<img src="assets/img/sign.jpg">
					<p>Jika Kamu sudah punya account, Kamu bisa langsung <a href="sign">Sign In</a>. Isi form Login, masukkan email dan passwordmu lalu LOGIN.</p>
					<br>
					<h3 class="title">PENCARIAN PRODUK</h3>
					<p>Semua produk kami dapat ditemukan lewat menu utama. atau lewat menu <a href="katalog">Produk</a> dikelompokan berdasarkan Kategori.</p>
					<img src="assets/img/produk.jpg">
					<p>Ketika Kamu sudah menemukan produk yang Kamu inginkan, klik gambar atau namanya untuk melihat detail produk tersebut.</p>
					<br>
					<h3 class="title">Menambahkan Produk Ke Keranjang Belanja</h3>
					<p>Di halaman detail produk, tentukan ukuran dan jumlahnya yang ingin Kamu beli lalu klik tombol ‘ADD TO CART’. Kamu bisa menambahkan lebih dari satu produk ke dalam Keranjang Belanja.</p>
					<img src="assets/img/detail.jpg">
					<br>
					<h3 class="title">Shopping Cart</h3>
					<p>Lihat CART dari <a href="cart">Shopping Cart</a> untuk memeriksa kembali seluruh produk yang akan kamu beli. Kemudian disini kamu bisa merubah jumlah produk yang kamu beli atau menghapusnya.</p>
					<img src="assets/img/cart.jpg">					
					<p>Klik 'PROSES BELANJA' untuk lanjut ke tahap berikutnya.</p>
					<br>
					<h3 class="title">Alamat Pengiriman</h3>
					<p>Lengkapi form Alamat Pengiriman, untuk mengirim produk yang Kamu beli. Pastikan alamat tersebut benar.</p>
					<img src="assets/img/alamat.jpg">
					<p>Kemudian tampila ringkasan belanja Kamu, periksa kembali. Jika sudah yakin klik tombol 'PESAN SEKARANG'</p>
					<img src="assets/img/detailorder.jpg">
					<br>
					<h3 class="title">Faktur Pemesanan</h3>
					<p>Cetak Faktur Pemesanan, perlu diingat No. ID Pemesanan jangan sampai lupa, karena ini menjadi No. Id Pemesanan Kamu ketika melakukan <a href="konfirmasi-pembayaran">Konfirmasi</a> Pembayaran</p>
					<img src="assets/img/faktur.jpg">
					<p>    Silahkan lakukan pembayaran ke Bank BNI 08867 757587 757 a.n Umil Charshaf atau ke Bank BRI 09708 8675675 757 a.n Umil Charshaf. Apabila tidak melakukan pemabayaran selama 2x24 jam, pemesanan dianggap batal  Jika sudah melakukan pembayaran / transfer, silahkan melakukan <a href="konfirmasi-pembayaran">Konfirmasi</a> pembayaran dengan memasukan No. ID Pemesanan</p>
				</div>
			</div>				
		</div>
		<?php
		break;
	
	default:
		# code...
		break;
}
?>