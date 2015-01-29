<?php 
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include './../lib/config.php';
$proses = "page/berita/proses.php";


switch ($_GET['act']) {
    case 'listberita':
    if ($_SESSION['level'] == "Admin") {
        $jml_berita_query = mysql_query("select count(berita_id) as 'jml' from berita");

        $query_berita = mysql_query("select b.judul, k.kategori_nama, u.username, b.tanggal, b.dibaca, b.status, b.berita_id, b.gambar from berita b, users u, berita_kategori k where b.user_id=u.user_id and b.kategori_id=k.kategori_id order by b.judul");
    } else {
        $jml_berita_query = mysql_query("select count(berita_id) as 'jml' from berita where user_id='$_SESSION[userid]' group by user_id");

        $query_berita = mysql_query("select b.judul, k.kategori_nama, u.username, b.tanggal, b.dibaca, b.status, b.berita_id, b.gambar from berita b, users u, berita_kategori k where b.user_id=u.user_id and b.kategori_id=k.kategori_id and u.username='$_SESSION[username]' order by b.judul");
    }

    $jml_berita = mysql_fetch_array($jml_berita_query);
    ?>
        <div class='row'>
            <div class='col-md-12'>
                <div class="box">
                    <div class="box-header">
                        <i class="fa fa-newspaper-o"></i>
                        <h3 class="box-title">Semua Berita (<?php echo $jml_berita['jml']; ?>)</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">                        
                        <table class="table table-hover">
                            <form name="formlistberita[0]" action="page/berita/proses.php?page=berita&act=hapusberitacek" method="post">
                                <tr style="background-color: #F3F4F5">                                    
                                    <th style="text-align:center; vertical-align: middle"><input type="checkbox"  name="allbox" onclick="checkAll(0);" /></th>
                                    <th colspan="5">
                                        <div class="btn-group">
                                            <button name="btnpublish" class="btn btn-info btn-sm">Publish</button>
                                            <button name="btndraft" class="btn btn-info btn-sm">Kembalikan Ke Draft</button>
                                            <button name="btnhapus" class="btn btn-info btn-sm" title="Hapus"><i class="fa fa-trash"></i></button>
                                        </div>
                                        <a href="?page=berita&act=tulisberita" class="btn btn-info btn-sm" style="margin-left: 15px;"><i class="fa fa-edit"></i> Tulis Berita</a>
                                    </th>
                                </tr>
                                <!--<tr>
                                    <th style="width: 10px">No</th>
                                    <th style="text-align:center">Judul Berita</th>                                
                                    <th>Penulis</th>
                                    <th style="text-align:center">Tgl. Posting</th>
                                    <th style="text-align:center; width: 40px">Dibaca</th>
                                    <th style="text-align:center; width: 40px">Status</th>
                                    <th style="text-align:center">Action</th>
                                </tr>-->
                                <?php                                 
                                $no = 1;
                                $cek_berita = mysql_num_rows($query_berita);
                                if ($cek_berita != 0) {
                                    while ($d = mysql_fetch_array($query_berita)) {
                                        if ($d['status']=="Y") {
                                            $status = "Publish";
                                        } else {
                                            $status = "Draft";
                                        }
                                        echo "<tr>
                                            <td align='center'>
                                                <input type='checkbox' value='$d[berita_id]' name='berita_id[]'/>
                                                <!--<input type='hidden' name='gambar[]' value='$d[gambar]'>--> </td>
                                            <td style='width:65%'>".$d['judul']."&nbsp;&nbsp;<em style='color:rgba(0, 0, 0, 0.4)'>".$d['kategori_nama']."</em>
                                                <div class='tools'>
                                                    <a href='?page=berita&act=editberita&id=$d[berita_id]' title='Edit'><i class='fa fa-edit'></i></a>
                                                    <a href='page/berita/proses.php?page=berita&act=hapusberita&id=$d[berita_id]&filename=$d[gambar]' onclick='return confirm(\"Apakah anda yakin akan menghapusnya?\");' title='Hapus'><i class='fa fa-trash-o'></i></a>
                                                </div>
                                            </td>                                          
                                            <td>".$d['username']."</td>                                   
                                            <td align='center'>".$status."</td>
                                            <td align='center' style='width:'><div class='tools-view'>".$d['dibaca']." <i class='fa fa-eye'></i></div></td>
                                            <td align='center'>".date('d/m/y', strtotime($d['tanggal']))."</td>         
                                                   
                                            <!--<td align='center'>                                        
                                                <a href='?page=berita&act=editberita&id=$d[berita_id]'>Edit</a> | 
                                                <a href='page/berita/proses.php?page=berita&act=hapusberita&id=$d[berita_id]&filename=$d[gambar]' onclick='return confirm(\"Apakah anda yakin akan menghapusnya?\");'>Hapus</a>
                                            </td>--></tr>";
                                        $no++;
                                    }
                                } else {
                                    echo "<tr>
                                            <td colspan='3' align='center'>Tidak ada berita</td></tr>";
                                }
                                
                                ?>
                            </form> 
                        </table>                                               
                    </div><!-- /.box-body -->                    
                </div>
            </div>
        </div> 
        <script type="text/javascript">
        //check all checkbox
        function checkAll(formlistberita) {
            for (var i=0;i<document.forms[formlistberita].elements.length;i++) {
                var e=document.forms[formlistberita].elements[i];
                if ((e.name !='allbox') && (e.type=='checkbox')) {
                    e.checked=document.forms[formlistberita].allbox.checked;
                }
            }
        }
        </script>       
        <?php
        break;

    case 'tulisberita':
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <!-- New Post -->
                    <div class="box-header">
                        <i class="fa fa-edit"></i>
                        <h3 class="box-title">Tulis Berita Baru</h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button class="btn btn-default btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div><!-- /. tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body pad">
                        <form name="" action="page/berita/proses.php?page=berita&act=post" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="text" class="form-control" name="judul" placeholder="Judul Berita"/>
                            </div>                            
                            <div class="form-group">
                                <textarea name="isi" class="textarea" placeholder="Tuliskan isi berita disini" style="width: 100%; height: 300px; font-size: 14px; font-family: 'ProximaNova', sans-serif !important; line-height: 18px; border: 1px solid #dddddd; padding: 10px; overflow:auto"></textarea>              
                            </div> 
                            <div class="form-group">
                                <label style="font-weight:normal; margin-top:0; padding-top:0">Pilih Gambar Berita, format harus *.jpg</label>                            
                            </div> 
                            <div class="form-group clearfix">
                                <div class="thumbnail col-md-4">
                                    <img id="img_prev" src="./../assets/img/nopreview.jpg" style="width:auto;height:auto;"/>
                                    <div class="caption">
                                        <span class="btn btn-default fileinput-button">
                                            <i class="glyphicon glyphicon-camera"></i>                              
                                            <input type="file" id="fileupload" name="gambar" onchange="readURL(this);" >
                                        </span>
                                    </div>
                                </div>
                                <!--<input type="file" name="gambar" title="Pilih Gambar" >-->
                            </div>                                                      
                            <div class="form-group">
                                <select name="kategori" class="form-control" style="width: auto">
                                    <option value="1">Pilih Kategori</option>
                                    <?php                                   
                                    $result = mysql_query("select * from berita_kategori where kategori_id not like '1' order by kategori_nama");
                                    while ($kategori = mysql_fetch_array($result)) {
                                        echo "<option value='$kategori[kategori_id]'>".ucwords($kategori['kategori_nama'])."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="radio-inline">
                                    <input type="radio" name="status" value="Y" checked> Publish
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="status" value="N" > Draft
                                </label>
                            </div>                     
                            <div class="box-footer clearfix">
                                <button class="pull-right btn btn-default">Post <i class="fa fa-arrow-circle-right"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- /.col-->
        </div><!-- ./row -->
        <?php
        break;

    case 'editberita':
        $query_edit = mysql_query("select * from berita where berita_id='$_GET[id]'");
        $d = mysql_fetch_array($query_edit);
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class='box'>
                    <div class="box-header">
                        <i class="fa fa-edit"></i>
                        <h3 class="box-title">Edit Berita Baru</h3>
                        <!-- tools box -->                     
                        <div class="pull-right box-tools">
                            <a class="btn btn-default btn-sm" onclick="history.back();" ><i class="fa fa-arrow-circle-o-left"></i> Batal</a>
                            <button class="btn btn-default btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div><!-- /. tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body pad">
                        <form name="" action="page/berita/proses.php?page=berita&act=updateberita" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="id" value="<?php echo $d['berita_id'];?>" />
                                <input type="hidden" class="form-control" name="filename" value="<?php echo $d['gambar'];?>" />
                                <input type="text" class="form-control" name="judul" value="<?php echo $d['judul'];?>" />
                            </div>                            
                            <div class="form-group">
                                <textarea name="isi" class="textarea" placeholder="Tuliskan isi berita disini" style="width: 100%; height: 300px; overflow:auto; font-size: 14px; font-family: 'ProximaNova', sans-serif !important; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $d['isi_berita'];?></textarea>              
                            </div>
                            <div class="form-group clearfix">
                                <div class="thumbnail col-md-4">
                                    <img id="img_prev" src="./../upload/berita/<?php echo $d['gambar'];?>" style="width:100%;height:auto;"/>
                                    <div class="caption">
                                        <span class="btn btn-default fileinput-button">
                                            <i class="glyphicon glyphicon-camera"></i>                              
                                            <input type="file" id="fileupload" name="gambar" onchange="readURL(this);" >
                                        </span>
                                    </div>
                                </div>
                                <!--<img src="./../upload/berita/<?php echo $d['gambar'];?>" class="img-thumbnail img-responsive" style="width: auto; height: 255px;">-->                  
                            </div> 
                            <div class="form-group">
                                <label style="font-weight:normal; margin-top:0; padding-top:0">Ganti Gambar Berita, format harus *.jpg</label>                   
                            </div>                                                      
                            <div class="form-group">
                                <select name="kategori" class="form-control" style="width: auto">
                                    <option disabled>Pilih Kategori</option>
                                    <?php               
                                    $result = mysql_query("select * from berita_kategori order by kategori_nama");
                                    while ($kategori = mysql_fetch_array($result)) {
                                        if ($d['kategori_id']==$kategori['kategori_id']) {
                                            echo "<option value='$kategori[kategori_id]' selected>".ucwords($kategori['kategori_nama'])."</option>";
                                        } else {
                                            echo "<option value='$kategori[kategori_id]'>".ucwords($kategori['kategori_nama'])."</option>";
                                        }               
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="radio-inline">
                                    <input type="radio" name="status" value="Y" <?php echo $d['status']=="Y" ? 'checked' : '' ;?>> Publish
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="status" value="N" <?php echo $d['status']=="N" ? 'checked' : '' ;?>> Draft
                                </label>
                            </div>                     
                            <div class="box-footer clearfix">
                                <button class="pull-right btn btn-default">Update <i class="fa fa-arrow-circle-right"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- /.col-->
        </div><!-- ./row -->
        <?php
        break;

    case 'hapusberita':
        # code...
        break;
    
    default:
        ?>
        <div class="error-page">
            <h2 class="headline text-info"> 404</h2>
            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> Oops! Halaman tidak ada.</h3>
                <p>saya bingung maksud anda apa</p>                
            </div><!-- /.error-content -->
        </div><!-- /.error-page -->
        <?php
        break;
}
?>