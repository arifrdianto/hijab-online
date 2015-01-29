<?php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include 'lib/config.php';
include 'lib/fungsi_seo.php';
?>
<div class="parallax">
	<ul class="cb-slideshow">
        <li><span>Image 01</span></li>
        <li><span>Image 02</span></li>
        <li><span>Image 03</span></li>
        <li><span>Image 04</span></li>
        <li><span>Image 05</span></li>
        <li><span>Image 06</span></li>
    </ul>
</div>
	<div class="what">
		<div class="container clear">
			<div class="what-umil">
				<h3 class="title">Apa itu UMIL charshaf ?</h3>
				<p>Umil Charshaf adalah perusahaan busana muslim hijab indonesia yang berkantor pusat di Cirebon. Umil Charshaf hijab menyediakan berbagai produk fashion hijab, seperti jilbab, kerudung, pashmina/ selendang, Scarf/ kerudung segi empat dan dari hijab Umil Charshaf/ jilbab Umil Charshaf, kerudung, pashmina, scarf Umil Charshaf memiliki warna motif produk dan model yang variatif. Ada banyak tipe konsumen fashion hijab indonesia dalam merespons tren baru. Kira-kira Anda termasuk konsumen fashion hijab indonesia yang seperti apa? Innovators Sekelompok kecil konsumen yang menginisiasi tren atau mengadopsi inovasi produk baru dan tipe baru di produk fashion hijab indonesia (jilbab, scarf atau kerudung dan pashmina) sebelum orang lain melakukannya. Mereka visioner dan berani mengambil risiko. Dan mereka orang-orang yang berani tampil beda. </p>
			</div>
			<div class="news">
				<h3 class="title">Blog</h3>
				<?php
				$query = mysql_query("select * from berita where status='Y' order by berita_id desc limit 3");
				while ($b = mysql_fetch_array($query)) {
					$judul_seo = seo_title($b['judul']);				
					echo 
						"<div class='post'>
							<h3><a href='artikel-$b[berita_id]-$judul_seo'>$b[judul]</a></h3>
							<span class='date'>".date('d F', strtotime($b['tanggal']))."</span>
						</div>";
						echo mysql_error();
				} 
				?>
			</div>
		</div>
	</div>
	<div class="product">
		<div class="container">
			<h3 class="title">Etalase</h3>
			<ul>
				<?php
				$query_p = mysql_query("select * from produk order by produk_id desc limit 8");
				
				while ($p = mysql_fetch_array($query_p)) {
					if ($p['stok']!=0) {
						$stok = "Tersedia";
					} else {
						$stok = "Habis";
					}
					$nama_seo = seo_title($p['produk_nama']);

					echo				
						"<a href=\"item-$p[produk_id]-$nama_seo\">
							<li class=\"product-item\">
								<div class=\"product-thumb\">
									<img src=\"upload/produk/thumb/$p[image]\" alt=\"$p[produk_nama]\">
								</div>
								<div class=\"desc\">
									<h4>$p[produk_nama]</h4>
									<div class=\"descrip\">
										<p>$stok</p>
										<p>Rp. $p[harga]</p>
									</div>
								</div>						
							</li>
						</a>";	
				}
				?>			
			</ul>
		</div>
	</div>
	<div class="testimoni">
		<div class="container clear">
			<h3 class="title">Mereka mengatakan</h3>
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					<div class="item active">
						<div class="avatar">
							<img src="assets/img/testi1.jpg" alt="">
							<h4>Citra Kirana</h4>
							<span>Aktris</span>
						</div>
						<div class="say">
							<p>"Bicara hijab di Indonesia dan perkembangannya, tidak bisa dilepas peran Umil Charshaf hijab dengan produk jilbab Umil Charshaf atau kerudung Umil Charshaf, kerudung segi empat, kerudung pashmina dan kerudung instan."</p>
						</div>
					</div>

					<div class="item">
						<div class="avatar">
							<img src="assets/img/testi2.jpg" alt="">
							<h4>Desiana</h4>
							<span>Mahasiswa</span>
						</div>
						<div class="say">
							<p>"Harga terjangkau semua produk Umil Charshaf hijab baik itu  produk jilbab atau kerudung segi empat, kerudung pashmina dan tentunya juga produk kerudung instan / bergo itu bisa didapat dengan harga terjangkau."</p>
						</div>
					</div>

					<div class="item">
						<div class="avatar">
							<img src="assets/img/testi3.jpg" alt="">
							<h4>Susan Devy</h4>
							<span>Desainer Painting</span>
						</div>
						<div class="say">
							<p>"Fashion hijab muslimah dikenakan untuk menutup aurat dan sesuai dengan aturan syari. Begitu juga dengan hijab indonesia / hijab Umil Charshaf.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>