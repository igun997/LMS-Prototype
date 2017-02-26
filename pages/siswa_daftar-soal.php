<?php
if(isset($_SESSION["level_user"]))
{
if($_SESSION["level_user"] == 1)
{
    $sistemApp = new sistemApp;
    $db        = new BukaDB;
    $frontend   = new frontend_app;
if(!isset($_GET["open"]))
{
?>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <b>Daftar Soal</b>
                </div>
                <div class="box-body">

                    <table class="table table-bordered table-striped rekap-nilai">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Ujian</th>
                                <th>Skor Per Soal</th>
                                <th>Tanggal Buat</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                     $info_soal = json_decode($sistemApp->list_soal($_SESSION["id_kelas"]));
                                     $no = 1;
                                     foreach($info_soal as $obj_soal)
                                     {
                                         
                                        
                                 ?>
                                <tr>
                                    <td>
                                        <?php echo $no++;?>
                                    </td>
                                    <td>
                                        <?php echo $obj_soal->judul_soal;?>
                                    </td>
                                    <td>
                                        <?php echo $obj_soal->nilai_per_soal;?>
                                    </td>
                                    <td>
                                        <?php echo $obj_soal->tgl_buat;?>
                                    </td>
                                    <?php $cek_pengerjaan = json_decode($sistemApp->cek_pengerjaan_soal($obj_soal->id_soal,$_SESSION["id_user"]));
                                         if($cek_pengerjaan->status != 1){ ?>
                                        <td><a href="./?page=daftar-soal&open=<?php echo $obj_soal->id_soal; ?>" class="btn btn-primary">Kerjakan</a></td>
                                        <?php }else{?>
                                            <td><a href="javascript:void(0)" class="btn btn-danger" disabled>Sudah Di Kerjakan</a></td>
                                            <?php }?>
                                </tr>
                                <?php }?>
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
    <?php }else{?>
        <?php 
$id = (is_numeric($_GET["open"]))?$_GET['open']:null;
if($id != null){
$cek_pengerjaan = json_decode($sistemApp->cek_pengerjaan_soal($id,$_SESSION["id_user"]));
$info_soal = json_decode($db->hitung_data("sistem_soal","id_kelas",$_SESSION["id_kelas"],"id_soal",$id));
$status =  ($info_soal->total != 1)?null:1;

if($status != null && $cek_pengerjaan->status != 1)
{
$rekap_nilai = json_decode($sistemApp->open_soal($id));
?>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <b><?php echo $rekap_nilai->master_data->judul_soal; ?> </b>
                        </div>
                        <div class="box-body">
                            <?php 
                            if(isset($_POST["form_soal"]))
                            {
                                $hitung = count($_SESSION["id_soal"]);
                                
                                $no = 1;
                                $jawaban = "";
                                foreach($_SESSION["id_soal"] as $obj_id)
                                {
                                    if(!empty($_POST["rad-soal-".$obj_id]))
                                    {
                                    $jawaban.= $_POST["rad-soal-".$obj_id];
                                    if($no != $hitung)
                                    {
                                        $jawaban.= ",";
                                    }
                                    $no++;
                                    }else{
                                        $status = 0;
                                        break;
                                    }
                                    
                                    
                                }
                                if($status == 1)
                                {
                                $id_soal = $id;
                                $id_siswa = $_SESSION["id_user"];
                                $time = date("d-m-Y");
                                $insert_jawaban = json_decode($sistemApp->input_jawaban($jawaban,$id_soal,$id_siswa,$time));
                                if($insert_jawaban->status == 1)
                                {
                                    $open_jawaban = json_decode($db->custom_query("SELECT id_jawaban FROM sistem_jawaban WHERE soal_id =".$db->sql_escape($id_soal)." AND siswa_id =".$db->sql_escape($id_siswa)));
                                    $buka_soal = json_decode($db->select_db("sistem_soal",array("nilai_per_soal"),"id_soal",$_GET["open"]));
                                    $nilai = json_decode($sistemApp->hitung_jawaban($buka_soal[0]->nilai_per_soal,$_SESSION["id_user"],$_GET["open"]));
                                    $input_db = json_decode($sistemApp->input_nilai($nilai->data->nilai,$_SESSION["id_user"],$open_jawaban[0]->id_jawaban,$_GET["open"]));
                                    if($input_db->status == 1)
                                    {
                                        echo $sistemApp->alert("success","Data Berhasil Di Simpan","Tunggu Anda Akan Di Alihkan");
                                    }else{
                                        echo $sistemApp->alert("danger","Data Gagal Di Simpan","Error :".$input_db->error);
                                    }
                                    
                                }else{
                                    echo $sistemApp->alert("danger","Data Gagal Di Simpan","Error :".$insert_jawaban->error);
                                }
                                }else{
                                    echo $sistemApp->alert("danger","Error","Maaf Soal Harus Di Isi Semua");
                                }
                                
                            }
                            ?>
                                <form action="" method="post">
                                    <?php 
                               $data_pilihan = $rekap_nilai->master_data->data_pilihan;
                               $no = 1;
                               foreach($data_pilihan as $obj_pilih)
                               {
                                   $obj_pilih = json_decode($obj_pilih);
                                   
                                   $decode = json_decode($sistemApp->encode_escape($obj_pilih[0]->pilihan));
                                   
                            ?>

                                        <ul class="timeline">
                                            <!-- timeline time label -->
                                            <li class="time-label">
                                                <span class="bg-red">
                                               <?php echo $no++;?>
                                              </span>
                                            </li>
                                            <!-- /.timeline-label -->
                                            <!-- timeline item -->
                                            <li>


                                                <div class="timeline-item">
                                                    <h3 class="timeline-header"><?php echo htmlspecialchars_decode($obj_pilih[0]->soal); ?></h3>
                                                        <hr>
                                                    <div class="timeline-body">
                                                        <?php foreach($decode as $x => $y){ ?>
                                                                <fieldset>
                                                                    <div class="some-class">
                                                                        <input name="rad-soal-<?php echo $obj_pilih[0]->id_bank_soal; $session[] =  $obj_pilih[0]->id_bank_soal;?>" value="<?php echo $x;?>" type="radio">
                                                                        <label><?php echo $x." . ".$y; ?></label>
                                                                    </div>
                                                                </fieldset>
                                                            <?php }?>
                                                    </div>

                                                </div>
                                            </li>
                                            <!-- END timeline item -->
                                        </ul>



                                        <?php }$_SESSION["id_soal"] = array_unique($session);?>

                                            <button class="btn btn-primary" name="form_soal" type="submit">Simpan</button>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php }else{$frontend->err404();}}else{ $frontend->err404(); }?>
                <?php }?>
                    <?php
}else{
$frontend->err404();
}
}
?>
