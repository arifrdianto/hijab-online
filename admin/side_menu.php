<?php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include './../lib/config.php';

//query nilai notifikasi  
$notif = mysql_fetch_array(mysql_query("select count(order_id) as 'order' from orders where dilihat='0'"));
$notifp = mysql_fetch_array(mysql_query("select count(order_id) as 'pembayaran' from pembayaran where dilihat='0'"));
//menu admin
if ($_SESSION['level']=='Admin') {
    ?>
    <li>
        <a href="?page=dashboard">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a> 
    </li>
    <li>
        <a href="?page=order&act=listorder">
            <i class="fa fa-shopping-cart"></i> <span>List Order</span>
            <small class="badge pull-right bg-blue"><?php echo $notif['order']; ?></small>
        </a>
    </li>
    <li>
        <a href="?page=order&act=pembayaran">
            <i class="fa fa-credit-card"></i> <span>Konfirmasi</span>
            <small class="badge pull-right bg-green"><?php echo $notifp['pembayaran']; ?></small>
        </a>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-qrcode"></i>
            <span>Produk</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>    
        <ul class="treeview-menu">
            <li><a href="?page=produk&act=listproduk"><i class="fa fa-angle-double-right"></i> Produk List</a></li>
            <li><a href="?page=produk&act=addproduk"><i class="fa fa-angle-double-right"></i> Tambah Produk</a></li>
            <li><a href="?page=produk&act=listprodkategori"><i class="fa fa-angle-double-right"></i> Kategori Produk</a></li>
        </ul>
    </li>                        
    <li class="treeview">
        <a href="#">
            <i class="fa fa-newspaper-o"></i>
            <span>Berita</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="?page=berita&act=listberita"><i class="fa fa-angle-double-right"></i> Semua Berita</a></li>
            <li><a href="?page=berita&act=tulisberita"><i class="fa fa-angle-double-right"></i> Tulis Baru</a></li>
            <li><a href="?page=kategoriberita&act=listkategori"><i class="fa fa-angle-double-right"></i> Kategori Berita</a></li>
        </ul>    
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-user"></i>
            <span>Users Admin</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>    
        <ul class="treeview-menu">
            <li><a href="?page=users&act=listuser"><i class="fa fa-angle-double-right"></i> Users List</a></li>
            <li><a href="?page=users&act=buatuser"><i class="fa fa-angle-double-right"></i> Buat User</a></li>
        </ul>
    </li>
    <li>
        <a href="?page=cust&act=listcust">
            <i class="fa fa-users"></i>
            <span>Customers</span>
        </a> 
    </li>
<?php
//menu operator
} else {
?>
    <li>
        <a href="?page=dashboard">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a> 
    </li>
    <li>
        <a href="?page=order&act=listorder">
            <i class="fa fa-shopping-cart"></i> <span>List Order</span>
            <small class="badge pull-right bg-blue"><?php echo $notif['order']; ?></small>
        </a>
    </li>
    <li>
        <a href="?page=order&act=pembayaran">
            <i class="fa fa-credit-card"></i> <span>Konfirmasi</span>
            <small class="badge pull-right bg-green"><?php echo $notifp['pembayaran']; ?></small>
        </a>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-qrcode"></i>
            <span>Produk</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>    
        <ul class="treeview-menu">
            <li><a href="?page=produk&act=listproduk"><i class="fa fa-angle-double-right"></i> Produk List</a></li>
            <li><a href="?page=produk&act=addproduk"><i class="fa fa-angle-double-right"></i> Tambah Produk</a></li>
            <li><a href="?page=produk&act=listprodkategori"><i class="fa fa-angle-double-right"></i> Kategori Produk</a></li>
        </ul>
    </li>                        
    <li class="treeview">
        <a href="#">
            <i class="fa fa-newspaper-o"></i>
            <span>Berita</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="?page=berita&act=listberita"><i class="fa fa-angle-double-right"></i> Semua Berita</a></li>
            <li><a href="?page=berita&act=tulisberita"><i class="fa fa-angle-double-right"></i> Tulis Baru</a></li>
            <li><a href="?page=kategoriberita&act=listkategori"><i class="fa fa-angle-double-right"></i> Kategori Berita</a></li>
        </ul>    
    </li>
    <li>
        <a href="?page=cust&act=listcust">
            <i class="fa fa-users"></i>
            <span>Customers</span>
        </a> 
    </li>
<?php
}
?>