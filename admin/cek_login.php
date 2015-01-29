<?php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include '../lib/config.php';
$username = mysql_real_escape_string($_POST['username']);
$password = md5($_POST['password']);

if (isset($username) && isset($password)) {
	$cek_query = mysql_query("select * from users where username = '$username' and password = '$password'");
	$cek_user = mysql_num_rows($cek_query);
	$data_user = mysql_fetch_array($cek_query);

	if ($cek_user > 0) {
		session_start();	
		$_SESSION['userid'] = $data_user['user_id'];	
		$_SESSION['username'] = $data_user['username'];
		$_SESSION['password'] = $data_user['password'];
		$_SESSION['fullname'] = $data_user['fullname'];
		$_SESSION['email'] = $data_user['email'];
		$_SESSION['level'] = $data_user['level'];
		$_SESSION['avatar'] = $data_user['avatar'];

		header('location:index.php?page=dashboard');
	} else {
		header('location:login.php');
	}
} 

?>