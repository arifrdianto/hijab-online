<?php
if(!defined('__NOT_DIRECT')){
	//mencegah akses langsung ke file ini
	die('Oops, akses tidak diizinkan!');
}
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);

$host = "localhost"; //nama host
$user = "root"; //nama user mysql
$pass = "root"; //password mysql
$db = "db_umil"; //nama database 

$upload_dir = "../../../upload";

$connect = mysql_connect($host, $user, $pass);
mysql_select_db($db, $connect) or die ("<b>Koneksi Database Gagal</b></br>".mysql_error());
?>
