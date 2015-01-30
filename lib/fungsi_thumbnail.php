<?php
function UnggahImageBerita($fupload_name){
	//direktori gambar
	$dir_upload = "../../../upload/berita/";
	//$vdir_upload = "../../../foto_berita/";
	$file_upload = $dir_upload.$fupload_name;

	//Simpan gambar dalam ukuran sebenarnya
	move_uploaded_file($_FILES["gambar"]["tmp_name"], $file_upload);

	//identitas file asli
	$im_src = imagecreatefromjpeg($file_upload);
	$src_width = imageSX($im_src);
	$src_height = imageSY($im_src);

	//Simpan dalam versi small 110 pixel
	//Set ukuran gambar hasil perubahan
	$dst_width = 210;
	$dst_height = ($dst_width/$src_width)*$src_height;

	//proses perubahan ukuran
	$im = imagecreatetruecolor($dst_width,$dst_height);
	imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

	//Simpan gambar
	imagejpeg($im,$dir_upload ."thumb/". $fupload_name);

	//Hapus gambar di memori komputer
	imagedestroy($im_src);
	imagedestroy($im);
}

function UnggahImageProduk($fupload_name){
	//direktori gambar
	$dir_upload = "../../../upload/produk/";
	//$vdir_upload = "../../../foto_berita/";
	$file_upload = $dir_upload.$fupload_name;

	//Simpan gambar dalam ukuran sebenarnya
	move_uploaded_file($_FILES["p_img"]["tmp_name"], $file_upload);

	//identitas file asli
	$im_src = imagecreatefromjpeg($file_upload);
	$src_width = imageSX($im_src);
	$src_height = imageSY($im_src);

	//Simpan dalam versi small 110 pixel
	//Set ukuran gambar hasil perubahan
	$dst_width = 190;
	$dst_height = 200;

	//proses perubahan ukuran
	$im = imagecreatetruecolor($dst_width,$dst_height);
	imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

	//Simpan gambar
	imagejpeg($im,$dir_upload ."thumb/". $fupload_name);

	//Hapus gambar di memori komputer
	imagedestroy($im_src);
	imagedestroy($im);
}

function UnggahImageAvatar($fupload_name){
	//direktori gambar
	$dir_upload = "../../../upload/users/";
	//$vdir_upload = "../../../foto_berita/";
	$file_upload = $dir_upload.$fupload_name;

	//Simpan gambar dalam ukuran sebenarnya
	move_uploaded_file($_FILES["avatar"]["tmp_name"], $file_upload);

	//identitas file asli
	$im_src = imagecreatefromjpeg($file_upload);
	$src_width = imageSX($im_src);
	$src_height = imageSY($im_src);

	//Simpan dalam versi small 110 pixel
	//Set ukuran gambar hasil perubahan
	$dst_width = 90;
	//$dst_height = ($dst_width/$src_width)*$src_height;
	$dst_height = 90;

	//proses perubahan ukuran
	$im = imagecreatetruecolor($dst_width,$dst_height);
	imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

	//Simpan gambar
	imagejpeg($im,$dir_upload ."avatar/". $fupload_name);

	//Hapus gambar di memori komputer
	imagedestroy($im_src);
	imagedestroy($im);
}
?>