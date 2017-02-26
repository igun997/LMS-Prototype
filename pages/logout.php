<?php
$sistemApp = new sistemApp;
echo $sistemApp->alihkan("./index.php",1000);
session_destroy();
?>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger">
        <center><b>Sesi Telah Di Hapus</b></center>
        </div>
    </div>
</div>