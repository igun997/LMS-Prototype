<?php
if(isset($_SESSION["level_user"]))
{
if($_SESSION["level_user"] == 3)
{
    $sistemApp = new sistemApp;
    $db        = new BukaDB;
    $frontend   = new frontend_app;
?>
    <?php 
    if(!isset($_GET["edit-data-kelas"]))
    {
    if(!isset($_GET["tambah-kelas"]))
    {
    ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <b>Daftar Kelas</b>
                    </div>
                    <div class="box-body">
                        <?php 
                        if(isset($_GET["hapus-data-kelas"]))
                        {
                            if($sistemApp->enkripsi($_GET["hapus-data-kelas"]) == $_GET["uuid"])
                            {
                                $cek_data = json_decode($db->hitung_data("sistem_kelas","id_kelas",$_GET["hapus-data-kelas"]));
                                if($cek_data->total > 0)
                                {
                                    $hapus = json_decode($db->delete_db("sistem_kelas","id_kelas",$_GET["hapus-data-kelas"]));
                                    if($hapus->status == 1)
                                    {
                                        echo $sistemApp->alert("success","Data Berhasil Di Hapus","Tunggu Anda Akan Di Alihkan ..");
                                        echo $sistemApp->alihkan("./?page=reg-kelas",200);
                                    }else{
                                        echo $sistemApp->alert("danger","Error Ditemukan","SQL Error :".$hapus->error);
                                    }
                                }else{
                                    echo $sistemApp->alert("danger","Error Ditemukan","Maaf Kelas Yang Anda Hapus Sudah Tidak Ada");
                                }
                            }else{
                                echo $sistemApp->alert("danger","Error Ditemukan","Verifikasi Gagal");
                            }
                        }
                        if(isset($_GET["backup"]))
                        {
                            $_SESSION["backup"] = $_GET["backup"];
                            echo $sistemApp->alihkan("./backup.php",200);
                        }
                        ?>
                        <div class="input-group">
                            <a href="./?page=reg-kelas&tambah-kelas" class="btn btn-success">
                                <li class="fa fa-plus"></li> Tambah Data</a>
                            <a href="./?page=reg-kelas&backup=kelas" class="btn btn-primary">
                                <li class="fa fa-hdd-o"></li> Backup Data Kelas</a>
                        </div>
                        <br>
                        <table class="table table-bordered table-striped rekap-nilai">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kelas</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                            $cek_list_admin =json_decode($db->select_db("sistem_kelas",array("id_kelas","nama_kelas")));
                            if(!empty($cek_list_admin))
                            {
                                $no = 1;
                                foreach($cek_list_admin as $obj_admin)
                                {
                            ?>
                                    <tr>
                                        <td>
                                            <?php echo $no++;?>
                                        </td>
                                        <td>
                                            <?php echo $obj_admin->nama_kelas;?>
                                        </td>
                                        <td>
                                            <a href="./?page=reg-kelas&edit-data-kelas=<?php echo $obj_admin->id_kelas;?>&uuid=<?php echo $sistemApp->enkripsi($obj_admin->id_kelas);?>" class="btn btn-warning">
                                                <li class="fa fa-edit"></li> Edit Data</a>
                                            <a href="./?page=reg-kelas&hapus-data-kelas=<?php echo $obj_admin->id_kelas;?>&uuid=<?php echo $sistemApp->enkripsi($obj_admin->id_kelas);?>" class="btn btn-danger">
                                                <li class="fa fa-ban"></li> Hapus Data</a>
                                        </td>
                                    </tr>
                                    <?php }}else{ ?>
                                        <tr>
                                            <td>Data Kosong</td>
                                            <td>Data Kosong</td>
                                            <td>Data Kosong</td>
                                        </tr>
                                        <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php }else{ //Add ?>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <b>Tambah Kelas</b>
                        </div>
                        <div class="box-body">
                            <form class="form-horizontal" action="" method="post" id="form-bank-soal">
                                <div class="box-body">
                                    <?php
                                        if (isset($_POST["frm_add_kelas"])) 
                                        {
                                            if(isset($_POST["nama_kelas"]))
                                            {
                                                if($_POST["nama_kelas"] != null)
                                                {
                                                    $cek_kelas = json_decode($db->hitung_data("sistem_kelas","nama_kelas",$_POST["nama_kelas"]));
                                                    if($cek_kelas->total == 0)
                                                    {
                                                        $input_data = json_decode($db->insert_db("sistem_kelas",array("nama_kelas"),array(htmlentities($_POST["nama_kelas"]))));
                                                        if($input_data->status == 1)
                                                        {
                                                            echo $sistemApp->alert("success","Data Berhasil Di Simpan","Tunggu Anda Akan Di Alihkan");
                                                            echo $sistemApp->alihkan("./?page=".$_GET["page"],200);
                                                        }else{
                                                            echo $sistemApp->alert("danger","Error Ditemukan","SQL Error :".$input_data->error);
                                                        }
                                                    }else{
                                                        echo $sistemApp->alert("danger","Error Ditemukan","Nama Kelas Sudah Ada");
                                                    }
                                                }else{
                                                    echo $sistemApp->alert("danger","Error Ditemukan","Maaf Kelas Harus Di isi");
                                                }
                                            }else{
                                                echo $sistemApp->alert("danger","Error Ditemukan","Elemen Tidak Ditemukan");
                                            }
                                        }
                                        ?>

                                        <div class="form-group has-feedback">
                                            <label for="pilihan-ganda" class="col-sm-2 control-label">Nama Kelas</label>
                                            <div class="col-sm-10">
                                                <input name="nama_kelas" type="text" class="form-control" value="" required>
                                            </div>
                                        </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button onclick="history.back()" type="submit" class="btn btn-default">Batal</button>
                                    <button type="submit" name="frm_add_kelas" class="btn btn-info pull-right">Simpan Perubahan</button>
                                </div>
                                <!-- /.box-footer -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
                <?php }else{
                if(isset($_GET["uuid"]))
                {
                    if($_GET["uuid"] == $sistemApp->enkripsi($_GET["edit-data-kelas"]))
                    {
                        $open_kelas = json_decode($db->select_db("sistem_kelas",array("nama_kelas"),"id_kelas",$_GET["edit-data-kelas"]));
                ?>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <b>Edit Kelas</b>
                                </div>
                                <div class="box-body">
                                    <form class="form-horizontal" action="" method="post" id="form-bank-soal">
                                        <div class="box-body">
                                            <?php
                                        if (isset($_POST["frm_edit_kelas"])) 
                                        {
                                            if(isset($_POST["nama_kelas"]))
                                                {
                                                    if($_POST["nama_kelas"] != null)
                                                    {
                                                        $update = json_decode($db->update_db("sistem_kelas","nama_kelas",$_POST["nama_kelas"],"id_kelas",$_GET["edit-data-kelas"]));
                                                        if($update->status == 1)
                                                        {
                                                            echo $sistemApp->alert("success","Data Berhasil Di Update","Tunggu Anda Akan Dialihkan");
                                                            echo $sistemApp->alihkan("./?page=".$_GET["page"],200);
                                                        }else{
                                                             echo $sistemApp->alert("danger","Error Ditemukan","SQL Error :".$update->error);
                                                        }
                                                    }else{
                                                        echo $sistemApp->alert("danger","Error Ditemukan","Isi Nama Kelas");
                                                    }
                                                }else{
                                                     echo $sistemApp->alert("danger","Error Ditemukan","Elemen Kelas Hilang");
                                                }
                                        }
                                        ?>

                                                <div class="form-group has-feedback">
                                                    <label for="pilihan-ganda" class="col-sm-2 control-label">Nama Kelas</label>
                                                    <div class="col-sm-10">
                                                        <input name="nama_kelas" type="text" class="form-control" value="<?php echo $open_kelas[0]->nama_kelas;?>" required>
                                                    </div>
                                                </div>
                                        </div>
                                        <!-- /.box-body -->
                                        <div class="box-footer">
                                            <a href="./?page=reg-kelas" type="button" class="btn btn-default">Batal</a>
                                            <button type="submit" name="frm_edit_kelas" class="btn btn-info pull-right">Simpan Perubahan</button>
                                        </div>
                                        <!-- /.box-footer -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }else{$frontend->err404();}}else{$frontend->err404();} //uuid?>
                        <?php } // Edit?>
                            <?php
}else{
$frontend->err404();
}
}
?>
