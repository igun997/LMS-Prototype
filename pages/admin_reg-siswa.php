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
                        <b>Daftar Siswa</b>
                    </div>
                    <div class="box-body">
                        <?php 
                        if(isset($_GET["hapus-data"]))
                        {
                            if(isset($_GET["uuid"]))
                            {
                                if($_GET["uuid"] == $sistemApp->enkripsi($_GET["hapus-data"]))
                                {
                                    $cek_id = json_decode($db->hitung_data("user_siswa","id_siswa",$_GET["hapus-data"]));
                                    if($cek_id->total > 0)
                                    {
                                        $hapus = json_decode($db->delete_db("user_siswa","id_siswa",$_GET["hapus-data"]));
                                        if($hapus->status == 1)
                                        {
                                            echo $sistemApp->alert("success","Data Berhasil Di Hapus","Tunggu Anda Akan Di Alihkan");
                                            echo $sistemApp->alihkan("./?page=reg-siswa",200);
                                        }else{
                                            echo $sistemApp->alert("danger","Error Ditemukan","SQL Error :".$hapus->error);
                                        }
                                    }else{
                                        echo $sistemApp->alert("danger","Error Ditemukan","Data Yang Akan Anda Hapus Sudah Tidak Ada");
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
                                <a href="./?page=reg-siswa&tambah" class="btn btn-success">
                                    <li class="fa fa-plus"></li> Tambah Data</a>
                                <a href="./?page=reg-siswa&backup=siswa" class="btn btn-primary">
                                <li class="fa fa-hdd-o"></li> Backup Data Siswa</a>
                            </div>
                            <br>
                            <table class="table table-bordered table-striped rekap-nilai">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Kelas</th>
                                        <th>Nomor Siswa</th>
                                        <th>Dibuat</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                            $cek_list_admin =json_decode($db->custom_query("SELECT sistem_kelas.nama_kelas,user_siswa.nama_siswa,user_siswa.no_siswa,user_siswa.id_siswa,user_siswa.user_siswa as user,user_siswa.tgl_buat FROM user_siswa JOIN sistem_kelas ON sistem_kelas.id_kelas = user_siswa.kelas_id"));
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
                                                <?php echo $obj_admin->nama_siswa;?>
                                            </td>
                                            <td>
                                                <?php echo $obj_admin->user;?>
                                            </td>
                                            <td>
                                                <?php echo $obj_admin->nama_kelas;?>
                                            </td>
                                             <td>
                                                <?php echo $obj_admin->no_siswa;?>
                                            </td>
                                            <td>
                                                <?php echo $obj_admin->tgl_buat;?>
                                            </td>
                                            <td>
                                                <a href="./?page=reg-siswa&edit-data=<?php echo $obj_admin->id_siswa;?>&uuid=<?php echo $sistemApp->enkripsi($obj_admin->id_siswa);?>" class="btn btn-warning">
                                                    <li class="fa fa-edit"></li> Edit Data</a>
                                                <a href="./?page=reg-siswa&hapus-data=<?php echo $obj_admin->id_siswa;?>&uuid=<?php echo $sistemApp->enkripsi($obj_admin->id_siswa);?>" class="btn btn-danger">
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
                            <b>Tambah Siswa</b>
                        </div>
                        <div class="box-body">
                            <?php 
                    
                        if(isset($_POST["frm_add_siswa"]))
                        {
                            
                            $stage_satu = (isset($_POST["nama_siswa"]) && isset($_POST["no_siswa"]) &&isset($_POST["user_siswa"]) && isset($_POST["password"]) && isset($_POST["password_ulang"]) && isset($_POST["kelas"]))?true:false;
                            if($stage_satu == true)
                            {
                                $stage_dua =  (is_numeric($_POST["no_siswa"]) && $_POST["nama_siswa"] != "" && $_POST["user_siswa"] != "" && $_POST["password"] != ""&& $_POST["password_ulang"] != "" && $_POST["kelas"] != "" && $_POST["no_siswa"] != "" && is_numeric($_POST["kelas"]))?true:false;
                                if($stage_dua == true)
                                {
                                    if($_POST["password"] == $_POST["password_ulang"])
                                    {
                                        $input_data = json_decode($db->insert_db("user_siswa",array("nama_siswa","user_siswa","pass_siswa","no_siswa","kelas_id","tgl_buat"),array(htmlentities($_POST["nama_siswa"]),htmlentities($_POST["user_siswa"]),$sistemApp->enkripsi($_POST["password"]),$_POST["no_siswa"],$_POST["kelas"],date("d-m-Y"))));
                                        if($input_data->status == 1)
                                        {
                                            echo $sistemApp->alert("success","Data Berhasil Di Simpan","Tunggu Anda Akan Di Alihkan");
                                            echo $sistemApp->alihkan("./?page=reg-siswa",200);
                                        }else{
                                            echo $sistemApp->alert("danger","Error Ditemukan","SQL Error :".$input_data->error);
                                        }
                                    }else{
                                        echo $sistemApp->alert("danger","Error Ditemukan","Password Tidak Sama");
                                    }
                                }else{
                                    echo $sistemApp->alert("danger","Error Ditemukan","Isi Semua Field Sesuai Aturan");
                                }
                            }else{
                                echo $sistemApp->alert("danger","Error Ditemukan","Elemen Telah Berubah");
                            }
                        }
                        ?>
                                <form class="form-horizontal" action="" method="post">
                                    <div class="form-group has-feedback">
                                        <label class="col-sm-2 control-label">Nama</label>
                                        <div class="col-sm-10">
                                            <input name="nama_siswa" type="text" class="form-control" value="" placeholder="Ex: Nama Siswa" required>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label class="col-sm-2 control-label">Username</label>
                                        <div class="col-sm-10">
                                            <input name="user_siswa" type="text" class="form-control" placeholder="Ex: Username" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label class="col-sm-2 control-label">Nomor HP</label>
                                        <div class="col-sm-10">
                                            <input name="no_siswa" type="number" class="form-control" placeholder="Ex: 081xxx" value="" required>
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
                                    <div class="form-group has-feedback">
                                        <label for="pilihan-ganda" class="col-sm-2 control-label">Pilih Kelas</label>
                                        <div class="col-sm-10">
                                            <select name="kelas" class="pilihan-kelas form-control">
                                                <?php 
                                                $buka_kelas = json_decode($db->select_db("sistem_kelas",array("nama_kelas","id_kelas")));
                                                foreach($buka_kelas as $kelas)
                                                {
                                                ?>
                                                    <option value="<?php echo $kelas->id_kelas;?>">
                                                        <?php echo $kelas->nama_kelas;?>
                                                    </option>
                                                    <?php }?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="box-footer">
                                        <button onclick="history.back()" type="button" class="btn btn-default">Batal</button>
                                        <button type="submit" name="frm_add_siswa" class="btn btn-info pull-right">Simpan Perubahan</button>
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
                        $open_id = json_decode($db->custom_query("SELECT user_siswa.id_siswa,user_siswa.no_siswa, user_siswa.nama_siswa,user_siswa.user_siswa,user_siswa.kelas_id,sistem_kelas.nama_kelas FROM user_siswa JOIN sistem_kelas ON sistem_kelas.id_kelas = user_siswa.kelas_id WHERE user_siswa.id_siswa =".$db->sql_escape($_GET["edit-data"])));
                       foreach($open_id as $obj_edit)
                       {
                ?>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <b>Edit Siswa</b>
                                </div>
                                <div class="box-body">
                                    <?php 
                                    if(isset($_POST["frm_edit_siswa"]))
                                    {
                                    if(isset($_POST["nama_siswa"]) && isset($_POST["no_siswa"]) && isset($_POST["user_siswa"]) && isset($_POST["password"]) && isset($_POST["kelas"]))
                                        {
                                            if(is_numeric($_POST["no_siswa"]) && $_POST["no_siswa"] != "" && $_POST["nama_siswa"] != "" && $_POST["user_siswa"] != "" && $_POST["kelas"] != "" && is_numeric($_POST["kelas"]))
                                            {
                                                   if($_POST["password"] != null)
                                                   {
                                                       $input_data = json_decode($db->update_db("user_siswa",array("nama_siswa","no_siswa","user_siswa","pass_siswa","kelas_id"),array(htmlentities($_POST["nama_siswa"]),$_POST["no_siswa"],htmlentities($_POST["user_siswa"]),$sistemApp->enkripsi($_POST["password"]),$_POST["kelas"]),"id_siswa",$_GET["edit-data"]));
                                                   }else{
                                                       $input_data = json_decode($db->update_db("user_siswa",array("nama_siswa","no_siswa","user_siswa","kelas_id"),array(htmlentities($_POST["nama_siswa"]),$_POST["no_siswa"],htmlentities($_POST["user_siswa"]),$_POST["kelas"]),"id_siswa",$_GET["edit-data"]));
                                                   }
                                                    if($input_data->status == 1)
                                                    {
                                                        echo $sistemApp->alert("success","Data Telah Di Simpan","Tunggu Anda Akan Di Alihakan");
                                                        echo $sistemApp->alihkan("./?page=reg-siswa",200);
                                                    }else{
                                                        echo $sistemApp->alert("danger","Error Ditemukan","SQL Error :".$input_data->error);
                                                    }
                                            }else{
                                                echo $sistemApp->alert("danger","Error Ditemukan","Isi Field Wajib Di Isi Sesuai Aturan");
                                            }
                                        }else{
                                            echo $sistemApp->alert("danger","Error Ditemukan","Elemen Telah Berubah");
                                        }
                                    }
                                    ?>
                                        <form class="form-horizontal" action="" method="post">
                                            <div class="form-group has-feedback">
                                                <label class="col-sm-2 control-label">Nama</label>
                                                <div class="col-sm-10">
                                                    <input name="nama_siswa" type="text" class="form-control" value="<?php echo $obj_edit->nama_siswa;?>" placeholder="Ex: Nama Siswa" required>
                                                </div>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label class="col-sm-2 control-label">Username</label>
                                                <div class="col-sm-10">
                                                    <input name="user_siswa" value="<?php echo $obj_edit->user_siswa;?>" type="text" class="form-control" placeholder="Ex: Username" value="" required>
                                                </div>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label class="col-sm-2 control-label">Nomor HP</label>
                                                <div class="col-sm-10">
                                                    <input name="no_siswa" value="<?php echo $obj_edit->no_siswa;?>" type="number" class="form-control" placeholder="Ex: 08xxxx" value="" required>
                                                </div>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label class="col-sm-2 control-label">Password</label>
                                                <div class="col-sm-10">
                                                    <input name="password" type="password" placeholder="Ex: Isi Jika Ingin Merubah Password" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label for="pilihan-ganda" class="col-sm-2 control-label">Pilih Kelas</label>
                                                <div class="col-sm-10">
                                                    <select name="kelas" class="pilihan-kelas form-control">
                                                        <option value="<?php echo $obj_edit->kelas_id;?>">
                                                            <?php echo $obj_edit->nama_kelas;?>
                                                        </option>
                                                        <?php 
                                                $buka_kelas = json_decode($db->select_db("sistem_kelas",array("nama_kelas","id_kelas")));
                                                foreach($buka_kelas as $kelas)
                                                {
                                                    if($kelas->id_kelas == $obj_edit->kelas_id)
                                                    {
                                                        continue;
                                                    }
                                                ?>
                                                            <option value="<?php echo $kelas->id_kelas;?>">
                                                                <?php echo $kelas->nama_kelas;?>
                                                            </option>
                                                            <?php }?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="box-footer">
                                                <button onclick="history.back()" type="button" class="btn btn-default">Batal</button>
                                                <button type="submit" name="frm_edit_siswa" class="btn btn-info pull-right">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                        <?php }else{$frontend->err404();}}else{$frontend->err404();}?>
                            <?php } // Edit?>
                                <?php
}else{
$frontend->err404();
}
}
?>
