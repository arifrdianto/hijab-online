<?php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include 'lib/config.php';
include 'lib/fungsi_seo.php';

switch ($_GET['act']) {
	case 'artikel':
	$entri = mysql_query("SELECT * FROM berita where status='Y' ORDER BY berita_id DESC LIMIT 10");
	
		?>
		<div style="margin-top:90px; padding-top: 60px; padding-bottom: 20px;">
			<div class="container clear">
				<div class="mainblog">					
					<?php
					while ($artikel=mysql_fetch_array($entri)) {
						$isi = html_entity_decode($artikel['isi_berita']);
						$headline = substr($isi, 0, 600);
						$headline = substr($isi, 0, strrpos($headline, " "));
						$judul_seo = seo_title($artikel['judul']);
					?>
						<div class="recent">
							<h3><a href="<?php echo "artikel-$artikel[berita_id]-$judul_seo"?>"><?php echo $artikel['judul']; ?></a></h3>
							<span class="tgl"><?php echo date('d F Y', strtotime($artikel['tanggal'])); ?></span>
							<p><?php echo $headline."..."; ?></p>
						</div>
					<?php
					}
					?>
				
				</div>
			</div>				
		</div>
		<?php
		break;

	case 'detailartikel':
		$detailartikel = mysql_query("SELECT * FROM berita b, berita_kategori bk, users u 
										WHERE b.kategori_id=bk.kategori_id
										AND b.user_id=u.user_id
										AND berita_id='$_GET[bid]'");
		$d = mysql_fetch_array($detailartikel);
		$tgl = date('l, d F Y - H:i', strtotime($d['tanggal']));
		$isi = html_entity_decode($d['isi_berita']);

		$artikelpopuler = mysql_query("SELECT * FROM berita ORDER BY dibaca DESC LIMIT 5");

		mysql_query("update berita set dibaca=$d[dibaca]+1 where berita_id='$_GET[bid]'");
		?>
		<div style="margin-top:90px; padding-top: 60px; padding-bottom: 50px;">
			<div class="container clear">
				<div class="maincol">
					<h1><?php echo $d['judul'];?></h1>
					<span class="meta"><?php echo $tgl." WIB";?></span>
					<?php
					if ($d['gambar']!="") {
						echo "<img src=\"upload/berita/$d[gambar]\">";
					}
					?>
					<p><?php echo $isi;?></p>
					<small>Kontributor: <em><?php echo $d['fullname']; ?></em></small>
				</div>
				<aside class="sidebar">
					<h3>Berita Populer</h3>
					<ul>
					<?php
					while ($populer=mysql_fetch_array($artikelpopuler)) {
					$judul_seo = seo_title($populer['judul']);
					?>
						<li>
							<h3><a href="<?php echo "artikel-$populer[berita_id]-$judul_seo"?>"><?php echo $populer['judul']; ?></a></h3>
							<span class="tgl"><?php echo date('d F Y', strtotime($populer['tanggal'])); ?></span>
						</li>
					<?php
					}
					?>
					</ul>
				</aside>
			</div>
		</div>
		<?php

		break;

	default:
		# code...
		break;
}
?>