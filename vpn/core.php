<?php
$configfile = 'config.php';
if (!file_exists($configfile)) {
    echo '<meta http-equiv="refresh" content="0; url=install" />';

    exit();
}

require 'config.php';

if(!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['sec-username'])) {
    $uname = $_SESSION['sec-username'];
    $table = $prefix . 'settings';
    $suser = $mysqli->query("SELECT username, password FROM `$table` WHERE username='$uname' LIMIT 1");
    $count = $suser->num_rows;
    if ($count < 0) {
        echo '<meta http-equiv="refresh" content="0; url=index.php" />';
        exit;
    }
} else {
    echo '<meta http-equiv="refresh" content="0; url=index.php" />';
    exit;
}

if (basename($_SERVER['SCRIPT_NAME']) != 'warning-pages.php') {
    $_GET  = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
}

$table = $prefix . 'settings';
$query = $mysqli->query("SELECT * FROM `$table` LIMIT 1");
$row   = mysqli_fetch_array($query);

function get_banned($ip)
{
    include 'config.php';
    $table = $prefix . 'bans';
    $query = $mysqli->query("SELECT * FROM `$table` WHERE ip='$ip' LIMIT 1");
    $count = mysqli_num_rows($query);
    if ($count > 0) {
        return 1;
    } else {
        return 0;
    }
}

function get_bannedid($ip)
{
    include 'config.php';
    $table = $prefix . 'bans';
    $query = $mysqli->query("SELECT * FROM `$table` WHERE ip='$ip' LIMIT 1");
    $row   = mysqli_fetch_array($query);
    return $row['id'];
}

function head()
{
    include 'config.php';
    
    $table = $prefix . 'settings';
    $query = $mysqli->query("SELECT * FROM `$table` LIMIT 1");
    $row   = mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<meta name="theme-color" content="#000000">
    <link rel="shortcut icon" href="assets/img/favicon.png">
    <title>IDS Security &rsaquo; Admin Panel</title>


    <!--STYLESHEET-->
    <!--=================================================-->
	
    <!--Bootstrap Stylesheet-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

	<!--Font Awesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.1/css/all.css">
	
	<!--Stylesheet-->
    <link href="assets/css/admin.min.css" rel="stylesheet">
	
    <!--Switchery-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
        
<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-country.php') {
        echo '
    <!--Select2-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">';
    }
?>

    <!--DataTables-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/r-2.2.5/datatables.min.css"/>
 
    <!--Flags-->
    <link href="assets/plugins/flags/flags.css" rel="stylesheet">
	
    <!--SCRIPT-->
    <!--=================================================-->

    <!--jQuery-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
	integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
	crossorigin="anonymous"></script>
	
<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'dashboard.php' || basename($_SERVER['SCRIPT_NAME']) == 'visit-analytics.php') {
        echo '
	<!--Chart.js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>';
    }
?>

<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'log-details.php' || basename($_SERVER['SCRIPT_NAME']) == 'search.php') {
        echo '
	
    <!--Map-->
    <script src="https://openlayers.org/api/OpenLayers.js"></script>';
    }
?>
<style>
/* width */
::-webkit-scrollbar {
    width: 8px;
}

/* Track */
::-webkit-scrollbar-track {
    background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
    background: #699; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: #555; 
}

.scroll-btn {
	height: 30px;
	width: 30px;
	border: 2px solid #000;
	border-radius: 10%;
	background-color: #000;
	position: fixed;
	bottom: 25px;
	right: 20px;
	opacity: 0.5;
	z-index: 9999;
	cursor: pointer;
	display: none;
}

.scroll-btn .scroll-btn-arrow {
	height: 8px;
	width: 8px;
	border: 3px solid;
	border-right: none;
	border-top: none;
	margin: 12px 9px;
	-webkit-transform: rotate(135deg);
	-moz-transform: rotate(135deg);
	-ms-transform: rotate(135deg);
	-o-transform: rotate(135deg);
	transform: rotate(135deg);
	color: white;
}
.bg-aside{
    background:#8362C8;
    color: #fff;
}
.badge{
    border-radius: 0;
}
.btn-aside{
    background:#A086D5;
    color:#fff;
}
.card-header p{
    margin-bottom: 0!important;
    font-weight: 600;
}
.store_icon{
    width: 120px;
}
.dashbord_cont{
    float: left;
}
.store_icon_cont{
    margin-left: 4rem;
    float: left;
}
.search_button{
    color: #A086D5;
}
.head_title{
    font-size: 20px;
    text-align: center;
    width: 500px;
}
.small-box .icon{
    width: 50%;
    float: left;
    margin-top: 10px;
    text-align: right;
}
.small-box .inner{
    width: 50%;
    float: left;
}
.small-box .small-box-footer{
    clear: both;
}
.small-box .icon .imgis {
  width: 80px;
}

