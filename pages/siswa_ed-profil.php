<?php
if(isset($_SESSION["level_user"]))
{
if($_SESSION["level_user"] == 1)
{
    $sistemApp = new sistemApp;
    $db        = new BukaDB;
    $frontend   = new frontend_app;
?>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <b>Ubah Profil</b>
                </div>
                <div class="box-body">
                    <?php
                    $data_siswa = json_decode($sistemApp->search_siswa($_SESSION["id_user"]));
                    if(isset($_POST["edit_form"]))
                    {
                        if($_POST["nama_siswa"] !="" && $_POST["username_siswa"] !="")
                        {
                            $pass = ($_POST["password_siswa"] == "")?null:$_POST["password_siswa"];
                            $nama = $_POST["nama_siswa"];
                            $user = $_POST["username_siswa"];
                            $update_data = json_decode($sistemApp->update_siswa($_SESSION["id_user"],$nama,$user,$pass));
                            if($update_data->status == 1)
                            {
                                echo $sistemApp->alert("success","Update Data Sukses","Tunggu Anda Akan Di Alihkan","./?page=edit-profil",2);
                                $_SESSION["nama_user"] = $nama;
                            }else{
                                echo $sistemApp->alert("danger","Update Data Gagal","Terjadi Error Saat Menyimpan Data : $update_data->error");
                               
                            }
                        }else{
                            echo $sistemApp->alert("danger","Update Data Gagal","Cek Kembali Data Anda");
                        }
                        
                    }
                    ?>
                        <form action="" method="post">
                            <label>Nama Siswa :</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" name="nama_siswa" placeholder="Nama Siswa" value="<?php echo $data_siswa[0]->nama_siswa; ?>">
                            </div>
                            <label>Username :</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                <input type="text" class="form-control" name="username_siswa" placeholder="Username" value="<?php echo $data_siswa[0]->user_siswa; ?>">
                            </div>
                            <label>Password :</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control" name="password_siswa" placeholder="Isi Untuk Mengubah Password" value="">
                            </div>
                            <br>
                            <div class="input-group">
                                <button type="submit" name="edit_form" class="btn btn-primary btn-block btn-flat">Simpan</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>

    <?php
}else{
$frontend->err404();
}
}
?>
