<?php
if(isset($_SESSION["level_user"]))
{
if($_SESSION["level_user"] == 2)
{
    $sistemApp = new sistemApp;
    $db        = new BukaDB;
    $frontend   = new frontend_app;
    if(!isset($_GET["change"]))
    {
    if(!isset($_GET["tambah-soal"]))
    {
?>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <b>Register Ujian</b>
                </div>
                <div class="box-body">
                    <?php 
                    if(isset($_GET["del"]) && isset($_GET["uuid"]))
                    {
                        if($_GET["uuid"] == $sistemApp->enkripsi($_GET["del"]))
                        {
                            $hitung = json_decode($db->hitung_data("sistem_soal","id_soal",$_GET["del"]));
                            if($hitung->total == 0)
                            {
                                echo $sistemApp->alert("danger","Hapus Gagal","Data Yang Akan Di Hapus Tidak Ada");
                            }else{
                                $delete = json_decode($db->delete_db("sistem_soal","id_soal",$_GET["del"]));
                                if($delete->status == 1)
                                {
                                    echo $sistemApp->alert("success","Data Berhasil Di Hapus","Data Telah Di Hapus");
                                }else{
                                    echo $sistemApp->alert("danger","Terjadi Error","Error".$delete->error);
                                }
                            }
                        }else{
                            echo $sistemApp->alert("danger","UUID Tidak Valid","Maaf UUID Tidak Valid, Silahkan Log-Out Dan Masuk Kembali, ");
                        }
                    }
                    ?>
                    <?php
                    if(isset($_GET["b-sms"]))
                    {
                        if(isset($_GET["kelas"]) && isset($_GET["guru"]) && isset($_GET["uuid"]))
                        {
                            $id_ujian = $_GET["b-sms"];
                            $id_kelas = $_GET["kelas"];
                            $id_guru  = $_GET["guru"];
                            $verif = $sistemApp->enkripsi($id_ujian.$id_kelas.$id_guru);
                            if($_GET["uuid"] == $verif)
                            {
                                $cek_id = json_decode($db->hitung_data("sistem_sms","id_ujian",$id_ujian));
                                if($cek_id->total == 0)
                                {
                                $insert = json_decode($db->insert_db("sistem_sms",array("id_ujian","id_kelas","guru_id","status"),array($id_ujian,$id_kelas,$id_guru,0)));
                                if($insert->status == 1)
                                {
                                    echo $sistemApp->alert("success","Broadcast Terkirim","Menunggu Verifikasi Admin");
                                }else{
                                    echo $sistemApp->alert("danger","Error Ditemukan","SQL Error :".$insert->error);
                                }
                                }else{
                                    echo $sistemApp->alert("danger","Error Ditemukan","Permintaan Telah Di Kirim Sebelumnya");
                                }
                            }else{
                                echo $sistemApp->alert("danger","Error Ditemukan","Verifikasi Gagal");
                            }
                        }else{
                            echo $sistemApp->alert("danger","Error Ditemukan","Salah Satu Persyaratan Access Tidak Ada");
                        }
                    }
                    ?>
                    <div class="input-group">
                        <a href="./?page=register-soal&tambah-soal=yes" class="btn btn-success">
                            <li class="fa fa-plus"></li> Tambah Data</a>
                    </div>
                    <br>
                    <table class="table table-bordered table-striped rekap-nilai">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Ujian</th>
                                <th>Soal</th>
                                <th>Kelas</th>
                                <th>Di Buat</th>
                                <th>NIlai Per Soal</th>
                                <th>Nilai KKM</th>
                                <th>Tanggal Buat</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $hitung_ujian = json_decode($db->hitung_data("sistem_soal","guru_id",$_SESSION["id_user"]));
                            if($hitung_ujian->total > 0){
                                $select_soal = json_decode($db->select_db("sistem_soal",array("id_soal","judul_soal","bank_soal","id_kelas","nilai_per_soal","nilai_lulus","tgl_buat"),"guru_id",$_SESSION["id_user"]));
                                $no = 1;
                                foreach($select_soal as $obj_list)
                                {
                            ?>
                            <tr>
                                <td><?php echo $no++;?></td>
                                <td><?php echo $obj_list->judul_soal;?></td>
                                <td>
                                    <?php
                                    $soal_id = explode(",",$obj_list->bank_soal);
                                    //print_r($soal_id);
                                    $no_soal = 1;
                                    foreach($soal_id as $obj_id_soal){
                                        $bank_soal = json_decode($db->select_db("sistem_bank_soal",array("soal"),"id_bank_soal",$obj_id_soal));
                                    ?>
                                    <div class="info"><?php echo htmlspecialchars_decode($bank_soal[0]->soal); ?></div><hr>
                                    <?php } ?>
                                </td>
                                <td>
                                <?php 
                                    $id_kelas = $obj_list->id_kelas;
                                    $kelas = json_decode($db->select_db("sistem_kelas",array("nama_kelas"),"id_kelas",$id_kelas));
                                    echo $kelas[0]->nama_kelas;
                                ?>
                                </td>
                                <td><?php echo $obj_list->tgl_buat;?></td>
                                <td><?php echo $obj_list->nilai_per_soal;?></td>
                                <td><?php echo $obj_list->nilai_lulus;?></td>
                                <td><?php echo $obj_list->tgl_buat;?></td>
                                <td>
                                    <a href="./?page=register-soal&del=<?php echo $obj_list->id_soal;?>&uuid=<?php echo $sistemApp->enkripsi($obj_list->id_soal);?>" class="btn btn-danger">
                                        <li class="fa fa-ban"></li> Hapus Data</a> <br> <br>
                                    <a href="./?page=register-soal&change=<?php echo $obj_list->id_soal;?>&uuid=<?php echo $sistemApp->enkripsi($obj_list->id_soal);?>" class="btn btn-warning">
                                        <li class="fa fa-edit"></li> Edit Data</a>
                                    <?php 
                                    $hitung = json_decode($db->hitung_data("sistem_sms","id_ujian",$obj_list->id_soal));
                                    if($hitung->total == 0)
                                    {
                                    ?>
                                    <br> <br>
                                     <a href="./?page=register-soal&b-sms=<?php echo $obj_list->id_soal;?>&kelas=<?php echo $obj_list->id_kelas;?>&guru=<?php echo $_SESSION["id_user"];?>&uuid=<?php echo $sistemApp->enkripsi($obj_list->id_soal.$obj_list->id_kelas.$_SESSION["id_user"]);?>" class="btn btn-primary">
                                        <li class="fa fa-signal"></li> Broadcast Soal</a>
                                    <?php 
                                    }else{
                                        $hitung_selesai = json_decode($db->hitung_data("sistem_sms","status",1));
                                        if($hitung_selesai->total > 0)
                                        {
                                    ?>
                                   <br> <br>
                                    <a href="javascript:void(0)" class="btn btn-success" >
                                        <li class="fa fa-signal"></li> Permintaan Broadcast Sudah Di Setujui</a>
                                    <?php }else{ ?>
                                    <br> <br>
                                    <a href="javascript:void(0)" class="btn btn-primary" >
                                        <li class="fa fa-signal"></li> Permintaan Broadcast Sudah Dikirim</a>
                                    <?php }} ?>
                                </td>
                            </tr>
                            <?php }?>
                            <?php }else{ ?>
                            <tr>
                                <td>Data Kosong</td>
                                <td>Data Kosong</td>
                                <td>
                                    Data Kosong
                                </td>
                                <td>Data Kosong</td>
                                <td>Data Kosong</td>
                                <td>Data Kosong</td>
                                <td>Data Kosong</td>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-danger">
                                        <li class="fa fa-ban"></li> Hapus Data</a>
                                    <a href="javascript:void(0)" class="btn btn-warning">
                                        <li class="fa fa-edit"></li> Edit Data</a>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php }else{
        ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <b>Tambah Ujian</b>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" action="" method="post" id="form-bank-soal">
                            <?php 
                                if(isset($_POST["frm_bank_soal"]))
                                {
                                    //print_r($_POST);
                                    if(isset($_POST["soal"]) && isset($_POST["nama_ujian"]) && isset($_POST["kelas"]) && isset($_POST["nilai_per_soal"]) && isset($_POST["nilai_kkm"]))
                                    {
                                        if($_POST["soal"] != ""  && $_POST["nama_ujian"] != "" && $_POST["kelas"] != "" && $_POST["nilai_per_soal"] != "" && $_POST["nilai_kkm"] != "" && is_numeric($_POST["nilai_kkm"]) && is_numeric($_POST["nilai_per_soal"]))
                                        {
                                            $status_kelas = json_decode($db->hitung_data("sistem_kelas","id_kelas",$_POST["kelas"]));
                                           if($status_kelas->total != 0)
                                           {
                                               $hitung_total_soal = count($_POST["soal"]);
                                               $counter = 1;
                                               $temp_kelas = "";
                                               $temp_soal = "";
                                               foreach($_POST["soal"] as $temp_s)
                                               {
                                                   $temp_soal .= $temp_s;
                                                   if($hitung_total_soal != $counter++)
                                                   {
                                                       $temp_soal .= ",";
                                                   }
                                               }
                                               $input_soal = json_decode($sistemApp->input_soal($_POST["nama_ujian"],$temp_soal,$_POST["kelas"],date("d-m-Y"),$_POST["nilai_per_soal"],$_POST["nilai_kkm"],$_SESSION["id_user"]));
                                               if($input_soal->status != 0)
                                               {
                                                   echo $sistemApp->alert("success","Sukses Mendaftarkan Ujian","Tunggu Anda Akan Di Alihkan");
                                                   echo $sistemApp->alihkan("./?page=register-soal",200);
                                               }else{
                                                   echo $sistemApp->alert("danger","Oops Kesalahan Pada Saat Menyimpan","Error :".$input_soal->error);
                                               }
                                              
                                           }else{
                                               echo $sistemApp->alert("danger","Error Ditemukan","Kelihatannya Ada Perubahan Elemen Secara Ilegal");
                                           }
                                            
                                        }else{
                                            echo $sistemApp->alert("danger","Error Ditemukan","Salah Satu Form Belum Di Isi atau Terdapat Karakter Illegal");
                                        }
                                    }else{
                                        echo $sistemApp->alert("danger","Error Ditemukan","Sepertinya Salah Satu Elemen Telah Di Modifikasi / Belum Di Isi");
                                    }
                                }
                                
                                ?>
                                <div class="form-group">
                                    <label for="soal" class="col-sm-2 control-label">Nama Ujian</label>
                                    <div class="col-sm-10">
                                        <input name="nama_ujian" type="text" class="form-control" placeholder="Ex: UTS">
                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="col-sm-2 control-label">Soal</label>
                                    <div class="col-sm-10">
                                        <select name="soal[]" class="pilihan-soal form-control select2" id="soal" multiple="" data-placeholder="Pilih Soal">
                                            
                                            <?php 
                                                $soal = $db->select_db("sistem_bank_soal",array("id_bank_soal","soal"),"guru_id",$_SESSION["id_user"]);
                                                $soal = json_decode($soal);
                                                if(!empty($soal)):
                                                foreach($soal as $obj_pili_soal){
                                            ?>
                                            <option value="<?php echo $obj_pili_soal->id_bank_soal;?>"><?php echo htmlspecialchars_decode($obj_pili_soal->soal);?></option>
                                            <?php 
                                                }endif;
                                            ?>
                                        </select>
                                        <span class="label bg-red soal">0 Soal Terpilih</span>
                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="col-sm-2 control-label">Kelas</label>
                                    <div class="col-sm-10">
                                        <select name="kelas" class="pilihan-kelas form-control select2" id="kelas"  data-placeholder="Pilih Kelas">
                                            <option selected>== Pilih Kelas ==</option>
                                            <?php 
                                                $kelas = $db->select_db("sistem_kelas",array("id_kelas","nama_kelas"));
                                                $kelas = json_decode($kelas);
                                                if(!empty($kelas)):
                                                foreach($kelas as $obj_pilih_kelas){
                                            ?>
                                            <option value="<?php echo $obj_pilih_kelas->id_kelas;?>"><?php echo htmlspecialchars_decode($obj_pilih_kelas->nama_kelas);?></option>
                                            <?php 
                                                } endif;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="soal" class="col-sm-2 control-label">Nilai Per Soal</label>
                                    <div class="col-sm-10">
                                        <input name="nilai_per_soal" type="text" class="form-control" placeholder="Ex: 70">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="soal" class="col-sm-2 control-label">Nilai KKM</label>
                                    <div class="col-sm-10">
                                        <input name="nilai_kkm" type="text" class="form-control" placeholder="Ex: 70">
                                    </div>
                                </div>

                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button onclick="history.back()" type="submit" class="btn btn-default">Batal</button>
                                    <button type="submit" name="frm_bank_soal" class="btn btn-info pull-right">Simpan Perubahan</button>
                                </div>
                                <!-- /.box-footer -->
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <?php  } //tambah-soal ?>
        <?php
        }else{ if(isset($_GET["uuid"])){
        if($_GET["uuid"] == $sistemApp->enkripsi($_GET["change"]))
        {
        ?>
            <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <b>Ubah Ujian</b>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" action="" method="post" id="form-bank-soal">
                            <?php 
                                if(isset($_POST["frm_bank_soal"]))
                                {
                                    //print_r($_POST);
                                    if(isset($_POST["soal"]) && isset($_POST["nama_ujian"]) && isset($_POST["kelas"]) && isset($_POST["nilai_per_soal"]) && isset($_POST["nilai_kkm"]))
                                    {
                                        if($_POST["soal"] != ""  && $_POST["nama_ujian"] != "" && $_POST["kelas"] != "" && $_POST["nilai_per_soal"] != "" && $_POST["nilai_kkm"] != "" && is_numeric($_POST["nilai_kkm"]) && is_numeric($_POST["nilai_per_soal"]))
                                        {
                                            $status_kelas = json_decode($db->hitung_data("sistem_kelas","id_kelas",$_POST["kelas"]));
                                           if($status_kelas->total != 0)
                                           {
                                               $hitung_total_soal = count($_POST["soal"]);
                                               $counter = 1;
                                               
                                               $temp_soal = "";
                                               foreach($_POST["soal"] as $temp_s)
                                               {
                                                   $temp_soal .= $temp_s;
                                                   if($hitung_total_soal != $counter++)
                                                   {
                                                       $temp_soal .= ",";
                                                   }
                                               }
                                               $input_soal = json_decode($db->update_db("sistem_soal", array("judul_soal","bank_soal","id_kelas","nilai_per_soal","nilai_lulus","tgl_buat","guru_id"), array($_POST["nama_ujian"],$temp_soal,$_POST["kelas"],$_POST["nilai_per_soal"],$_POST["nilai_kkm"],date("d-m-Y"),$_SESSION["id_user"]),"id_soal",$_GET["change"]));
                                               if($input_soal->status != 0)
                                               {
                                                   echo $sistemApp->alert("success","Sukses Mendaftarkan Ujian","Tunggu Anda Akan Di Alihkan");
                                                   echo $sistemApp->alihkan("./?page=register-soal",200);
                                               }else{
                                                   echo $sistemApp->alert("danger","Oops Kesalahan Pada Saat Menyimpan","Error :".$input_soal->error);
                                               }
                                              
                                           }else{
                                               echo $sistemApp->alert("danger","Error Ditemukan","Kelihatannya Ada Perubahan Elemen Secara Ilegal");
                                           }
                                            
                                        }else{
                                            echo $sistemApp->alert("danger","Error Ditemukan","Salah Satu Form Belum Di Isi atau Terdapat Karakter Illegal");
                                        }
                                    }else{
                                        echo $sistemApp->alert("danger","Error Ditemukan","Sepertinya Salah Satu Elemen Telah Di Modifikasi / Belum Di Isi");
                                    }
                                }
                                $open = json_decode($db->select_db("sistem_soal",array("id_soal","judul_soal","bank_soal","id_kelas","nilai_per_soal","nilai_lulus"),"id_soal",$_GET["change"]));
                                $kelas = json_decode($db->select_db("sistem_kelas",array("nama_kelas"),"id_kelas",$open[0]->id_kelas));
                                
            
                                ?>
                                <div class="form-group">
                                    <label for="soal" class="col-sm-2 control-label">Nama Ujian</label>
                                    <div class="col-sm-10">
                                        <input name="nama_ujian" type="text" class="form-control" value="<?php echo $open[0]->judul_soal;?>" placeholder="Ex: UTS">
                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="col-sm-2 control-label">Soal</label>
                                    <div class="col-sm-10">
                                        <select name="soal[]" class="pilihan-soal form-control select2" id="soal" multiple="" data-placeholder="Pilih Soal">
                                            <?php   
                                            $explode = explode(",",$open[0]->bank_soal);
                                            foreach($explode as $dor)
                                            {
                                            $buka_soal = json_decode($db->select_db("sistem_bank_soal",array("id_bank_soal","soal"),"id_bank_soal",$dor));
                                            ?>
                                            <option value="<?php echo $buka_soal[0]->id_bank_soal;?>" selected><?php echo htmlspecialchars_decode($buka_soal[0]->soal); ?></option>
                                            <?php }?>
                                            <?php 
                                                $soal = $db->select_db("sistem_bank_soal",array("id_bank_soal","soal"),"guru_id",$_SESSION["id_user"]);
                                                $soal = json_decode($soal);
                                                if(!empty($soal)):
                                                $explode = explode(",",$open[0]->bank_soal);
                                                foreach($soal as $obj_pili_soal){
                                                   if(in_array($obj_pili_soal->id_bank_soal,$explode))
                                                   {
                                                      
                                                        
                                                       continue;
                                                   }
                                                     
                                               
                                            
                                            ?>
                                            <option value="<?php echo $obj_pili_soal->id_bank_soal;?>"><?php echo htmlspecialchars_decode($obj_pili_soal->soal);?></option>
                                            <?php 
                                                }endif;
                                            ?>
                                        </select>
                                        
                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="col-sm-2 control-label">Kelas</label>
                                    <div class="col-sm-10">
                                        <select name="kelas" class="pilihan-kelas form-control select2" id="kelas"  data-placeholder="Pilih Kelas">
                                            <option value="<?php echo $open[0]->id_kelas;?>" selected><?php echo $kelas[0]->nama_kelas;?></option>
                                            <?php 
                                                $kelas = $db->select_db("sistem_kelas",array("id_kelas","nama_kelas"));
                                                $kelas = json_decode($kelas);
                                                if(!empty($kelas)):
                                                foreach($kelas as $obj_pilih_kelas){
                                                if($open[0]->id_kelas == $obj_pilih_kelas->id_kelas)
                                                {
                                                    continue;
                                                }
                                            ?>
                                            <option value="<?php echo $obj_pilih_kelas->id_kelas;?>"><?php echo htmlspecialchars_decode($obj_pilih_kelas->nama_kelas);?></option>
                                            <?php 
                                                } endif;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="soal" class="col-sm-2 control-label">Nilai Per Soal</label>
                                    <div class="col-sm-10">
                                        <input name="nilai_per_soal" type="text" class="form-control" value="<?php echo $open[0]->nilai_per_soal;?>" placeholder="Ex: 70">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="soal" class="col-sm-2 control-label">Nilai KKM</label>
                                    <div class="col-sm-10">
                                        <input name="nilai_kkm" type="text" value="<?php echo $open[0]->nilai_lulus;?>" class="form-control" placeholder="Ex: 70">
                                    </div>
                                </div>

                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button onclick="history.back()" type="submit" class="btn btn-default">Batal</button>
                                    <button type="submit" name="frm_bank_soal" class="btn btn-info pull-right">Simpan Perubahan</button>
                                </div>
                                <!-- /.box-footer -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php }else{$frontend->err404();}}else{$frontend->err404();}} //Hapus?>

            <?php
}else{
$frontend->err404();
}
}
?>