.small-box .icon:hover .imgis {
  width: 100px;
  transition: all .3s linear;
}
.att-summary .imgis{
    width: 50px;
}
.att-summary .card{
    /*background: -webkit-linear-gradient(to right, rgba(29,162,31,0.6), rgba(241,208,65,1));
    background: linear-gradient(to right, rgba(29,162,31,0.6), rgba(241,208,65,1)); */
}
.content-wrapper{
	        background: -webkit-linear-gradient(to bottom, rgba(255,123,100,.9), rgba(146,48,165,.9));
            background: linear-gradient(to right, rgba(56,238,126,1), rgba(168,192,255,1));
            /*background: url('assets/img/bk.jpg');*/
}
#panel-network{
	background: transparent;
	color: #fff;
}
.modules_stat{
	background: transparent;
}
.modules .imgis{
    width: 25px;
}
.wi-30{
    width: 30px;
}
.wi-25{
    width: 25px;
}
.wi-40{
	width: 40px;
}
.wi-45{
	width: 45px;
	height: 45px;
}
.data_files .small-box{
    overflow: hidden;
}

.data_files .small-box .icon{
    text-align: left;
}
.data_files .small-box .icon>i {
    left: 15px;
}

.notouch .scroll-btn:hover { opacity: 0.8 }

@media only screen and (max-width: 700px), only screen and (max-device-width: 700px) {
	.scroll-btn {
		bottom: 8px;
		right: 8px;
	}
}
</style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-dark bg-aside border-bottom">

        <ul class="nav navbar-nav">
		  <li class="nav-item">
             <a class="nav-link" data-widget="pushmenu" href="#">
                 <img src="assets/img/menu.png" class="wi-40">
             </a>
          </li>
		</ul>
		  
		  <form class="form-inline ml-3" action="search.php" method="get">
      		  <div class="input-group input-group-sm">
      		    <input type="text" name="ip" class="form-control form-control-navbar iplookup" placeholder="IP Lookup" required>
				<div class="input-group-append ">
				  <button type="submit" class="btn btn-navbar"><i class="fa fa-search search_button"></i></button>
                </button>
     		    </div>
     		  </div>
   		  </form>
		  <div class="head_title">
            SkyNet VPN & IDS
          </div>
		<ul class="nav navbar-nav ml-auto">
          <li class="nav-item d-none d-md-block">
             <a href="<?php
    echo $site_url;
?>" class="nav-link" target="_blank" title="View Site">
			 <!-- <i class="fas fa-desktop"></i> -->
             <img src="assets/img/view_site.png" class="wi-30">
			 </a>
          </li>
          <li class="nav-item">
             <a href="settings.php" class="nav-link" title="Settings"><img src="assets/img/settings.png" class="wi-30"><!-- <i class="fas fa-cogs"></i> --></a>
          </li>
		  
<?php
    $uname = $_SESSION['sec-username'];
    $table = $prefix . 'settings';
    $suser = $mysqli->query("SELECT username, password FROM `$table` WHERE username='$uname' LIMIT 1");
    $urow  = mysqli_fetch_array($suser);
?>
        </ul>
    </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4 bg-aside">

	<center><a href="dashboard.php" class="brand-link bg-aside">
      <span class="brand-text" style="font-weight:700;color: black;"><img src="assets/img/logo.png" alt="SkyNet IDS Security" style="width:100px;">VPN-IDS</span>
    </a></center>
	
	<div class="sidebar">
	
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <p style="margin: auto;"><a href="account.php" class="btn btn-sm btn-secondary" style="background: deepskyblue;" ><i class="fas fa-user fa-fw"></i> Account</a>
		  &nbsp;&nbsp;<a href="logout.php" class="btn btn-sm btn-danger btn-flat"><i class="fas fa-sign-out-alt fa-fw"></i> Logout</a></p>
      </div>

	  <nav class="mt-2">
	  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
		<li class="nav-header">NAVIGATION</li>
        
        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'dashboard.php') {
        echo 'active';
    }
?>">
           <a href="dashboard.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'dashboard.php') {
        echo 'active';
    }
