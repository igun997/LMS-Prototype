<?php
if(isset($_SESSION["level_user"]))
{
if($_SESSION["level_user"] == 2)
{
    $sistemApp = new sistemApp;
    $db        = new BukaDB;
    $frontend   = new frontend_app;
    if(!isset($_GET["tambah-soal"]))
    {
?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <b>Analisis Pekerjaan Siswa</b>
                </div>
                <div class="box-body">
                    <div class="box-body">
                        <?php 
                        if(isset($_GET["req"]))
                        {
                            if(isset($_GET["uuid"]))
                            {
                                if($_GET["uuid"] == $sistemApp->enkripsi($_GET["req"]))
                                {
                                    $hitung_reseter = json_decode($db->hitung_data("sistem_reset","id_jawaban",$_GET["req"]));
                                    if($hitung_reseter->total == 0)
                                    {
                                        $req = explode("-",$_GET["req"]);
                                        $input_data = json_decode($db->insert_db("sistem_reset",array("status","id_siswa","id_guru","id_jawaban"),array(0,$req[1],$_SESSION["id_user"],$req[0])));
                                        if($input_data->status == 1)
                                        {
                                            echo $sistemApp->alert("success","Permintaan Anda Telah Terkirim","Tunggu Anda Akan Di Alihkan . . .");
                                            echo $sistemApp->alihkan("./?page=analisis-soal",200);
                                        }else{
                                             echo $sistemApp->alert("danger","Error Ditemukan","MYSQL Error :".$input_data->error);
                                        }
                                        
                                    }else{
                                        echo $sistemApp->alert("warning","Anda Sudah Melakukan Permintaan","Permintaan Anda Sedang Dalam Antrian Mohon Tunggu . . .");
                                    }
                                }else{
                                    echo $sistemApp->alert("danger","Error Ditemukan","Verifikasi Gagal");
                                }
                            }else{
                                echo $sistemApp->alert("danger","Error Ditemukan","Tidak Ada UUID");
                            }
                        }
                        ?>
                        <table class="table table-bordered table-striped rekap-nilai">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Ujian</th>
                                    <th>Kelas</th>
                                    <th>Nilai</th>
                                    <th>Analisis Kesalahan</th>
                                    <th>Nilai KKM</th>
                                    <th>Waktu Pengerjaan</th>
                                    <th>Status</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $list_analisis = json_decode($sistemApp->analisis($_SESSION["id_user"]));
                                if(!empty($list_analisis))
                                {
                                $no = 1;
                                foreach($list_analisis as $obj_analisis)
                                {
                                ?>
                                <tr>
                                    <td><?php echo $no++;?></td>
                                    <td><?php echo $obj_analisis->nama;?></td>
                                    <td><?php echo $obj_analisis->ujian;?></td>
                                    <td><?php echo $obj_analisis->kelas;?></td>
                                    <td><?php echo $obj_analisis->nilai;?></td>
                                    <td>
                                        <?php 
                                        $analisis = json_decode($sistemApp->hitung_jawaban(1,$obj_analisis->id_siswa,$obj_analisis->id_soal));
                                        foreach($analisis as $obj_anal)
                                        {
                                            if($obj_anal->salah == "Tidak Ada"){
                                        ?>
                                        <p>Tidak Ada Kesalahan</p>
                                        <?php }else{
                                        $wrong = json_decode($obj_anal->salah);
                                        foreach($wrong as $obj_wrong)
                                        {
                                        ?>
                                        <center><p class="label bg-red">Soal No <?php echo $obj_wrong->index_soal; ?></p></center>
                                        <center><?php echo htmlspecialchars_decode($obj_wrong->soal);?></center>
                                        <p class="label bg-red">Jawaban Siswa : <?php echo $obj_wrong->jawaban;?></p>
                                        <p class="label bg-green">Kunci Jawaban : <?php echo $obj_wrong->kunci_jawaban;?></p>
                                        <hr>
                                        <?php }?>
                                        <?php }?>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $obj_analisis->nilai_kkm;?></td>
                                    <td><?php echo $obj_analisis->tgl_input;?></td>
                                    <td><?php echo ($obj_analisis->nilai < $obj_analisis->nilai_kkm)?'<span class="label bg-red">Tidak Lulus</span>':'<span class="label bg-green">Lulus</span>';?></td>
                                    <td>
                                        <?php 
                                        $hitung_setter = json_decode($db->hitung_data("sistem_reset","id_jawaban",$obj_analisis->id_jawaban,"id_siswa",$obj_analisis->id_siswa));
                                        if($hitung_setter->total == 0)
                                        {
                                        ?>
                                        <a href="./?page=analisis-soal&req=<?php echo $obj_analisis->id_jawaban."-".$obj_analisis->id_siswa;?>&uuid=<?php echo $sistemApp->enkripsi($obj_analisis->id_jawaban."-".$obj_analisis->id_siswa);?>" class="btn btn-danger"><li class="fa fa-ban"></li> Permintaan Reset</a>
                                        <?php }else{ ?>
                                        <a href="javascript:void(0);" class="btn btn-success" disabled><li class="fa fa-ban"></li> Anda Sudah Melakukan Permintaan Reset</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php } }else{ ?>
                                <tr>
                                    <td>Data Kosong</td>
                                    <td>Data Kosong</td>
                                    <td>Data Kosong</td>
                                    <td>Data Kosong</td>
                                    <td>Data Kosong</td>
                                    <td>Data Kosong</td>
                                    <td>Data Kosong</td>
                                    <td>Data Kosong</td>
                                    <td>Data Kosong</td>
                                    <td>Data Kosong</td>
                                </tr>
                                <?php } ?>  
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php
}
}else{
$frontend->err404();
}
}
?>
