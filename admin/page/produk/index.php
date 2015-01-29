<?php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include './../lib/config.php';
$proses = "page/produk/proses.php";

switch ($_GET['act']) {
    case 'listproduk':
    $jml_produk_query = mysql_query("select count(produk_id) as 'jml' from produk");
    $jml_produk = mysql_fetch_array($jml_produk_query);
    ?>
        <div class="row">
            <section class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="fa fa-qrcode"></i>
                        <h3 class="box-title">List Produk (<?php echo $jml_produk['jml'];?>)</h3>
                        <div class="box-tools pull-right">
                            <a href="?page=produk&act=addproduk" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Tambah item</a>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                    <form name="listproduk[0]" action="page/produk/proses.php?page=produk&act=hapusprodukcek" method="post"> 
                        <ul class="todo-list">
                            <?php
                            if ($_SESSION['level']=="Admin") {
                            ?>
                            <li style="background-color:#f5f5f5">   
                                <!-- checkbox -->
                                <input type="checkbox" value="" name="allbox" onclick="checkAll(0);"/> 
                                <button name="btnhapus" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
                            </li>
                            <?php
                            }
                            $query = mysql_query("select * from produk order by produk_nama");
                            $no = 1;
                            
                            while ($d = mysql_fetch_array($query)) {
                            ?>
                            <li>
                                <?php if ($_SESSION['level']=="Admin") { ?>
                                <!-- checkbox -->
                                <input type="checkbox" value="<?php echo $d['produk_id']; ?>" name="id[]"/> 
                                <?php } ?>
                                <img src="../upload/produk/thumb/<?php echo $d['image']; ?>">               
                                                                           
                                <!-- todo text -->
                                <span class=""><?php echo $d['produk_nama']; ?></span>
                                <!-- Emphasis label -->
                                <?php 
                                if ($d['stok']!=0) {
                                ?>
                                <small class="label label-primary" style="font-weight:normal; font-size: 75%;"><i class="fa fa-pie-chart"></i> <?php echo $d['stok']; ?> Ready</small>
                                <?php
                                }else{
                                ?>
                                <small class="label label-danger" style="font-weight:normal; font-size: 75%;"><i class="fa fa-pie-chart"></i> <?php echo $d['stok']; ?> Empty</small>
                                <?php 
                                }                               
                                ?>
                                <div class="tools-edit">    
                                    <a href="?page=produk&act=editproduk&id=<?php echo $d['produk_id'];?>" title="Edit"><i class="fa fa-edit"></i></a>
                                    <?php if ($_SESSION['level']=="Admin") { ?>
                                    <a href="page/produk/proses.php?page=produk&act=hapusproduk&id=<?php echo $d['produk_id'];?>&img=<?php echo $d['image'];?>" title="Hapus" onclick="return confirm('Apakah anda yakin akan menghapusnya?');"><i class="fa fa-trash-o"></i></a>
                                    <?php } ?>
                                </div>                                
                                <div class="right">
                                    <span><?php echo $d['warna']; ?> | </span>
                                    <?php 
                                    $size = explode(' ', $d['ukuran']);
                                    foreach ($size as $k) {
                                        if($k=="S"){
                                            $bg = "bg-aqua";
                                        }elseif ($k=="M") {
                                            $bg = "bg-green";
                                        }elseif ($k=="L") {
                                            $bg = "bg-yellow";
                                        }else{
                                            $bg = "bg-red";
                                        }

                                        echo "<span class=\"badge $bg\">$k</span>";
                                    }
                                    ?> | 
                                    
                                    <span><?php echo $d['bahan']; ?></span>
                                </div>                                
                            </li>   
                            <?php } ?>                         
                        </ul>
                    </form>    
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </section>
        </div>
        <script type="text/javascript">
        //check all checkbox
        function checkAll(listproduk) {
            for (var i=0;i<document.forms[listproduk].elements.length;i++) {
                var e=document.forms[listproduk].elements[i];
                if ((e.name !='allbox') && (e.type=='checkbox')) {
                    e.checked=document.forms[listproduk].allbox.checked;
                }
            }
        }
        </script>   
    <?php
        break;

    case 'addproduk':
    ?>
        <div class="row">
            <section class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <i class="fa fa-qrcode"></i>
                        <h3 class="box-title">Tambah Produk Baru</h3>                
                    </div>
                    <div class="box-body">
                        <form name="" method="post" action="page/produk/proses.php?page=produk&act=insert" onsubmit="return cek_pass()" class="form-horizontal" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Nama Produk</label>
                                <div class="col-md-4">
                                    <input type="text" name="p_nama" class="form-control" placeholder="Umil Charshaf" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Foto Produk</label>
                                <div class="col-md-4">
                                    <div class="thumbnail">
                                        <img id="img_prev" src="./../assets/img/nopreview.jpg" style="width:100%;height:auto;"/>
                                        <div class="caption">
                                            <span class="btn btn-default fileinput-button">
                                                <i class="glyphicon glyphicon-camera"></i>                              
                                                <input type="file" id="fileupload" name="p_img" onchange="readURL(this);" >
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Bahan</label>
                                <div class="col-md-4">
                                    <input type="text" name="p_bahan" class="form-control" placeholder="Bahan" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Ukuran</label>
                                <div class="col-md-4">
                                    <select name="p_ukuran[]" data-placeholder="Pilih Ukuran" class="form-control chosen-select" multiple tabindex="4">
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                    </select>                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Warna</label>
                                <div class="col-md-4">
                                    <input type="text" name="p_warna" class="form-control" placeholder="Merah, Kuning, Hijau" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Harga</label>
                                <div class="col-md-4">
                                    <input type="text" name="p_harga" class="form-control" placeholder="Ex: 82000" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Stok</label>
                                <div class="col-md-4">
                                    <input type="number" name="p_stok" class="form-control" min="0" placeholder="0" required>
                                </div>
                            </div>                       
                            <div class="form-group">
                                <label class="col-md-4 control-label">Kategori</label>
                                <div class="col-md-4">
                                    <select name="p_kategori" data-placeholder="Pilih Kategori" class="chosen-select form-control">
                                        <option value=""></option>
                                        <?php                                   
                                        $result = mysql_query("select * from produk_kategori order by pk_nama");
                                        while ($kategori = mysql_fetch_array($result)) {
                                            echo "<option value='$kategori[pk_id]'>".ucwords(implode(' ', explode('-', $kategori['pk_nama'])))."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">   
                                <div class="col-md-offset-4 col-md-4">
                                    <input type="submit" class="btn btn-primary" value="Tambah">
                                </div>
                            </div>
                        </form>
                    </div><!-- /.box-body -->            
            </section>
        </div>        
    <?php
        break;

    case 'editproduk':
    $query_edit = mysql_query("select * from produk where produk_id='$_GET[id]'");
        $d = mysql_fetch_array($query_edit);
        ?>
        <div class="row">
            <section class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <i class="fa fa-qrcode"></i>
                        <h3 class="box-title">Edit Produk</h3>                
                    </div>
                    <div class="box-body">
                        <form name="" method="post" action="page/produk/proses.php?page=produk&act=update" onsubmit="return cek_pass()" class="form-horizontal" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Nama Produk</label>
                                <div class="col-md-4">
                                    <input type="text" name="p_nama" class="form-control" value="<?php echo $d['produk_nama'];?>" required>
                                    <input type="hidden" name="id" class="form-control" value="<?php echo $d['produk_id'];?>">
                                    <input type="hidden" name="img" class="form-control" value="<?php echo $d['image'];?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Foto Produk</label>
                                <div class="col-md-4">
                                    <div class="thumbnail">
                                        <img id="img_prev" src="./../upload/produk/<?php echo $d['image'];?>" style="width:100%;height:auto;"/>
                                        <div class="caption">
                                            <span class="btn btn-default fileinput-button">
                                                <i class="glyphicon glyphicon-camera"></i>                              
                                                <input type="file" id="fileupload" name="p_img" onchange="readURL(this);" >
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Bahan</label>
                                <div class="col-md-4">
                                    <input type="text" name="p_bahan" class="form-control" value="<?php echo $d['bahan'];?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Ukuran</label>
                                <div class="col-md-4">
                                    <select name="p_ukuran[]" data-placeholder="Pilih Ukuran" class="form-control chosen-select" multiple tabindex="4">
                                    <?php 
                                    $uk = explode(' ', $d['ukuran']);                                    
                                    $arrayUkuran = array('S', 'M', 'L', 'XL');
                                    foreach ($arrayUkuran as $u) {

                                         $select = (array_search($u, $uk) === false) ? '' : 'selected="selected"';                                        
                                    
                                    ?>                                   
                                        <option value="<?php echo $u ?>" <?php echo $select ?>><?php echo $u ?></option>
                                    <?php } ?>
                                    </select>                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Warna</label>
                                <div class="col-md-4">
                                    <input type="text" name="p_warna" class="form-control" value="<?php echo $d['warna'];?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Harga</label>
                                <div class="col-md-4">
                                    <input type="text" name="p_harga" class="form-control" value="<?php echo $d['harga'];?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Stok</label>
                                <div class="col-md-4">
                                    <input type="number" name="p_stok" class="form-control" min="0" value="<?php echo $d['stok'];?>" required>
                                </div>
                            </div>                       
                            <div class="form-group">
                                <label class="col-md-4 control-label">Kategori</label>
                                <div class="col-md-4">
                                    <select name="p_kategori" class="chosen-select form-control">
                                        <?php               
                                        $result = mysql_query("select * from produk_kategori order by pk_nama");
                                        while ($kategori = mysql_fetch_array($result)) {
                                            if ($d['pk_id']==$kategori['pk_id']) {
                                                echo "<option value='$kategori[pk_id]' selected>".ucwords(implode(' ', explode('-', $kategori['pk_nama'])))."</option>";
                                            } else {
                                                echo "<option value='$kategori[pk_id]'>".ucwords(implode(' ', explode('-', $kategori['pk_nama'])))."</option>";
                                            }               
                                        }
                                        ?>
                                    </select>                                    
                                </div>
                            </div>
                            <div class="form-group">   
                                <div class="col-md-offset-4 col-md-4">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                            </div>
                        </form>
                    </div><!-- /.box-body -->            
            </section>
        </div> 
        <?php
        break;

    case 'listprodkategori':
        ?>
        <div class="row">
            <section class="col-lg-6 connectedSortable">
                <!-- quick post widget -->
                <div class="box">
                    <div class="box-header">
                        <i class="fa fa-tags"></i>
                        <h3 class="box-title">Kategori Produk</h3>    
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <a href="?page=produk&act=addprodkategori" class="btn btn-primary btn-sm" style="color:#fff"><i class="fa fa-plus"></i> Tambah Kategori</a>
                        </div><!-- /. tools -->            
                    </div>
                    <div class="box-body no-padding">
                        <table class="table">
                            <tr>
                                <th style="width: 10px; text-align:center">No</th>
                                <th>Kategori</th>                                
                            </tr>
                            
                            <?php
                            $query = mysql_query("select * from produk_kategori order by pk_nama");
                            $no = 1;
                            $cek_kategori = mysql_num_rows($query);
                            if ($cek_kategori != 0) {
                                while ($d = mysql_fetch_array($query)) {                                    
                                    echo "<tr>
                                        <td align='center'>$no</td>
                                        <td>".ucwords(implode(' ', explode('-', $d['pk_nama'])))."
                                            <div class='tools'>
                                                <a href='?page=produk&act=editprodkategori&id=$d[pk_id]' title='Edit'><i class='fa fa-edit'></i></a>
                                                <a href='$proses?page=produk&act=hapuspk&id=$d[pk_id]' onclick='return confirm(\"Apakah anda yakin akan menghapusnya?\");' title='Hapus'><i class='fa fa-trash-o'></i></a>
                                            </div>
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

    case 'addprodkategori':
        ?>
        <div class="row">
            <section class="col-lg-6 connectedSortable">
                <!-- quick post widget -->
                <div class="box">
                    <div class="box-header">
                        <i class="fa fa-edit"></i>
                        <h3 class="box-title">Tambah Kategori Produk</h3>  
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <a class="btn btn-default btn-sm" onclick="history.back();" ><i class="fa fa-arrow-circle-o-left"></i> Kembali</a>
                        </div><!-- /. tools -->               
                    </div>
                    <div class="box-body">
                        <form name="" method="post" action="page/produk/proses.php?page=produk&act=submitpk" onsubmit="return cek_pass()" class="form-horizontal" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Nama Kategori</label>
                                <div class="col-md-8">
                                    <input type="text" name="pk_nama" class="form-control" required>
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
    case 'editprodkategori':
        include './../lib/config.php';
        $id = $_GET['id'];
        $q = mysql_query("select * from produk_kategori where pk_id='$id'");
        $d = mysql_fetch_array($q);
        ?>
        <div class="row">
            <section class="col-lg-6 connectedSortable">
                <!-- quick post widget -->
                <div class="box">
                    <div class="box-header">
                        <i class="fa fa-edit"></i>
                        <h3 class="box-title">Edit Nama Kategori</h3>  
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <a class="btn btn-default btn-sm" onclick="history.back();" ><i class="fa fa-arrow-circle-o-left"></i> Kembali</a>
                        </div><!-- /. tools -->               
                    </div>
                    <div class="box-body">
                        <form name="" method="post" action="page/produk/proses.php?page=produk&act=updatepk&id=<?php echo $d['pk_id']; ?>" onsubmit="return cek_pass()" class="form-horizontal" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Judul Kategori</label>
                                <div class="col-md-8">
                                    <input type="text" name="pk_nama" value="<?php echo ucwords(implode(' ', explode('-', $d['pk_nama'])));?>" class="form-control" required>
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