?>">
              <img src="assets/img/ConsoleiconSkyNet.png" class="wi-25"><!-- <i class="fas fa-home"> --></i>&nbsp; <p>Console</p>
           </a>
        </li>
          
        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'site-info.php') {
        echo 'active';
    }
?>">
           <a href="site-info.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'site-info.php') {
        echo 'active';
    }
?>">
              <img src="assets/img/console_i.png" class="wi-25"><!-- <i class="fas fa-info-circle"></i> -->&nbsp; <p>Host Information</p>
           </a>
        </li>
          
        <li class="nav-item has-treeview <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'ip-whitelist.php' OR basename($_SERVER['SCRIPT_NAME']) == 'file-whitelist.php') {
        echo 'menu-open';
    }
?>">
           <a href="#" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'ip-whitelist.php' OR basename($_SERVER['SCRIPT_NAME']) == 'file-whitelist.php') {
        echo 'active';
    }
?>">
              <img src="assets/img/Approvedicon.jpg" class="wi-25"><!-- <i class="fas fa-flag"></i> -->&nbsp; <p>Approval List <i class="fas fa-angle-right right"></i>
           </p></a>
           <ul class="nav nav-treeview">
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'ip-whitelist.php') {
        echo 'active';
    }
?>"><a href="ip-whitelist.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'ip-whitelist.php') {
        echo 'active';
    }
?>"><i class="fas fa-user"></i>&nbsp; <p>Approved IP Addresses</p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'file-whitelist.php') {
        echo 'active';
    }
?>"><a href="file-whitelist.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'file-whitelist.php') {
        echo 'active';
    }
?>"><i class="far fa-file-alt"></i>&nbsp; <p>Approved Files</p></a></li>
           </ul>
        </li>
          
        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'warning-pages.php') {
        echo 'active';
    }
?>">
           <a href="warning-pages.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'warning-pages.php') {
        echo 'active';
    }
?>">
              <img src="assets/img/WarningReplyIcon.png" class="wi-25"><!-- <i class="fas fa-file-alt"> --></i>&nbsp; <p>System Alerts</p>
           </a>
        </li>
		
		<li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'users.php') {
        echo 'active';
    }
?>">
           <a href="login-history.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'login-history.php') {
        echo 'active';
    }
?>">
              <img src="assets/img/loginhistorySNicon.png" class="wi-25"><!-- <i class="fas fa-history"></i> -->&nbsp; <p>Login History</p>
           </a>
        </li>
        <li class="nav-item">
        	<div class="digital_forensics">
		        <a href="dashboard.php">
		            <img src="assets/img/Digital_ForensicsVM.png" style="width: 100%;margin: 1rem auto;display: block;">
		        </a>
		      </div>
        </li>
        <li class="nav-header">SECURITY</li>
          
        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'sql-injection.php') {
        echo 'active';
    }
?>">
           <a href="sql-injection.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'sql-injection.php') {
        echo 'active';
    }
?>">
              <img src="assets/img/time-based-sql-injectionSNicon.png" class="wi-25"><!-- <i class="fas fa-code"></i> -->&nbsp; <p> SQL Attacks
<?php
    $table = $prefix . 'sqli-settings';
    $query = $mysqli->query("SELECT * FROM `$table`");
    $row   = mysqli_fetch_array($query);
    if ($row['protection'] == 1) {
        echo '<span class="right badge badge-success">ON</span>';
    } else {
        echo '<span class="right badge badge-danger">OFF</span>';
    }
?>     
           </p></a>
        </li>
		
		<li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'badbots.php') {
        echo 'active';
    }
?>">
           <a href="badbots.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'badbots.php') {
        echo 'active';
    }
?>">
              <img src="assets/img/Botbender.png" class="wi-25"><!-- <i class="fas fa-user-secret"></i> -->&nbsp; <p>Bot Attacks
<?php
    $table = $prefix . 'badbot-settings';
    $query = $mysqli->query("SELECT * FROM `$table`");
    $row   = mysqli_fetch_array($query);
    if ($row['protection'] == 1 OR $row['protection2'] == 1 OR $row['protection3'] == 1) {
        echo '<span class="right badge badge-success">ON</span>';
    } else {
        echo '<span class="right badge badge-danger">OFF</span>';
    }
?>     
           </p></a>
        </li>
          
        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'proxy.php') {
        echo 'active';
    }
?>">
           <a href="proxy.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'proxy.php') {
        echo 'active';
    }
