<?php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include '../../../lib/config.php';
include '../../../lib/fungsi_thumbnail.php';
include '../../../lib/fungsi_seo.php';

$page = $_GET['page'];
$act = $_GET['act'];

if ($page == "produk" && $act == "insert") {
	$pnama = ucwords($_POST['p_nama']);
	$bahan = ucwords($_POST['p_bahan']);
	//$ukuran = $_POST['p_ukuran'];
	$ukuran = implode(' ', $_POST['p_ukuran']);
	$warna = ucwords($_POST['p_warna']);
	$harga = $_POST['p_harga'];
	//$harga = number_format($_POST['p_harga'], 2, ',', '.');
	$stok = $_POST['p_stok'];
	$kategori = $_POST['p_kategori'];
	$tgl = date('Y-m-d');

	//unggah foto
	$lokasi_file = $_FILES['p_img']['tmp_name'];
	$tipe_file = $_FILES['p_img']['type'];
	$nama = str_replace(" ", "_", $_FILES['p_img']['name']);
	$datename = date('dmyhi');
	$nama_img = $datename.$nama;

	if (!empty($lokasi_file)) {
		UnggahImageProduk($nama_img);

		mysql_query("insert into produk (produk_nama,
										image,
										bahan,
										ukuran,
										warna,
										harga,
										stok,
										pk_id,
										tgl_entri)
								values 	('$pnama', 
										'$nama_img',
										'$bahan',
										'$ukuran',
										'$warna',
										'$harga',
										'$stok',
										'$kategori',
										'$tgl')");	
	} else {
		mysql_query("insert into produk (produk_nama,										
										bahan,
										ukuran,
										warna,
										harga,
										stok,
										pk_id,
										tgl_entri)
								values 	('$pnama', 
										'$bahan',
										'$ukuran',
										'$warna',
										'$harga',
										'$stok',
										'$kategori',
										'$tgl')");	
	}

	header('location:../../../admin/index.php?page=produk&act=listproduk');


} elseif ($page == "produk" && $act == "update") {
	$id = $_POST['id'];
	$pnama = ucwords($_POST['p_nama']);
	$bahan = ucwords($_POST['p_bahan']);
	//$ukuran = $_POST['p_ukuran'];
	$ukuran = implode(' ', $_POST['p_ukuran']);
	$warna = ucwords($_POST['p_warna']);
	$harga = $_POST['p_harga'];
	//$harga = number_format($_POST['p_harga'], 2, ',', '.');
	$stok = $_POST['p_stok'];
	$kategori = $_POST['p_kategori'];	

	//unggah foto
	$lokasi_file = $_FILES['p_img']['tmp_name'];
	$tipe_file = $_FILES['p_img']['type'];
	$nama = str_replace(" ", "_", $_FILES['p_img']['name']);
	$datename = date('dmyhi');
	$nama_img = $datename.$nama;

	if (empty($lokasi_file)) {		

		mysql_query("UPDATE produk SET produk_nama	= '$pnama',
										bahan 		= '$bahan',
										ukuran 		= '$ukuran',
										warna 		= '$warna',
										harga 		= '$harga',
										stok 		= '$stok',
										pk_id 		= '$kategori'
								WHERE 	produk_id 	= '$id'");
								
	} else {
		UnggahImageProduk($nama_img);
		mysql_query("UPDATE produk SET produk_nama	= '$pnama',
										image 		= '$nama_img',
										bahan 		= '$bahan',
										ukuran 		= '$ukuran',
										warna 		= '$warna',
										harga 		= '$harga',
										stok 		= '$stok',
										pk_id 		= '$kategori'
								WHERE 	produk_id 	= '$id'");
		//hapus gambar lama
		$filename = $_POST['img'];		
		$dir = "$upload_dir/produk/";
		unlink($dir.$filename);
		unlink($dir."thumb/".$filename);
	}

	header('location:../../../admin/index.php?page=produk&act=listproduk');

} elseif ($page == "produk" && $act == "hapusproduk") {
	$filename = $_GET['img'];
	//hapus foto 
	$dir = "$upload_dir/produk/";
	unlink($dir.$filename);
	unlink($dir."thumb/".$filename);

	mysql_query("delete from produk where produk_id = '$_GET[id]'");
	header('location:../../../admin/index.php?page=produk&act=listproduk');
} elseif ($page == "produk" && $act == "hapusprodukcek") {
	$dir = "$upload_dir/produk/";
	if(isset($_POST['btnhapus'])){
		foreach ($_POST['id'] as $key) {
			$result = mysql_query("select image from produk where produk_id = '$key'");
			$gmb = mysql_fetch_array($result);
			unlink($dir.$gmb['image']);
			unlink($dir."thumb/".$gmb['image']);

			mysql_query("delete from produk where produk_id = '$key'");
		}	
	}

	header('location:../../../admin/index.php?page=produk&act=listproduk');
}

elseif ($page == "produk" && $act == "submitpk") {
	$nama = seo_title($_POST['pk_nama']);

	mysql_query("insert into produk_kategori values('', '$nama')");

	header('location:../../../admin/index.php?page=produk&act=listprodkategori');

} elseif ($page == "produk" && $act == "updatepk") {
	$id = $_GET['id'];
	$nama = seo_title($_POST['pk_nama']);

	mysql_query("update produk_kategori set pk_nama = '$nama' where pk_id = '$id'");
	
	header('location:../../../admin/index.php?page=produk&act=listprodkategori');
} elseif ($page == "produk" && $act == "hapuspk") {
	mysql_query("delete from produk_kategori where pk_id = '$_GET[id]'");
	header('location:../../../admin/index.php?page=produk&act=listprodkategori');
}
?>