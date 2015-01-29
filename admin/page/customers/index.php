
<?php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include './../lib/config.php';


switch ($_GET['act']) {
	case 'listcust':
		?>
		<div class="row">
            <section class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <i class="fa fa-users"></i>
                        <h3 class="box-title">Daftar Customers</h3>                
                    </div>
                    <div class="box-body table-responsive">
                       <table class="table table-bordered">
                            <tr>
                                <th  style="width: 10px; text-align:center">No</th>                                
                                <th style="text-align:center">Nama Lengkap</th>
                                <th style="text-align:center">Email</th>
                                <th style="text-align:center">Status</th>
                                <th style="text-align:center">Tgl. Daftar</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                            
                            <?php
                            $query_user = mysql_query("select * from cust_users");
                            $no = 1;
                            while ($user = mysql_fetch_array($query_user)) {
                            	if ($user['status']=="Y") {
                            		$status = "<i class='fa fa-check' style='color:#84ad05;'></i>";
                            	} else {
                            		$status = "<i class='fa fa-times' style='color:#e30b13;'></i>";
                            	}
                                echo "<tr>
                                    <td align='center'>$no</td>
                                    <td>".$user['cust_fn']."</td>
                                    <td>".$user['cust_mail']."</td>
                                    <td align='center'>$status</td>
                                    <td align='center'>".date('d M y', strtotime($user['tgl_daftar']))."</td>                                    
                                    <td align='center'>
                                        <a href='?page=cust&act=editcust&id=$user[cust_id]'>Edit</a> | 
                                        <a href='page/customers/proses.php?page=cust&act=delete&id=$user[cust_id]' onclick='return confirm(\"Apakah anda yakin akan menghapusnya?\");'>Hapus</a>
                                    </td></tr>";
                                $no++;
                            }
                            ?>                        
                            </tr>                           
                        </table>
                    </div><!-- /.box-body -->            
            </section>
        </div>
		<?php
		break;
	case 'editcust':
        $id = $_GET['id'];
        $q = mysql_query("select * from cust_users where cust_id='$id'");
        $d = mysql_fetch_array($q);
        ?>
        <div class="row">
            <section class="col-md-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Edit User Customer</h3>  
                        <div class="pull-right box-tools">
                            <a class="btn btn-default btn-sm" onclick="history.back();" ><i class="fa fa-arrow-circle-o-left"></i> Kembali</a>
                        </div>                        
                    </div>
                    <div class="box-body">
                        <dl class="dl-horizontal">
                            <form method="post" action="page/customers/proses.php?page=cust&act=update">
                                <dt>Nama Lengkap</dt>
                                <dd>: <?php echo $d['cust_fn']?></dd>
                                <dt>Email</dt>
                                <dd>: <?php echo $d['cust_mail']?></dd>
                                <dt>Status</dt>
                                <dd>:
                                <label class="radio-inline">
                                    <input type="radio" name="status" value="Y" <?php echo $d['status']=="Y" ? 'checked' : '' ;?>> Aktif
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="status" value="N" <?php echo $d['status']=="N" ? 'checked' : '' ;?>> Blokir
                                </label>
                                </dd>
                                
                                <dt>&nbsp;</dt>
                                <dd>&nbsp;</dd>
                                <dt>&nbsp;</dt>
                                <dd>
                            
                                <input type="hidden" name="id" value="<?php echo $d['cust_id'];?>"/>
                                <input type="submit" value="Update" class="btn btn-primary btn-sm">
                            </form>
                            <!--<a href="?page=profile&act=editprofile" class="btn btn-primary btn-sm">Edit Profil</a>-->  
                            </dd>                                  
                        </dl>                      
                    </div>
                </div><!-- /.box-body -->            
            </section>
        </div>
        <?php
        break;
	default:
		# code...
		break;
}
		