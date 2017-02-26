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
    if(!isset($_GET["edit-data"]))
    {
    if(!isset($_GET["tambah"]))
    {
    ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <b>Daftar Guru</b>
                    </div>
                    <div class="box-body">
                        <?php 
                        if(isset($_GET["hapus-data"]))
                        {
                         $cek_id = json_decode($db->hitung_data("user_guru","id_guru",$_GET["hapus-data"]));
                        if($cek_id->total > 0)
                        {
                            $hapus = json_decode($db->delete_db("user_guru","id_guru",$_GET["hapus-data"]));
                            if($hapus->status == 1)
                            {
                                echo $sistemApp->alert("success","Data Terhapus","Tunggu Anda Akan Di Alihkan");
                                echo $sistemApp->alihkan("./?page=reg-guru",200);
                            }else{
                                echo $sistemApp->alert("danger","Error Ditemukan","SQL Error:".$hapus->error);
                            }
                        }else{
                            echo $sistemApp->alert("danger","Error Ditemukan","Maaf ID Yang Anda Akan Hapus Tidak Ada");
                        }
                        }
                        if(isset($_GET["backup"]))
                        {
                            $_SESSION["backup"] = $_GET["backup"];
                            echo $sistemApp->alihkan("./backup.php",200);
                        }
                        ?>
                        <div class="input-group">
                            <a href="./?page=reg-guru&tambah" class="btn btn-success">
                                <li class="fa fa-plus"></li> Tambah Data</a>
                            <a href="./?page=reg-guru&backup=guru" class="btn btn-primary">
                                <li class="fa fa-hdd-o"></li> Backup Data Guru</a>
                        </div>
                        <br>
                        <table class="table table-bordered table-striped rekap-nilai">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Guru</th>
                                    <th>Username</th>
                                    <th>NIP</th>
                                    <th>No HP</th>
                                    <th>Tanggal Buat</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                            $cek_list_admin =json_decode($db->select_db("user_guru",array("id_guru","user_guru","nama_guru","nip_guru","tgl_buat","no_guru")));
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
                                            <?php echo $obj_admin->nama_guru;?>
                                        </td>
                                        <td>
                                            <?php echo $obj_admin->user_guru;?>
                                        </td>
                                        <td>
                                            <?php echo $obj_admin->nip_guru;?>
                                        </td>
                                         <td>
                                            <?php echo $obj_admin->no_guru;?>
                                        </td>
                                        <td>
                                            <?php echo $obj_admin->tgl_buat;?>
                                        </td>
                                        <td>
                                            <a href="./?page=reg-guru&edit-data=<?php echo $obj_admin->id_guru;?>&uuid=<?php echo $sistemApp->enkripsi($obj_admin->id_guru);?>" class="btn btn-warning">
                                                <li class="fa fa-edit"></li> Edit Data</a>
                                            <a href="./?page=reg-guru&hapus-data=<?php echo $obj_admin->id_guru;?>&uuid=<?php echo $sistemApp->enkripsi($obj_admin->id_guru);?>" class="btn btn-danger">
                                                <li class="fa fa-ban"></li> Hapus Data</a>
                                        </td>
                                    </tr>
                                    <?php }}else{ ?>
                                        <tr>
                                            <td>Data Kosong</td>
                                            <td>Data Kosong</td>
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
        <?php }else{ //Add ?>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <b>Tambah Guru</b>
                        </div>
                        <div class="box-body">
                            <?php 
                            if(isset($_POST["frm_add_guru"]))
                            {
                                if(isset($_POST["nama_guru"]) && isset($_POST["nip_guru"]) && isset($_POST["no_guru"]) && isset($_POST["user_guru"]) && isset($_POST["password"]) && isset($_POST["password_ulang"]))
                                {
                                    if($_POST["nama_guru"] != "" && $_POST["user_guru"] != "" && $_POST["password"] != "" && $_POST["password_ulang"] != "" && $_POST["no_guru"] != "" && is_numeric($_POST["no_guru"]))
                                    {
                                        $status_nip = ($_POST["nip_guru"] != null)?true:false;
                                        $status_pass = ($_POST["password"] == $_POST["password_ulang"])?true:false;
                                        if($status_nip == true)
                                        {
                                            if(is_numeric($_POST["nip_guru"]))
                                            {
                                                if($status_pass == true)
                                                {
                                                    $input_data = json_decode($db->insert_db("user_guru",array("nama_guru","no_guru","user_guru","pass_guru","nip_guru","tgl_buat"),array($_POST["nama_guru"],$_POST["no_guru"],$_POST["user_guru"],$sistemApp->enkripsi($_POST["password"]),$_POST["nip_guru"],date("d-m-Y"))));
                                                    if($input_data->status == 1)
                                                    {
                                                        echo $sistemApp->alert("success","Data Di Tambahkan","Tunggu Anda Akan Di Alihkan");
                                                        echo $sistemApp->alihkan("./?page=reg-guru",200);
                                                    }else{
                                                        echo $sistemApp->alert("danger","Error Ditemukan","SQL Error :".$input_data->error);
                                                    }
                                                }else{
                                                    echo $sistemApp->alert("danger","Error Ditemukan","Password Tidak Sama");
                                                }
                                            }else{
                                                echo $sistemApp->alert("danger","Error Ditemukan","NIP Harus Angka !");
                                            }
                                        }else{
                                            if($status_pass == true)
                                                {
                                                    $input_data = json_decode($db->insert_db("user_guru",array("nama_guru","no_guru","user_guru","pass_guru","tgl_buat"),array($_POST["nama_guru"],$_POST["no_guru"],$_POST["user_guru"],$sistemApp->enkripsi($_POST["password"]),date("d-m-Y"))));
                                                    if($input_data->status == 1)
                                                    {
                                                        echo $sistemApp->alert("success","Data Di Tambahkan","Tunggu Anda Akan Di Alihkan");
                                                        echo $sistemApp->alihkan("./?page=reg-guru",200);
                                                    }else{
                                                        echo $sistemApp->alert("danger","Error Ditemukan","SQL Error :".$input_data->error);
                                                    }
                                                }else{
                                                    echo $sistemApp->alert("danger","Error Ditemukan","Password Tidak Sama");
                                                }
                                        }
                                    }else{
                                        echo $sistemApp->alert("danger","Error Ditemukan","Isi Semua Field Wajib !");
                                    }
                                }else{
                                    echo $sistemApp->alert("danger","Error Ditemukan","Elemen Tidak Ada");
                                }
                            }
                            ?>
                                <form class="form-horizontal" action="" method="post">
                                    <div class="form-group has-feedback">
                                        <label class="col-sm-2 control-label">Nama</label>
                                        <div class="col-sm-10">
                                            <input name="nama_guru" type="text" class="form-control" value="" placeholder="Ex: Nama Guru" required>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="pilihan-ganda" class="col-sm-2 control-label">NIP</label>
                                        <div class="col-sm-10">
                                            <input name="nip_guru" type="number" placeholder="Kosong Kan Jika Tidak Ada" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="pilihan-ganda" class="col-sm-2 control-label">No HP</label>
                                        <div class="col-sm-10">
                                            <input name="no_guru" type="number" placeholder="Ex : 08xxx" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label class="col-sm-2 control-label">Username</label>
                                        <div class="col-sm-10">
                                            <input name="user_guru" type="text" class="form-control" placeholder="Ex: Username" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label class="col-sm-2 control-label">Password</label>
                                        <div class="col-sm-10">
                                            <input name="password" type="password" placeholder="Ex: Password" class="form-control" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label class="col-sm-2 control-label">Password (Ulang)</label>
                                        <div class="col-sm-10">
                                            <span class="bg-red form-control-feedback"><li class="fa fa-refresh"></li></span>
                                            <input name="password_ulang" type="password" placeholder="Ex: Ulangi Password" class="form-control" value="" required>
                                        </div>
                                    </div>

                                    <div class="box-footer">
                                        <button onclick="history.back()" type="button" class="btn btn-default">Batal</button>
                                        <button type="submit" name="frm_add_guru" class="btn btn-info pull-right">Simpan Perubahan</button>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
                <?php }else{
                            if(isset($_GET["uuid"]))
                            {
                                if($_GET["uuid"] == $sistemApp->enkripsi($_GET["edit-data"]))
                                {
                                    $buka_guru = json_decode($db->select_db("user_guru",array("nama_guru","user_guru","nip_guru","no_guru"),"id_guru",$_GET["edit-data"]));
                            ?>
                            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <b>Edit Guru</b>
                        </div>
                        <div class="box-body">
                            <?php 
                            if(isset($_POST["frm_edit_guru"]))
                            {
                                
                                if(isset($_POST["nama_guru"]) && isset($_POST["nip_guru"])  && isset($_POST["no_guru"]) && isset($_POST["user_guru"]) && isset($_POST["password"]))
                                {
                                    if($_POST["nama_guru"] != "" && $_POST["user_guru"] != "" && $_POST["no_guru"] != "" && is_numeric($_POST["no_guru"]))
                                    {
                                        $nip = ($_POST["nip_guru"] == "")?"":intval($_POST["nip_guru"]);
                                        if($_POST["password"] != "")
                                        {
                                            $input_data = json_decode($db->update_db("user_guru",array("nama_guru","no_guru","nip_guru","user_guru","pass_guru"),array($_POST["nama_guru"],$_POST["no_guru"],$nip,$_POST["user_guru"],$sistemApp->enkripsi($_POST["password"])),"id_guru",$_GET["edit-data"]));
                                        }else{
                                            $input_data = json_decode($db->update_db("user_guru",array("nama_guru","no_guru","nip_guru","user_guru"),array($_POST["nama_guru"],$_POST["no_guru"],$nip,$_POST["user_guru"]),"id_guru",$_GET["edit-data"]));
                                        }
                                        if($input_data->status == 1)
                                        {
                                            echo $sistemApp->alert("success","Data Telah Di Simpan","Tunggu Anda Akan Di Alihkan");
                                            echo $sistemApp->alihkan("./?page=reg-guru",200);
                                        }else{
                                            echo $sistemApp->alert("danger","Error Ditemukan","SQL error :".$input_data->error);
                                        }
                                    }else{
                                        echo $sistemApp->alert("danger","Error Ditemukan","Field Wajib, Harus Di Isi !");
                                    }
                                }
                            }
                            ?>
                                <form class="form-horizontal" action="" method="post">
                                    <div class="form-group has-feedback">
                                        <label class="col-sm-2 control-label">Nama</label>
                                        <div class="col-sm-10">
                                            <input name="nama_guru" type="text" class="form-control" value="<?php echo $buka_guru[0]->nama_guru; ?>" placeholder="Ex: Nama Guru" required>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="pilihan-ganda" class="col-sm-2 control-label">NIP</label>
                                        <div class="col-sm-10">
                                            <input name="nip_guru" type="number" placeholder="Kosong Kan Jika Tidak Ada" class="form-control" value="<?php echo $buka_guru[0]->nip_guru; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label class="col-sm-2 control-label">Username</label>
                                        <div class="col-sm-10">
                                            <input name="user_guru" type="text" class="form-control" placeholder="Ex: Username" value="<?php echo $buka_guru[0]->user_guru; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label class="col-sm-2 control-label">Password</label>
                                        <div class="col-sm-10">
                                            <input name="password" type="password" placeholder="Ex: Isi Jika Ingin Di Rubah" class="form-control" value="" >
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label class="col-sm-2 control-label">No HP</label>
                                        <div class="col-sm-10">
                                            <input name="no_guru" type="number" placeholder="Ex: 08xxxx" class="form-control" value="<?php echo $buka_guru[0]->no_guru; ?>" >
                                        </div>
                                    </div>

                                    <div class="box-footer">
                                        <button onclick="history.back()" type="button" class="btn btn-default">Batal</button>
                                        <button type="submit" name="frm_edit_guru" class="btn btn-info pull-right">Simpan Perubahan</button>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
                    <?php }else{$frontend->err404();}}else{$frontend->err404();}?>
                        <?php } // Edit?>
                            <?php
}else{
$frontend->err404();
}
}
?>
