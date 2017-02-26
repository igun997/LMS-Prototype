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
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <b>Lihat Nilai</b>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-sthiped lihat-nilai">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Ujian</th>
                                <th>Skor Per Soal</th>
                                <th>Waktu Pengerjaan</th>
                                <th>Nilai KKM</th>
                                <th>Waktu Mengerjakan</th>
                                <th>Nilai Akhir</th>
                                <th>Status Kelulusan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no= 1;
                                $hitung_dulu = json_decode($db->hitung_data("sistem_jawaban","siswa_id",$_SESSION["id_user"]));
                                if($hitung_dulu->total != 0)
                                {
                                $jawaban = json_decode($sistemApp->buka_jawaban_siswa($_SESSION["id_user"]));
                                foreach($jawaban as $obj_jawab)
                                {
                                    $data_points = json_decode($sistemApp->open_soal($obj_jawab->soal_id));
                                    $data_nilai_per_soal = $data_points->master_data->nilai_per_soal;
                                    $nilai = json_decode($sistemApp->hitung_jawaban($data_nilai_per_soal,$_SESSION["id_user"],$obj_jawab->soal_id));
                                    $data_nilai = $nilai->data->nilai;
                                    $data_nama_ujian = $data_points->master_data->judul_soal;
                                    $data_nilai_kkm = $data_points->master_data->nilai_kkm;
                                    $tgl_dikerjakan = $obj_jawab->waktu_mengerjakan;
                                    $pengerjaan = $data_points->master_data->tgl_buat;
                                    $data[] = array("nama_ujian"=>$data_nama_ujian,"skor_per_soal"=>$data_nilai_per_soal,"pengerjaaan"=>$pengerjaan,"nilai_akhir"=>$data_nilai,"dikerjakan"=>$tgl_dikerjakan,"nilai_kkm"=>$data_nilai_kkm);
                                }
                            foreach($data as $obj_data){
                            ?>
                            <tr>
                                <td><?php echo $no++;?></td>
                                <td><?php echo $obj_data['nama_ujian'];?></td>
                                <td><?php echo $obj_data['skor_per_soal'];?></td>
                                <td><?php echo $obj_data['pengerjaaan'];?></td>
                                <td><?php echo $obj_data['nilai_kkm'];?></td>
                                <td><?php echo $obj_data['dikerjakan'];?></td>
                                <td><?php echo $obj_data['nilai_akhir'];?></td>
                                <td><?php echo ($obj_data["nilai_kkm"] > $obj_data["nilai_akhir"])?"<span class='label bg-red'>Tidak Lulus</span>":"<span class='label bg-green'>Lulus</span>";?></td>
                            </tr>
                            <?php }}else{?>
                                <td>1</td>
                                <td>DATA KOSONG</td>
                                <td>DATA KOSONG</td>
                                <td>DATA KOSONG</td>
                                <td>DATA KOSONG</td>
                                <td>DATA KOSONG</td>
                                <td>DATA KOSONG</td>
                                <td>DATA KOSONG</td>
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
