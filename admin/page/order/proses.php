<?php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include '../../../lib/config.php';

$page = $_GET['page'];
$act = $_GET['act'];

//hapus konfirmasi pembayaran
if ($page == "order" && $act == "aksipembayaran") {
	if (isset($_POST['btnhapus'])) {
		foreach ($_POST['ordid'] as $key) {
			mysql_query("delete from pembayaran where order_id='$key'");
		} 
	}
	if (isset($_POST['btnbatal'])) {
		foreach ($_POST['ordid'] as $key) {
			mysql_query("update orders set pelunasan='0' where order_id='$key'");
		} 
	}
	header('location:../../../admin/index.php?page=order&act=pembayaran');

} elseif ($page == "order" && $act == "aksilistorder") {
	if (isset($_POST['btnhapus'])) {
		foreach ($_POST['id'] as $key) {
			mysql_query("delete from orders where order_id='$key'");
			mysql_query("delete from order_detail where order_id='$key'");
		} 
	}
	if (isset($_POST['btnbatalproses'])) {
		foreach ($_POST['id'] as $key) {
			mysql_query("update orders set status='Menunggu' where order_id='$key'");
		} 
	}
	if (isset($_POST['btnproses'])) {
		foreach ($_POST['id'] as $key) {
			mysql_query("update orders set status='Dalam Proses' where order_id='$key'");
		} 
	}
	if (isset($_POST['btndikirim'])) {
		foreach ($_POST['id'] as $key) {
			mysql_query("update orders set status='Dikirim' where order_id='$key'");
		} 
	}
	if (isset($_POST['btnbatal'])) {
		foreach ($_POST['id'] as $key) {
			mysql_query("update orders set status='Batal' where order_id='$key'");
		} 
	}
	header('location:../../../admin/index.php?page=order&act=listorder');
}
?>