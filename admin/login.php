<?php
session_start();
if (isset($_SESSION['username'])) {
	header('location:index.php?page=dashboard');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login - UMIL Charshaf</title>
	
	<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../assets/fonts/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/style.css">
	<style>
		body{
			background-color: #f0f0f0;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="main">
			
			<div class="tile tile-login">
				<img src="../assets/img/umil-logo.svg" class="logo">
				<form method="post" action="cek_login.php">
					<div class="input-icon">
						<span class="fa-user fa"></span>
						<input type="text" name="username" class="form-control" placeholder="Username">
					</div>
					<div class="input-icon">
						<span class="fa-lock fa"></span>
						<input type="password" name="password" class="form-control" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
					</div>
						<input type="submit" value="Log In" class="btn-block buton primary">
				</form>
			</div>

			<small><a href="./">Umil</a> &copy; <?php echo date('Y');?> All rights reserved</small>
		</div>
	</div>

</body>
</html>