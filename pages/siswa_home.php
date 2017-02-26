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
                    <b>Rangkuman Nilai</b>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped rekap-nilai">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Ujian</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $id_siswa = $_SESSION["id_user"];
                            $id_soal = json_decode($sistemApp->buka_jawaban_siswa($id_siswa));
                            foreach($id_soal as $obj_soal)
                            {
                                $rekap_id[] = $obj_soal->soal_id;
                            }
                            if(!empty($rekap_id))
                            {
                            $no = 1;
                            foreach ($rekap_id as $obj_id)
                            {   
                                $nilai = json_decode($sistemApp->open_soal($obj_id));
                                $rekap_nilai = json_decode($sistemApp->hitung_jawaban($nilai->master_data->nilai_per_soal,$id_siswa,$obj_id));
                                //print_r($rekap_nilai);
                                foreach($rekap_nilai as $obj_nilai)
                                {
                                    
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $no++; ?>
                                    </td>
                                    <td>
                                        <?php  echo $obj_nilai->judul_soal;?>
                                    </td>
                                    <td>
                                        <?php  echo $obj_nilai->nilai;?>
                                    </td>
                                </tr>
                                <?php }}}else{?>
                                    <tr>
                                        <td>Tidak Ada Rekap Nilai</td>
                                        <td>Tidak Ada Rekap Nilai</td>
                                        <td>Tidak Ada Rekap Nilai</td>

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
                    <table class="table table-bordered table-striped rekap-nilai">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pengumuman</th>
                                    <th>Kelas</th>
                                    <th>Tanggal</th>
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
                                    </tr>
                                <?php }else{ 
                                    $no = 1;
                                    $data_ann = json_decode($db->custom_query("SELECT sistem_pengumuman.id_pengumuman,sistem_pengumuman.tgl_input,sistem_pengumuman.id_kelas,sistem_pengumuman.isi,sistem_kelas.nama_kelas FROM sistem_pengumuman JOIN sistem_kelas ON sistem_kelas.id_kelas = sistem_pengumuman.id_kelas WHERE sistem_pengumuman.id_kelas =".$_SESSION["id_kelas"]));
                                   foreach($data_ann as $ann)
                                   {
                                ?>
                                    <tr>
                                        <td><?php echo $no++;?></td>
                                        <td><?php echo htmlspecialchars_decode($ann->isi);?></td>
                                        <td><?php echo $ann->nama_kelas;?></td>
                                        <td><?php echo $ann->tgl_input;?></td>
                                    </tr>
                                <?php }}?>
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
