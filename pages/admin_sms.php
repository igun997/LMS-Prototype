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
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <b>Pengaturan SMS Center</b>
                </div>
                <div class="box-body">
                    <?php 
                    if($status_config == true)
                    {
                        echo $sistemApp->alert("success","Pengaturan Sudah DI Atur","Silahkan Check Status Server");
                    }else{
                        echo $sistemApp->alert("danger","Pengaturan Belum DI Atur","Silahkan Isi Pengaturan Server");
                    }?>
                        <?php
                        if(isset($_POST["frm_set"]))
                        {
                            if(isset($_POST["u_api"]) && isset($_POST["p_api"]))
                            {
                                if($status_config == true)
                                {
                                    $set = json_decode($db->update_db("p_sms",array("user_api","pass_api"),array($_POST["u_api"],$_POST["p_api"]),"user_api",$open_sms[0]->user_api));
                                }else{
                                    $set = json_decode($db->insert_db("p_sms",array("user_api","pass_api"),array($_POST["u_api"],$_POST["p_api"])));
                                }
                                if($set->status == 1)
                                {
                                    echo $sistemApp->alert("success","Data Disimpan","Data Server Telah Di Simpan");
                                    echo $sistemApp->alihkan("./?page=set-sms",200);
                                }else{
                                    echo $sistemApp->alert("danger","Error Ditemukan","SQL Error:".$set->error); 
                                }
                            }else{
                                echo $sistemApp->alert("danger","Error Ditemukan","Elemen Tidak Ada");
                            }
                        }
                    ?>
                            <form class="form-horizontal" method="post" action="">
                                <div class="form-group has-feedback">
                                    <label for="pilihan-ganda" class="col-sm-2 control-label">Username API</label>
                                    <div class="col-sm-10">
                                        <input name="u_api" type="text" class="form-control" value="<?php echo (empty($open_sms[0]->user_api))?" ":$open_sms[0]->user_api;?>" required>
                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="pilihan-ganda" class="col-sm-2 control-label">Password API</label>
                                    <div class="col-sm-10">
                                        <input name="p_api" type="text" class="form-control" value="<?php echo (empty($open_sms[0]->pass_api))?" ":$open_sms[0]->pass_api;?>" required>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button name="form_change" onclick="javascript:$('.set').prop('disabled', false);" type="button" class="btn btn-default">Ubah Setting</button>
                                    <button type="submit" name="frm_set" class="btn btn-info pull-right set" <?php echo ($status_config==true)? "disabled": "";?> >Simpan Perubahan</button>
                                </div>
                            </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <b>Status Server SMS</b>
                </div>
                <div class="box-body">
                    <?php if($status_config != false){ ?>
                        <a href="./?page=set-sms&checkServer" class="btn btn-danger">Check Server</a>
                        <?php 
                        if(isset($_GET["checkServer"]))
                        {
                            $status  = json_decode($sistemApp->checkServer($open_sms[0]->user_api,$open_sms[0]->pass_api));
                            if(!isset($status->status))
                            {
                               echo "<p>".$sistemApp->alert("success","Server Aktif","Pulsa Utama Credit :".$status->message->value)."</p>"; 
                            }else{
                                echo "<p>".$sistemApp->alert("danger","Server Offline","Server Sedang Ofline ..")."</p>"; 
                            }
                            
                        }
                    ?>
                            <p>*Check Server Memerlukan Biaya Sebesar Rp.20 Dari Pulsa Utama</p>
                            <?php }else{echo $sistemApp->alert("danger","Error Ditemukan","Silahkan Set API Server Pulsa");}?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <b>Kirim SMS Pengumuman</b>
                </div>
                <div class="box-body">
                    <?php
                    if(isset($_POST["form_sender"]))
                    {
                        //print_r($_POST);
                        if(isset($_POST["no_tujuan"]) && isset($_POST["isi_sms"]))
                        {
                            if($_POST["no_tujuan"] != "" && is_numeric($_POST["no_tujuan"]) && $_POST["isi_sms"])
                            {
                                $send = json_decode($sistemApp->SendSMS($open_sms[0]->user_api,$open_sms[0]->pass_api,$_POST["no_tujuan"],$_POST["isi_sms"]));
                                if($send->message->text == "Success")
                                {
                                    echo $sistemApp->alert("success","Pengiriman Sukses","SMS Ke Nomor :".$send->message->to."<br>Status : Sukses");
                                }else{
                                    echo $sistemApp->alert("danger","Pengiriman Gagal","Error");
                                }
                                
                            }else{
                                echo $sistemApp->alert("danger","Error Ditemukan","Isi Semua Field");
                            }
                            
                        }else{
                            echo $sistemApp->alert("danger","Error Ditemukan","Isi Semua Field");
                        }
                    }
                    ?>
                        <form class="form-horizontal" method="post" action="">
                            <div class="form-group has-feedback">
                                <label for="pilihan-ganda" class="col-sm-2 control-label">Nomor Tujuan</label>
                                <div class="col-sm-10">
                                    <input name="no_tujuan" type="number" class="form-control" value="" required>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="pilihan-ganda" class="col-sm-2 control-label">Isi Pesan</label>
                                <div class="col-sm-10">
                                    <textarea name="isi_sms"></textarea>
                                </div>
                            </div>
                            <div class="box-footer">
                                    <button name="form_sender" type="submit" class="btn btn-default">Kirim SMS</button>
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
