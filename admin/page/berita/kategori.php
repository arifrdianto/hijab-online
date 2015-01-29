<?php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
$proses = "page/berita/proses.php";

switch ($_GET['act']) {
    case 'listkategori':
        ?>
        <div class="row">
            <section class="col-lg-6 connectedSortable">
                <!-- quick post widget -->
                <div class="box">
                    <div class="box-header">
                        <i class="fa fa-tag"></i>
                        <h3 class="box-title">Kategori Berita</h3>    
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <a href="?page=kategoriberita&act=addkategori" class="btn btn-primary btn-sm" style="color:#fff"><i class="fa fa-plus"></i> Tambah Kategori</a>
                        </div><!-- /. tools -->            
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 10px; text-align:center">No</th>
                                <th style="text-align:center">Kategori</th>
                                <th style="text-align:center">Deskripsi</th>
                                <th style="text-align:center; width: auto">Action</th>                                
                            </tr>
                            
                            <?php
                            include './../lib/config.php';
                            $query = mysql_query("select * from berita_kategori where kategori_id not like '1' order by kategori_nama");
                            $no = 1;
                            $cek_kategori = mysql_num_rows($query);
                            if ($cek_kategori != 0) {
                                while ($d = mysql_fetch_array($query)) {
                                    echo "<tr>
                                        <td align='center'>$no</td>
                                        <td>".ucwords($d['kategori_nama'])."</td> 
                                        <td>".ucfirst($d['kategori_desk'])."</td>                      
                                        <td align='center'>
                                            <a href='?page=kategoriberita&act=editkategori&id=$d[kategori_id]'>Edit</a> | 
                                            <a href='$proses?page=kategoriberita&act=hapuskategori&id=$d[kategori_id]' onclick='return confirm(\"Apakah anda yakin akan menghapusnya?\");'>Hapus</a>
                                        </td></tr>";
                                    $no++;
                                }
                            } else {
                                echo "<tr>
                                        <td colspan='3' align='center'>Tidak ada kategori</td></tr>";
                            }
                            
                            ?>
                                                     
                        </table>
                    </div>                    
                </div>
            </section>
        </div>
        <?php
        break;

    case 'addkategori':
        ?>
        <div class="row">
            <section class="col-lg-6 connectedSortable">
                <!-- quick post widget -->
                <div class="box">
                    <div class="box-header">
                        <i class="fa fa-edit"></i>
                        <h3 class="box-title">Tambah Kategori Berita</h3>  
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <a class="btn btn-default btn-sm" onclick="history.back();" ><i class="fa fa-arrow-circle-o-left"></i> Kembali</a>
                        </div><!-- /. tools -->               
                    </div>
                    <div class="box-body">
                        <form name="" method="post" action="page/berita/proses.php?page=kategoriberita&act=addkategori" onsubmit="return cek_pass()" class="form-horizontal" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Judul Kategori</label>
                                <div class="col-md-8">
                                    <input type="text" name="kategori_nm" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Deskripsi</label>
                                <div class="col-md-8">
                                    <textarea name="kategori_desk" class="form-control"></textarea>
                                </div>
                            </div>                            
                            <div class="form-group">   
                                <div class="col-md-offset-3 col-md-8">
                                    <input type="submit" class="btn btn-primary" value="Tambah">
                                </div>
                            </div>
                        </form>
                    </div>                    
                </div>
            </section>
        </div>
        <?php
        break;
    case 'editkategori':
        include './../lib/config.php';
        $id = $_GET['id'];
        $q = mysql_query("select * from berita_kategori where kategori_id='$id'");
        $d = mysql_fetch_array($q);
        ?>
        <div class="row">
            <section class="col-lg-6 connectedSortable">
                <!-- quick post widget -->
                <div class="box">
                    <div class="box-header">
                        <i class="fa fa-edit"></i>
                        <h3 class="box-title">Edit Kategori Berita</h3>  
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <a class="btn btn-default btn-sm" onclick="history.back();" ><i class="fa fa-arrow-circle-o-left"></i> Kembali</a>
                        </div><!-- /. tools -->               
                    </div>
                    <div class="box-body">
                        <form name="" method="post" action="page/berita/proses.php?page=kategoriberita&act=updatekategori&id=<?php echo $d['kategori_id']; ?>" onsubmit="return cek_pass()" class="form-horizontal" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Judul Kategori</label>
                                <div class="col-md-8">
                                    <input type="text" name="kategori_nm" value="<?php echo $d['kategori_nama'];?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Deskripsi</label>
                                <div class="col-md-8">
                                    <textarea name="kategori_desk" class="form-control"><?php echo $d['kategori_desk'];?></textarea>
                                </div>
                            </div>                            
                            <div class="form-group">   
                                <div class="col-md-offset-3 col-md-8">
                                    <input type="submit" class="btn btn-primary" value="Tambah">
                                </div>
                            </div>
                        </form>
                    </div>                    
                </div>
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