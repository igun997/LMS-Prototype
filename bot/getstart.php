<?php
    include ("./../class/core.class.php");
    $db = new BukaDB;
    $sistemApp = new sistemApp;
    $TOKEN="342545883:AAFGM85wq19a-XWvXy2J6NtbNkarxvA3c4o";
    function request_url($method)
    {
     global $TOKEN;
     
     return "https://api.telegram.org/bot" . $TOKEN . "/". $method;
    }
    function send_reply($chatid, $msgid, $text)
    {
     $data = array(
     'parse_mode' => 'HTML',
     'chat_id' => $chatid,
     'text' => $text,
     'disable_web_page_preview' => true
     //'reply_to_message_id' => $msgid
     );
     // use key 'http' even if you send the request to https://...
     $options = array(
     'http' => array(
     'header' => "Content-type: application/x-www-form-urlencoded\r\n",
     'method' => 'POST',
     'content' => http_build_query($data),
     ),
     );
     $context = stream_context_create($options);
     $result = file_get_contents(request_url('sendMessage'), false, $context);
    }
    function create_response($text)
    {
    global $db;
    global $sistemApp;
     $hitung_sub = substr_count($text,".");
    if($hitung_sub == 2)
    {
        $text_cmd = explode(".",$text);
        if($text_cmd[0] == "ujian")
        {
           $cek_user = json_decode($db->hitung_data("user_siswa","user_siswa",$text_cmd[1],"pass_siswa",$sistemApp->enkripsi($text_cmd[2])));
            if($cek_user->total != 0)
            {
               $access = json_decode($db->custom_query("SELECT user_siswa.id_siswa,sistem_soal.id_soal,sistem_soal.judul_soal as nama_ujian,sistem_soal.tgl_buat,sistem_kelas.nama_kelas FROM sistem_kelas JOIN sistem_soal ON sistem_soal.id_kelas = sistem_kelas.id_kelas JOIN user_siswa ON user_siswa.kelas_id = sistem_kelas.id_kelas WHERE user_siswa.user_siswa ='".$db->sql_escape($text_cmd[1])."'"));
                $result = "[DAFTAR SOAL]\n";
                foreach($access as $obj_data)
                {
                    $cek = json_decode($db->hitung_data("sistem_jawaban","soal_id",$obj_data->id_soal,"siswa_id",$obj_data->id_siswa));
                    if($cek->total > 0)
                    {
                        $result .= $obj_data->nama_ujian."-".$obj_data->tgl_buat." [Sudah Mengerjakan]\n";
                    }else{
                        $result .= $obj_data->nama_ujian."-".$obj_data->tgl_buat." [Belum Mengerjakan]\n";
                    }
                }
            }else{
                $result = "Username dan Password Salah !";
            }
        }else{
            if($text_cmd[0] == "nilai")
            {
                $cek_user = json_decode($db->custom_query("SELECT id_siswa FROM user_siswa WHERE user_siswa.user_siswa = '".$db->sql_escape($text_cmd[1])."' AND user_siswa.pass_siswa ='".$db->sql_escape($sistemApp->enkripsi($text_cmd[2]))."'"));
                if(!empty($cek_user))
                {
                   $getNilai = json_decode($db->custom_query("SELECT sistem_soal.judul_soal as nama_ujian,sistem_jawaban.waktu_mengerjakan as waktu_pengerjaan,sistem_soal.nilai_lulus,sistem_nilai.nilai FROM sistem_nilai JOIN sistem_soal ON sistem_soal.id_soal = sistem_nilai.id_soal JOIN sistem_jawaban ON sistem_jawaban.id_jawaban = sistem_nilai.id_jawaban WHERE sistem_nilai.id_siswa = ".$cek_user[0]->id_siswa));
                   $result ="";
                   foreach($getNilai as $obj_nilai)
                   {
                       $lulus = ($obj_nilai->nilai >= $obj_nilai->nilai_lulus)?"LULUS":"TIDAK LULUS";
                       $result .="Nilai Pada Ujian [".$obj_nilai->nama_ujian."] Adalah ".$obj_nilai->nilai." Dikerjakan Pada ".$obj_nilai->waktu_pengerjaan." [SISWA DINYATAKAN ".$lulus."]\n\n";
                   }
                }else{
                    $result = "Username dan Password Salah !";
                }
            }else{
                if($text_cmd[0] == "pengumuman")
                {
                    $cek_user = json_decode($db->custom_query("SELECT id_siswa,kelas_id FROM user_siswa WHERE user_siswa.user_siswa = '".$db->sql_escape($text_cmd[1])."' AND user_siswa.pass_siswa ='".$db->sql_escape($sistemApp->enkripsi($text_cmd[2]))."'"));
                    if(!empty($cek_user))
                    {
                       $getPegumuman = json_decode($db->custom_query("SELECT sistem_pengumuman.isi as isi_pengumuman,sistem_pengumuman.tgl_input, user_guru.nama_guru FROM sistem_pengumuman JOIN user_guru ON user_guru.id_guru = sistem_pengumuman.id_guru WHERE sistem_pengumuman.id_kelas =".$cek_user[0]->kelas_id));
                       $result ="";
                       foreach($getPegumuman as $obj_umum)
                       {
                          $result .="Pengumuman :".strip_tags(htmlspecialchars_decode($obj_umum->isi_pengumuman))."\nDari :".$obj_umum->nama_guru."\nTanggal Dibuat :".$obj_umum->tgl_input;
                       }
                    }else{
                        $result = "Username dan Password Salah !";
                    }
                }
            }
        }
    }else{
        $result = "[SELAMAT DATANG DI SISTEM TERPADU LMS PROTOTYPE]\nSilahkan Gunakan Command Di Bawah Untuk Mengakses Sistem\n[aksi].[user].[pass]\n[AKSI YANG TERSEDIA]\n[ujian].[user].[pass]\n[nilai].[user].[pass]\n[pengumuman].[user].[pass]\nKhusus Command List Admin Kontak Bagian ICT";
    }
    
     return $result;
    }
    function process_message($message)
    {
     $updateid = $message["update_id"];
     $message_data = $message["message"];
     if (isset($message_data["text"])) {
     $chatid = $message_data["chat"]["id"];
     $message_id = $message_data["message_id"];
     $text = $message_data["text"];
     $response = create_response($text);
     send_reply($chatid, $message_id, $response);
     } 
     return $updateid;
    }
    function get_updates($offset) 
    {
     $url = request_url("getUpdates")."?offset=".$offset;
     $resp = file_get_contents($url);
     $result = json_decode($resp, true);
     if ($result["ok"]==1)
     return $result["result"];
     return array();
    }
    function process_one()
    {
     $update_id = 0;
     
     if (file_exists("last_update_id")) {
     $update_id = (int)file_get_contents("last_update_id");
     }
     
     $updates = get_updates($update_id);
     
     foreach ($updates as $message)
     {
     $update_id = process_message($message);
     }
     file_put_contents("last_update_id", $update_id + 1);
    }
     
    while (true) {
     process_one();
    }
    ?>
