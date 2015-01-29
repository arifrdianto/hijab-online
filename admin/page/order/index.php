<?php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include './../lib/config.php';

switch ($_GET['act']) {
    case 'listorder':
    $jml_order = mysql_fetch_array(mysql_query("select count(order_id) as jml_order from orders"));
    ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">                        
                        <h3 class="box-title">List Order (<?php echo $jml_order['jml_order']; ?>)</h3>
                        <div class="box-tools">                            
                            <div class="input-group">
                                <input type="text" name="table_search" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <form name="formlist[0]" action="page/order/proses.php?page=order&act=aksilistorder" method="post">
                            <table class="table table-hover">
                                <tr>
                                    <th colspan="7">
                                        <div class="pull-left box-tools"> 
                                            <div class="btn-group">
                                                <button name="btnhapus" class="btn btn-sm"><i class="fa fa-trash-o"></i> Hapus</button>
                                                <button name="btnbatalproses" class="btn btn-warning btn-sm"><i class="fa fa-undo"></i> Batalkan Proses</button>
                                                <button name="btnproses" class="btn btn-primary btn-sm"><i class="fa fa-spinner"></i> Proses</button>
                                                <button name="btndikirim" class="btn btn-success btn-sm"><i class="fa fa-send-o"></i> Dikirim</button>
                                                <button name="btnbatal" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Cancel</button>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr style="background-color: #F3F4F5">
                                    <th style="text-align:center;"><input type="checkbox"  name="allbox" onclick="checkAll(0);" /></th>
                                    <th>Tgl. Order</th>
                                    <th>ID Pemesanan</th>
                                    <th>Status</th>
                                    <th>Nama Pemesan</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                                <?php
                                $d = mysql_query("select o.tgl_pesan, o.order_id, o.nama, o.status, o.dilihat, o.pelunasan, sum(od.qty) as item, sum(od.total) as subtotal from orders o, order_detail od where o.order_id=od.order_id group by od.order_id order by o.tgl_pesan desc ");
                                if (mysql_num_rows($d)>0) {
                                    while ($data = mysql_fetch_array($d)) {
                                        if ($data['status']=="Menunggu") {
                                            $label = "<span class=\"label label-warning\"><i class=\"fa fa-clock-o\"></i> ";
                                        } elseif ($data['status']=="Dalam Proses") {
                                            $label = "<span class=\"label label-primary\"><i class=\"fa fa-spinner\"></i> ";
                                        } elseif ($data['status']=="Dikirim") {
                                            $label = "<span class=\"label label-success\"><i class=\"fa fa-check\"></i> ";
                                        } else {
                                            $label = "<span class=\"label label-danger\"><i class=\"fa fa-times\"></i> ";
                                        }
                                        if ($data['dilihat']==0) {
                                            $bold = "font-weight:bold";
                                        } else {
                                            $bold = "font-weight:normal";
                                        }
                                        $pelunasan = ($data['pelunasan']=="1") ? '<i class="fa fa-check" style="color:#84AD05"></i>' : '';
                                ?>
                                <tr>
                                    <td align="center"><input type="checkbox" value="<?php echo $data['order_id']; ?>" name="id[]"/></td>
                                    <td style="<?php echo $bold ?>"><?php echo date('d/m/Y', strtotime($data['tgl_pesan'])); ?></td>
                                    <td style="<?php echo $bold ?>"><?php echo "<a href='?page=order&act=detilorder&id=$data[order_id]'>".$data['order_id']."</a> $pelunasan"; ?></td>
                                    <td style="<?php echo $bold ?>"><?php echo $label.$data['status']; ?></span></td>
                                    <td style="<?php echo $bold ?>"><?php echo $data['nama']; ?></td>
                                    <td style="<?php echo $bold ?>"><?php echo $data['item']; ?></td>
                                    <td style="<?php echo $bold ?>"><?php echo "Rp. ".number_format($data['subtotal'], 0,',','.'); ?></td>
                                </tr>  
                                <?php
                                    }
                                } else {
                                ?>
                                <tr>
                                    <td colspan="7" align="center">Tidak ada daftar pemesanan</td>
                                </tr>
                                <?php
                                }
                                ?>                        
                            </table>
                        </form>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
        <script type="text/javascript">
        //check all checkbox
        function checkAll(formlist) {
            for (var i=0;i<document.forms[formlist].elements.length;i++) {
                var e=document.forms[formlist].elements[i];
                if ((e.name !='allbox') && (e.type=='checkbox')) {
                    e.checked=document.forms[formlist].allbox.checked;
                }
            }
        }
        </script> 
        <?php
        break;

    case 'detilorder':
        $msg = "";
        //proses buton 
         if (isset($_POST['btndikirim'])) {
            $idord = $_POST['kodeord'];
            $proses = mysql_query("update orders set status='Dikirim' where order_id='$idord'");
            if ($proses) {
                $msg = "<div class=\"alert alert-success\" style=\"margin-bottom: 0!important;\">
                            <i class=\"fa fa-spinner\"></i>
                            <b>Sukses:</b> Status Pemesanan dikirim.
                        </div>"; 
            }
        }
        if (isset($_POST['btnproses'])) {
            $idord = $_POST['kodeord'];
            $proses = mysql_query("update orders set status='Dalam Proses' where order_id='$idord'");
            if ($proses) {
                $msg = "<div class=\"alert alert-info\" style=\"margin-bottom: 0!important;\">
                            <i class=\"fa fa-spinner\"></i>
                            <b>Sukses:</b> Pesanan akan segera diproses.
                        </div>"; 
            }
        }
        if (isset($_POST['btncancel'])) {
            $idord = $_POST['kodeord'];
            $proses = mysql_query("update orders set status='Batal' where order_id='$idord'");
            if ($proses) {
                $msg = "<div class=\"alert alert-success\" style=\"margin-bottom: 0!important;\">
                            <i class=\"fa fa-spinner\"></i>
                            <b>Cancel:</b> Pesanan berhasil dicancel.
                        </div>"; 
            }
        }

        //get informasi
        if (isset($_GET['id'])) {
            $kodeord = $_GET['id'];     
            $d = mysql_fetch_array(mysql_query("select o.order_id, o.nama, o.kota, o.provinsi, o.alamat, o.kodepos, o.phone, o.tgl_pesan, o.pelunasan, c.cust_fn, c.cust_mail from orders o, cust_users c where o.cust_id=c.cust_id and order_id='$kodeord'"));
            $c = mysql_query("select p.produk_nama, o.size, p.harga, o.qty, o.total from order_detail o, produk p where o.produk_id=p.produk_id and o.order_id='$kodeord'");
        
            //set dilihat menjadi 1
            mysql_query("update orders set dilihat='1' where order_id='$kodeord'");
        ?>
        <div class="pad margin no-print">
            <?php echo $msg; ?>
        </div>
        <section class="content invoice">                    
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <i class="fa fa-"></i> Detail Pemesanan
                        <small class="pull-right"></small>
                    </h2>                          
                </div><!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <address>
                        <strong><?php echo $d['nama']?></strong><br>
                        <?php echo $d['alamat']?><br>
                        <?php echo $d['kota']." ".$d['kodepos']?><br>
                        <?php echo $d['provinsi']?><br>
                        Phone: <?php echo $d['phone']?><br/>
                    </address>
                </div><!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    
                </div><!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>ID Pemesanan</b>
                    <h3 style="margin: 0"><?php echo $d['order_id']?></h3>
                    Tanggal: <?php echo date('d/m/Y', strtotime($d['tgl_pesan']))?><br/>
                    Akun: <?php echo $d['cust_fn']?> (<?php echo $d['cust_mail']?>)<br>
                    Pembayaran: <?php echo ($d['pelunasan']=="1") ? '<span style="color:#84AD05"><i class="fa fa-check-square-o"></i> Terverifikasi</span>' : '<span style="color:#F4543C"><i class="fa fa-clock-o"></i> Menunggu</span>'; ?>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="text-align:center">No</th>
                                <th>Produk</th>
                                <th style="text-align:center">Ukuran</th>
                                <th style="text-align:center">Harga</th>
                                <th style="text-align:center">Qty</th>
                                <th style="text-align:center">Total</th>
                            </tr>                                    
                        </thead>
                        <tbody>
                            <?php
                            $no=1;
                            while ($data = mysql_fetch_array($c)) {
                            ?>                                                                  
                            <tr>
                                <td align="center"><?php echo $no; ?></td>
                                <td style="text-align: left; width:40%;"><?php echo $data['produk_nama']; ?></td>
                                <td align="center"><?php echo $data['size']; ?></td>
                                <td align="center"><?php echo "Rp. ".number_format($data['harga'], 0,',','.'); ?></td>
                                <td align="center"><?php echo $data['qty']; ?></td>
                                <td align="center"><?php echo "Rp. ".number_format($data['total'], 0,',','.'); ?></td>                                             
                            </tr>   
                            <?php
                                $no++;
                            }
                            $sub = mysql_fetch_array(mysql_query("select sum(total) as subtotal from order_detail where order_id='$kodeord' group by order_id"));
                            ?>
                            <tr>
                                <td colspan="5" align="right"><strong>Subtotal</strong></td>
                                <td align="center"><strong><?php echo "Rp. ".number_format($sub['subtotal'], 0,',','.'); ?></strong></td>
                            </tr>  
                        </tbody>
                    </table>                            
                </div><!-- /.col -->
            </div><!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
                <div class="col-xs-12">
                    <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                    <form action="" method="post">
                        <input type="hidden" name="kodeord" value="<?php echo $d['order_id']?>">
                        <button name="btndikirim" class="btn btn-success pull-right" style="margin-right: 5px;"><i class="fa fa-send-o"></i> Dikirim</button>
                        <button name="btnproses" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-spinner"></i> Proses</button>
                        <button name="btncancel" class="btn pull-right" style="margin-right: 5px;"><i class="fa fa-times"></i> Cancel Pesanan</button>
                    </form>
                </div>
            </div>
        </section><!-- /.content -->
        <?php
        }        
        break;

    case 'pembayaran':
    $jml_p = mysql_fetch_array(mysql_query("select count(pembayaran_id) as jml_pembayaran from pembayaran"));
        ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">                        
                        <h3 class="box-title">Konfirmasi Pembayaran (<?php echo $jml_p['jml_pembayaran']; ?>)</h3>
                        <div class="box-tools">                            
                            <div class="input-group">
                                <input type="text" name="table_search" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <form name="formlist[0]" action="page/order/proses.php?page=order&act=aksipembayaran" method="post">
                            <table class="table table-hover" style="font-size:90%">
                                <tr>
                                    <th colspan="9">
                                        <div class="pull-left box-tools"> 
                                            <div class="">
                                                <button name="btnhapus" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
                                                <button name="btnbatal" class="btn btn-primary btn-sm"><i class="fa fa-undo"></i> Batalkan Verifikasi</button>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr style="background-color: #F3F4F5">
                                    <th style="text-align:center;"><input type="checkbox"  name="allbox" onclick="checkAll(0);" /></th>
                                    <th>Tgl. Transfer</th>
                                    <th>ID Pemesanan</th>
                                    <th>Bank</th>
                                    <th>Atas Nama</th>
                                    <th>Rek. Pemilik</th>
                                    <th>Rek. Tujuan</th>
                                    <th>Jumlah Transfer (Rp)</th>
                                    <th>Jumlah Tagihan (Rp)</th>
                                </tr>
                                <?php
                                $d = mysql_query("select t.tgl_transfer, t.order_id, t.bank, t.atas_nama, t.rek_cust, t.rek_admin, t.jml_transfer, t.ket, t.dilihat, o.pelunasan, sum(od.total) as subtotal from pembayaran t, orders o, order_detail od where t.order_id=od.order_id and t.order_id=o.order_id group by od.order_id order by t.pembayaran_id desc");
                                if (mysql_num_rows($d)>0) {
                                    while ($data = mysql_fetch_array($d)) {
                                        if ($data['pelunasan']=="1") {
                                            $label = "<i class=\"fa fa-check\" style=\"color:#84ad05 \"></i>";
                                        } else {
                                            $label = "";
                                        }

                                        if ($data['dilihat']==0) {
                                            $bold = "font-weight:bold";
                                        } else {
                                            $bold = "font-weight:normal";
                                        }
                                ?>
                                <tr>
                                    <td align="center"><input type="checkbox" value="<?php echo $data['order_id']; ?>" name="ordid[]"></td>
                                    <td style="<?php echo $bold ?>"><?php echo date('d/m/Y', strtotime($data['tgl_transfer'])); ?></td>
                                    <td style="<?php echo $bold ?>"><?php echo "<a href='?page=order&act=detilpembayaran&id=$data[order_id]'>".$data['order_id']."</a> ".$label; ?></td>
                                    <td style="<?php echo $bold ?>"><?php echo $data['bank']; ?></td>
                                    <td style="<?php echo $bold ?>"><?php echo $data['atas_nama']; ?></td>
                                    <td style="<?php echo $bold ?>"><?php echo $data['rek_cust']; ?></td>
                                    <td style="<?php echo $bold ?>"><?php echo $data['rek_admin']; ?></td>
                                    <td style="<?php echo $bold ?>"><?php echo number_format($data['jml_transfer'], 0,',','.'); ?></td>
                                    <td style="<?php echo $bold ?>"><?php echo number_format($data['subtotal'], 0,',','.'); ?></td>
                                </tr>  
                                <?php
                                    }
                                } else {
                                ?>
                                <tr>
                                    <td colspan="7" align="center">Tidak ada daftar pembayaran</td>
                                </tr>
                                <?php
                                }
                                ?>                        
                            </table>
                        </form>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
        <script type="text/javascript">
        //check all checkbox
        function checkAll(formlist) {
            for (var i=0;i<document.forms[formlist].elements.length;i++) {
                var e=document.forms[formlist].elements[i];
                if ((e.name !='allbox') && (e.type=='checkbox')) {
                    e.checked=document.forms[formlist].allbox.checked;
                }
            }
        }
        </script> 
        <?php
        break;

    case 'detilpembayaran':
        $msg = "";
        //proses verifikasi
        if (isset($_POST['btnverifikasi'])) {
            $idord = $_POST['kodeord'];
            $prosesverif = mysql_query("update orders set pelunasan='1' where order_id='$idord'");
            if ($prosesverif) {
                $msg = "<div class=\"alert alert-success\" style=\"margin-bottom: 0!important;\">
                            <i class=\"fa fa-check\"></i>
                            <b>Sukses:</b> Berhasil diverifikasi.
                        </div>"; 
            }
        }
         if (isset($_POST['btnbatalverifikasi'])) {
            $idord = $_POST['kodeord'];
            $prosesverif = mysql_query("update orders set pelunasan='0' where order_id='$idord'");
            if ($prosesverif) {
                $msg = "<div class=\"alert alert-info\" style=\"margin-bottom: 0!important;\">
                            <i class=\"fa fa-info\"></i>
                            <b>Sukses:</b> Verifikasi Pembayaran dibatalkan.
                        </div>"; 
            }
        }

        //proses get informasi
        if (isset($_GET['id'])) {
            $kodeord = $_GET['id'];     
            $d = mysql_fetch_array(mysql_query("select o.order_id, o.nama, o.kota, o.provinsi, o.alamat, o.kodepos, o.phone, o.tgl_pesan, o.pelunasan, c.cust_fn, c.cust_mail from orders o, cust_users c where o.cust_id=c.cust_id and order_id='$kodeord'"));
            $c = mysql_query("select p.produk_nama, o.size, p.harga, o.qty, o.total from order_detail o, produk p where o.produk_id=p.produk_id and o.order_id='$kodeord'");
        
            //set dilihat menjadi 1
            mysql_query("update pembayaran set dilihat='1' where order_id='$kodeord'");
        ?>
        <div class="pad margin no-print">
            <?php echo $msg; ?>
        </div>
        <section class="content invoice">                    
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <i class="fa fa-"></i> Detail Pembayaran
                        <small class="pull-right"></small>
                    </h2>                                              
                </div><!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <address>
                        <strong><?php echo $d['nama']?></strong><br>
                        <?php echo $d['alamat']?><br>
                        <?php echo $d['kota']." ".$d['kodepos']?><br>
                        <?php echo $d['provinsi']?><br>
                        Phone: <?php echo $d['phone']?><br/>
                    </address>
                </div><!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    
                </div><!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>ID Pemesanan</b>
                    <h3 style="margin: 0"><?php echo $d['order_id']?></h3>
                    Tanggal: <?php echo date('d/m/Y', strtotime($d['tgl_pesan']))?><br/>
                    Akun: <?php echo $d['cust_fn']?> (<?php echo $d['cust_mail']?>)<br>
                    Pembayaran: <?php echo ($d['pelunasan']=="1") ? '<span style="color:#84AD05"><i class="fa fa-check-square-o"></i> Terverifikasi</span>' : '<span style="color:#F4543C"><i class="fa fa-clock-o"></i> Menunggu</span>'; ?>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="text-align:center">No</th>
                                <th>Produk</th>
                                <th style="text-align:center">Ukuran</th>
                                <th style="text-align:center">Harga</th>
                                <th style="text-align:center">Qty</th>
                                <th style="text-align:center">Total</th>
                            </tr>                                    
                        </thead>
                        <tbody>
                            <?php
                            $no=1;
                            while ($data = mysql_fetch_array($c)) {
                            ?>                                                                  
                            <tr>
                                <td align="center"><?php echo $no; ?></td>
                                <td style="text-align: left; width:40%;"><?php echo $data['produk_nama']; ?></td>
                                <td align="center"><?php echo $data['size']; ?></td>
                                <td align="center"><?php echo "Rp. ".number_format($data['harga'], 0,',','.'); ?></td>
                                <td align="center"><?php echo $data['qty']; ?></td>
                                <td align="center"><?php echo "Rp. ".number_format($data['total'], 0,',','.'); ?></td>                                             
                            </tr>   
                            <?php
                                $no++;
                            }
                            $sub = mysql_fetch_array(mysql_query("select sum(total) as subtotal from order_detail where order_id='$kodeord' group by order_id"));
                            ?>
                            <tr>
                                <td colspan="5" align="right"><strong>Subtotal</strong></td>
                                <td align="center"><strong><?php echo "Rp. ".number_format($sub['subtotal'], 0,',','.'); ?></strong></td>
                            </tr>  
                        </tbody>
                    </table>                            
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row">
                <!-- accepted payments column -->
                <div class="col-xs-6">
                <!--kosongkan-->   
                </div><!-- /.col -->
                <?php
                 $p = mysql_fetch_array(mysql_query("select * from pembayaran where order_id='$kodeord'"));
                 ?>
                <div class="col-xs-6">
                    <p class="lead">Tgl. Transfer <?php echo date('d/m/Y', strtotime($p['tgl_transfer']))?></p>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th style="width:50%">Bank</th>
                                <td><?php echo $p['bank']?></td>
                            </tr>
                            <tr>
                                <th>Atas Nama</th>
                                <td><?php echo $p['atas_nama']?></td>
                            </tr>
                            <tr>
                                <th>No. Rekening</th>
                                <td><?php echo $p['rek_cust']?></td>
                            </tr>
                            <tr>
                                <th>Rek. Tujuan</th>
                                <td><?php echo $p['rek_admin']?></td>
                            </tr>
                            <tr>
                                <th>Jumlah Transfer</th>
                                <td><?php echo "Rp. ".number_format($p['jml_transfer'], 0,',','.');?></td>
                            </tr>
                            <tr>
                                <th>Jumlah Tagihan</th>
                                <td><?php echo "Rp. ".number_format($sub['subtotal'], 0,',','.');?></td>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <td><?php echo $p['ket']?></td>
                            </tr>
                        </table>
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <!-- this row will not appear when printing -->
            <div class="row no-print">
                <div class="col-xs-12">
                    <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                    <form action="" method="post">
                        <input type="hidden" name="kodeord" value="<?php echo $d['order_id']?>">
                        <button name="btnverifikasi" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-check-square-o"></i> Verifikasi</button>
                        <button name="btnbatalverifikasi" class="btn pull-right" style="margin-right: 5px;"><i class="fa fa-undo"></i> Batalkan Verifikasi</button>
                    </form>
                </div>
            </div>
        </section><!-- /.content -->
        <?php            
        }        
        break;

    default:
        ?>
        <label>404 Halaman tidak ditemukan</label>
        <?php
        break;
}
?>