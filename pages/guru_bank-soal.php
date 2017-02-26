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
                    <b>Bank Soal</b>
                </div>
                <div class="box-body">
                    <div class="input-group">
                        <a href="./?page=bank-soal&tambah-soal=yes" class="btn btn-success">
                            <li class="fa fa-plus"></li> Tambah Data</a>
                    </div>
                    <br>
                    <?php 
                    if(isset($_GET["del"]) && isset($_GET["uuid"]))
                    {
                        if($sistemApp->enkripsi($_GET['del']) == $_GET["uuid"])
                        {
                            $sistem_soal = $db->select_db("sistem_soal",array("bank_soal"),"guru_id",$_SESSION["id_user"]);
                            $sistem_soal = json_decode($sistem_soal);
                            foreach($sistem_soal as $id_bank)
                            {
                                $pecah = explode(",",$id_bank->bank_soal);
                                foreach ($pecah as $pecah_aja)
                                {
                                    if($_GET["del"] == $pecah_aja)
                                    {
                                        $status_id = true;
                                        break;
                                    }
                                }
                            }
                            $status = (isset($status_id) == true)?"1":"0";
                            if($status == 1)
                            {
                                echo $sistemApp->alert("danger","Error Di Temukan","Maaf Bank Soal Ini Sedang Di Pakai");
                            }else{
                                $cek_id = $db->hitung_data("sistem_bank_soal","id_bank_soal",$_GET["del"]);
                                $cek_id = json_decode($cek_id);
                                if($cek_id->total > 0)
                                {
                                $hapus = json_decode($db->delete_db("sistem_bank_soal","id_bank_soal",$_GET["del"]));
                                if($hapus->status == 1)
                                {
                                    echo $sistemApp->alert("success","Data Berhasil Di Hapus","Anda Telah Berhasil Menghapus Soal");
                                }else{
                                    echo $sistemApp->alert("danger","Sepertinya Terjadi Masalah !","Error Di Bagian Database :".$hapus->error);
                                }
                                }else{
                                    echo $sistemApp->alert("danger","Sepertinya Terjadi Masalah !","Data Yang Di Pilih Sudah Di Hapus");
                                }
                            }
                        }else{
                            echo $sistemApp->alert("danger","Error Di Temukan","Maaf Sepertinya ID Ilegal");
                        }
                    }
                    ?>
                        <table class="table table-bordered table-striped rekap-nilai">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Soal</th>
                                    <th>Pilihan</th>
                                    <th>Kunci Jawaban</th>
                                    <th>Dibuat</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $hitung_data = json_decode($db->hitung_data("sistem_bank_soal","guru_id",$_SESSION["id_user"]));
                            $status = ($hitung_data->total > 0)?true:false;
                            if($status == true)
                            {
                                $open_data = $db->select_db("sistem_bank_soal",array("id_bank_soal","soal","pilihan","jawaban","tgl_buat"),"guru_id",$_SESSION["id_user"]);
                                $open_data = json_decode($open_data);
                                $no = 1;
                                foreach($open_data as $obj_data)
                                {
                            ?>
                                    <tr>
                                        <td>
                                            <?php echo $no++;?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars_decode($obj_data->soal);?>
                                        </td>
                                        <td>
                                            <?php
                                    $pilihan = json_decode($sistemApp->encode_escape($obj_data->pilihan));
                                    foreach($pilihan as $key => $value)
                                    {
                                        echo "<p class='label bg-primary'>".$key.".".$value."</p><br>";
                                    }
                                    ?>
                                        </td>
                                        <td>
                                            <?php echo $obj_data->jawaban;?>
                                        </td>
                                        <td>
                                            <?php echo $obj_data->tgl_buat;?>
                                        </td>
                                        <td>
                                            <a onclick="confirm('Apakah Anda Akan Menghapus Data Ini ?')" href="./?page=bank-soal&del=<?php echo $obj_data->id_bank_soal;?>&uuid=<?php echo $sistemApp->enkripsi($obj_data->id_bank_soal);?>" class="btn btn-danger hapusData" data-id="" data-verif="">
                                                <li class="fa fa-ban"></li> Hapus</a>
                                            <a href="./?page=bank-soal&change=<?php echo $obj_data->id_bank_soal;?>&uuid=<?php echo $sistemApp->enkripsi($obj_data->id_bank_soal);?>" data-id="" data-verif="" class="btn btn-warning">
                                                <li class="fa fa-edit"></li> Ubah</a>
                                        </td>
                                    </tr>
                                    <?php }?>
                                        <?php }else{?>
                                            <tr>
                                                <td>Data Kosong</td>
                                                <td>Data Kosong</td>
                                                <td>Data Kosong</td>
                                                <td>Data Kosong</td>
                                                <td>Data Kosong</td>
                                                <td>
                                                    <a href="javascript:void(0)" class="btn btn-danger" data-id="" data-verif="">
                                                        <li class="fa fa-ban"></li> Hapus</a>
                                                    <a href="javascript:void(0)" data-id="" data-verif="" class="btn btn-warning">
                                                        <li class="fa fa-edit"></li> Ubah</a>
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
    if($_GET["tambah-soal"] == "yes")
    {
    ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <b>Tambah Bank Soal</b>
                    </div>
                    <div class="box-body">
                        <div class="box-body">
                            <form class="form-horizontal" action="" method="post" id="form-bank-soal">
                                <?php 
                                if(isset($_POST["frm_bank_soal"]))
                                {
                                     //print_r($_POST);
                                    if(isset($_POST["soal"]) && isset($_POST["pilih_a"]) && isset($_POST["pilih_b"]) && isset($_POST["pilih_c"]) && isset($_POST["pilih_d"]) && isset($_POST["pilih_e"]) && isset($_POST["jawaban"]))
                                    {
                                        if(strlen($_POST["jawaban"]) == 1 && ctype_alpha($_POST["jawaban"]))
                                        {
                                            if($_POST["soal"] !="" && $_POST["pilih_a"] !="" && $_POST["pilih_b"] !="" && $_POST["pilih_c"] !="" && $_POST["pilih_d"] !="" && $_POST["pilih_e"] !="")
                                            {
                                                $input_bank = $sistemApp->input_bank_soal($_POST["soal"],array("A"=>$_POST["pilih_a"],"B"=>$_POST["pilih_b"],"C"=>$_POST["pilih_c"],"D"=>$_POST["pilih_d"],"E"=>$_POST["pilih_e"]),strtoupper($_POST["jawaban"]),$_SESSION["id_user"]);
                                                $input_bank = json_decode($input_bank);
                                                if($input_bank->status == 1)
                                                {
                                                    echo $sistemApp->alert("success","Soal Berhasil Di Tambahkan","Tunggu Anda Akan di alihkan","./?page=bank-soa","2");
                                                }else{
                                                    echo $sistemApp->alert("danger","Soal Gagal Di Tambah","Error Sistem :".$input_bank->error);
                                                }
                                            }else{
                                                echo $sistemApp->alert("danger","Error","Isi Semua Field");
                                            }
                                        }else{
                                            echo $sistemApp->alert("danger","Error","Maaf Jawaban Harus Berupa Huruf Tunggal!");
                                           
                                        }
                                    }else{
                                         echo $sistemApp->alert("danger","Error","Maaf Salah Satu $\_POST\ tidak ada");
                                    }
                                }
                                
                                ?>
                                    <div class="form-group">
                                        <label for="soal" class="col-sm-2 control-label">Soal</label>
                                        <div class="col-sm-10">
                                            <textarea name="soal" class="form-control" id="soal"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="pilihan-ganda" class="col-sm-2 control-label">Pilihan Ganda</label>
                                        <div class="col-sm-10">
                                            <span class="bg-red form-control-feedback">A</span>
                                            <input name="pilih_a" type="text" class="form-control" placeholder="Pilihan A">
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="pilihan-ganda" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-10">
                                            <span class="bg-red form-control-feedback">B</span>
                                            <input name="pilih_b" type="text" class="form-control" placeholder="Pilihan B">
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="pilihan-ganda" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-10">
                                            <span class="bg-red form-control-feedback">C</span>
                                            <input name="pilih_c" type="text" class="form-control" placeholder="Pilihan C">
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="pilihan-ganda" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-10">
                                            <span class="bg-red form-control-feedback">D</span>
                                            <input name="pilih_d" type="text" class="form-control" placeholder="Pilihan D">
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="pilihan-ganda" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-10">
                                            <span class="bg-red form-control-feedback">E</span>
                                            <input name="pilih_e" type="text" class="form-control" placeholder="Pilihan E">
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="jawaban-ganda" class="col-sm-2 control-label">Jawaban</label>
                                        <div class="col-sm-10">
                                            <input name="jawaban" type="text" class="form-control" placeholder="Ex : A">
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
        </div>
        <?php }else{$frontend->err404();}}}else{?>
            <?php 
            if($_GET["change"] != "" && isset($_GET["uuid"])){
                $hitung_data = json_decode($db->hitung_data("sistem_bank_soal","id_bank_soal",$_GET["change"]));
               if($_GET["uuid"] == $sistemApp->enkripsi($_GET["change"]) && $hitung_data->total > 0)
               {
                   $data_soal = $db->select_db("sistem_bank_soal",array("id_bank_soal","soal","pilihan","jawaban"),"id_bank_soal",$_GET["change"]);
                  $data_soal = json_decode($data_soal);
                  $data_pilihan = json_decode($sistemApp->encode_escape($data_soal[0]->pilihan));
                   
            ?>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <b>Ubah Bank Soal</b>
                            </div>
                            <div class="box-body">
                                <form class="form-horizontal" action="" method="post" id="form-bank-soal">
                                    <div class="box-body">
                                        <?php 
                                if(isset($_POST["frm_bank_soal"]))
                                {
                                    if(strlen($_POST["jawaban"]) == 1)
                                    {
                                        if(isset($_POST["soal"]) && isset($_POST["pilih_a"]) && isset($_POST["pilih_b"]) && isset($_POST["pilih_c"]) && isset($_POST["pilih_d"]) && isset($_POST["pilih_e"]) && isset($_POST["jawaban"]))
                                        {
                                            $data_update = $db->update_db("sistem_bank_soal",array("soal","pilihan","jawaban","tgl_buat"),array($_POST["soal"],json_encode(array("A"=>$_POST["pilih_a"],"B"=>$_POST["pilih_b"],"C"=>$_POST["pilih_c"],"D"=>$_POST["pilih_d"],"E"=>$_POST["pilih_e"])),$_POST["jawaban"],date("d-m-Y")),"id_bank_soal",$_GET["change"]);
                                            $data_update = json_decode($data_update);
                                            if($data_update->status == 1)
                                            {
                                                echo $sistemApp->alert("success","Data Telah Di Update","Data Berhasil Di Perbaharui");
                                            }else{
                                                echo $sistemApp->alert("danger","Error Ditemukan","MYSQL Error :".$data_update->error);
                                            }
                                        }else{
                                            echo $sistemApp->alert("danger","Error Ditemukan","Maaf Terdeteksi Perubahan Elements");
                                        }
                                    }else{
                                        echo $sistemApp->alert("danger","Error Ditemukan","Maaf Jawaban Harus Berupa Huruf Tunggal");
                                    }
                                }
                                
                                ?>
                                            <div class="form-group">
                                                <label for="soal" class="col-sm-2 control-label">Soal</label>
                                                <div class="col-sm-10">
                                                    <textarea name="soal" class="form-control" id="soal">
                                                        <?php echo $data_soal[0]->soal; ?>
                                                    </textarea>
                                                </div>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label for="pilihan-ganda" class="col-sm-2 control-label">Pilihan Ganda</label>
                                                <div class="col-sm-10">
                                                    <span class="bg-red form-control-feedback">A</span>
                                                    <input name="pilih_a" type="text" class="form-control" value="<?php echo (empty($data_pilihan->A))?null:$data_pilihan->A;?>" placeholder="Pilihan A">
                                                </div>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label for="pilihan-ganda" class="col-sm-2 control-label"></label>
                                                <div class="col-sm-10">
                                                    <span class="bg-red form-control-feedback">B</span>
                                                    <input name="pilih_b" type="text" value="<?php echo (empty($data_pilihan->B))?null:$data_pilihan->B;?>" class="form-control" placeholder="Pilihan B">
                                                </div>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label for="pilihan-ganda" class="col-sm-2 control-label"></label>
                                                <div class="col-sm-10">
                                                    <span class="bg-red form-control-feedback">C</span>
                                                    <input name="pilih_c" type="text" value="<?php echo (empty($data_pilihan->C))?null:$data_pilihan->C;?>" class="form-control" placeholder="Pilihan C">
                                                </div>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label for="pilihan-ganda" class="col-sm-2 control-label"></label>
                                                <div class="col-sm-10">
                                                    <span class="bg-red form-control-feedback">D</span>
                                                    <input name="pilih_d" type="text" value="<?php echo (empty($data_pilihan->D))?null:$data_pilihan->D;;?>" class="form-control" placeholder="Pilihan D">
                                                </div>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label for="pilihan-ganda" class="col-sm-2 control-label"></label>
                                                <div class="col-sm-10">
                                                    <span class="bg-red form-control-feedback">E</span>
                                                    <input name="pilih_e" type="text" value="<?php echo (empty($data_pilihan->E))?null:$data_pilihan->E;?>" class="form-control" placeholder="Pilihan E">
                                                </div>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label for="jawaban-ganda" class="col-sm-2 control-label">Jawaban</label>
                                                <div class="col-sm-10">
                                                    <input name="jawaban" type="text" value="<?php echo $data_soal[0]->jawaban;?>" class="form-control" placeholder="Ex : A">
                                                </div>
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
                <?php
            }else{$frontend->err404();}}else{ $frontend->err404(); }
            ?>

                    <?php }?>
<?php
}else{
$frontend->err404();
}
}
?>
