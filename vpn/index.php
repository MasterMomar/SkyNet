<?php
$configfile = 'config.php';
if (!file_exists($configfile)) {
    echo '<meta http-equiv="refresh" content="0; url=install" />';
    exit();
}

include "config.php";

if(!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['sec-username'])) {
    $uname = $_SESSION['sec-username'];
    $table = $prefix . 'settings';
    $suser = $mysqli->query("SELECT username, password FROM `$table` WHERE username = '$uname' LIMIT 1");
    $count = mysqli_num_rows($suser);
    if ($count > 0) {
        echo '<meta http-equiv="refresh" content="0; url=dashboard.php" />';
        exit;
    }
}

$_GET  = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

$error = 0;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
        <link rel="manifest" href="/manifest.json">
        <link rel="apple-touch-icon" href="/pwa/img/192.png">
        <meta name="theme-color" content="#5269fb">
        <meta name="apple-mobile-web-app-status-bar" content="#FFE1C4">';
        <title>VPN & IDS SECURITY &rsaquo; Admin Panel</title>

        <!-- CSS -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.1/css/all.css">
		<link href="/assets/css/admin.min.css" rel="stylesheet">

        <!-- Favicon -->
        <link rel="shortcut icon" href="/assets/img/favicon.png">
        <script src="/pwa/app.js"></script>
        <style type="text/css">
            #myVideo {
              position: fixed;
              right: 0;
              bottom: 0;
              min-width: 100%; 
              min-height: 100%;
            }
            .login-page {
              position: fixed;
              bottom: 0;
              background: rgba(0, 0, 0, 0.5);
              color: #f1f1f1;
              width: 100%;
              padding: 20px;
            }
            .login-logo{
                position: relative;
                display: -ms-flexbox;
                /* display: flex; */
                -ms-flex-direction: column;
                flex-direction: column;
                min-width: 0;
                word-wrap: break-word;
                /* background-color: #fff; */
                /* background-clip: border-box; */
                /* border: 1px solid rgba(0,0,255,.3); */
                border-radius: 0;
            }
        </style>
    </head>

    <body class="login-page">
        <video autoplay muted loop id="myVideo">
          <source src="assets/background.mp4" type="video/mp4">
          Your browser does not support HTML5 video.
        </video>
	<div class="login-box">
	    <form action="" method="post">
	    
		<div class="login-logo">
            <div class="mainl">
                <img style="width: 10rem;border-radius: 50%;margin-bottom: 10px;" src="assets/img/SkyNet_login.jpg"> 
            </div>
           <a href="#"><!-- <i class="fab fa-get-pocket"></i> --> SkyNet VPN & IDS <b>SECURITY</b></a>
        </div>
		
		<div class="card">
           <div class="card-body text-white bg-dark">
<?php
if (isset($_POST['signin'])) {
    $ip    = addslashes(htmlentities($_SERVER['REMOTE_ADDR']));
	if ($ip == "::1") {
		$ip = "127.0.0.1";
	}
	@$date = @date("d F Y");
    @$time = @date("H:i");
    
    $username = mysqli_real_escape_string($mysqli, $_POST['username']);
    $password = hash('sha256', $_POST['password']);
    $table    = $prefix . "settings";
    $check    = $mysqli->query("SELECT username, password FROM `$table` WHERE `username`='$username' AND password='$password'");
    if (mysqli_num_rows($check) > 0) {
        $table   = $prefix . "logins";
        $checklh = $mysqli->query("SELECT id FROM `$table` WHERE `username`='$username' AND ip='$ip' AND date='$date' AND time='$time' AND successful='1'");
        if (mysqli_num_rows($checklh) == 0) {
            $log = $mysqli->query("INSERT INTO `$table` (username, ip, date, time, successful) VALUES ('$username', '$ip', '$date', '$time', '1')");
        }
        
        $_SESSION['sec-username'] = $username;
        echo '<meta http-equiv="refresh" content="0;url=dashboard.php">';
    } else {
		$table   = $prefix . "logins";
        $checklh = $mysqli->query("SELECT id FROM `$table` WHERE `username`='$username' AND ip='$ip' AND date='$date' AND time='$time' AND successful='0'");
        if (mysqli_num_rows($checklh) == 0) {
            $log = $mysqli->query("INSERT INTO `$table` (username, ip, date, time, successful) VALUES ('$username', '$ip', '$date', '$time', '0')");
        }
        
        echo '
		<div class="alert alert-danger">
              <i class="fas fa-exclamation-circle"></i> The entered <strong>Username</strong> or <strong>Password</strong> is incorrect.
        </div>';
        $error = 1;
    }
}
?> 
			<div class="form-group has-feedback <?php
if ($error == 1) {
    echo 'has-danger';
}
?>">
            <div class="input-group mb-3">
				<input type="username" name="username" class="form-control <?php
if ($error == 1) {
    echo 'is-invalid';
}
?>" placeholder="Username" <?php
if ($error == 1) {
    echo 'autofocus';
}
?> required>
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
				</div>
            </div>
			</div>
            <div class="form-group has-feedback">
			    <div class="input-group mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
				<div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
				</div>
				</div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" name="signin" class="btn btn-md btn-primary btn-block btn-flat"><i class="fas fa-sign-in-alt"></i>
&nbsp;Sign In</button>
                </div>
            </div>
			</div>
			</div>
        </form> 
		
		</div>
        <script>
            // Get the video
            var video = document.getElementById("myVideo");

            // Get the button
            var btn = document.getElementById("myBtn");

            // Pause and play the video, and change the button text
            function myFunction() {
              if (video.paused) {
                video.play();
                btn.innerHTML = "Pause";
              } else {
                video.pause();
                btn.innerHTML = "Play";
              }
            }
            </script>
    </body>
</html>

