<?php
ini_set('session.gc_maxlifetime', 360000);
session_set_cookie_params(360000);
date_default_timezone_set('Asia/Jakarta');
session_start();
class BukaDB
{
    private $host;
    private $user;
    private $pass;
    private $db;
    public $mysqli;
    
    public function __construct()
    {
        $this->db_connect();
    }
    
    private function db_connect()
    {
        $this->host = 'localhost';
        $this->user = 'root';
        $this->pass = '';
        $this->db   = 'db_lomba';
        
        $this->mysqli = new mysqli($this->host, $this->user, $this->pass, $this->db);
        return $this->mysqli;
    }
    function flush_tabel ($tabel)
    {
        $tabel = mysqli_escape_string($this->mysqli, $tabel);
         $query = "DELETE FROM " . $tabel;
            $hasil = $this->mysqli->query($query);
            if ($hasil) {
                return json_encode(array(
                    "status" => 1
                ));
            } else {
                return json_encode(array(
                    "status" => 0,
                    "error" => mysqli_error($this->mysqli)
                ));
            }
    }
    function delete_db($tabel, $acuan, $acuan_value)
    {
        $acuan       = mysqli_escape_string($this->mysqli, $acuan);
        $acuan_value = mysqli_escape_string($this->mysqli, $acuan_value);
        if (!empty($acuan) && !empty($acuan_value)) {
            $query = "DELETE FROM " . $tabel . " WHERE " . $acuan . "='" . $acuan_value . "'";
            $hasil = $this->mysqli->query($query);
            if ($hasil) {
                return json_encode(array(
                    "status" => 1
                ));
            } else {
                return json_encode(array(
                    "status" => 0,
                    "error" => mysqli_error($this->mysqli)
                ));
            }
        } else {
            return json_encode(array(
                "status" => 0,
                "error" => "Tidak Ada Nilai "
            ));
        }
    }
    function gabung_db($select, $tabel_select, $join, $value_join, $value_tabel, $acuan="" , $acuan_value="" ,$acuan_dua="",$acuan_dua_value="",$acuan_tiga="",$acuan_tiga_value="")
    {
        
        $total_select = count($select);
        if ($total_select <= 1) {
            $query = "SELECT " . mysqli_escape_string($this->mysqli, $select) . " FROM " . mysqli_escape_string($this->mysqli, $tabel_select) . " JOIN " . mysqli_escape_string($this->mysqli, $join) . " ON " . mysqli_escape_string($this->mysqli, $join) . "." . mysqli_escape_string($this->mysqli, $value_join) . "=" . mysqli_escape_string($this->mysqli, $tabel_select) . "." . mysqli_escape_string($this->mysqli, $value_tabel);
            if ($acuan != null) {
                $query .= " WHERE " . mysqli_escape_string($this->mysqli, $acuan) . " = " . mysqli_escape_string($this->mysqli, $acuan_value);
            }
        } else {
            $query = "SELECT ";
            for ($counter_select = 0; $counter_select <= $total_select - 1; $counter_select++) {
                $query .= mysqli_escape_string($this->mysqli, $select[$counter_select]);
                if ($counter_select != count($select) - 1) {
                    $query .= ",";
                }
            }
            
            $query .= " FROM " . mysqli_escape_string($this->mysqli, $tabel_select) . " JOIN " . mysqli_escape_string($this->mysqli, $join) . " ON " . mysqli_escape_string($this->mysqli, $join) . "." . mysqli_escape_string($this->mysqli, $value_join) . "=" . mysqli_escape_string($this->mysqli, $tabel_select) . "." . mysqli_escape_string($this->mysqli, $value_tabel);
            if ($acuan != null) {
                $query .= " WHERE " . mysqli_escape_string($this->mysqli, $acuan) . " ='" . mysqli_escape_string($this->mysqli, $acuan_value)."'";
                if($acuan_dua != null)
                {
                    $query .= " AND ".mysqli_escape_string($this->mysqli, $acuan_dua)."='".mysqli_escape_string($this->mysqli, $acuan_dua_value)."'"; 
                }
                if($acuan_tiga != null)
                {
                     $query .= " OR ".mysqli_escape_string($this->mysqli, $acuan_tiga)."='".mysqli_escape_string($this->mysqli, $acuan_tiga_value)."'"; 
                }
            }
        }
        $hasil = $this->mysqli->query($query);
        if ($hasil) {
            $data = $hasil->fetch_all(MYSQLI_ASSOC);
            return json_encode($data);
        } else {
            return json_encode(array(
                "status" => 0,
                "error" => mysqli_error($this->mysqli)
            ));
        }
    }
    function gabung_db_tri($select, $tabel_select, $join, $value_join, $value_tabel, $acuan="" , $acuan_value="" ,$acuan_dua="",$acuan_dua_value="",$acuan_tiga="",$acuan_tiga_value="")
    {
        
        $total_select = count($select);
        if ($total_select <= 1) {
            $query = "SELECT " . mysqli_escape_string($this->mysqli, $select) . " FROM " . mysqli_escape_string($this->mysqli, $tabel_select) . " JOIN " . mysqli_escape_string($this->mysqli, $join) . " ON " . mysqli_escape_string($this->mysqli, $join) . "." . mysqli_escape_string($this->mysqli, $value_join) . "=" . mysqli_escape_string($this->mysqli, $tabel_select) . "." . mysqli_escape_string($this->mysqli, $value_tabel);
            if ($acuan != null) {
                $query .= " WHERE " . mysqli_escape_string($this->mysqli, $acuan) . " = " . mysqli_escape_string($this->mysqli, $acuan_value);
            }
        } else {
            $query = "SELECT ";
            for ($counter_select = 0; $counter_select <= $total_select - 1; $counter_select++) {
                $query .= mysqli_escape_string($this->mysqli, $select[$counter_select]);
                if ($counter_select != count($select) - 1) {
                    $query .= ",";
                }
            }
            
            $query .= " FROM " . mysqli_escape_string($this->mysqli, $tabel_select) . " JOIN " . mysqli_escape_string($this->mysqli, $join) . " ON " . mysqli_escape_string($this->mysqli, $join) . "." . mysqli_escape_string($this->mysqli, $value_join) . "=" . mysqli_escape_string($this->mysqli, $tabel_select) . "." . mysqli_escape_string($this->mysqli, $value_tabel);
            if ($acuan != null) {
                $query .= " WHERE " . mysqli_escape_string($this->mysqli, $acuan) . " ='" . mysqli_escape_string($this->mysqli, $acuan_value)."'";
                if($acuan_dua != null)
                {
                    $query .= " AND (".mysqli_escape_string($this->mysqli, $acuan_dua)."='".mysqli_escape_string($this->mysqli, $acuan_dua_value)."'"; 
                }
                if($acuan_tiga != null)
                {
                     $query .= " OR ".mysqli_escape_string($this->mysqli, $acuan_tiga)."='".mysqli_escape_string($this->mysqli, $acuan_tiga_value)."')"; 
                }
            }
        }
        $hasil = $this->mysqli->query($query);
        if ($hasil) {
            $data = $hasil->fetch_all(MYSQLI_ASSOC);
            return json_encode($data);
        } else {
            return json_encode(array(
                "status" => 0,
                "error" => mysqli_error($this->mysqli)
            ));
        }
    }
    function import_database($sql_file_OR_content)
    {
        set_time_limit(3000);
        $SQL_CONTENT = (strlen($sql_file_OR_content) > 300 ?  $sql_file_OR_content : file_get_contents($sql_file_OR_content)  );  
        $allLines = explode("\n",$SQL_CONTENT); 
            $zzzzzz = $this->mysqli->query('SET foreign_key_checks = 0');	        preg_match_all("/\nCREATE TABLE(.*?)\`(.*?)\`/si", "\n". $SQL_CONTENT, $target_tables); foreach ($target_tables[2] as $table){$this->mysqli->query('DROP TABLE IF EXISTS '.$table);}         $zzzzzz = $this->mysqli->query('SET foreign_key_checks = 1');    $this->mysqli->query("SET NAMES 'utf8'");	
        $templine = '';	// Temporary variable, used to store current query
        foreach ($allLines as $line)	{											// Loop through each line
            if (substr($line, 0, 2) != '--' && $line != '') {$templine .= $line; 	// (if it is not a comment..) Add this line to the current segment
                if (substr(trim($line), -1, 1) == ';') {		// If it has a semicolon at the end, it's the end of the query
                    if(!$this->mysqli->query($templine)){ $status = 'Error performing query \'<strong>' . $templine . '\': ' . $this->mysqli->error . '<br /><br />';  }  $templine = ''; // set variable to empty, to start picking up the lines after ";"
                }
            }
        }	
        
        return json_encode(array("status"=>1));
       
    }
    function upload_file($target_direktori,$files,$allowed_files)
    {
        $sistemApp = new sistemApp;
        $target_dir = $target_direktori;
        $files_base = basename($files["name"]);
        $target_file = $target_dir . $files_base;
        $uploadOk = 1;
        $FileType = pathinfo($target_file,PATHINFO_EXTENSION);
        if(in_array($FileType,$allowed_files))
        {
            if(move_uploaded_file($files["tmp_name"], $target_dir.sha1($files_base).".".$FileType))
            {
                return json_encode(array("status"=>1,"files_name"=>$target_dir.sha1($files_base).".".$FileType));
            }else{
                return json_encode(array("status"=>0,"error"=>"Gagal Upload Files"));
            }
        }else{
            return json_encode(array("status"=>0,"error"=>"File Tidak Di Ijinkan : .".$FileType));
        }
    }
    function export_database($tables=false, $backup_name=false){ 
	set_time_limit(3000); $this->mysqli->query("SET NAMES 'utf8'");
	$queryTables = $this->mysqli->query('SHOW TABLES'); while($row = $queryTables->fetch_row()) { $target_tables[] = $row[0]; }	if($tables !== false) { $target_tables = array_intersect( $target_tables, $tables); } 
	$content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `".$name."`\r\n--\r\n\r\n\r\n";
	foreach($target_tables as $table){
		if (empty($table)){ continue; } 
		$result	= $this->mysqli->query('SELECT * FROM `'.$table.'`');  	$fields_amount=$result->field_count;  $rows_num=$mysqli->affected_rows; 	$res = $this->mysqli->query('SHOW CREATE TABLE '.$table);	$TableMLine=$res->fetch_row(); 
		$content .= "\n\n".$TableMLine[1].";\n\n";   $TableMLine[1]=str_ireplace('CREATE TABLE `','CREATE TABLE IF NOT EXISTS `',$TableMLine[1]);
		for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) {
			while($row = $result->fetch_row())	{ //when started (and every after 100 command cycle):
				if ($st_counter%100 == 0 || $st_counter == 0 )	{$content .= "\nINSERT INTO ".$table." VALUES";}
					$content .= "\n(";    for($j=0; $j<$fields_amount; $j++){ $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); if (isset($row[$j])){$content .= '"'.$row[$j].'"' ;}  else{$content .= '""';}	   if ($j<($fields_amount-1)){$content.= ',';}   }        $content .=")";
				//every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
				if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter==$rows_num) {$content .= ";";} else {$content .= ",";}	$st_counter=$st_counter+1;
			}
		} $content .="\n\n\n";
	}
	$content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
	$backup_name = $backup_name ? $backup_name : $name.'___('.date('H-i-s').'_'.date('d-m-Y').').sql';
	ob_get_clean(); header('Content-Type: application/octet-stream');  header("Content-Transfer-Encoding: Binary");  header('Content-Length: '. (function_exists('mb_strlen') ? mb_strlen($content, '8bit'): strlen($content)) );    header("Content-disposition: attachment; filename=\"".$backup_name."\""); 
	echo $content; exit;
    }   
    function gabung_db_tiga($select, $tabel_utama, $tabel_join_satu, $tabel_join_dua, $value_utama, $value_utama_dua, $value_satu, $value_dua, $acuan = null, $acuan_value = null,$acuan_dua = null,$acuan_value_dua = null)
    {
        $total_select = count($select);
        if ($total_select > 1) {
            $query = "SELECT ";
            for ($counter_select = 0; $counter_select <= $total_select - 1; $counter_select++) {
                $query .= mysqli_escape_string($this->mysqli, $select[$counter_select]);
                if ($counter_select != count($select) - 1) {
                    $query .= ",";
                }
            }
            $query .= " FROM " . mysqli_escape_string($this->mysqli, $tabel_utama) . " JOIN " . mysqli_escape_string($this->mysqli, $tabel_join_satu) . " JOIN " . mysqli_escape_string($this->mysqli, $tabel_join_dua) . " ON " . mysqli_escape_string($this->mysqli, $tabel_utama) . "." . mysqli_escape_string($this->mysqli, $value_utama) . " = " . mysqli_escape_string($this->mysqli, $tabel_join_satu) . "." . mysqli_escape_string($this->mysqli, $value_satu) . " AND " . mysqli_escape_string($this->mysqli, $tabel_utama) . "." . mysqli_escape_string($this->mysqli, $value_utama_dua) . " = " . mysqli_escape_string($this->mysqli, $tabel_join_dua) . "." . mysqli_escape_string($this->mysqli, $value_dua);
        } else {
            $query = "SELECT " . mysqli_escape_string($this->mysqli, $select);
            
            $query .= " FROM " . mysqli_escape_string($this->mysqli, $tabel_utama) . " JOIN " . mysqli_escape_string($this->mysqli, $tabel_join_satu) . " JOIN " . mysqli_escape_string($this->mysqli, $tabel_join_dua) . " ON " . mysqli_escape_string($this->mysqli, $tabel_utama) . "." . mysqli_escape_string($this->mysqli, $value_utama) . " = " . mysqli_escape_string($this->mysqli, $tabel_join_satu) . "." . mysqli_escape_string($this->mysqli, $value_satu) . " AND " . mysqli_escape_string($this->mysqli, $tabel_utama) . "." . mysqli_escape_string($this->mysqli, $value_utama_dua) . " = " . mysqli_escape_string($this->mysqli, $tabel_join_dua) . "." . mysqli_escape_string($this->mysqli, $value_dua);
        }
        if ($acuan != null) {
            $query .= " WHERE " . mysqli_escape_string($this->mysqli, $acuan) . " = " . mysqli_escape_string($this->mysqli, $acuan_value);
            if($acuan_dua != null)
            {
                $query .= " AND ".mysqli_escape_string($this->mysqli, $acuan_value)."=".mysqli_escape_string($this->mysqli, $acuan_value_dua); 
            }
        }
        $hasil = $this->mysqli->query($query);
        if ($hasil) {
            $data = $hasil->fetch_all(MYSQLI_ASSOC);
            return json_encode($data);
        } else {
            return json_encode(array(
                "status" => 0,
                "error" => mysqli_error($this->mysqli)
            ));
        }
    }
   
    function hitung_data($tabel, $acuan = null, $acuan_value = null,$acuan_dua = null,$acuan_dua_value = null)
    {
        $acuan       = mysqli_escape_string($this->mysqli, $acuan);
        $acuan_value = mysqli_escape_string($this->mysqli, $acuan_value);
        if (empty($acuan)) {
            $query = "SELECT COUNT(*) as total FROM `" . $tabel . "`";
        } else {
            $query = "SELECT COUNT(*) as total FROM `" . $tabel . "`";
            $query .= " WHERE " . $acuan . "='" . $acuan_value . "'";
            if(!empty($acuan_dua))
            {
                $query .= " AND ".mysqli_escape_string($this->mysqli,$acuan_dua)."='".mysqli_escape_string($this->mysqli,$acuan_dua_value)."'";
            }
        }
        
        $hasil = $this->mysqli->query($query);
        if ($hasil) {
            $hasil_num = $hasil->fetch_assoc();
            return json_encode(array(
                "total" => $hasil_num["total"]
            ));
        } else {
            return json_encode(array(
                "total" => "Error = " . $hasil . " " . mysqli_error($this->mysqli)
            ));
        }
    }
    function single_select($table, $max_col)
    {
        $query = "SELECT max(".mysqli_escape_string($this->mysqli,$max_col).")  as maksimal FROM ".mysqli_escape_string($this->mysqli,$table);
        $hasil = $this->mysqli->query($query);
        if ($hasil) {
            $data = $hasil->fetch_all(MYSQLI_ASSOC);
            return json_encode($data);
        } else {
            return json_encode(array(
                "status" => 0,
                "error" => mysqli_error($this->mysqli)
            ));
        }
    }
    function update_db($tabel, $kolom, $kolom_value, $acuan = "", $acuan_value = "")
    {
        $total_kolom       = count($kolom);
        $total_kolom_value = count($kolom_value);
        $acuan             = mysqli_escape_string($this->mysqli, $acuan);
        $acuan_value       = mysqli_escape_string($this->mysqli, $acuan_value);
        if ($total_kolom > 1) {
            if ($total_kolom == $total_kolom_value) {
                $query = "UPDATE " . $tabel . " SET ";
                for ($counter_kolom = 0; $counter_kolom <= $total_kolom - 1; $counter_kolom++) {
                    $query .= mysqli_escape_string($this->mysqli, htmlspecialchars($kolom[$counter_kolom])) . "='" . mysqli_escape_string($this->mysqli,htmlspecialchars($kolom_value[$counter_kolom])) . "'";
                    if ($counter_kolom != count($kolom) - 1) {
                        $query .= ",";
                    }
                }
                $query .= " WHERE " . $acuan . " ='" . $acuan_value . "'";
                
            } else {
                return json_encode(array(
                    "status" => 0
                ));
            }
        } else {
            $query = "UPDATE " . $tabel . " SET " . $kolom . "='" . $kolom_value . "'" . " WHERE " . $acuan . "='" . $acuan_value . "'";
        }
        $hasil = $this->mysqli->query($query);
        if ($hasil) {
            return json_encode(array(
                "status" => 1
            ));
        } else {
            return json_encode(array(
                "status" => 0,
                "error" => mysqli_error($this->mysqli)
            ));
        }
        
        
    }
    function select_db($tabel, $kolom, $acuan = "", $acuan_value = "")
    {
        $total_kolom = count($kolom);
        $acuan       = mysqli_escape_string($this->mysqli, $acuan);
        $acuan_value = mysqli_escape_string($this->mysqli, $acuan_value);
        if (!empty($acuan)) {
            $query = "SELECT ";
            for ($counter_kolom = 0; $counter_kolom <= $total_kolom - 1; $counter_kolom++) {
                $query .= mysqli_escape_string($this->mysqli, $kolom[$counter_kolom]);
                ;
                if ($counter_kolom != count($kolom) - 1) {
                    $query .= ",";
                }
            }
            $query .= " FROM " . $tabel . " WHERE ";
            $query .= $acuan . "='" . $acuan_value . "'";
        } else {
            $query = "SELECT ";
            for ($counter_kolom = 0; $counter_kolom <= $total_kolom - 1; $counter_kolom++) {
                $query .= mysqli_escape_string($this->mysqli, $kolom[$counter_kolom]);
                ;
                if ($counter_kolom != count($kolom) - 1) {
                    $query .= ",";
                }
            }
            $query .= " FROM " . $tabel;
        }
        $hasil = $this->mysqli->query($query);
        if ($hasil) {
            $data = $hasil->fetch_all(MYSQLI_ASSOC);
            return json_encode($data);
        } else {
            return json_encode(array(
                "status" => 0,
                "error" => mysqli_error($this->mysqli),
                "query" => mysqli_real_escape_string($this->mysqli, $query)
            ));
        }
        
    }
    function insert_db($tabel, $kolom, $value)
    {
        $total_kolom = count($kolom);
        $total_value = count($value);
        if ($total_kolom == $total_value) {
            $query = "INSERT INTO " . $tabel;
            $query .= " (";
            for ($counter_kolom = 0; $counter_kolom <= $total_kolom - 1; $counter_kolom++) {
                $query .= mysqli_escape_string($this->mysqli, htmlspecialchars($kolom[$counter_kolom]));
                ;
                if ($counter_kolom != count($kolom) - 1) {
                    $query .= ",";
                }
            }
            $query .= ")";
            if ($total_value != 1) {
                $query .= " VALUES (";
            } else {
                $query .= " VALUE (";
            }
            for ($counter_value = 0; $counter_value <= $total_value - 1; $counter_value++) {
                
                $query .= "'" . mysqli_escape_string($this->mysqli, htmlspecialchars($value[$counter_value])) . "'";
                if ($counter_value != count($value) - 1) {
                    $query .= ",";
                }
            }
            $query .= ")";
            $hasil = $this->mysqli->query($query);
            if ($hasil) {
                return json_encode(array(
                    "status" => 1
                ));
            } else {
                return json_encode(array(
                    "status" => 0,
                    "error" => mysqli_error($this->mysqli)
                ));
            }
        } else {
            return json_encode(array(
                "status" => 404,
                "error" => "Table And Value Not Same !"
            ));
        }
        
        
    }
    function custom_query($string)
    {
        $hasil = $this->mysqli->query($string);
        if ($hasil) {
            $data = $hasil->fetch_all(MYSQLI_ASSOC);
            return json_encode($data);
        } else {
            return json_encode(array(
                "status" => 0,
                "error" => mysqli_error($this->mysqli),
                "query" => $string
            ));
        }
    }
    function sql_escape($string)
    {
        return mysqli_escape_string($this->mysqli, $string);
    }
}
class sistemApp
{
    function limiter($string, $value)
    {
        $strip = strip_tags($string);
        return substr($strip, 0, $value);
    }
    function checkServer($user,$pass)
    {
        $access = file_get_contents("https://reguler.zenziva.net/apps/smsapibalance.php?userkey=".$user."&passkey=".$pass);
        $xml = simplexml_load_string($access);
        if ($xml == false) {
            return json_encode(array("status"=>0));
        }else{
            if(!isset($xml->message->status))
            {
                return json_encode($xml);

            }else{
                return json_encode(array("status"=>0));
            }
        }
    }
    function SendSMS($user,$pass,$no,$isi)
    {
       // Script http API SMS Reguler Zenziva

        $userkey=$user; // userkey lihat di zenziva

        $passkey=$pass; // set passkey di zenziva

        $message=$isi;

        $url = "https://reguler.zenziva.net/apps/smsapi.php";
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);

        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, 'userkey='.$userkey.'&passkey='.$passkey.'&nohp='.$no.'&pesan='.urlencode($message));

        curl_setopt($curlHandle, CURLOPT_HEADER, 0);

        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);

        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);

        curl_setopt($curlHandle, CURLOPT_POST, 1);

        $xml = curl_exec($curlHandle);

        curl_close($curlHandle);
        
        $xml = simplexml_load_string($xml);
        if ($xml == false) {
            return json_encode(array("status"=>0));
        }else{
            if(!isset($xml->message->status))
            {
                return json_encode(array("status"=>0));
            }else{
                return json_encode($xml);
            }
        }
    }
    function login($user,$pass,$lvl)
    {
        $con                = new BukaDB;
        $sis                = new sistemApp;
        switch($lvl)
        {
            case 1 : $login_siswa = $con->hitung_data("user_siswa","user_siswa",$user,"pass_siswa",$sis->enkripsi($pass));$login_siswa = json_decode($login_siswa,true);
            if($login_siswa["total"] != 0)
            {
                $open_session = $con->select_db("user_siswa",array("id_siswa","nama_siswa","kelas_id","user_siswa","pass_siswa","log_masuk"),"user_siswa",$user);
                $open_session = json_decode($open_session);
                $update_log = json_decode($con->update_db("user_siswa","log_masuk",date("d-m-Y"),"id_siswa",$open_session[0]->id_siswa));
                if($update_log->status == 1)
                {
                    $_SESSION['level_user'] = $lvl;
                    $_SESSION['nama_user'] = $open_session[0]->nama_siswa;
                    $_SESSION["id_user"] = $open_session[0]->id_siswa;
                    $_SESSION['id_kelas']   = $open_session[0]->kelas_id;
                    return json_encode(array("status" => 1));
                }else{
                    return json_encode(array("status" => 0,"error"=>"Update Log Gagal"));
                }
                
                
            }else{
                return json_encode(array("status"=>0,"error"=>"Tidak Ada User"));
            }
            
            break;
            case 2 : 
                $login_guru = $con->hitung_data("user_guru","user_guru",$user,"pass_guru",$sis->enkripsi($pass));$login_guru = json_decode($login_guru,true);
            if($login_guru["total"] != 0)
            {
                $open_session = $con->select_db("user_guru",array("id_guru","nama_guru","nip_guru","user_guru","pass_guru","log_masuk"),"user_guru",$user);
                $open_session = json_decode($open_session);
                $update_log = json_decode($con->update_db("user_guru","log_masuk",date("d-m-Y"),"id_guru",$open_session[0]->id_guru));
                if($update_log->status == 1)
                {
                    $_SESSION['level_user'] = $lvl;
                    $_SESSION['nama_user'] = $open_session[0]->nama_guru;
                     $_SESSION["id_user"] = $open_session[0]->id_guru;
                    $_SESSION['nip']   = $open_session[0]->nip_guru;
                    return json_encode(array("status" => 1));
                }else{
                    return json_encode(array("status" => 0,"error"=>"Update Log Gagal"));
                }
                
                
            }else{
                return json_encode(array("status"=>0,"error"=>"Tidak Ada User"));
            }
            break;
            case 3 : 
                $login_admin = $con->hitung_data("user_admin","user_admin",$user,"pass_admin",$sis->enkripsi($pass));$login_admin = json_decode($login_admin,true);
            if($login_admin["total"] != 0)
            {
                $open_session = $con->select_db("user_admin",array("id_admin","nama_admin","user_admin","pass_admin","log_masuk"),"user_admin",$user);
                $open_session = json_decode($open_session);
                $update_log = json_decode($con->update_db("user_admin","log_masuk",date("d-m-Y"),"id_admin",$open_session[0]->id_admin));
                if($update_log->status == 1)
                {
                    $_SESSION['level_user'] = $lvl;
                     $_SESSION["id_user"] = $open_session[0]->id_admin;
                    $_SESSION['nama_user'] = $open_session[0]->nama_admin;
                    return json_encode(array("status" => 1));
                }else{
                    return json_encode(array("status" => 0,"error"=>"Update Log Gagal"));
                }
            }else{
                return json_encode(array("status"=>0,"error"=>"Tidak Ada User"));
            }
            break;
            default : return json_encode(array("status" => 0,"error" => "Pilihan Level Melibihi Batas"));
        }
        
    }
    function buka_soal($id_soal)
    {
        $con  = new BukaDB;
        $soal = $con->select_db("sistem_bank_soal",array("id_bank_soal","soal","pilihan","jawaban","guru_id","tgl_buat"),"id_bank_soal",$id_soal);
        return $soal;
    }
    function buka_jawaban_siswa($id_siswa)
    {
        $con  = new BukaDB;
        $soal = $con->select_db("sistem_jawaban",array("id_jawaban","jawaban","soal_id","siswa_id","waktu_mengerjakan"),"siswa_id",$id_siswa);
        return $soal;
    }
     function input_nilai($nilai,$id_siswa,$id_jawaban,$id_soal)
    {
         $con  = new BukaDB;
         $input_data = $con->insert_db("sistem_nilai",array("nilai","id_siswa","id_jawaban","id_soal","tgl_input"),array($nilai,$id_siswa,$id_jawaban,$id_soal,date("d-m-Y")));
         $input_data = json_decode($input_data);
         if($input_data->status == 1)
         {
             return json_encode(array("status"=>$input_data->status));
         }else{
             return json_encode(array("status"=>0,"error"=>$input_data->error));
         }
    }
    function input_jawaban($jawaban,$id_soal,$id_siswa,$time)
    {
        $con  = new BukaDB;
        $hitung_soal =  json_decode($con->hitung_data("sistem_soal","id_soal",$id_soal),true);
        $hitung_siswa =  json_decode($con->hitung_data("user_siswa","id_siswa",$id_siswa),true);
        if($hitung_siswa["total"] != 0 && $hitung_soal["total"] != 0)
        {
            $input_data = $con->insert_db("sistem_jawaban",array("jawaban","siswa_id","soal_id","waktu_mengerjakan"),array($jawaban,$id_siswa,$id_soal,$time));
            return $input_data;
        }else{
            return json_encode(array("status"=>0,"error"=>"ID Soal = ".$hitung_soal["total"].", ID Siswa = ".$hitung_siswa["total"]));
        }
        
    }
    function encode_escape($json)
    {
        return str_replace('&quot;','"',$json);
    }
    function input_soal($judul,$bank_soal,$id_kelas,$tgl_buat,$nilai_per_soal,$kkm,$guru_id)
    {
        $con = new BukaDB;
        $bank_soal_cek = explode(",",$bank_soal);
        $tgl_buat = date("d-m-Y");
        foreach($bank_soal_cek as $checker)
        {
            $cek_id = json_decode($con->hitung_data("sistem_bank_soal","id_bank_soal",$checker));
            if($cek_id->total > 0)
            {
                $status = 1;
            }else{
                $status = 0;
                break;
            }
        }
        
        if($status == 1)
        {
                return $con->insert_db("sistem_soal",array("judul_soal","bank_soal","tgl_buat","guru_id","id_kelas","nilai_per_soal","nilai_lulus"),array($judul,$bank_soal,$tgl_buat,$guru_id,$id_kelas,$nilai_per_soal,$kkm));
        }else{
            return json_encode(array("status"=>0,"error"=>"Salah Satu ID Tidak Ada UUID = ".$status));
        }
        
    }
    function input_bank_soal($soal,$pilihan,$jawaban,$guru_id)
    {
        $con = new BukaDB;
        $tgl_buat = date("d-m-Y");
        $pilihan = json_encode($pilihan);
        return $con->insert_db("sistem_bank_soal",array("soal","pilihan","jawaban","guru_id","tgl_buat"),array($soal,$pilihan,$jawaban,$guru_id,$tgl_buat));
        
        
    }
    function enkripsi($string)
    {
        return  crypt($string, '%^.SystemFive');
    }
    function match_enkripsi($string,$hash)
    {
        $con = new sistemApp;
        if($con->enkripsi($string) == $hash)
        {
            return true;
        }else{
            return false;
        }
    }
    function input_kelas($nama_kelas)
    {
        $con  = new BukaDB;
        $sis = new sistemApp;
        $input_data = $con->insert_db("sistem_kelas",array("nama_kelas"),array($nama_kelas));
        return $input_data;
    }
    function input_admin($nama_admin,$user_admin,$pass_admin)
    {
        $con  = new BukaDB;
        $sis = new sistemApp;
        
        $input_data = $con->insert_db("user_admin",array("nama_admin","user_admin","pass_admin","log_masuk"),array($nama_admin,$user_admin,$sis->enkripsi($pass_admin),"0"));
        return $input_data;
        
    }
    function input_siswa($nama_siswa,$id_kelas,$user_siswa,$pass_siswa)
    {
        $con  = new BukaDB;
        $sis = new sistemApp;
        $data_kelas = json_decode($con->hitung_data("sistem_kelas"),true);
        if($data_kelas["total"] != 0)
        {
        $input_data = $con->insert_db("user_siswa",array("nama_siswa","kelas_id","user_siswa","pass_siswa","log_masuk"),array($nama_siswa,$id_kelas,$user_siswa,$sis->enkripsi($pass_siswa),"0"));
        return $input_data;
        }else{
            return json_encode(array("status"=>0,"error"=>"Kelas Tidak Ada"));
        }
    }
    function update_siswa($id_user,$nama,$user,$pass="")
    {
        $con  = new BukaDB;
        $sis = new sistemApp;
        if($pass != null)
        {
            $update_siswa = $con->update_db("user_siswa",array("nama_siswa","user_siswa","pass_siswa"),array(htmlspecialchars($nama,ENT_QUOTES),$user,$sis->enkripsi($pass)),"id_siswa",$id_user);   
        }else{
            $update_siswa = $con->update_db("user_siswa",array("nama_siswa","user_siswa"),array(htmlspecialchars($nama,ENT_QUOTES),$user),"id_siswa",$id_user);
        }
        return $update_siswa;
    }
    function search_siswa($id_user)
    {
        $con  = new BukaDB;
        $sis = new sistemApp;
        $data_siswa = $con->select_db("user_siswa",array("id_siswa","kelas_id","log_masuk","nama_siswa","pass_siswa","user_siswa"),"id_siswa",$id_user);
        return $data_siswa;
    }
    function hitung_jawaban($points,$id_siswa,$id_soal)
    {
        $con = new sistemApp;
        $db = new BukaDB;
        $status = json_decode($db->hitung_data("user_siswa","id_siswa",$id_siswa),true);
        $status_soal = json_decode($db->hitung_data("sistem_soal","id_soal",$id_soal),true);
        if($status["total"] != 0 && $status_soal["total"] != 0)
        {
        $buka_soal = json_decode($db->custom_query("SELECT * FROM sistem_jawaban WHERE sistem_jawaban.soal_id = ".$db->sql_escape($id_soal)." AND sistem_jawaban.siswa_id = ".$db->sql_escape($id_siswa)));
        $select = $db->select_db("sistem_soal",array("id_soal","judul_soal","bank_soal","guru_id"),"id_soal",$id_soal);
        $select = json_decode($select);
        
            foreach(explode(",",$select[0]->bank_soal) as $obj_split)
            {    
                $soal =  json_decode($con->buka_soal($obj_split));
                $temp_kunci[] =  $soal[0]->jawaban;
                $temp_soal[] = $soal[0]->soal;
            }
        
        
            $counter = explode(",",$buka_soal[0]->jawaban);
            foreach($counter as $obj_split)
            {
                $temp_jawaban[] = $obj_split;
            }
        
        $kunci_jawaban = count($temp_kunci);
        $jawaban = count($temp_jawaban);
        $hitung = "";
        if($kunci_jawaban == $jawaban)
        {
            for($i=0; $i <= $jawaban-1; $i++)
            {
                if($temp_jawaban[$i] == $temp_kunci[$i])
                {
                    $hitung = $hitung+$points;
                }else{
                    $wrong[] = array("index_soal"=>$i+1,"soal"=>$temp_soal[$i],"jawaban"=>$temp_jawaban[$i],"kunci_jawaban"=>$temp_kunci[$i]);
                }
            }
        }
        return json_encode(array("data"=>array("judul_soal"=>$select[0]->judul_soal,"nilai"=>($hitung == null)?"0":$hitung,"salah"=>(isset($wrong))?json_encode($wrong):"Tidak Ada")));
        }else{
            return json_encode(array("status"=>0,"error"=>"ID Siswa = ".$status["total"]." ID Soal = ".$status_soal["total"]));
        }
    }
    function list_soal($kelas)
    {
        $db = new BukaDB;
        $sistemApp = new sistemApp;
        $select = $db->select_db("sistem_soal",array("id_soal","judul_soal","bank_soal","guru_id","tgl_buat","nilai_per_soal"),"id_kelas",$kelas);
        $select = json_decode($select);
        return json_encode($select);
    }
    function open_soal($id_soal)
    {
        $db = new BukaDB;
        $sistemApp = new sistemApp;
        $select = $db->select_db("sistem_soal",array("id_soal","judul_soal","bank_soal","guru_id","tgl_buat","nilai_per_soal","nilai_lulus"),"id_soal",$id_soal);
        $select = json_decode($select);
        $bank_soal = explode(",",$select[0]->bank_soal);
        foreach($bank_soal as $obj_soal)
        {
            $data = $sistemApp->buka_soal($obj_soal);
            $pilihan_ganda[] = $data;
        }
        return json_encode(array("master_data"=>array("id_soal"=>$select[0]->id_soal,"judul_soal"=>$select[0]->judul_soal,"data_pilihan"=>$pilihan_ganda,"nilai_per_soal"=>$select[0]->nilai_per_soal,"nilai_kkm"=>$select[0]->nilai_lulus,"tgl_buat"=>$select[0]->tgl_buat)));
    }
    function list_siswa()
    {
        $con = new BukaDB;
        $get = $con->select_db("user_siswa",array("id_siswa","kelas_id","log_masuk","nama_siswa","pass_siswa","user_siswa"));
        $get = json_decode($get);
        $siswa_return;
        foreach($get as $obj_get)
        {
            $get_kelas = $con->select_db("sistem_kelas",array("id_kelas","nama_kelas"),"id_kelas",$obj_get->kelas_id);
            $get_kelas = json_decode($get_kelas);
            $siswa_return[] = array("nama"=>$obj_get->nama_siswa,"kelas"=>$get_kelas[0]->nama_kelas,"log_masuk" => $obj_get->log_masuk);

        }
        return json_encode($siswa_return);
    }
    function analisis ($guru_id)
    {
        $db = new BukaDB;
        $sistemApp = new sistemApp;
        $data = $db->custom_query("SELECT user_siswa.id_siswa, sistem_jawaban.id_jawaban, sistem_soal.id_soal, user_siswa.nama_siswa as nama, sistem_soal.judul_soal as ujian, sistem_kelas.nama_kelas as kelas, sistem_nilai.nilai as nilai, sistem_soal.nilai_lulus as nilai_kkm, sistem_nilai.tgl_input FROM user_siswa JOIN sistem_jawaban ON sistem_jawaban.siswa_id = user_siswa.id_siswa JOIN sistem_soal ON sistem_jawaban.soal_id = sistem_soal.id_soal JOIN sistem_kelas ON sistem_kelas.id_kelas = user_siswa.kelas_id JOIN sistem_nilai ON sistem_nilai.id_jawaban = sistem_jawaban.id_jawaban WHERE sistem_soal.guru_id =".$db->sql_escape($guru_id));
        return $data;
    }
    function rekap_soal($guru_id)
    {
        $db = new BukaDB;
        $sistemApp = new sistemApp;
        $data = $db->custom_query("SELECT sistem_kelas.id_kelas,sistem_soal.id_soal,sistem_soal.judul_soal,sistem_kelas.nama_kelas,sistem_soal.tgl_buat FROM sistem_soal JOIN user_guru ON user_guru.id_guru = sistem_soal.guru_id JOIN sistem_kelas ON sistem_kelas.id_kelas = sistem_soal.id_kelas WHERE user_guru.id_guru =".$db->sql_escape($guru_id));
        return $data;
        
       
    }
    function cek_pengerjaan_soal($id_soal,$id_siswa)
    {
        $db = new BukaDB;
        $sistemApp = new sistemApp;
        $hitung = json_decode($db->hitung_data("sistem_jawaban","soal_id",$id_soal,"siswa_id",$id_siswa));
        if($hitung->total == 1)
        {
            return json_encode(array("status"=>1));
        }else{
            return json_encode(array("status"=>0,"error"=>$hitung->total));
        }
    }
    function generate_session()
    {
        return $_SESSION["pages_token"] = md5(date("d-m-Y"));
    }
    function alert($type,$title,$content,$addons="",$time="")
    {
        $icon = ($type == "success")?"check":"ban";
        if($addons != "" && $time != "")
        {
            return '<div class="alert alert-'.$type.' alert-dismissible">   
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-'.$icon.'"></i> '.$title.'</h4>'.$content.'</div><meta http-equiv="refresh" content="'.$time.';URL="'.$addons.'"" />';
        }else{
            return '<div class="alert alert-'.$type.' alert-dismissible">   
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-'.$icon.'"></i> '.$title.'</h4>'.$content.'</div>';
        }
        
    }
    function alihkan($url,$time)
    {
        $redir = "<script>setTimeout(function () {window.location.replace('" . $url . "');},".$time.")</script>";
        return $redir;
    }
    function add_date ($days)
    {
        return date('d-m-Y', strtotime($days." days"));
    }
    function compare_date($date_1 , $date_2 , $differenceFormat = '%a' )
    {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($differenceFormat);

    }
    
}
class frontend_app{
    function sisip_halaman($string)
    {
        return include("./pages/pages_" . $string . ".php");
    }
    function sisip_halaman_siswa($string)
    {
        return include("./pages/siswa_" . $string . ".php");
    }
    function sisip_halaman_guru($string)
    {
        return include("./pages/guru_" . $string . ".php");
    }
    function sisip_halaman_admin($string)
    {
        return include("./pages/admin_" . $string . ".php");
    }
    function err404()
    {
        return include("./pages/404.php");
    }
    function logout()
    {
        return include("./pages/logout.php");
    }

        
}



?>
