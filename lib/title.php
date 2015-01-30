<?php
if (isset($_GET['id'])) {
	$judulitem = mysql_fetch_array(mysql_query("select produk_nama from produk where produk_id='$_GET[id]'"));
	echo "$judulitem[produk_nama] - UMIL Charshaf";
} elseif (isset($_GET['bid'])) {
	$judulberita = mysql_fetch_array(mysql_query("select judul from berita where berita_id='$_GET[bid]'"));
	echo "$judulberita[judul] - UMIL Charshaf";
} else {
	echo "UMIL Charshaf - shine and syar'i";
}
?>