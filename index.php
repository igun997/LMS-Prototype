<?php
include ("./class/core.class.php");
$sistemApp = new sistemApp;
$db = new BukaDB;
?>
    <!DOCTYPE html>
    <!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>LMS Prototype</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="./assets/css/AdminLTE.min.css">
        <!-- Data Tables -->
        <link rel="stylesheet" href="./assets/plugins/datatables/dataTables.bootstrap.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="./assets/plugins/select2/select2.min.css">
        <!-- CKeditor -->
        <script src="./assets/plugins/ckeditor/ckeditor.js"></script>


        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
        <link rel="stylesheet" href="./assets/css/skins/_all-skins.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
    </head>
    <!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidecar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->

    <body class="hold-transition skin-red sidebar-mini ">
        <div class="wrapper">
            <!-- Main Header -->
            <header class="main-header">
                <!-- Logo -->
                <a href="./index.php" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini">LMS</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg">LMS Prototype</span>
                </a>
                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <?php if(isset($_SESSION["nama_user"])): ?>
                        <div class="user-panel">
                            <div class="pull-left image">
                                <img src="./assets/image/avatar5.png" class="img-circle" alt="User Image">
                            </div>
                            <div class="pull-left info">
                                <p>
                                    <?php echo htmlspecialchars($_SESSION["nama_user"]);?>
                                </p>
                                <!-- Status -->
                                <a href="#"><i class="fa fa-circle text-success"></i> <?php if($_SESSION["level_user"] == 1){ echo "Siswa"; }else{if($_SESSION["level_user"] == 2 ){echo "Guru";}else{echo "Administrator";}} ?></a>

                                <a href="./?page=logout"><i class="fa fa-sign-out text-danger"></i> Log-Out</a>
                                <br>
                                <?php if($_SESSION["level_user"] == 1): ?>
                                    <a href=""><i class="fa fa-book text-success"></i> Kelas <?php $kelas = json_decode($db->select_db("sistem_kelas",array("nama_kelas"),"id_kelas",$_SESSION["id_kelas"])); echo $kelas[0]->nama_kelas;?></a>
                                    <?php endif;?>
                            </div>


                        </div>
                        <?php endif;?>
                            <!-- search form (Optional) -->

                            <!-- /.search form -->
                            <!-- Sidebar Menu -->
                            <br>
                            <ul class="sidebar-menu">
                                <li class="header">Menu Utama</li>
                                <?php if(isset($_SESSION["level_user"])): ?>
                                    <?php if($_SESSION["level_user"] == 1): ?>
                                        <li><a href="./index.php"><i class="fa fa-home"></i><span>Beranda</span></a></li>
                                        <li><a href="./?page=daftar-soal"><i class="fa fa-book"></i><span>Daftar Ujian</span></a></li>
                                        <li><a href="./?page=lihat-nilai"><i class="fa fa-search"></i><span>Lihat Nilai</span></a></li>
                                        <li><a href="./?page=edit-profil"><i class="fa fa-users"></i><span>Edit Profil</span></a></li>
                                        <?php endif;?>
                                            <?php if($_SESSION["level_user"] == 2): ?>
                                                <li><a href="./index.php"><i class="fa fa-home"></i><span>Beranda</span></a></li>
                                                <li><a href="./?page=bank-soal"><i class="fa fa-book"></i><span>Bank Soal</span></a></li>
                                                <li><a href="./?page=register-soal"><i class="fa fa-question"></i><span>Register Ujian</span></a></li>
                                                <li><a href="./?page=analisis-soal"><i class="fa fa-check-square"></i><span>Analisis Pekerjaan Siswa</span></a></li>
                                                <?php endif;?>
                                                    <?php if($_SESSION["level_user"] == 3): ?>
                                                        <li><a href="./index.php"><i class="fa fa-home"></i><span>Beranda</span></a></li>
                                                        <li><a href="./?page=reg-admin"><i class="fa fa-book"></i><span>Register Administrator</span></a></li>
                                                        <li><a href="./?page=reg-kelas"><i class="fa fa-sign-in"></i><span>Register Kelas</span></a></li>
                                                        <li><a href="./?page=reg-siswa"><i class="fa fa-sign-in"></i><span>Register Siswa</span></a></li>
                                                        <li><a href="./?page=reg-guru"><i class="fa fa-sign-in"></i><span>Register Guru</span></a></li>
                                                        <li><a href="./?page=log"><i class="fa fa-list"></i><span>Catatan Sistem</span></a></li>
                                                        <li><a href="./?page=set-sms"><i class="fa fa-gear"></i><span>Pengaturan SMS Center</span></a></li> 
                                                        <li><a href="./?page=backup"><i class="fa fa-hdd-o"></i><span>Restore DB</span></a></li> 
                                                        <?php endif;?>
                                                            <?php endif;?>
                            </ul>
                            <!-- /.sidebar-menu -->
                </section>
                <!-- /.sidebar -->
            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <!-- Main content -->
                <section class="content">
                    <?php
        $sistemApp->generate_session();
        include("./pages/mod_halaman.php");
        ?>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <!-- Main Footer -->
            <footer class="main-footer">
                <!-- To the right -->
                <div class="pull-right hidden-xs">
                    Learning Management System - Prototype
                </div>
                <!-- Default to the left -->
                <strong>Copyright &copy; 2017 <a href="#">SystemFive</a>.</strong> All rights reserved. </footer>
            <!-- Control Sidebar -->
            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
            <div class="control-sidebar-bg">
            </div>
        </div>
        <!-- ./wrapper -->
        <!-- REQUIRED JS SCRIPTS -->
        <!-- jQuery 2.2.3 -->
        <script src="./assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="./assets/js/bootstrap.min.js"></script>
        <!-- AdminLTE App -->
        <script src="./assets/js/app.min.js"></script>
        <!-- Select2 -->
        <script src="./assets/plugins/select2/select2.full.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $(".pilihan-soal").select2();
            });
            $(document).ready(function() {
                $(".pilihan-kelas").select2();
            });

            $(document).ready(function() {
                $('#soal').on('select2:close', function(evt) {
                    var count = $(".pilihan-soal :selected").length;
                    $(".soal").html("Soal Yang Terpilih = " + count);
                });
            });

        </script>
        <!-- Data Tables -->
        <script src="./assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="./assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.rekap-nilai').dataTable({
                    "sScrollX": "100%",
                    "sScrollXInner": "100%",
                    "bScrollCollapse": true
                });
                $('.lihat-nilai').dataTable({
                    "sScrollX": "100%",
                    "sScrollXInner": "100%",
                    "bScrollCollapse": true
                });
            });

        </script>
        <script src="./assets/js/ajax.js"></script>
        <!-- CKeditor -->
        <script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">


        </script>
        <script>
            $("textarea").each(function() {
                CKEDITOR.replace(this, {
                    extraPlugins: 'mathjax',
                    mathJaxLib: 'http://cdn.mathjax.org/mathjax/2.6-latest/MathJax.js?config=TeX-AMS_HTML',
                    height: 320
                });
            });

        </script>
        <script>
            (function(i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function() {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-36088804-5', 'auto');
            ga('send', 'pageview');

        </script>
        <!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
    </body>

    </html>
