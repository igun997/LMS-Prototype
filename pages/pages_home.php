<?php 
$sistemApp = new sistemApp;
$db = new BukaDB;
?>
<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="box box-info">
					<div class="box-header with-border">
                        <b>Halaman Login</b>
						
					</div>
                    <div class="box-body">
                    <div class="login-box-body">
							
                            <?php
                            if(isset($_POST["login_form"]) && isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["role_login"]))
                            {
                                if($_POST["password"] != "" && $_POST["username"] != "" && $_POST["role_login"] !="")
                                {
                                    $user = $_POST["username"];
                                    $pass = $_POST["password"];
                                    $lvl  = $_POST["role_login"];
                                    $login = json_decode($sistemApp->login($user,$pass,$lvl));
                                    if($login->status == 1)
                                    {
                                        echo $sistemApp->alert("success","Login Sukses","Silahkan Tunggu Anda Akan Di Aliihkan","./index.php",2);
                                    }else{
                                        echo $sistemApp->alert("danger","Login Gagal","Periksa Kembali Username Dan Password","./index.php",2);
                                    }
                                }else{
                                    //alert
                                }
                            }
                            ?>
							<form action="" method="post">
								<div class="form-group has-feedback">
									<input type="text" name="username" class="form-control" placeholder="Username">
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
								</div>
								<div class="form-group has-feedback">
									<input type="password" name="password" class="form-control" placeholder="Password">
									<span class="glyphicon glyphicon-lock form-control-feedback"></span>
								</div>
								<div class="form-group">
									<select class="form-control" name="role_login">
										<option>-- Login Sebagai --</option>
										<option value="1">Siswa</option>
										<option value="2">Guru</option>
										<option value="3">Administrator</option>
									</select>
								</div>
								<div class="row">
									<!-- /.col -->
									<div class="col-xs-4">
										<button type="submit" name="login_form" class="btn btn-primary btn-block btn-flat">Sign In</button>
									</div>
									<!-- /.col -->
								</div>
							</form>
						</div>
                    </div>
				</div>
			</div>
			
		</div>