<?php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include 'lib/config.php';

switch ($_GET['act']) {
	case 'sign':	
	$pesan="";
	if (isset($_POST['login'])) {
		
			$usercust = mysql_real_escape_string($_POST['usercust']);
			$passcust = md5($_POST['passcust']);
		
			$cek_query = mysql_query("select * from cust_users where  cust_mail = '$usercust' and cust_pass = '$passcust'");
			$cek_user = mysql_num_rows($cek_query);
			$data_user = mysql_fetch_array($cek_query);


			if ($cek_user != 0) {
				if ($data_user['status'] == "Y") {
					$_SESSION['cust'] = $data_user['cust_fn'];	
					$_SESSION['ecust'] = $data_user['cust_mail'];
					$_SESSION['custid'] = $data_user['cust_id'];
					
					header('location:akun-saya');
				} else {
					$pesan = "<div class=\"msg msg-error\"><i class=\"fa fa-times\" style='vertical-align:middle'></i> Oops, Email user diblokir</div>";
				}	
				
			} else {
				//header('location:../../index');
				$pesan = "<div class=\"msg msg-error\"><i class=\"fa fa-times\" style='vertical-align:middle'></i> Oops, kombinasi email dan password salah</div>";
			}
		 
	} elseif (isset($_POST['signup'])) {
		$cekmail = mysql_num_rows(mysql_query("select cust_mail from cust_users where cust_mail='$_POST[emailcust]'"));
		if ($cekmail != 0) {
			$pesan = "<div class=\"msg msg-warn\"><i class=\"fa fa-warning\" style='vertical-align:middle'></i> Email sudah terdaftar, silahkan login</div>";
		} else {
			if ($_POST['passc']!=$_POST['passcust']) {
				$pesan = "<div class=\"msg msg-error\"><i class=\"fa fa-times\" style='vertical-align:middle'></i> Oops, terjadi kesalahan password tidak sama</div>";
			} else {
				$fncust = $_POST['fullnamecust'];
				$ecust = $_POST['emailcust'];
				$pcust = md5($_POST['passcust']);
				mysql_query("insert into cust_users values('', '$fncust', '$ecust', '$pcust', 'Y', now())");
				$_SESSION['ecust']=$ecust;
				$_SESSION['cust']=$fncust;
				header('location:akun-saya');				
			} 
		}
	}
	?>
		<div style="padding-top: 120px; padding-bottom: 50px;">
			<div class="container clear">
				<h3 class="title">Masuk</h3>
				<?php echo $pesan; ?>
				
				<div class="box-cust login-cust">
					<div class="log-head">
						<i class="fa fa-sign-in"></i>
						<h4>Sudah Punya Akun?</h4>
						<small>Silahkan login, untuk melanjutkan</small>
					</div>
					<form action="" method="post" class="form form-cust">
						<label for="user">Email</label>
						<input type="email" name="usercust" id="user">
						<label for="pass">Password</label>
						<input type="password" name="passcust" id="pass">
						<p><input type="submit" name="login" value="LOGIN" class="buton primary" style="width:auto; float:right; margin: 15px 0;"></p>
					</form>
				</div>
				<div class="or-cust">Atau</div>
				<div class="box-cust sign-cust">					
					<div class="log-head">
						<i class="fa fa-user"></i>
						<h4>Customer Baru?</h4>
						<small>Silahkan mendaftar, untuk bergabung</small>
					</div>
					<form action="" method="post" class="form form-cust">
						<label for="fn">Nama Lengkap<span class="required">*</span></label>
						<input type="text" name="fullnamecust" id="fn" required>
						<label for="ec">Email<span class="required">*</span></label>
						<input type="email" name="emailcust" id="ec" required>
						<label for="p">Password<span class="required">*</span></label>
						<input type="password" name="passc" id="p" required>
						<label for="rp">Ulangi Password<span class="required" required>*</span></label>
						<input type="password" name="passcust" id="rp">
						<p><input name="signup" type="submit" value="DAFTAR" class="buton primary" style="width:auto; float:right; margin: 15px 0;"></p>
					</form>
				</div>
			</div>
		</div>
		<?php 
		break;
	
	case 'logout':
		unset($_SESSION['ecust']);
		unset($_SESSION['cust']);		
		unset($_SESSION['custid']); 
	
		//echo "<script>window.location.current();</script>";
		header('location:index');
		break;

	case 'akunsaya':
		if (empty($_SESSION['ecust'])) {
				header('location:sign');
			} else {
				$custid = $_SESSION['custid'];
				
				//$c = mysql_query("select p.produk_nama, o.size, p.harga, o.qty, o.total from order_detail o, produk p where o.produk_id=p.produk_id and o.cust_id='$custid'");
				//$sub = mysql_fetch_array(mysql_query("select sum(total) as subtotal from order_detail where order_id='$kodeord' group by order_id"));
			?>
			<div class="shop-cart">
				<div class="container clear">
					<h3 class="title">Akun Saya</h3>
					<hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 20px;">
					<p>Hello <b><?php echo $_SESSION['cust']."</b> (".$_SESSION['ecust'].") selamat datang di Umil Charshaf, show your inner beauty - shine and syar'i";?></p>
					<br><br>
					<h4>HISTORY BELANJA</h4>
					<table class="listprod">
						<tr>
							<th>NO</th>
							<th style="width:15%">TGL. PEMESANAN</th>
							<th>ID PEMESANAN</th>
							<th>NAMA PEMESAN</th>
							<th>ITEM</th>
							<th>SUBTOTAL</th>
							<th>SATUS</th>
						</tr>	
						<?php
						$no=1;
						$d = mysql_query("select o.tgl_pesan, o.order_id, o.nama, o.status, sum(od.qty) as item, sum(od.total) as subtotal from orders o, order_detail od where o.order_id=od.order_id and o.cust_id='$custid' group by od.order_id");
						if (mysql_num_rows($d)>0) {
							while ($data = mysql_fetch_array($d)) {
						?>																	
						<tr>
							<td><?php echo $no; ?></td>
							<td><?php echo date('d/m/Y', strtotime($data['tgl_pesan'])); ?></td>
							<td><?php echo "<a href='detail-id-pemesanan-$data[order_id]'>".$data['order_id']."</a>"; ?></td>
							<td><?php echo $data['nama']; ?></td>
							<td><?php echo $data['item']; ?></td>
							<td><?php echo "Rp. ".number_format($data['subtotal'], 0,',','.'); ?></td>
							<td><?php echo $data['status']; ?></td>
						</tr>	
						<?php
							$no++;
							}
						}else{
							?>
						<tr>
							<td colspan="7">Tidak ada history belanja</td>
						</tr>
							<?php
						}
						?>				
					</table>
				</div>
			</div>
			<?php
		}
		break;

	case 'detailpemesanan':
		if (empty($_SESSION['ecust'])) {
				header('location:sign');
			} else {
			$kodeord = $_GET['pid'];		
			$d = mysql_fetch_array(mysql_query("select * from orders where order_id='$kodeord'"));
			$c = mysql_query("select p.produk_nama, o.size, p.harga, o.qty, o.total from order_detail o, produk p where o.produk_id=p.produk_id and o.order_id='$kodeord'");		
			?>
			<div class="shop-cart">
				<div class="container clear">
					<div class="clear">
						<div style="float:left">
							<h3 class="title" style="">DETAIL PEMESANAN</h3>
						</div>
						<div style="float:right">
							<button class="buton" onclick="history.back();">KEMBALI</button>
						</div>
					</div>
					<hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 20px;">
					<div class="clear">
						<div style="float:left">
							<?php 
								
							?>
							<table class="inv">
								<tr>
									<td colspan="3"><h4>Customer</h4></td>
								</tr>
								<tr>
									<td width="">Nama</td>
									<td>: </td>
									<td><?php echo $d['nama']?></td>
								</tr>
								<tr>
									<td>Kota</td>
									<td>: </td>
									<td><?php echo $d['kota']?></td>
								</tr>
								<tr>
									<td>Provinsi</td>
									<td>: </td>
									<td><?php echo $d['provinsi']?></td>
								</tr>
								<tr>
									<td>Alamat</td>
									<td>: </td>
									<td><?php echo $d['alamat']." ".$d['kodepos']?></td>
								</tr>
								<tr>
									<td>No. Handphone</td>
									<td>: </td>
									<td><?php echo $d['phone']?></td>
								</tr>
							</table>
						</div>
						<div class="clear" style="float:right;text-align:right;">
							<p>Tanggal : <?php echo date('d/m/Y', strtotime($d['tgl_pesan']))?></p>
							<p style="font-size: 16px; font-family: 'ProximaNova-Bold', sans-serif;">No. ID Pemesanan</p>
							<h2><?php echo $d['order_id']?></h2>
						</div>
					</div>
					<div class="clear" style="margin:20px 0;">
						<table class="listprod">
							<tr>
								<th>NO</th>
								<th>PRODUK</th>
								<th>SIZE</th>
								<th>HARGA</th>
								<th>QTY</th>
								<th>TOTAL</th>
							</tr>	
							<?php
							$no=1;
							while ($data = mysql_fetch_array($c)) {
							?>																	
							<tr>
								<td><?php echo $no; ?></td>
								<td style="text-align: left; width:40%;"><?php echo $data['produk_nama']; ?></td>
								<td><?php echo $data['size']; ?></td>
								<td><?php echo "Rp. ".number_format($data['harga'], 0,',','.'); ?></td>
								<td><?php echo $data['qty']; ?></td>
								<td><?php echo "Rp. ".number_format($data['total'], 0,',','.'); ?></td>												
							</tr>	
							<?php
								$no++;
							}
							?>																	

							<tr>
								<td colspan="5"><div class="pull-right">SUB TOTAL</div></td>
								<td>
									<div class="subtotal">
										<?php 
										$sub = mysql_fetch_array(mysql_query("select sum(total) as subtotal from order_detail where order_id='$kodeord' group by order_id"));
										echo "Rp. ".number_format($sub['subtotal'], 0,',','.'); 
										?>
									</div>
								</td>
							</tr>					
						</table>
					</div>
				</div>
			</div>
			<?php
		}
		break;

	default:
		# code...
		break;
}
?>