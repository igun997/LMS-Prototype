<?php
$frontend = new frontend_app;
if($_SESSION["pages_token"] == md5(date("d-m-Y")))
{
    if(!isset($_SESSION["level_user"]))
    {
        if(isset($_GET["page"]))
        {
            $page_name = $_GET["page"];
        }else{
            $frontend->sisip_halaman("home");
        }
    }else{
        if($_SESSION["level_user"] == 1)
        {
            if(isset($_GET["page"]))
            {
                $page_name = $_GET["page"];
                if($page_name == "logout")
                {
                    $frontend->logout();
                }else{
                    if($page_name == "daftar-soal")
                    {
                         $frontend->sisip_halaman_siswa("daftar-soal");
                    }else{
                        if($page_name == "lihat-nilai")
                        {
                            $frontend->sisip_halaman_siswa("lihat-nilai");
                        }else{
                            if($page_name == "edit-profil")
                            {
                                $frontend->sisip_halaman_siswa("ed-profil");
                            }else{
                                $frontend->err404();
                            }
                        }
                    }
                }
            }else{
                $frontend->sisip_halaman_siswa("home");
            }
        }else{
            if($_SESSION["level_user"] == 2)
            {
                if(isset($_GET["page"]))
                {
                    $page_name = $_GET["page"];
                    if($page_name == "logout")
                    {
                        $frontend->logout();
                    }else{
                        if($page_name == "bank-soal")
                        {
                            $frontend->sisip_halaman_guru("bank-soal");
                            
                        }else{
                                if($page_name == "register-soal")
                                {
                                    $frontend->sisip_halaman_guru("register-soal");
                                }else{
                                     if($page_name == "analisis-soal")
                                     {
                                         $frontend->sisip_halaman_guru("analisis-soal");
                                     }else{
                                         $frontend->err404();
                                     }
                                }
                            }
                    }
                }else{
                    $frontend->sisip_halaman_guru("home");
                }
            }else{
                if($_SESSION["level_user"] == 3)
                {
                    if(isset($_GET["page"]))
                    {
                        $page_name = $_GET["page"];
                        if($page_name == "logout")
                        {
                            $frontend->logout();
                        }else{
                            if($page_name == "reg-admin")
                            {
                                $frontend->sisip_halaman_admin("reg-admin");
                            }else{
                                if($page_name == "reg-guru")
                                {
                                    $frontend->sisip_halaman_admin("reg-guru");
                                }else{
                                    if($page_name == "reg-siswa")
                                    {
                                        $frontend->sisip_halaman_admin("reg-siswa");
                                    }else{
                                        if($page_name == "reg-kelas" )
                                        {
                                            $frontend->sisip_halaman_admin("reg-kelas");
                                        }else{
                                            if($page_name == "log")
                                            {
                                                  $frontend->sisip_halaman_admin("log");
                                            }else{
                                                if($page_name == "set-sms")
                                                {
                                                    $frontend->sisip_halaman_admin("sms");
                                                }else{
                                                    if($page_name = "backup")
                                                    {
                                                        $frontend->sisip_halaman_admin("backup");
                                                    }else{
                                                        $frontend->err404();
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }else{
                        $frontend->sisip_halaman_admin("home");
                    }
                }
            }
        }
    }
    
}else{
    echo "Access Restriction";
}

?>