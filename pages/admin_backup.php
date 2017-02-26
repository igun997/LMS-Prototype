<?php
if(isset($_SESSION["level_user"]))
{
if($_SESSION["level_user"] == 3)
{
    $sistemApp = new sistemApp;
    $db        = new BukaDB;
    $frontend   = new frontend_app;
?>

    <div class="row">
        <div class="col-md-12">
        <?php echo $sistemApp->alert("warning","Peringatan","Anda Memasuki Halaman Sensitif, Jika Anda Ingin Melakukan Full Restore maka di awali dengan restore kelas -> siswa -> guru -> admin , jika anda ingin melakukan pengembalian data guru saja / admin saja, maka pastikan status data kelas tidak berubah sejak anda melakukan backup terakhir kali, ingat mengembalikan data di bawah ini artinya me-reset ulang, <b>semua data ujian</b>"); ?>
        </div>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <b>Import Data Guru</b>
                </div>
                <div class="box-body">
                     <?php
                    if(isset($_POST["restore_guru"]))
                    {
                        $upload = json_decode($db->upload_file("./resource/sql/",$_FILES["sql_full"],array("sql")));
                        if($upload->status == 1)
                        {
                            $status = json_decode($db->import_database($upload->files_name));
                            if($status->status == 1)
                            {
                                echo $sistemApp->alert("success","Import Sukses","Import Database Sukses");
                            }else{
                                echo $sistemApp->alert("danger","Import Gagal","Import Database Gagal");
                            }
                            unlink($upload->files_name);
                        }else{
                            echo $sistemApp->alert("danger","Error Ditemukan","Error :".$upload->error);
                        }
                    }
                    ?>
                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input class="form-control" type="file" name="sql_full">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" name="restore_guru">Import</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <b>Import Data Adminsitrator</b>
                </div>
                <div class="box-body">
                     <?php
                    if(isset($_POST["restore_admin"]))
                    {
                        $upload = json_decode($db->upload_file("./resource/sql/",$_FILES["sql_full"],array("sql")));
                        if($upload->status == 1)
                        {
                            $status = json_decode($db->import_database($upload->files_name));
                            if($status->status == 1)
                            {
                                echo $sistemApp->alert("success","Import Sukses","Import Database Sukses");
                            }else{
                                echo $sistemApp->alert("danger","Import Gagal","Import Database Gagal");
                            }
                            unlink($upload->files_name);
                        }else{
                            echo $sistemApp->alert("danger","Error Ditemukan","Error :".$upload->error);
                        }
                    }
                    ?>
                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input class="form-control" type="file" name="sql_full">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" name="restore_admin">Import</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <b>Import Data Kelas</b>
                </div>
                <div class="box-body">
                     <?php
                    if(isset($_POST["restore_kelas"]))
                    {
                        $upload = json_decode($db->upload_file("./resource/sql/",$_FILES["sql_full"],array("sql")));
                        if($upload->status == 1)
                        {
                            $status = json_decode($db->import_database($upload->files_name));
                            if($status->status == 1)
                            {
                                echo $sistemApp->alert("success","Import Sukses","Import Database Sukses");
                            }else{
                                echo $sistemApp->alert("danger","Import Gagal","Import Database Gagal");
                            }
                            unlink($upload->files_name);
                        }else{
                            echo $sistemApp->alert("danger","Error Ditemukan","Error :".$upload->error);
                        }
                    }
                    ?>
                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input class="form-control" type="file" name="sql_full">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" name="restore_kelas">Import</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <b>Import Data Siswa</b>
                </div>
                <div class="box-body">
                     <?php
                    if(isset($_POST["restore_siswa"]))
                    {
                        $upload = json_decode($db->upload_file("./resource/sql/",$_FILES["sql_full"],array("sql")));
                        if($upload->status == 1)
                        {
                            $status = json_decode($db->import_database($upload->files_name));
                            if($status->status == 1)
                            {
                                echo $sistemApp->alert("success","Import Sukses","Import Database Sukses");
                            }else{
                                echo $sistemApp->alert("danger","Import Gagal","Import Database Gagal");
                            }
                            unlink($upload->files_name);
                        }else{
                            echo $sistemApp->alert("danger","Error Ditemukan","Error :".$upload->error);
                        }
                    }
                    ?>
                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input class="form-control" type="file" name="sql_full">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" name="restore_siswa">Import</button>
                            </div>
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
