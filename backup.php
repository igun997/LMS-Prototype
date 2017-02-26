<?php
include ("./class/core.class.php");
$sistemApp = new sistemApp;
$db = new BukaDB;
if(isset($_SESSION["backup"]))
{
    if($_SESSION["backup"] == "kelas")
    {
        $db->export_database(array("sistem_kelas"),"kelas_".date("d-m-Y").".sql");
    }else{
        if($_SESSION["backup"] == "guru")
        {
            $db->export_database(array("user_guru"),"guru_".date("d-m-Y").".sql");
        }else{
            if($_SESSION["backup"] == "siswa")
            {
                $db->export_database(array("user_siswa"),"siswa_".date("d-m-Y").".sql");
            }else{
                if($_SESSION["backup"] == "admin")
                {
                    $db->export_database(array("user_admin"),"admin_".date("d-m-Y").".sql");
                }else{
                    if($_SESSION["backup"] == "full")
                    {
                        $db->export_database(false,"full_backup_".date("d-m-Y").".sql");
                    }else{
                        header('Location: ./');
                    }
                }
            }
        }
    }
}
?>