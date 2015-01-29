<?php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include 'lib/config.php';
include 'lib/fungsi_seo.php';
include 'lib/addtocart.php';

$pesan="";
switch ($_GET['act']) {
	case 'katalog':
		?>
		<div style="padding-top: 120px; margin-bottom: 20px;">
			<div class="container clear">
				<h3 class="title">Katalog Produk</h3>
				<hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 20px;">
				<form class="form" action="" method="post">
					<label>Pilih Kategori</label>
					<select name="p_kategori" onchange="this.form.submit();">
		                <option value="0">Semua Kategori</option>
		                <?php               
		                $result = mysql_query("select * from produk_kategori order by pk_nama");
		                while ($kategori = mysql_fetch_array($result)) {
		                    if (isset($_POST['p_kategori'])) {          
			                    if ($_POST['p_kategori']==$kategori['pk_id']) {
			                        echo "<option value='$kategori[pk_id]' selected>".ucwords(implode(' ', explode('-', $kategori['pk_nama'])))."</option>";
			                     
			                	} else {
		                        	echo "<option value='$kategori[pk_id]'>".ucwords(implode(' ', explode('-', $kategori['pk_nama'])))."</option>";
		                    	}
		                    } elseif (isset($_GET['kid'])) {
		                    	$id = explode('-', $_GET['kid']);
		                    	if ($id[0]==$kategori['pk_id']) {
			                        echo "<option value='$kategori[pk_id]' selected>".ucwords(implode(' ', explode('-', $kategori['pk_nama'])))."</option>";
			                     
			                	} else {
		                        	echo "<option value='$kategori[pk_id]'>".ucwords(implode(' ', explode('-', $kategori['pk_nama'])))."</option>";
		                    	}
		                    } else {
		                    	echo "<option value='$kategori[pk_id]'>".ucwords(implode(' ', explode('-', $kategori['pk_nama'])))."</option>";
		                    }           
		                }
		                ?>
		            </select>
		            <?php            
		            
		            if (isset($_POST['p_kategori'])) {
		            	if ($_POST['p_kategori']==0) {
		            		$query_p = mysql_query("select * from produk order by produk_id desc");
		            	} else {
				        	$query_p = mysql_query("select * from produk where pk_id = '$_POST[p_kategori]' order by produk_id desc");
			            } 
		            } elseif (isset($_GET['kid'])) {
		            	$query_p = mysql_query("select * from produk where pk_id = '$_GET[kid]' order by produk_id desc");
		            } else {
		            	$query_p = mysql_query("select * from produk order by produk_id desc");
		            }
		            ?>
				</form>
			</div>
		</div>
			
		<div class="product">
			<div class="container">			
				<ul>
					<?php			
					while ($p = mysql_fetch_array($query_p)) {
						if ($p['stok']!=0) {
							$stok = "Tersedia";
						} else {
							$stok = "Habis";
						}
						$nama_seo = seo_title($p['produk_nama']);
						echo				
							"<a href=\"item-$p[produk_id]-$nama_seo\">
								<li class=\"product-item\">
									<div class=\"product-thumb\">
										<img src=\"upload/produk/thumb/$p[image]\" alt=\"$p[produk_nama]\">
									</div>
									<div class=\"desc\">
										<h4>$p[produk_nama]</h4>
										<div class=\"descrip\">
											<p>$stok</p>
											<p>Rp. $p[harga]</p>
										</div>
									</div>						
								</li>
							</a>";	
					}
					?>			
				</ul>
			</div>
		</div>
		<?php
		break;
	
	case 'detailproduk':
	$detail = mysql_query("SELECT * FROM produk p, produk_kategori pk
							WHERE p.pk_id=pk.pk_id 
							AND p.produk_id='$_GET[id]'");
	$d = mysql_fetch_array($detail);	

	//update dilihat
	mysql_query("update produk set dilihat=$d[dilihat]+1 where produk_id='$_GET[id]'");
	//$pesan = "";


	//session addtocart
	if (isset($_POST['add'])) {
		
		if($_POST['produkid']>0){
			$pid=$_POST['produkid'];
			$q=$_POST['qty'];
			$s=$_POST['ukuran'];
			//addtocart($pid,$q,$s);
			if(produk_exist($pid)){
				$pesan = "<div class=\"msg msg-warn\"><i class=\"fa fa-warning\" style='vertical-align:middle'></i> \"$d[produk_nama]\" Sudah ada di <a href=\"cart\">shopping cart</a> kamu.</div>";
			} else { 
				if ($_POST['qty']<=$d['stok']) {
					$max=count($_SESSION['cart']);
					$_SESSION['cart'][$max]['produkid']=$pid;
					$_SESSION['cart'][$max]['qty']=$q;
					$_SESSION['cart'][$max]['size']=$s;

					$pesan = "<div class=\"msg msg-sukses\"><i class=\"fa fa-check-square-o\" style='vertical-align:middle'></i> \"$d[produk_nama]\" Berhasil ditambahkan ke <a href=\"cart\">shopping cart</a> kamu.</div>";
					$_SESSION['subtotal']+=($_POST['harga']*$_POST['qty']);
				} else {
					$pesan = "<div class=\"msg msg-warn\"><i class=\"fa fa-warning\" style='vertical-align:middle'></i> Kamu tidak bisa menambahkan \"$d[produk_nama]\" ke cart, karena melebehi stok ($d[stok] tersedia)</div>";
				}
			}
			//header("location:shoppingcart.php");
			//exit();
			//$_SESSION['subtotal']+=($_POST['harga']*$_POST['qty']);		
			//$pesan = "<div class=\"msg msg-warn\"><i class=\"fa fa-warning\" style='vertical-align:middle'></i> \"$d[produk_nama]\" Sudah ada di <a href=\"cart\">shopping cart</a></div>";		
			//$pesan = "<div class=\"msg msg-sukses\"><i class=\"fa fa-check-square-o\" style='vertical-align:middle'></i> \"$d[produk_nama]\" Berhasil ditambahkan ke <a href=\"cart\">shopping cart</a></div>";
		}
	}
	?>
		<div class="detail">
			<div class="container clear">
				<?php echo $pesan; ?>
				<div class="detail-thumb">
					<div class="detail-bg-thumb">
						<img id="zoom_01" src="upload/produk/<?php echo $d['image'] ?>" data-zoom-image="upload/produk/<?php echo $d['image'] ?>" alt="">
					</div>
				</div>
				<div class="detail-desc">
					<form action="" method="post" class="form">
						<table border="1px" cellspacing="10" cellpadding="10" style="width:100%">
							<tr>
								<td colspan="2">
									<h3><?php echo $d['produk_nama'] ?></h3>
									<input type="hidden" name="produkid" value="<?php echo $d['produk_id'] ?>">
									<input type="hidden" name="harga" value="<?php echo $d['harga'] ?>">
								</td>
							</tr>
							<tr>
								<td width="40%">Bahan</td>
								<td width="60%"><?php echo $d['bahan'] ?></td>
							</tr>
							<tr>
								<td>Warna</td>
								<td><?php echo $d['warna'] ?></td>
							</tr>
							<tr>
								<td>Ukuran</td>
								<td>
									<select name="ukuran" width="auto">		
									<?php //echo $d['ukuran'] 
									//echo $ukuran = implode(', ', explode(' ', $d['ukuran']));
									$ukuran = explode(' ', $d['ukuran']);
									foreach ($ukuran as $size) {
										echo "<option value='$size'>$size</option>";
									}
									?>
									</select>
								</td>
							</tr>														
							<tr>
								<td>Qty</td>
								<td>
									<div class="qty-block quantity buttons_added">
										<input type="button" value="-" class="minus">
										<input name="qty" type="text" step="1" name="quantity" value="1" title="Qty" class="input-qty qty" size="1" min="1" max="<?php echo $d['stok'] ?>">
										<input type="button" value="+" class="plus">
									</div>
								<!--<input name="qty" type="number" value="1" min="1" max="<?php echo $d['stok'] ?>" size="2" style="text-align:center">-->
								</td>
							</tr>
							<tr>
								<td>Harga</td>
								<td><h4>Rp. <?php echo number_format($d['harga'], 0,',','.'); ?></h4></td>
							</tr>
							<tr>
								<td colspan="2"><button name="add" class="buton primary" onclick="document.location.reload(true);"><i class="fa fa-shopping-cart"></i> ADD TO CART</button></td>
							</tr>
							<tr>
								<td colspan="2"><small style="font-size: 75%">Tersedia <?php echo $d['stok'] ?> dalam stok</small>
								<br>Kategori : <a href="item-kategori-<?php echo $d['pk_id']."-".$d['pk_nama']; ?>" style="font-style:italic; text-decoration: underline"><?php echo strtolower(implode(' ', explode('-', $d['pk_nama']))); ?></a></td>
							</tr>						
						</table>
					</form>
				</div>
			</div>
		</div>
		<div class="product">
			<div class="container">
				<h3 class="title">Terlaris</h3>
				<ul>
					<?php
					$query_p = mysql_query("select * from produk order by dilihat desc limit 4");
					
					while ($p = mysql_fetch_array($query_p)) {
						if ($p['stok']!=0) {
							$stok = "Tersedia";
						} else {
							$stok = "Habis";
						}
						$nama_seo = seo_title($p['produk_nama']);
						//<a href=\"item-$p[produk_id]-$nama_seo\">
						echo				
							"<a href=\"item-$p[produk_id]-$nama_seo\">
								<li class=\"product-item\">
									<div class=\"product-thumb\">
										<img src=\"upload/produk/thumb/$p[image]\" alt=\"$p[produk_nama]\">
									</div>
									<div class=\"desc\">
										<h4>$p[produk_nama]</h4>
										<div class=\"descrip\">
											<p>$stok</p>
											<p>Rp. $p[harga]</p>
										</div>
									</div>						
								</li>
							</a>";	
					}
					?>			
				</ul>
			</div>
		</div>	
		
		<?php
		break;

	default:
		# code...
		break;
}
?>
	