?>">
              <img src="assets/img/proxy.png" class="wi-25"><!-- <i class="fas fa-globe"></i> -->&nbsp; <p>Proxy Attacks
<?php
    $table = $prefix . 'proxy-settings';
    $query = $mysqli->query("SELECT * FROM `$table`");
    $row   = mysqli_fetch_array($query);
    if ($row['protection'] > 0 OR $row['protection2'] == 1 OR $row['protection3'] == 1) {
        echo '<span class="right badge badge-success">ON</span>';
    } else {
        echo '<span class="right badge badge-danger">OFF</span>';
    }
?>     
           </p></a>
        </li>
		
		<li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'spam.php') {
        echo 'active';
    }
?>">
           <a href="spam.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'spam.php') {
        echo 'active';
    }
?>">
              <img src="assets/img/Spamrecycle-bin-SNicon.png" class="wi-25"><!-- <i class="fas fa-keyboard"></i> -->&nbsp; <p>Spam Attacks
<?php
    $table = $prefix . 'spam-settings';
    $query = $mysqli->query("SELECT * FROM `$table`");
    $row   = mysqli_fetch_array($query);
    if ($row['protection'] == 1) {
        echo '<span class="right badge badge-success">ON</span>';
    } else {
        echo '<span class="right badge badge-danger">OFF</span>';
    }
?>     
           </p></a>
        </li>
        
<?php
    $table   = $prefix . 'logs';
    $lquery1 = $mysqli->query("SELECT * FROM `$table`");
    $lcount1 = mysqli_num_rows($lquery1);
    $lquery2 = $mysqli->query("SELECT * FROM `$table` WHERE `type`='SQLi'");
    $lcount2 = mysqli_num_rows($lquery2);
    $lquery3 = $mysqli->query("SELECT * FROM `$table` WHERE `type`='Bad Bot' or `type`='Fake Bot' or type='Missing User-Agent header' or type='Missing header Accept' or type='Invalid IP Address header'");
    $lcount3 = mysqli_num_rows($lquery3);
    $lquery4 = $mysqli->query("SELECT * FROM `$table` WHERE `type`='Proxy'");
    $lcount4 = mysqli_num_rows($lquery4);
    $lquery5 = $mysqli->query("SELECT * FROM `$table` WHERE `type`='Spammer'");
    $lcount5 = mysqli_num_rows($lquery5);
?>
        <li class="nav-item has-treeview <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'all-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'sqli-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'badbot-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'proxy-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'spammer-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'log-details.php') {
        echo 'menu-open';
    }
?>">
           <a href="#" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'all-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'sqli-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'badbot-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'proxy-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'spammer-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'log-details.php') {
        echo 'active';
    }
?>">
              <img src="assets/img/logSNicon.png" class="wi-25"><!-- <i class="fas fa-align-justify"></i> -->&nbsp; <p>Logs <i class="fas fa-angle-right right"></i>
           </p></a>
           <ul class="nav nav-treeview">
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'all-logs.php') {
        echo 'active';
    }
?>"><a href="all-logs.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'all-logs.php') {
        echo 'active';
    }
?>"><i class="fas fa-align-justify"></i>&nbsp; <p>All Logs <span class="badge right badge-primary"><?php
    echo $lcount1;
?></span></p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'sqli-logs.php') {
        echo 'active';
    }
?>"><a href="sqli-logs.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'sqli-logs.php') {
        echo 'active';
    }
?>"><img src="assets/img/time-based-sql-injectionSNicon.png" class="wi-25"><!-- <i class="fas fa-code"></i> -->&nbsp; <p>SQL Attack Logs <span class="badge right badge-info"><?php
    echo $lcount2;
?></span></p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'badbot-logs.php') {
        echo 'active';
    }
?>"><a href="badbot-logs.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'badbot-logs.php') {
        echo 'active';
    }
?>"><img src="assets/img/Botbender.png" class="wi-25"><!-- <i class="fas fa-robot"></i> -->&nbsp; <p>Bot Attacks Logs <span class="badge right badge-danger"><?php
    echo $lcount3;
?></span></p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'proxy-logs.php') {
        echo 'active';
    }
?>"><a href="proxy-logs.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'proxy-logs.php') {
        echo 'active';
    }
?>"><img src="assets/img/proxy.png" class="wi-25"><!-- <i class="fas fa-globe"></i> -->&nbsp; <p>Proxy Attack Logs <span class="badge right badge-success"><?php
    echo $lcount4;
