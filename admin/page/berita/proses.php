<?php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
session_start();
include '../../../lib/config.php';
include '../../../lib/fungsi_thumbnail.php';
include '../../../lib/fungsi_seo.php';

$page = $_GET['page'];
$act = $_GET['act'];

//insert berita
if ($page == "berita" && $act == "post") {
	$judul = $_POST['judul'];
	$isi = htmlspecialchars($_POST['isi'], ENT_QUOTES);
	$kategori = $_POST['kategori'];
	$status = $_POST['status'];
	$tgl = date("Y-m-d H:i:s");
	$pengirim = $_SESSION['userid'];

	//unggah foto
	$lokasi_file = $_FILES['gambar']['tmp_name'];
	$tipe_file = $_FILES['gambar']['type'];
	$nama = str_replace(" ", "_", $_FILES['gambar']['name']);
	$datename = date('dmyhi');
	$nama_file = $datename.$nama;	

	if (!empty($lokasi_file)) {
		UnggahImageBerita($nama_file);

		mysql_query("insert into berita (judul,
										isi_berita,
										tanggal,
										gambar,
										status,
										kategori_id,
										user_id)
								values 	('$judul', 
										'$isi',
										'$tgl',
										'$nama_file',
										'$status',
										'$kategori',
										'$pengirim')");	
	} else {
		mysql_query("insert into berita (judul,
										isi_berita,
										tanggal,
										status,
										kategori_id,
										user_id)
								values 	('$judul', 
										'$isi',
										'$tgl',
										'$status',
										'$kategori',
										'$pengirim')");	
	}

	header('location:../../../admin/index.php?page=berita&act=listberita');	

} elseif ($page == "berita" && $act == "updateberita") {
	$id = $_POST['id'];
	$judul = $_POST['judul'];
	$isi = htmlspecialchars($_POST['isi'], ENT_QUOTES);
	$kategori = $_POST['kategori'];
	$status = $_POST['status'];

	//unggah foto
	$lokasi_file = $_FILES['gambar']['tmp_name'];
	$tipe_file = $_FILES['gambar']['type'];
	$nama = str_replace(" ", "_", $_FILES['gambar']['name']);
	$datename = date('dmyhi');
	$nama_file = $datename.$nama;	

	if (empty($lokasi_file)) {
		mysql_query("UPDATE berita SET judul		= '$judul',
										isi_berita	= '$isi',
										status 		= '$status',
										kategori_id	= '$kategori'
								WHERE 	berita_id	= '$id'");	
	} else {
		UnggahImageBerita($nama_file);
		mysql_query("UPDATE berita SET judul		= '$judul',
										isi_berita	= '$isi',
										status 		= '$status',
										kategori_id	= '$kategori',
										gambar		= '$nama_file'
								WHERE 	berita_id	= '$id'");
		//hapus gambar lama
		$filename = $_POST['filename'];		
		$dir = "$upload_dir/berita/";
		unlink($dir.$filename);
		unlink($dir."thumb/".$filename);
	}

	header('location:../../../admin/index.php?page=berita&act=listberita');	

} elseif ($page == "berita" && $act == "hapusberita") {
	$filename = $_GET['filename'];
	//hapus foto 
	$dir = "$upload_dir/berita/";
	unlink($dir.$filename);
	unlink($dir."thumb/".$filename);

	mysql_query("delete from berita where berita_id = '$_GET[id]'");
	header('location:../../../admin/index.php?page=berita&act=listberita');
	
} elseif ($page == "berita" && $act == "hapusberitacek") {
	//hapus foto 
	$dir = "$upload_dir/berita/";
	//unlink($dir.$filename);
	//unlink($dir."thumb/".$filename);

	//mysql_query("delete from berita where berita_id = '$id'");
	//header('location:../../../admin/index.php?page=berita&act=listberita');
	if (isset($_POST['btnhapus'])) {
		foreach ($_POST['berita_id'] as $key) {	
			
			$result = mysql_query("select gambar from berita where berita_id = '$key'");
			$gmb = mysql_fetch_array($result);
			unlink($dir.$gmb['gambar']);
			unlink($dir."thumb/".$gmb['gambar']);

			mysql_query("delete from berita where berita_id = '$key'");
		}
		foreach ($_POST['gambar'] as $gmb) {
			//unlink($dir.$gmb);
			//unlink($dir."thumb/".$gmb);
		}
	}

	if (isset($_POST['btnpublish'])) {
		foreach ($_POST['berita_id'] as $key) {	
			mysql_query("update berita set status='Y' where berita_id = '$key'");
		}
	}

	if (isset($_POST['btndraft'])) {
		foreach ($_POST['berita_id'] as $key) {	
			mysql_query("update berita set status='N' where berita_id = '$key'");
		}
	}
	
	header('location:../../../admin/index.php?page=berita&act=listberita');
}

//kategori
elseif ($page == "kategoriberita" && $act == "addkategori") {
	$judul = seo_title($_POST['kategori_nm']);
	$deskripsi = $_POST['kategori_desk'];

	mysql_query("insert into berita_kategori values('', '$judul', '$deskripsi')");

	header('location:../../../admin/index.php?page=kategoriberita&act=listkategori');

} elseif ($page == "kategoriberita" && $act == "updatekategori") {
	$id = $_GET['id'];
	$judul = seo_title($_POST['kategori_nm']);
	$deskripsi = $_POST['kategori_desk'];

	mysql_query("update berita_kategori set kategori_nama = '$judul', kategori_desk = '$deskripsi' where kategori_id = '$id'");
	
	header('location:../../../admin/index.php?page=kategoriberita&act=listkategori');
} elseif ($page == "kategoriberita" && $act == "hapuskategori") {
	mysql_query("delete from berita_kategori where kategori_id = '$_GET[id]'");
	header('location:../../../admin/index.php?page=kategoriberita&act=listkategori');
}
?>