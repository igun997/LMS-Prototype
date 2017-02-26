<?php
include ("./class/core.class.php");
$sistemApp = new sistemApp;
$db = new BukaDB;
if(!isset($_SESSION["ujian_time"]) && !isset($_SESSION["end_time"]) && !isset($_SESSION["selisih"]))
{
    $end_time = date('H:i:s',time()+(60*5));
    $now = date('H:i:s');
    $_SESSION["ujian_time"] = $now;
    $_SESSION["end_time"] = $end_time;
    $_SESSION["selisih"] = (60*5);
}
if(date('H:i:s') <= $_SESSION["end_time"])
{
?>
    <html>

    <head>
        <title>Debug</title>
        <script src="./assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
    </head>

    <body>
        <span id="timepass"></span>\n
        <span id="end">END : <?php echo $_SESSION["end_time"];?></span>
        <script language="JavaScript">
            function Timer(duration, display) {
                var timer = duration,
                    minutes, seconds;
                setInterval(function() {
                    minutes = parseInt(timer / 60, 10)
                    seconds = parseInt(timer % 60, 10);

                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;

                    display.text(minutes + ":" + seconds);

                    if (--timer < 0) {
                        timer = duration;
                    }
                }, 1000);
            }

            jQuery(function($) {
                var fiveMinutes = <?php echo 60*5;?>;
                var display = $('#timepass');
                Timer(fiveMinutes, display);
            });

        </script>
    </body>

    </html>
    <?php  }else{ echo "Finished";}?>