?></span></p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'spammer-logs.php') {
        echo 'active';
    }
?>"><a href="spammer-logs.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'spammer-logs.php') {
        echo 'active';
    }
?>"><img src="assets/img/Spamrecycle-bin-SNicon.png" class="wi-25"><!-- <i class="fas fa-keyboard"></i> -->&nbsp; <p>Spam Attack Logs <span class="badge right badge-warning"><?php
    echo $lcount5;
?></span></p></a></li>
           </ul>
        </li>
        
<?php
    $table   = $prefix . 'bans';
    $bquery1 = $mysqli->query("SELECT * FROM `$table`");
    $bcount1 = mysqli_num_rows($bquery1);
    $table2  = $prefix . 'bans-country';
    $bquery2 = $mysqli->query("SELECT * FROM `$table2`");
    $bcount2 = mysqli_num_rows($bquery2);
    $table3  = $prefix . 'bans-ranges';
    $bquery3 = $mysqli->query("SELECT * FROM `$table3`");
    $bcount3 = mysqli_num_rows($bquery3);
    $table4  = $prefix . 'bans-other';
    $bquery4 = $mysqli->query("SELECT * FROM `$table4`");
    $bcount4 = mysqli_num_rows($bquery4);
?>
        <li class="nav-item has-treeview <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-ip.php' OR basename($_SERVER['SCRIPT_NAME']) == 'bans-iprange.php' OR basename($_SERVER['SCRIPT_NAME']) == 'bans-country.php' OR basename($_SERVER['SCRIPT_NAME']) == 'bans-other.php') {
        echo 'menu-open';
    }
?>">
           <a href="#" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-ip.php' OR basename($_SERVER['SCRIPT_NAME']) == 'bans-iprange.php' OR basename($_SERVER['SCRIPT_NAME']) == 'bans-country.php' OR basename($_SERVER['SCRIPT_NAME']) == 'bans-other.php') {
        echo 'active';
    }
?>">
              <img src="assets/img/banicon.png" class="wi-25"><!-- <i class="fas fa-ban"></i> -->&nbsp; <p>Bans <i class="fas fa-angle-right right"></i>
           </p></a>
           <ul class="nav nav-treeview">
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-ip.php') {
        echo 'active';
    }
?>"><a href="bans-ip.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-ip.php') {
        echo 'active';
    }
?>"><i class="fas fa-user"></i>&nbsp; <p>IP Bans <span class="badge right badge-secondary"><?php
    echo $bcount1;
?></span></p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-country.php') {
        echo 'active';
    }
?>"><a href="bans-country.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-country.php') {
        echo 'active';
    }
?>"><i class="fas fa-globe"></i>&nbsp; <p>Country Bans <span class="badge right badge-secondary"><?php
    echo $bcount2;
?></span></p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-iprange.php') {
        echo 'active';
    }
?>"><a href="bans-iprange.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-iprange.php') {
        echo 'active';
    }
?>"><i class="fas fa-grip-horizontal"></i>&nbsp; <p>IP Range Bans <span class="badge right badge-secondary"><?php
    echo $bcount3;
?></span></p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-other.php') {
        echo 'active';
    }
?>"><a href="bans-other.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-other.php') {
        echo 'active';
    }
?>"><i class="fas fa-desktop"></i>&nbsp; <p>Other Bans <span class="badge right badge-secondary"><?php
    echo $bcount4;
?></span></p></a></li>
           </ul>
        </li>
		

		
		<li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bad-words.php') {
        echo 'active';
    }
?>">
           <a href="bad-words.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bad-words.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-filter"></i>&nbsp; <p>Text/Words Audit
<?php
    $table   = $prefix . 'bad-words';
    $queryfc = $mysqli->query("SELECT * FROM `$table` LIMIT 1");
    $countfc = mysqli_num_rows($queryfc);
    if ($countfc > 0) {
        echo '<span class="right badge badge-success">ON</span>';
    } else {
        echo '<span class="right badge badge-primary">OFF</span>';
    }
?>
           </p></a>
        </li>
		

		
		<li class="nav-header">ANALYTICS &nbsp;
<?php
    $table = $prefix . 'settings';
    $query = $mysqli->query("SELECT * FROM `$table`");
    $row   = mysqli_fetch_array($query);
    if ($row['live_traffic'] == 1) {
        echo '<span class="right badge badge-success">ON</span>';
    } else {
        echo '<span class="right badge badge-primary">OFF</span>';
    }
