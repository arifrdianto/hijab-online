<?php
session_start();
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include '../../../lib/config.php';

$page = $_GET['page'];
$act = $_GET['act'];

if ($page == "cust" && $act == "update") {
	$custid = $_POST['id'];
	$status = $_POST['status'];
	
	mysql_query("update cust_users set status='$status' where cust_id='$custid'" );
	header('location:../../../admin/index.php?page=cust&act=listcust');	
} elseif ($page == "cust" && $act == "delete") {
	mysql_query("delete from cust_users where cust_id='$_GET[id]'");
	header('location:../../../admin/index.php?page=cust&act=listcust');
}
?>