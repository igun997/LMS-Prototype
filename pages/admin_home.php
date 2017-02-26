<?php
if(isset($_SESSION["level_user"]))
{
if($_SESSION["level_user"] == 3)
{
    $sistemApp = new sistemApp;
    $db        = new BukaDB;
    $frontend   = new frontend_app;
    $cek_config = json_decode($db->hitung_data("p_sms"));
    if($cek_config->total > 0)
    {
        $status_config = true;
        $open_sms = json_decode($db->select_db("p_sms",array("user_api","pass_api")));
    }else{
         $status_config = false;
    }
?>

    <div class="row">
        <div class="col-md-12">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="ion ion-android-contact"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Administrator</span>
                        <span class="info-box-number"><?php $admin = json_decode($db->hitung_data("user_admin")); echo $admin->total;?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="ion ion-android-contact"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Guru</span>
                        <span class="info-box-number"><?php $guru = json_decode($db->hitung_data("user_guru")); echo $guru->total;?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="ion ion-android-contact"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Siswa</span>
                        <span class="info-box-number"><?php $siswa = json_decode($db->hitung_data("user_siswa")); echo $siswa->total;?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-blue"><i class="ion ion-ios-list"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Kelas</span>
                        <span class="info-box-number"><?php $kelas = json_decode($db->hitung_data("sistem_kelas")); echo $kelas->total;?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
        </div>

        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <b>Permintaan Reset Jawaban</b>
                </div>
                <div class="box-body">
                    <?php 
                    if(isset($_GET["reset"]))
                    {
                        if(isset($_GET["uuid"]))
                        {
                            if($_GET["uuid"] == $sistemApp->enkripsi($_GET["reset"]))
                            {
                                $cek_reset = json_decode($db->hitung_data("sistem_reset","id_reset",$_GET["reset"]));
                                if($cek_reset->total > 0)
                                {
                                    $id_reset = $_GET["reset"];
                                    $fetch_data = json_decode($db->select_db("sistem_reset",array("id_jawaban"),"id_reset",$_GET["reset"]));
                                    $id_jawaban = $fetch_data[0]->id_jawaban;
                                    $open_siswa = json_decode($db->custom_query("SELECT user_siswa.id_siswa,user_guru.id_guru,user_siswa.nama_siswa,user_guru.nama_guru,sistem_soal.judul_soal as nama_ujian FROM sistem_jawaban JOIN user_siswa ON sistem_jawaban.siswa_id = user_siswa.id_siswa JOIN sistem_soal ON sistem_soal.id_soal = sistem_jawaban.soal_id JOIN user_guru ON user_guru.id_guru = sistem_soal.guru_id WHERE sistem_jawaban.id_jawaban =".$id_jawaban));
                                    $update_log = json_decode($db->insert_db("log_reset",array("log_id_reset","log_id_siswa","log_id_jawaban","log_id_guru","log_nama_siswa","log_nama_guru","log_nama_ujian","tgl_log"),array($id_reset,$open_siswa[0]->id_siswa,$id_jawaban,$open_siswa[0]->id_guru,$open_siswa[0]->nama_siswa,$open_siswa[0]->nama_guru,$open_siswa[0]->nama_ujian,date("d-m-Y"))));
                                    if($update_log->status == 1)
                                    {
                                        $hapus_jawaban = json_decode($db->delete_db("sistem_jawaban","id_jawaban",$fetch_data[0]->id_jawaban));
                                        if($hapus_jawaban->status == 1)
                                        {
                                            echo $sistemApp->alert("success","Data Berhasil Di Reset","Tunggu Anda Akan Di Alihkan");
                                            echo $sistemApp->alihkan("./",200);
                                        }else{
                                            echo $sistemApp->alert("danger","Error Ditemukan","MYSQL ERROR :".$hapus_jawaban->error);
                                        }
                                    }else{
                                        echo $sistemApp->alert("danger","Error Ditemukan","MYSQL ERROR".$update_log->error);
                                    }
                                }else{
                                     echo $sistemApp->alert("danger","Error Ditemukan","Data Tidak Ditemukan");
                                }
                            }else{
                                echo $sistemApp->alert("danger","Error Ditemukan","Veifikasi Gagal");
                            }
                        }else{
                            echo $sistemApp->alert("danger","Error Ditemukan","Veifikasi Tidak Ditemukan");
                        }
                    }
                    ?>
                    <?php 
                    if(isset($_GET["unreset"]))
                    {
                        if(isset($_GET["uuid"]))
                        {
                            if($_GET["uuid"] == $sistemApp->enkripsi($_GET["unreset"]))
                            {
                                $cek_id = json_decode($db->hitung_data("sistem_reset","id_reset",$_GET["unreset"]));
                                if($cek_id->total > 0)
                                {
                                    $hapus = json_decode($db->delete_db("sistem_reset","id_reset",$_GET["unreset"]));
                                    if($hapus->status == 1)
                                    {
                                        echo $sistemApp->alert("success","Data Telah Di Hapus","Tunggu Anda Akan Di Alihkan");
                                        echo $sistemApp->alihkan("./",200);
                                    }else{
                                        echo $sistemApp->alert("danger","Error Ditemukan","SQL Error :".$hapus->error);
                                    }
                                }else{
                                    echo $sistemApp->alert("danger","Error Ditemukan","Permintaan Yang Akan Di Hapus Tidak Ada");
                                }
                            }else{
                                echo $sistemApp->alert("danger","Error Ditemukan","Verifikasi Gagal");
                            }
                        }
                    }
                    ?>
                    <table class="table table-bordered table-striped rekap-nilai">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Diminta Oleh</th>
                                <th>Nama Siswa</th>
                                <th>Reset Jawaban Pada</th>
                                <th>Status</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $hitung_reset = json_decode($db->hitung_data("sistem_reset"));
                            if($hitung_reset->total < 1)
                            {
                            ?>
                            <tr>
                                <td>Kosong</td>
                                <td>Kosong</td>
                                <td>Kosong</td>
                                <td>Kosong</td>
                                <td>Kosong</td>
                                <td>Kosong</td>
                            </tr>
                            <?php }else{
                                $no = 1;
                                $sql = json_decode($db->custom_query("SELECT id_reset,user_siswa.nama_siswa,user_guru.nama_guru,sistem_soal.judul_soal as nama_ujian,sistem_reset.status FROM sistem_reset JOIN user_siswa ON user_siswa.id_siswa = sistem_reset.id_siswa JOIN user_guru ON user_guru.id_guru = sistem_reset.id_guru JOIN sistem_jawaban ON sistem_jawaban.id_jawaban = sistem_reset.id_jawaban JOIN sistem_soal ON sistem_soal.id_soal = sistem_jawaban.soal_id "));
                                foreach($sql as $obj_req)
                                {
                            ?>
                             <tr>
                                <td><?php echo $no++;?></td>
                                <td><?php echo $obj_req->nama_guru;?></td>
                                <td><?php echo $obj_req->nama_siswa;?></td>
                                <td><?php echo $obj_req->nama_ujian;?></td>
                                <td><?php echo ($obj_req->status == 0)?"<span class='label bg-red'>Belum Di Reset</span>":"<span class='label bg-green'>Sudah Di Reset</span>";?></td>
                                <td><a href="./?reset=<?php echo $obj_req->id_reset;?>&uuid=<?php echo $sistemApp->enkripsi($obj_req->id_reset);?>" class="btn btn-success"><li class="fa fa-check"></li> Reset Jawaban</a>
                                 <a href="./?unreset=<?php echo $obj_req->id_reset;?>&uuid=<?php echo $sistemApp->enkripsi($obj_req->id_reset);?>" class="btn btn-danger"><li class="fa fa-ban"></li> Hapus Permintaan</a></td>
                            </tr>
                            <?php }?>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
         <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <b>Permintaan Broadcast Ujian</b>
                </div>
                <div class="box-body">
                    <?php 
                        if(isset($_GET["status"]))
                        {
                            if(isset($_GET["uuid"]) && isset($_GET["sms"]))
                            {
                                if($_GET["uuid"] == $sistemApp->enkripsi($_GET["sms"]))
                                {
                                    $hitung_sms = json_decode($db->hitung_data("sistem_sms","id_sms",$_GET["sms"],"status",0));
                                    $sms = json_decode($db->custom_query("SELECT sistem_kelas.id_kelas,sistem_soal.judul_soal as nama_ujian,user_guru.nama_guru,sistem_kelas.nama_kelas,sistem_soal.tgl_buat as tgl_ujian FROM sistem_sms JOIN sistem_soal ON sistem_soal.id_soal = sistem_sms.id_ujian JOIN user_guru ON user_guru.id_guru = sistem_sms.guru_id JOIN sistem_kelas ON sistem_kelas.id_kelas = sistem_sms.id_kelas WHERE sistem_sms.id_sms =".$db->sql_escape($_GET["sms"])));
                                    
                                    if($_GET["status"] == 1)
                                    {
                                     if($status_config == true)
                                        {
                                        if($hitung_sms->total > 0)
                                        {
                                           
                                            $get_number = json_decode($db->select_db("user_siswa",array("no_siswa"),"kelas_id",$sms[0]->id_kelas));
                                            foreach($get_number as $numbers)
                                            {
                                                $send = json_decode($sistemApp->SendSMS($open_sms[0]->user_api,$open_sms[0]->pass_api,$numbers->no_siswa,"[Pengumuman]\nKepada Kelas :".$sms[0]->nama_kelas."\nUjian Online ".$sms[0]->nama_ujian." Akan Dilaksanakan Pada ".$sms[0]->tgl_ujian."\nPengumuman Dari :".$sms[0]->nama_guru));
                                                if($send->message->text == "Success")
                                                {
                                                    $status = true;
                                                }else{
                                                    $status = false;
                                                    $error = $send->message;
                                                    break;
                                                }
                                            }
                                            if($status == true)
                                            {
                                                $update_log_sms = json_decode($db->update_db("sistem_sms",array("status","tgl_input"),array(1,date("d-m-Y")),"id_sms",$_GET["sms"]));
                                                if($update_log_sms->status == 1)
                                                {
                                                    echo $sistemApp->alert("success","Broadcast Berhasi Di Kirimkan","Broadcast Dikirmkan Ke Kelas ".$sms[0]->nama_kelas);
                                                }else{
                                                    echo $sistemApp->alert("danger","Error Ditemukan","Broadcast Telah Terkirim, namun Log Gagal Di Update");
                                                }
                                            }else{
                                                echo $sistemApp->alert("danger","Error Ditemukan","Gagal Mengirim Broadcast :".json_encode($error));
                                            }
                                            
                                            
                                        }else{
                                            echo $sistemApp->alert("danger","Error Ditemukan","Data Sudah Di Proses / Tidak Ada");
                                        }
                                        }else{
                                            echo $sistemApp->alert("danger","Error Ditemukan","Server SMS Offline");
                                        }
                                    }else{
                                        if($hitung_sms->total > 0)
                                        {
                                            $hapus = json_decode($db->delete_db("sistem_sms","id_sms",$_GET["sms"]));
                                            if($hapus->status == 1)
                                            {
                                                echo $sistemApp->alert("success","Data Di Hapus","Data Berhasil Di Hapus");
                                            }else{
                                                echo $sistemApp->alert("danger","Error Ditemukan","SQL Error :".$hapus->error);
                                            }
                                        }else{
                                            echo $sistemApp->alert("danger","Error Ditemukan","Data Sudah Di Proses / Tidak Ada");
                                        }
                                    }
                                }else{
                                    echo $sistemApp->alert("danger","Error Ditemukan","Verifikasi Gagal");
                                }
                            }else{
                                echo $sistemApp->alert("danger","Error Ditemukan","Persyaratan Sistem Tidak Lengkap");
                            }
                        }
                    ?>
                    <table class="table table-bordered table-striped rekap-nilai">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Ujian</th>
                                <th>Guru</th>
                                <th>Kepada Kelas</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $hitung_reset = json_decode($db->hitung_data("sistem_sms"));
                            if($hitung_reset->total < 1)
                            {
                            ?>
                            <tr>
                                <td>Kosong</td>
                                <td>Kosong</td>
                                <td>Kosong</td>
                                <td>Kosong</td>
                                <td>Kosong</td>
                            </tr>
                            <?php }else{
                                $no = 1;
                                $sql = json_decode($db->custom_query("SELECT sistem_soal.id_soal as id_ujian,judul_soal as nama_ujian, sistem_kelas.nama_kelas as kelas,sistem_kelas.id_kelas,user_guru.nama_guru, user_guru.id_guru,sistem_sms.id_sms FROM sistem_sms JOIN sistem_soal ON sistem_soal.id_soal = sistem_sms.id_ujian JOIN sistem_kelas ON sistem_kelas.id_kelas = sistem_sms.id_kelas JOIN user_guru ON user_guru.id_guru = sistem_sms.guru_id WHERE sistem_sms.`status` = 0"));
                                foreach($sql as $obj_req)
                                {
                            ?>
                             <tr>
                                <td><?php echo $no++;?></td>
                                <td><?php echo $obj_req->nama_ujian;?></td>
                                <td><?php echo $obj_req->nama_guru;?></td>
                                <td><?php echo $obj_req->kelas;?></td>
                                <td><a href="./?status=1&sms=<?php echo $obj_req->id_sms;?>&uuid=<?php echo $sistemApp->enkripsi($obj_req->id_sms);?>" class="btn btn-success"><li class="fa fa-check"></li> Setuju Permintaan</a>
                                <a href="./?status=2&sms=<?php echo $obj_req->id_sms;?>&uuid=<?php echo $sistemApp->enkripsi($obj_req->id_sms);?>" class="btn btn-danger"><li class="fa fa-ban"></li> Tolak Permintaan</a></td>
                            </tr>
                            <?php }?>
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
