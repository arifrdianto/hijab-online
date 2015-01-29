<?php
switch ($_GET['page']) {
	case 'home':
		include 'pages/home/index.php';
		break;
	
	case 'produk':
		include 'pages/produk/index.php';
		break;

	case 'order':
		include 'pages/order/index.php';
		break;

	case 'blog':
		include 'pages/blog/index.php';
		break;

	case 'customers':
		include 'pages/cust/index.php';
		break;

	case 'about':
		include 'pages/about/index.php';
		break;

	default:

		# code...
		break;
}
?>