<?php
$sistemApp = new sistemApp;
$db = new BukaDB;
$frontend = new frontend_app;
if (isset($_SESSION["level_user"])) {
    if ($_SESSION["level_user"] == 3) {
        
        ?>
    <?php
        if (!isset($_GET["edit-data-admin"])) {
            if (!isset($_GET["tambah-admin"])) {
                ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <b>Daftar Administrator</b>
                    </div>
                    <div class="box-body">
                        <?php 
                        if(isset($_GET["hapus-data-admin"]))
                        {
                            if(isset($_GET["uuid"]))
                            {
                                if($sistemApp->enkripsi($_GET["hapus-data-admin"]) == $_GET["uuid"])
                                {
                                    $cek_id = json_decode($db->hitung_data("user_admin","id_admin",$_GET["hapus-data-admin"]));
                                    if($cek_id->total > 0 )
                                    {
                                        $delete = json_decode($db->delete_db("user_admin","id_admin",$_GET["hapus-data-admin"]));
                                        if($delete->status == 1)
                                        {
                                            echo $sistemApp->alert("success","Data Berhasil Di Hapus","Tunggu Anda Akan Di Alihkan");
                                            echo $sistemApp->alihkan("./?page=".$_GET["page"],200);
                                        }else{
                                            echo $sistemApp->alert("danger","Error Ditemukan","SQL Error".$delete->error);
                                        }
                                    }else{
                                        echo $sistemApp->alert("danger","Error Ditemukan","Data Yang Anda Akan Hapus Telah Tiada");
                                    }
                                }else{
                                    echo $sistemApp->alert("danger","Error Ditemukan","Verifikasi Gagal");
                                }
                            }else{
                                echo $sistemApp->alert("danger","Error Ditemukan","UUID Tidak Ditemukan");
                            }
                        }
                        if(isset($_GET["backup"]))
                        {
                            $_SESSION["backup"] = $_GET["backup"];
                            echo $sistemApp->alihkan("./backup.php",200);
                        }
                        ?>
                        <div class="input-group">
                            <a href="./?page=reg-admin&tambah-admin" class="btn btn-success">
                                <li class="fa fa-plus"></li> Tambah Data</a>
                            <a href="./?page=reg-admin&backup=admin" class="btn btn-primary">
                                <li class="fa fa-hdd-o"></li> Backup Data Admin</a>
                        </div>
                        <br>
                        <table class="table table-bordered table-striped rekap-nilai">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Admin</th>
                                    <th>Username</th>
                                    <th>Dibuat</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                $cek_list_admin = json_decode($db->select_db("user_admin", array("id_admin", "user_admin", "nama_admin", "tgl_buat")));
                if (!empty($cek_list_admin)) {
                    $no = 1;
                    foreach ($cek_list_admin as $obj_admin) {
                        ?>
                                    <tr>
                                        <td>
                                            <?php echo $no++; ?>
                                        </td>
                                        <td>
                                            <?php echo $obj_admin->nama_admin; ?>
                                        </td>
                                        <td>
                                            <?php echo $obj_admin->user_admin; ?>
                                        </td>
                                        <td>
                                            <?php echo $obj_admin->tgl_buat; ?>
                                        </td>
                                        <td>
                                            <a href="./?page=<?php echo $_GET["page"];?>&edit-data-admin=<?php echo $obj_admin->id_admin;?>&uuid=<?php echo $sistemApp->enkripsi($obj_admin->id_admin);?>" class="btn btn-warning">
                                                <li class="fa fa-edit"></li> Edit Data</a>
                                            <a href="./?page=<?php echo $_GET["page"];?>&hapus-data-admin=<?php echo $obj_admin->id_admin;?>&uuid=<?php echo $sistemApp->enkripsi($obj_admin->id_admin);?>" class="btn btn-danger">
                                                <li class="fa fa-ban"></li> Hapus Data</a>
                                        </td>
                                    </tr>
                                    <?php }
                } else { ?>
                                        <tr>
                                            <td>Data Kosong</td>
                                            <td>Data Kosong</td>
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
        <?php } else { //Add  ?>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <b>Tambah Admin</b>
                        </div>
                        <div class="box-body">
                            <form class="form-horizontal" action="" method="post" id="form-bank-soal">
                                <div class="box-body">
                                    <?php
                                        if (isset($_POST["frm_add_admin"])) 
                                        {
                                                $stage_satu = (isset($_POST["nama_admin"])  && isset($_POST["user"]) && isset($_POST["password"]) && isset($_POST["password_repeat"]))?true:false;
                                               if($stage_satu == true)
                                               {
                                                   $stage_dua = ($_POST["nama_admin"] == "" && $_POST["user"] == "" && $_POST["password"] == "" && $_POST["password_repeat"] == "")?false:true;
                                                   if($stage_dua == true)
                                                   {
                                                       $stage_tiga = ($_POST["password"] == $_POST["password_repeat"])?true:false;
                                                       if($stage_tiga == true)
                                                       {
                                                           $input_data = json_decode($db->insert_db("user_admin",array("nama_admin","user_admin","pass_admin","tgl_buat"),array(htmlentities($_POST["nama_admin"]),htmlentities($_POST["user"]),$sistemApp->enkripsi($_POST["password"]),date("d-m-Y"))));
                                                           if($input_data->status == 1)
                                                           {
                                                                echo $sistemApp->alert("success","Data Tersimpan","Tunggu Anda Akan Di Alihkan");
                                                               echo $sistemApp->alihkan("./?page=reg-admin",200);
                                                           }else{
                                                               echo $sistemApp->alert("danger","Error Ditemukan","SQL Error :".$input_data->error);
                                                           }
                                                       }else{
                                                           echo $sistemApp->alert("danger","Error Ditemukan","Password Tidak Sama");
                                                       }
                                                   }else{
                                                      echo $sistemApp->alert("danger","Error Ditemukan","Isi Semua Field");
                                                   }
                                               }else{
                                                   echo $sistemApp->alert("danger","Error Ditemukan","Salah Satu Field hilang Refresh Halaman");
                                                   echo $sistemApp->alihkan("./?page=reg-admin&tambah-admin",200);
                                               }
                                        }
                                        ?>

                                        <div class="form-group has-feedback">
                                            <label for="pilihan-ganda" class="col-sm-2 control-label">Nama</label>
                                            <div class="col-sm-10">
                                                <input name="nama_admin" type="text" class="form-control" value="" required>
                                            </div>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <label for="pilihan-ganda" class="col-sm-2 control-label">Username</label>
                                            <div class="col-sm-10">
                                                <input name="user" type="text" class="form-control" value="" required>
                                            </div>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <label for="pilihan-ganda" class="col-sm-2 control-label">Password</label>
                                            <div class="col-sm-10">
                                                <input name="password" type="password" class="form-control" value="" required>
                                            </div>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <label for="pilihan-ganda" class="col-sm-2 control-label">Password (Ulangi)</label>
                                            <div class="col-sm-10">
                                                <span class="bg-red form-control-feedback"><li class="fa fa-refresh"></li></span>
                                                <input name="password_repeat" type="password" class="form-control" value="" required>
                                            </div>
                                        </div>


                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button onclick="history.back()" type="submit" class="btn btn-default">Batal</button>
                                    <button type="submit" name="frm_add_admin" class="btn btn-info pull-right">Simpan Perubahan</button>
                                </div>
                                <!-- /.box-footer -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
                <?php } else { 
                if(isset($_GET["uuid"]))
                {
                    if($_GET["uuid"] == $sistemApp->enkripsi($_GET["edit-data-admin"]))
                    {
                        $buka_admin = json_decode($db->select_db("user_admin",array("nama_admin","user_admin"),"id_admin",$_GET["edit-data-admin"]));
                ?>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <b>Edit Admin</b>
                                </div>
                                <div class="box-body">
                                    <form class="form-horizontal" action="" method="post">
                                        <div class="box-body">
                                            <?php
                                        if (isset($_POST["frm_edit_admin"])) 
                                        {
                                         $stage_satu = (isset($_POST["nama_admin"])  && isset($_POST["user"]) && isset($_POST["password"]))?true:false;
                                        if($stage_satu == true)
                                        {
                                            $passwd_exist = ($_POST["password"] != "" or null)?true:false;
                                            if($passwd_exist != true)
                                            {
                                                $input_data = json_decode($db->update_db("user_admin",array("nama_admin","user_admin"),array($_POST["nama_admin"],$_POST["user"]),"id_admin",$_GET["edit-data-admin"]));
                                            }else{
                                                 $input_data = json_decode($db->update_db("user_admin",array("nama_admin","user_admin","pass_admin"),array($_POST["nama_admin"],$_POST["user"],$sistemApp->enkripsi($_POST["password"])),"id_admin",$_GET["edit-data-admin"]));
                                            }
                                            if($input_data->status == 1)
                                            {
                                                echo $sistemApp->alert("success","Data Berhasil Di Simpan","Tunngu Akan Di Alihkan");
                                                echo $sistemApp->alihkan("./?page=".$_GET["page"],200);
                                            }else{
                                                echo $sistemApp->alert("danger","Error Ditemukan","SQL Error :".$input_data->error);
                                            }
                                        }else{
                                            echo $sistemApp->alert("danger","Error Ditemukan","Maaf Salah Satu Element Tidak Ada");
                                            echo $sistemApp->alihkan("./?page=reg-admin&edit-data-admin=".$_GET["edit-data-admin"]."&uuid=".$sistemApp->enkripsi($_GET["edit-data-admin"]),200);
                                        }
                                        }
                                        ?>
                                                <div class="form-group has-feedback">
                                                    <label for="pilihan-ganda" class="col-sm-2 control-label">Nama</label>
                                                    <div class="col-sm-10">
                                                        <input name="nama_admin" type="text" class="form-control" value="<?php echo $buka_admin[0]->nama_admin;?>" required>
                                                    </div>
                                                </div>
                                                <div class="form-group has-feedback">
                                                    <label for="pilihan-ganda" class="col-sm-2 control-label">Username</label>
                                                    <div class="col-sm-10">
                                                        <input name="user" type="text" class="form-control" value="<?php echo $buka_admin[0]->user_admin;?>" required>
                                                    </div>
                                                </div>
                                                <div class="form-group has-feedback">
                                                    <label for="pilihan-ganda" class="col-sm-2 control-label">Password</label>
                                                    <div class="col-sm-10">
                                                        <input name="password" type="password" class="form-control" placeholder="Jika Tidak Di Ubah Harap Kosongkan" value="">
                                                    </div>
                                                </div>
                                        </div>
                                        <!-- /.box-body -->
                                        <div class="box-footer">
                                            <button onclick="history.back()" type="submit" class="btn btn-default">Batal</button>
                                            <button type="submit" name="frm_edit_admin" class="btn btn-info pull-right">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }else{$frontend->err404();} //verifikasi?>
                    <?php }else{ $frontend->err404();}//uuid?>
                        <?php } // Edit ?>
                            <?php
    } else {
        $frontend->err404();
    }
}else{$frontend->err404();}
?>
