<?php 
if (!isset($_GET['page'])) {
	include 'page/dashboard/index.php';
} else {
	switch ($_GET['page']) {
		case 'dashboard':
			include 'page/dashboard/index.php';
			break;

		case 'order':
			include 'page/order/index.php';
			break;

		case 'produk':
			include 'page/produk/index.php';
			break;

		case 'berita':
			include 'page/berita/index.php';
			break;

		case 'kategoriberita':
			include 'page/berita/kategori.php';
			break;

		case 'users':
			include 'page/users/index.php';
			break;

		case 'profile':
			include 'page/users/profile.php';
			break;

		case 'cust':
			include 'page/customers/index.php';
			break;	

		default:	        
	        echo "<label>404 Halaman tidak ditemukan</label>";
	        
	        break;
		
	}
}
?>