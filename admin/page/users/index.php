<?php
if($_SESSION['level']=="Sales"){
    //include './../lib/access_denied.php';
    die("Oops, akses tidak diizinkan!");
}
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include './../lib/config.php';
$proses = "page/users/proses.php";

switch ($_GET['act']) {
    case 'buatuser':
        ?>
        <div class="row">
            <section class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <i class="fa fa-user"></i>
                        <h3 class="box-title">Buat User Baru</h3>                
                    </div>
                    <div class="box-body">
                        <form name="userreg" method="post" action="page/users/proses.php?page=users&act=submit" onsubmit="return cek_pass()" class="form-horizontal" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Username</label>
                                <div class="col-md-4">
                                    <input type="text" name="username" class="form-control" placeholder="john" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Password</label>
                                <div class="col-md-4">
                                    <input type="password" name="pass" class="form-control" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Ulangi Password</label>
                                <div class="col-md-4">
                                    <input type="password" name="password" class="form-control" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Nama Lengkap</label>
                                <div class="col-md-4">
                                    <input type="text" name="fullname" class="form-control" placeholder="John Lenon" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Email</label>
                                <div class="col-md-4">
                                    <input type="email" name="email" class="form-control" placeholder="john@gmail.com">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">No. Telp</label>
                                <div class="col-md-4">
                                    <input type="text" name="telp" class="form-control" placeholder="08123456787">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Hak Akses</label>
                                <div class="col-md-4">
                                    <select name="level" class="form-control" required>
                                        <option>Pilih Level</option>
                                        <option value="Admin">Administrator</option>
                                        <option value="Sales">Sales</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Foto Profile*</label>
                                <div class="col-md-4">                                    
                                    <!--<img src="./../upload/users/<?php echo $d['avatar'];?>" class="img-thumbnail img-responsive" style="width: auto; height: 255px;">-->
                                    <div class="thumbnail">
                                        <img id="img_prev" src="./../assets/img/nopreview.jpg" style="width:100%;height:auto;"/>
                                        <div class="caption">
                                            <span class="btn btn-default fileinput-button">
                                                <i class="glyphicon glyphicon-camera"></i>                              
                                                <input type="file" id="fileupload" name="avatar" onchange="readURL(this);" >
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">   
                                <div class="col-md-offset-4 col-md-4">
                                    <input type="submit" class="btn btn-primary" value="Buat User">
                                </div>
                            </div>
                        </form>
                    </div><!-- /.box-body -->            
            </section>
        </div>
        <script type="text/javascript">
            function cek_pass(){
                if (userreg.password.value!=userreg.pass.value){
                    alert("Password tidak sama, silahkan ulangi");
                    userreg.pass.value="";
                    userreg.password.value="";
                    userreg.pass.focus()
                    return false
                }
                return true
            }
        </script>
        <?php
        break;
    case 'edituser':
        $id = $_GET['id'];
        $q = mysql_query("select * from users where user_id='$id'");
        $d = mysql_fetch_array($q);

        ?>
        <div class="row">
            <section class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <i class="fa fa-user"></i>
                        <h3 class="box-title">Edit Profile</h3> 
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <a class="btn btn-default btn-sm" onclick="history.back();" ><i class="fa fa-arrow-circle-o-left"></i> Kembali</a>
                        </div><!-- /. tools -->                      
                    </div>
                    <div class="box-body">
                        <form method="post" action="page/users/proses.php?page=users&act=updateuser&id=<?php echo $d['user_id']; ?>" class="form-horizontal" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Nama Lengkap</label>
                                <div class="col-md-4">                                    
                                    <input type="text" name="fullname" class="form-control" value="<?php echo $d['fullname']; ?>" required>                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Email</label>
                                <div class="col-md-4">
                                    <input type="email" name="email" class="form-control" value="<?php echo $d['email']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">No. Telp</label>
                                <div class="col-md-4">
                                    <input type="text" name="telp" class="form-control" value="<?php echo $d['no_telp']; ?>">
                                </div>
                            </div>
                            <?php
                            if ($_SESSION['level']=="Admin") {
                            ?> 
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Hak Akses</label>
                                    <div class="col-md-4">
                                        <select name="level" class="form-control" required>
                                            <option disabled="disabled">Pilih Level</option>
                                            <option value="Admin" <?php echo $d['level']=="Admin" ? 'selected="selected"' : ''?>>Administrator</option>
                                            <option value="Sales" <?php echo $d['level']=="Sales" ? 'selected="selected"' : ''?>>Sales</option>
                                        </select>
                                    </div>
                                </div>   
                            <?php
                            } else {
                                echo "<input type='hidden' name='level' value='".$d['level']."'>";
                            }

                            ?>                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">Foto Profile*</label>
                                <div class="col-md-4">
                                    <input type="hidden" name="avatar" value="<?php echo $d['avatar'];?>">
                                    <!--<img src="./../upload/users/<?php echo $d['avatar'];?>" class="img-thumbnail img-responsive" style="width: auto; height: 255px;">-->
                                    <div class="thumbnail">
                                        <img id="img_prev" src="./../upload/users/<?php echo $d['avatar'];?>" style="width:100%;height:auto;"/>
                                        <div class="caption">
                                            <span class="btn btn-default fileinput-button">
                                                <i class="glyphicon glyphicon-camera"></i>                              
                                                <input type="file" id="fileupload" name="avatar" onchange="readURL(this);" >
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Username*</label>
                                <div class="col-md-4">
                                    <input type="text" name="username" class="form-control" placeholder="<?php echo $d['username'];?>">                                   
                                </div>
                            </div>
                            <div class="form-group">   
                                <div class="col-md-offset-4 col-md-4">
                                    <label style="font-weight:normal; font-style:italic; margin-top:0; padding-top:0">*) Kosongkan jika tidak diganti</label>
                                </div>
                            </div>
                            <div class="form-group">   
                                <div class="col-md-offset-4 col-md-4">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-body -->            
            </section>
        </div>

        <!-- ganti password-->
        <div class="row">
            <section class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <i class="fa fa-lock"></i>
                        <h3 class="box-title">Ganti Password</h3>                          
                    </div>
                    <div class="box-body">
                        <form name="gantipass" method="post" action="page/users/proses.php?page=users&act=updatepass&id=<?php echo $d['user_id']; ?>" onsubmit="return cek_pass()" class="form-horizontal" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Password Sekarang</label>
                                <div class="col-md-4">
                                    <input type="password" name="current_pass" class="form-control" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Password Baru</label>
                                <div class="col-md-4">
                                    <input type="password" name="pass" class="form-control" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Ulangi Password</label>
                                <div class="col-md-4">
                                    <input type="password" name="password" class="form-control" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" required>
                                </div>
                            </div>
                            <div class="form-group">   
                                <div class="col-md-offset-4 col-md-4">
                                    <input type="submit" class="btn btn-primary" value="Ganti Password">
                                </div>
                            </div>
                        </form>
                    </div><!-- /.box-body -->            
            </section>
        </div>
        <script type="text/javascript">            
            function cek_pass(){
                if (gantipass.password.value!=gantipass.pass.value){
                    alert("Password tidak sama, silahkan ulangi");
                    gantipass.pass.value="";
                    gantipass.password.value="";
                    gantipass.pass.focus()
                    return false
                }
                return true
            }
        </script>
        <?php
        break;    
    case 'listuser':        
        ?>
        <div class="row">
            <section class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <i class="fa fa-user"></i>
                        <h3 class="box-title">Daftar User Administrator</h3>                
                    </div>
                    <div class="box-body table-responsive">
                       <table class="table table-bordered">
                            <tr>
                                <th  style="width: 10px; text-align:center">No</th>
                                <th style="text-align:center">Username</th>
                                <th style="text-align:center">Nama Lengkap</th>
                                <th style="text-align:center">Email</th>
                                <th style="text-align:center">No. Telp</th>
                                 <th style="text-align:center">Hak Akses</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                            
                            <?php
                            $query_user = mysql_query("select * from users order by level");
                            $no = 1;
                            while ($user = mysql_fetch_array($query_user)) {
                                echo "<tr>
                                    <td align='center'>$no</td>
                                    <td>".$user['username']."</td>
                                    <td>".$user['fullname']."</td>
                                    <td>".$user['email']."</td>
                                    <td align='center'>".$user['no_telp']."</td>
                                    <td align='center'>".$user['level']."</td>
                                    <td align='center'>
                                        <a href='?page=users&act=edituser&id=$user[user_id]'>Edit</a> | 
                                        <a href='$proses?page=users&act=hapususer&id=$user[user_id]&filename=$user[avatar]' onclick='return confirm(\"Apakah anda yakin akan menghapusnya?\");'>Hapus</a>
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
    default:
        ?>
        <label>404 Halaman tidak ditemukan</label>
        <?php
        break;
}
?>