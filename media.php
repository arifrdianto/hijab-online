<?php
	session_start(); 
	if(empty($_SESSION['cart'])){
		$_SESSION['subtotal'] = 0;
	}
	defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
	include 'lib/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="refresh" content="300">
	<title><?php include 'lib/title.php'; ?></title>
	<link rel="shortcut icon" href="assets/img/favico.png">
	<link rel="stylesheet" href="assets/css/carousel.css">
	<link rel="stylesheet" type="text/css" href="assets/fonts/font-awesome/css/font-awesome.min.css">
	<!--<link rel="stylesheet" type="text/css" href="assets/css/AdminLTE.css">-->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style(1.css">
</head>
<body>	
	<nav class="navbar">
		<div class="navtop">
			<div class="container">
				<div class="navtop-call">Hub: 0896 7923 0438 / 775C209C</div>
				<div class="navtop-sign">
					<ul>
						<li>
							<?php							
							if (empty($_SESSION['cust'])) {
								echo "<a href=\"sign\" class=\"shopping\">Sign In</a>";
							} else {
								$cust=explode(" ", $_SESSION['cust']);
								echo "Haii, <a href='akun-saya' style='color:#fff'>".$cust[0]."</a> / <a href=\"logout\" class=\"shopping\">Logout</a>";							
							}
							?>
							
						</li>
						<li>
							<a href="cart" class="shopping">Shopping Cart</a>
							<?php
							if(empty($_SESSION['subtotal'])) { 
								$_SESSION['subtotal'] = 0;
								echo "- Rp. 0,-"; 
								
							} else {
								echo "- Rp. ".number_format($_SESSION['subtotal'], 0,',','.').",-"; 
							}

							?>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div>
			<div class="container">
				<div class="navbar-brand">
					<a href="index">
						<img src="assets/img/umil-logo.svg">
					</a>
				</div>
				<div class="navbar-right">
					<ul>
						<li><a href="index">HOME</a></li>
						<li><a href="katalog">PRODUK</a></li>
						<li><a href="cara-belanja">CARA BELANJA</a></li>
						<li><a href="konfirmasi-pembayaran">KONFIRMASI</a></li>
						<li><a href="blog">BLOG</a></li>
					</ul>
				</div>
			</div>
		</div>
	</nav>
	<div class="konten">
		<?php
		include 'content.php';
		?>
	</div>
	<footer>
		<div class="container clear">
			<div class="socmed">
				<h3 class="title">Ngobrol dengan kami</h3>
				<ul>
					<li><i class="fa fa-phone"></i>  +62896 7923 0438</li>
					<li><a href="https://www.facebook.com/pages/UMIL-Charshaf"><i class="fa fa-facebook-square"></i>  UMIL Charshaf</a></li>
					<li><a href="http://twitter.com"><i class="fa fa-twitter"></i>  umil_charshaf</a></li>
					<li><i class="fa fa-envelope-o"></i> umil.charshaf@gmail.com</li>
				</ul>
			</div>
			<div class="info">
				<h3 class="title">Info</h3>
				<ul>
					<li><a href="#">Tentang Kami</a></li>
					<li><a href="cara-belanja">Cara Belanja</a></li>
					<li><a href="konfirmasi-pembayaran">Cara Bayar</a></li>
					<li><a href="#">Request</a></li>					
				</ul>
			</div>
			<div class="address">
				<p>Alamat : Jl. Fattahilah No. 73A Plered, Kab. Cirebon 45156 Jawa Barat</p>
			</div>
		</div>
		<div class="container clear">
			<div class="copy">
				<p><a href="./">Umil</a> &copy; 2014 All rights reserved</p>
			</div>
		</div>
	</footer>


	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/modernizr.custom.86080.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/woocommerce.min.js"></script>
	<script src="assets/js/jquery.nicescroll.min.js"></script>
    <script src="assets/js/jquery.elevatezoom.js"></script>
	<script>
	    $('#zoom_01').elevateZoom({
	    	zoomType: "inner",
			cursor: "crosshair",
			zoomWindowFadeIn: 500,
			zoomWindowFadeOut: 750
		}); 
		$(document).ready( function() {
			$("html").niceScroll();
		});
		var ajaxFilterEnabled = 1;
	</script>
</body>
</html>