<?php
if(!defined('__NOT_DIRECT')){
	//mencegah akses langsung ke file ini
	die('Oops, akses tidak diizinkan!');
}
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);

$host = "mysql.idhostinger.com";
$user = "u398863027_umil";
$pass = "m4njinGg";
$db = "u398863027_umil";
//$upload_dir = "C:/xampp/htdocs/pw2/project/upload";
$upload_dir = "../../../upload";

$connect = mysql_connect($host, $user, $pass);
mysql_select_db($db, $connect) or die ("<b>Koneksi Database Gagal</b></br>".mysql_error());
?>