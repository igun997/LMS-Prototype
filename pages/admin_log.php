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
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <b>Catatan Masuk Terakhir</b>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped rekap-nilai">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama User</th>
                                <th>Username</th>
                                <th>Last Login</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $open_union = json_decode($db->custom_query("SELECT nama_admin as nama,user_admin as user,log_masuk FROM user_admin UNION ALL SELECT nama_siswa,user_siswa as user,log_masuk FROM user_siswa UNION ALL SELECT nama_guru,user_guru as user,log_masuk FROM user_guru"));
                                $no = 1;
                                foreach($open_union as $log)
                                {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $no++;?>
                                    </td>
                                    <td>
                                        <?php echo $log->nama;?>
                                    </td>
                                    <td>
                                        <?php echo $log->user;?>
                                    </td>
                                    <td>
                                        <?php echo $log->log_masuk;?>
                                    </td>
                                </tr>
                                <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <b>Catatan Permintaan Broadcast</b>
                </div>
                <div class="box-body">
                    <?php
                    if(isset($_GET["flush-permintaan-broadcast"]))
                    {
                        $cek_tabel = json_decode($db->hitung_data("sistem_sms","status",1));
                        if($cek_tabel->total == 0)
                        {
                            echo $sistemApp->alert("warning","Data Kosong","Log Telah Bersih");
                        }else{
                           $flush = json_decode($db->delete_db("sistem_sms","status",1));
                            if($flush->status == 1)
                            {
                                echo $sistemApp->alert("success","Data Telah Di Bersihkan","Log Telah Bersih");
                            }else{
                                echo $sistemApp->alert("danger","SQL Error :".$flush->error);
                            }
                        }
                    }
                    ?>
                    <div class="input-group">
                            <a href="./?page=log&flush-permintaan-broadcast" class="btn btn-danger">
                                <li class="fa fa-ban"></li> Hapus Semua Log</a>
                        </div>
                    <br>
                    <table class="table table-bordered table-striped rekap-nilai">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Guru</th>
                                <th>Kelas</th>
                                <th>Nama Ujian</th>
                                <th>Tanggal Broadcast</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $open_union = json_decode($db->custom_query("SELECT sistem_sms.tgl_input,user_guru.nama_guru, sistem_kelas.nama_kelas, sistem_soal.judul_soal as nama_ujian FROM sistem_sms JOIN user_guru ON user_guru.id_guru = sistem_sms.guru_id JOIN sistem_kelas ON sistem_kelas.id_kelas = sistem_sms.id_kelas JOIN sistem_soal ON sistem_soal.id_soal = sistem_sms.id_ujian WHERE sistem_sms.`status` = 1"));
                                $no = 1;
                                foreach($open_union as $log)
                                {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $no++;?>
                                    </td>
                                    <td>
                                        <?php echo $log->nama_guru;?>
                                    </td>
                                    <td>
                                        <?php echo $log->nama_kelas;?>
                                    </td>
                                    <td>
                                        <?php echo $log->nama_ujian;?>
                                    </td>
                                     <td>
                                        <?php echo $log->tgl_input;?>
                                    </td>
                                </tr>
                                <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <b>Catatan Permintaan Reset</b>
                </div>
                <div class="box-body">
                    <?php 
                    if(isset($_GET["flush-permintaan"]))
                    {
                        $cek_tabel = json_decode($db->hitung_data("log_reset"));
                        if($cek_tabel->total == 0)
                        {
                            echo $sistemApp->alert("warning","Data Kosong","Log Telah Bersih");
                        }else{
                           $flush = json_decode($db->flush_tabel("log_reset"));
                            if($flush->status == 1)
                            {
                                echo $sistemApp->alert("success","Data Telah Di Bersihkan","Log Telah Bersih");
                            }else{
                                echo $sistemApp->alert("danger","SQL Error :".$flush->error);
                            }
                        }
                    }
                    ?>
                    <div class="input-group">
                            <a href="./?page=log&flush-permintaan" class="btn btn-danger">
                                <li class="fa fa-ban"></li> Hapus Semua Log</a>
                        </div>
                    <br>
                    <table class="table table-bordered table-striped rekap-nilai">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Guru</th>
                                <th>Nama Siswa</th>
                                <th>Ujian</th>
                                <th>Tanggal Reset</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $open_log = json_decode($db->select_db("log_reset",array("log_nama_siswa","log_nama_guru","log_nama_ujian","tgl_log")));
                                $no = 1;
                                foreach($open_log as $log_reset)
                                {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $no++;?>
                                    </td>
                                    <td>
                                        <?php echo $log_reset->log_nama_siswa;?>
                                    </td>
                                    <td>
                                        <?php echo $log_reset->log_nama_guru;?>
                                    </td>
                                    <td>
                                        <?php echo $log_reset->log_nama_ujian;?>
                                    </td>
                                    <td>
                                        <?php echo $log_reset->tgl_log;?>
                                    </td>
                                </tr>
                                <?php }?>
                        </tbody>
                    </table>
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