?></li>
		
		<li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'live-traffic.php') {
        echo 'active';
    }
?>">
           <a href="live-traffic.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'live-traffic.php') {
        echo 'active';
    }
?>">
              <img src="assets/img/LiveAnalytics.png" class="wi-25"><!-- <i class="fas fa-globe"></i> -->&nbsp; <p>Live Analytics</p>
           </a>
        </li>
		
		<li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'visit-analytics.php') {
        echo 'active';
    }
?>">
           <a href="visit-analytics.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'visit-analytics.php') {
        echo 'active';
    }
?>">
              <img src="assets/img/Homepage-Dashboard-transparent.png" class="wi-25"><!-- <i class="fas fa-chart-line"></i> -->&nbsp; <p>Analytics</p>
           </a>
        </li>
          
        <li class="nav-header">My IP Tools </li>

		<li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'error-monitoring.php') {
        echo 'active';
    }
?>">
           <a href="error-monitoring.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'error-monitoring.php') {
        echo 'active';
    }
?>">
              <img src="assets/img/Browsing-Error.png" class="wi-25"><!-- <i class="fas fa-exclamation-circle"></i> -->&nbsp; <p>Browsing Errors</p>
           </a>
        </li>
		

		
		<li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'port-scanner.php') {
        echo 'active';
    }
?>">
           <a href="port-scanner.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'port-scanner.php') {
        echo 'active';
    }
?>">
              <img src="assets/img/Portsopenclosed.png" class="wi-25"><!-- <i class="fas fa-search"></i> -->&nbsp; <p>Open/Closed Ports</p>
           </a>
        </li>

		<li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'blacklist-checker.php') {
        echo 'active';
    }
?>">
           <a href="blacklist-checker.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'blacklist-checker.php') {
        echo 'active';
    }
?>">
              <img src="assets/img/IP-Restricted-Websites.png" class="wi-25"><!-- <i class="fas fa-list"></i> -->&nbsp; <p>IP Address Restrictions</p>
           </a>
        </li>
          
        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'hashing.php') {
        echo 'active';
    }
?>">
           <a href="hashing.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'hashing.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-lock"></i>&nbsp; <p>Hashing</p>
           </a>
        </li>
		
		</ul>
          
      </nav>
      <div class="digital_forensics">
        <a href="dashboard.php">
            <img src="assets/img/Digital_ForensicsVM.png" style="width: 100%;margin: 1rem auto;">
        </a>
      </div>
    </div>
  </aside>
  
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

        <video autoplay muted loop id="myVideo">
          <source src="assets/background.mp4" type="video/mp4">
          Your browser does not support HTML5 video.
        </video>
<?php
}

function footer()
{
    include 'config.php';
    
    $table = $prefix . 'settings';
    $query = $mysqli->query("SELECT * FROM `$table`");
    $row   = mysqli_fetch_array($query);
?>
<footer class="main-footer">
    <div class="scroll-btn"><div class="scroll-btn-arrow"></div></div>
    <strong>&copy; <?php
    echo date("Y");
?> <a href="" target="_blank"><img src="assets/img/logo.png" alt="SkyNet IDS Security" style="width:50px;"></a></strong>
	
</footer>

</div>

    <!--JAVASCRIPT-->
    <!--=================================================-->

<script>
(function($) { // Avoid conflicts with other libraries

'use strict';

$(function() {
	var settings = {
			min: 200,
			scrollSpeed: 400
		},
		toTop = $('.scroll-btn'),
		toTopHidden = true;

	$(window).scroll(function() {
		var pos = $(this).scrollTop();
		if (pos > settings.min && toTopHidden) {
			toTop.stop(true, true).fadeIn();
			toTopHidden = false;
		} else if(pos <= settings.min && !toTopHidden) {
			toTop.stop(true, true).fadeOut();
			toTopHidden = true;
		}
	});

	toTop.bind('click touchstart', function() {
		$('html, body').animate({
			scrollTop: 0
		}, settings.scrollSpeed);
	});
});

})(jQuery);
</script>
	
<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'proxy.php') {
        echo '
	<!--Popper JS-->
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>';
    }
?>
	
    <!--Bootstrap-->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	
	<!--Admin-->
    <script src="assets/js/admin.min.js"></script>

<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-country.php') {
        echo '
    <!--Select2-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>';
    }
?>
    
    <!--DataTables-->
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/r-2.2.5/datatables.min.js"></script>

</body>
</html>
<?php
}
?>