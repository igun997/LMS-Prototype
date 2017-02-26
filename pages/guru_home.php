<?php
if(isset($_SESSION["level_user"]))
{
if($_SESSION["level_user"] == 2)
{
    $sistemApp = new sistemApp;
    $db        = new BukaDB;
    $frontend   = new frontend_app;
?>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <b>Proggress Pengerjaan Ujian</b>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped rekap-nilai">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Ujian</th>
                                <th>Kelas</th>
                                <th>Di Buat</th>
                                <th>Total Pengerjaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $data = $sistemApp->rekap_soal($_SESSION["id_user"]);
                            $data = json_decode($data);
                            //print_r($data);
                            $no = 1;
                            foreach($data as $obj_data)
                            {
                                $total = json_decode($db->hitung_data("sistem_jawaban","soal_id",$obj_data->id_soal));
                                $persentase = json_decode($db->hitung_data("user_siswa","kelas_id",$obj_data->id_kelas));
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $no++;?>
                                    </td>
                                    <td>
                                        <?php echo $obj_data->judul_soal;?>
                                    </td>
                                    <td>
                                        <?php echo $obj_data->nama_kelas;?>
                                    </td>
                                    <td>
                                        <?php echo $obj_data->tgl_buat;?>
                                    </td>
                                    <td>
                                        <?php echo round(($total->total*100)/$persentase->total)."%";?>
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
                    <b>Pengumuman</b>
                </div>
                <div class="box-body">
                    <?php 
                        if(!isset($_GET["p-edit"]))
                        {
                        if(!isset($_GET["tambah-pengumuman"]))
                        {
                    ?>
                        <div class="input-group">
                            <a href="./?tambah-pengumuman" class="btn btn-success">
                                <li class="fa fa-plus"></li> Tambah Data</a>
                        </div>
                        <br>
                        <?php 
                         $masuk = (isset($_GET["uuid"]) && $_GET["uuid"] == $sistemApp->enkripsi($_GET["p-hapus"]))?true:false;
                        if($masuk == true)
                        {
                            $cek_hapus = json_decode($db->hitung_data("sistem_pengumuman","id_pengumuman",$_GET["p-hapus"]));
                            if($cek_hapus->total > 0)
                            {
                            $hapus = json_decode($db->delete_db("sistem_pengumuman","id_pengumuman",$_GET["p-hapus"]));
                            if($hapus->status == 1)
                            {
                                echo $sistemApp->alert("success","Proses Hapus Berhasil","Tunggu Anda Akan Di Alihkan");
                                echo $sistemApp->alihkan("./",200);
                            }else{
                                echo $sistemApp->alert("danger","Error Ditemukan","SQL Error:".$hapus->error);
                            }
                            }else{
                                echo $sistemApp>alert("danger","Error Ditemukan","Id Tidak Ditemukan");
                            }
                        }
                        ?>
                        <table class="table table-bordered table-striped rekap-nilai">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pengumuman</th>
                                    <th>Kelas</th>
                                    <th>Tanggal</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $hitung_ann = json_decode($db->hitung_data("sistem_pengumuman"));
                                if($hitung_ann->total == 0)
                                {
                                ?>
                                    <tr>
                                        <td>Data Kosong</td>
                                        <td>Data Kosong</td>
                                        <td>Data Kosong</td>
                                        <td>Data Kosong</td>
                                        <td>Data Kosong</td>
                                    </tr>
                                <?php }else{ 
                                    $no = 1;
                                    $data_ann = json_decode($db->custom_query("SELECT  sistem_pengumuman.tgl_input,sistem_pengumuman.id_pengumuman,sistem_pengumuman.id_kelas,sistem_pengumuman.isi,sistem_kelas.nama_kelas FROM sistem_pengumuman JOIN sistem_kelas ON sistem_kelas.id_kelas = sistem_pengumuman.id_kelas"));
                                   foreach($data_ann as $ann)
                                   {
                                ?>
                                    <tr>
                                        <td><?php echo $no++;?></td>
                                        <td><?php echo htmlspecialchars_decode($ann->isi);?></td>
                                        <td><?php echo $ann->nama_kelas;?></td>
                                        <td><?php echo $ann->tgl_input;?></td>
                                        <td>
                                            <a href="./?p-edit=<?php echo $ann->id_pengumuman;?>&uuid=<?php echo $sistemApp->enkripsi($ann->id_pengumuman);?>" class="btn btn-warning"><li class="fa fa-edit"></li> Edit Data</a>
                                            <a href="./?p-hapus=<?php echo $ann->id_pengumuman;?>&uuid=<?php echo $sistemApp->enkripsi($ann->id_pengumuman);?>" class="btn btn-danger"><li class="fa fa-ban"></li> Hapus Data</a>
                                        </td>
                                    </tr>
                                <?php }}?>
                            </tbody>
                        </table>

                        <?php }else{?>
                            <?php 
                    if(isset($_POST["form_annaounce"]) && isset($_POST["isi"]) && isset($_POST["kelas"]))
                    {
                        $cek_isi = ($_POST["isi"] == null)?false:true;
                        $cek_kelas = ($_POST["kelas"] == null)?false:true;
                        if($cek_isi AND $cek_kelas != null)
                        {
                            $cek_kelas = json_decode($db->hitung_data("sistem_kelas","id_kelas",$_POST["kelas"]));
                            if($cek_kelas->total > 0)
                            {
                                $input_data = json_decode($db->insert_db("sistem_pengumuman",array("isi","id_kelas","id_guru","tgl_input"),array($_POST["isi"],$_POST["kelas"],$_SESSION["id_user"],date("d-m-Y"))));
                                if($input_data->status == 1)
                                {
                                     echo $sistemApp->alert("success","Proese Simpan Berhasil","Tunggu Anda Akan Di Alihkan");
                                     echo $sistemApp->alihkan("./index.php","200");
                                }else{
                                    echo $sistemApp->alert("danger","Error Ditemukan","SQL ERROR :".$input_data->error);
                                }
                            }else{
                                echo $sistemApp->alert("danger","Error Ditemukan","Maaf Kelas Yang Anda Pilih Tidak Ada");
                            }
                        }else{
                            echo $sistemApp->alert("danger","Error Ditemukan","Isi Semua Form");
                        }
                    }
                    ?>
                    <div class="input-group">
                            <a href="./" class="btn btn-primary">
                                <li class="fa fa-arrow-left"></li> Kembali</a>
                        </div>
                        <br>
                                <form class="form-horizontal" method="post" action="">
                                    <div class="form-group">
                                        <label for="soal" class="col-sm-2 control-label">Isi Pengumuman</label>
                                        <div class="col-sm-10">
                                            <textarea name="isi"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="soal" class="col-sm-2 control-label">Kelas</label>
                                        <div class="col-sm-10">
                                            <select name="kelas" class="pilihan-kelas form-control select2">
                                                <?php 
                                $buka_kelas = json_decode($db->select_db("sistem_kelas",array("id_kelas","nama_kelas")));
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
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <button class="btn btn-success" name="form_annaounce" type="submit">Publikasikan</button>
                                        </div>
                                    </div>

                                </form>
                                <?php }}else{
                                $masuk = (isset($_GET["uuid"]) && $_GET["uuid"] == $sistemApp->enkripsi($_GET["p-edit"]))?true:false;
                                if($masuk == true)
                                {
                                    $buka_request = json_decode($db->custom_query("SELECT sistem_pengumuman.id_pengumuman,sistem_pengumuman.id_kelas,sistem_pengumuman.isi,sistem_kelas.nama_kelas FROM sistem_pengumuman JOIN sistem_kelas ON sistem_kelas.id_kelas = sistem_pengumuman.id_kelas WHERE sistem_pengumuman.id_pengumuman =".$db->sql_escape($_GET["p-edit"])));
                                    //print_r($buka_request);
                                    
                                ?>
                                <?php 
                                if(isset($_POST["form_annaounce"]) && isset($_POST["isi"]) && isset($_POST["kelas"]))
                                {
                                    $cek_isi = ($_POST["isi"] == null)?false:true;
                                    $cek_kelas = ($_POST["kelas"] == null)?false:true;
                                    if($cek_isi AND $cek_kelas != null)
                                    {
                                        $cek_kelas = json_decode($db->hitung_data("sistem_kelas","id_kelas",$_POST["kelas"]));
                                        if($cek_kelas->total > 0)
                                        {
                                            $input_data = json_decode($db->update_db("sistem_pengumuman",array("isi","id_kelas","id_guru","tgl_input"),array($_POST["isi"],$_POST["kelas"],$_SESSION["id_user"],date("d-m-Y")),"id_pengumuman",$_GET["p-edit"]));
                                            if($input_data->status == 1)
                                            {
                                                 echo $sistemApp->alert("success","Proese Simpan Berhasil","Tunggu Anda Akan Di Alihkan");
                                                 echo $sistemApp->alihkan("./index.php","200");
                                            }else{
                                                echo $sistemApp->alert("danger","Error Ditemukan","SQL ERROR :".$input_data->error);
                                            }
                                        }else{
                                            echo $sistemApp->alert("danger","Error Ditemukan","Maaf Kelas Yang Anda Pilih Tidak Ada");
                                        }
                                    }else{
                                        echo $sistemApp->alert("danger","Error Ditemukan","Isi Semua Form");
                                    }
                                }
                                ?>
                            
                                <div class="input-group">
                                    <a href="./" class="btn btn-primary">
                                        <li class="fa fa-arrow-left"></li> Kembali</a>
                                </div>
                                <br>
                                        <form class="form-horizontal" method="post" action="">
                                            <div class="form-group">
                                                <label for="soal" class="col-sm-2 control-label">Isi Pengumuman</label>
                                                <div class="col-sm-10">
                                                    <textarea name="isi"><?php echo htmlspecialchars_decode($buka_request[0]->isi); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="soal" class="col-sm-2 control-label">Kelas</label>
                                                <div class="col-sm-10">
                                                    <select name="kelas" class="pilihan-kelas form-control select2">
                                                        <option value="<?php echo $buka_request[0]->id_kelas; ?>" selected><?php echo $buka_request[0]->nama_kelas;?></option>
                                                        <?php 
                                                        $buka_kelas = json_decode($db->select_db("sistem_kelas",array("id_kelas","nama_kelas")));
                                                        foreach($buka_kelas as $kelas)
                                                        {
                                                            if($kelas->id_kelas == $buka_request[0]->id_kelas)
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
                                            <div class="form-group">
                                                <div class="col-sm-10">
                                                    <button class="btn btn-success" name="form_annaounce" type="submit">Publikasikan</button>
                                                </div>
                                            </div>

                                        </form>
                                <?php }else{echo $sistemApp->alert("danger","Error DItemukan","Masalah Verifikasi");}}?>
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
