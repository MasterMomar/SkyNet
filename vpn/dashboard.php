<?php
require_once "core.php";
head();
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div class="content-header">
				
				<div class="container-fluid">
				  <div class="row mb-2">
        		    <div class="col-sm-9">
        		      <h1 class="m-0 text-white">
        		      	<div class="dashbord_cont">
	        		      	<!-- <i class="fas fa-home"></i>  -->
	        		      	<img src="assets/img/ConsoleiconSkyNet.png" class="wi-30">
	        		      	<span class="">Console</span>
        		      	</div>
        		      	<div class="store_icon_cont">
        		      		<a href=""><img class="store_icon" src="assets/img/appstore.png"></a>
        		      		<a href=""><img class="store_icon" src="assets/img/googleplay.png"></a>
        		      	</div>
        		      </h1>
        		    </div>
        		    <div class="col-sm-3">
        		      <ol class="breadcrumb float-sm-right">
        		        <li class="breadcrumb-item"><a href="dashboard.php"><!-- <i class="fas fa-home"></i> --><img src="assets/img/Homepage-Dashboard-transparent.png" class="wi-25"> Admin Panel</a></li>
        		        <li class="breadcrumb-item active">Console</li>
        		      </ol>
        		    </div>
        		  </div>
    			</div>
            </div>

				<!--Page content-->
				<!--===================================================-->
				<div class="content">
				<div class="container-fluid">
                    
<h4 class="card-title">Vulnerability Chart</h4><br />
<?php
$date   = date('d F Y');
$table  = $prefix . 'logs';
$query  = $mysqli->query("SELECT * FROM `$table` WHERE `date`='$date' AND `type`='SQLi'");
$count  = mysqli_num_rows($query);
$query2 = $mysqli->query("SELECT * FROM `$table` WHERE `date`='$date' AND `type`='Bad Bot' or `type`='Fake Bot' or type='Missing User-Agent header' or type='Missing header Accept' or type='Invalid IP Address header'");
$count2 = mysqli_num_rows($query2);
$query3 = $mysqli->query("SELECT * FROM `$table` WHERE `date`='$date' AND `type`='Proxy'");
$count3 = mysqli_num_rows($query3);
$query4 = $mysqli->query("SELECT * FROM `$table` WHERE `date`='$date' AND `type`='Spammer'");
$count4 = mysqli_num_rows($query4);
?>
                <div class="row">
                
					    <div class="col-sm-6 col-lg-3">
                            <div class="small-box bg-primary">
                               <div class="inner">
                                   <h3><?php
echo $count;
?></h3>
                                   <p>SQLi Attacks</p>
                               </div>
                               <div class="icon">
                                   <!-- <i class="fas fa-code"></i> -->
                                   <img class="imgis" src="assets/img/time-based-sql-injectionSNicon.png">
                               </div>
                               <a href="sqli-logs.php" class="small-box-footer">View Logs <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
					    </div>
					    <div class="col-sm-6 col-lg-3">
					        <div class="small-box bg-danger">
                               <div class="inner">
                                   <h3><?php
echo $count2;
?></h3>
                                   <p>Bot Attacks </p>
                               </div>
                               <div class="icon">
                                   <!-- <i class="fas fa-robot"></i> -->
                                   <img class="imgis" src="assets/img/Botbender.png">
                               </div>
                               <a href="badbot-logs.php" class="small-box-footer">View Logs <i class="fas fa-arrow-circle-right">
                               </i></a>
                            </div>
					    </div>
					    <div class="col-sm-6 col-lg-3">
					        <div class="small-box bg-success">
                               <div class="inner">
                                   <h3><?php
echo $count3;
?></h3>
                                   <p>Proxy Attacks</p>
                               </div>
                               <div class="icon">
                                   <!-- <i class="fas fa-globe"></i> -->
                                   <img class="imgis" src="assets/img/proxy.png">
                               </div>
                               <a href="proxy-logs.php" class="small-box-footer">View Logs <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
					    </div>
					    <div class="col-sm-6 col-lg-3">
					        <div class="small-box bg-warning">
                               <div class="inner">
                                   <h3><?php
echo $count4;
?></h3>
                                   <p>Spam</p>
                               </div>
                               <div class="icon">
                                   <!-- <i class="fas fa-keyboard"></i> -->                                   
                                   <img class="imgis" src="assets/img/Spamrecycle-bin-SNicon.png">
                               </div>
                               <a href="spammer-logs.php" class="small-box-footer">View Logs <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
					    </div>
					</div>
                    
                <br /><h4 class="card-title">Overall Statistics</h4><br />
                    
                <div class="row">          
					    <div class="col-lg-7">
					        <div id="panel-network" class="card">
					            <div class="card-header">
					                <h3 class="card-title"> Statistics</h3>
					            </div>
					            <div class="card-body">
                                    <canvas id="log-stats"></canvas>
                                </div>
                            </div>
					
					    </div>
<?php
$table   = $prefix . 'logs';
$querym  = $mysqli->query("SELECT * FROM `$table` WHERE `type`='SQLi'");
$countm  = mysqli_num_rows($querym);
$querym2 = $mysqli->query("SELECT * FROM `$table` WHERE `type`='Bad Bot' or `type`='Fake Bot' or type='Missing User-Agent header' or type='Missing header Accept' or type='Invalid IP Address header'");
$countm2 = mysqli_num_rows($querym2);
$querym3 = $mysqli->query("SELECT * FROM `$table` WHERE `type`='Proxy'");
$countm3 = mysqli_num_rows($querym3);
$querym4 = $mysqli->query("SELECT * FROM `$table` WHERE `type`='Spammer'");
$countm4 = mysqli_num_rows($querym4);
?>
                        <div class="col-lg-5 att-summary">
					        <div class="row">
					            <div class="col-sm-12 col-lg-12"> 
							         <div class="card card-primary card-outline">
							         	<div class="card-header">
							         		<div class="w-50 float-left"><p class="text-uppercase mar-btm text-lg">SQL Attacks </p></div>
							         		<div class="w-50 float-left text-right">
							         			<!-- <i class="fas fa-code fa-2x"></i> -->
							         			<img class="imgis" src="assets/img/time-based-sql-injectionSNicon.png">
							         		</div>
							         	</div>
										<div class="card-body text-center">
											<p class="h3 text-thin"><?php
											echo $countm;
											?></p>
										</div>
									 </div>
					            </div>
					        </div>

					        <div class="row">
					            <div class="col-sm-12 col-lg-12"> 
							         <div class="card card-danger card-outline">
							         	<div class="card-header">
							         		<div class="w-50 float-left"><p class="text-uppercase mar-btm text-lg">Bot Attacks </p></div>
							         		<div class="w-50 float-left text-right">
							         			<!-- <i class="fas fa-robot fa-2x"></i> -->
							         			<img class="imgis" src="assets/img/Botbender.png">
							         		</div>
							         	</div>
										<div class="card-body text-center">
											<p class="h3 text-thin"><?php
											echo $countm2;
											?></p>
										</div>
									 </div>
					            </div>
					        </div>

					        <div class="row">
					            <div class="col-sm-12 col-lg-12"> 
							         <div class="card card-warning card-outline">
							         	<div class="card-header">
							         		<div class="w-50 float-left"><p class="text-uppercase mar-btm text-lg">Proxy Attacks </p></div>
							         		<div class="w-50 float-left text-right">
							         			<!-- <i class="fas fa-globe fa-2x"></i> -->
							         			<img class="imgis" src="assets/img/proxy.png">
							         		</div>
							         	</div>
										<div class="card-body text-center">
											<p class="h3 text-thin"><?php
											echo $countm3;
											?></p>
										</div>
									 </div>
					            </div>
					        </div>

					        <div class="row">
					            <div class="col-sm-12 col-lg-12"> 
							         <div class="card card-success card-outline">
							         	<div class="card-header">
							         		<div class="w-50 float-left"><p class="text-uppercase mar-btm text-lg">Spam </p></div>
							         		<div class="w-50 float-left text-right">
							         			<!-- <i class="fas fa-keyboard fa-2x"></i> -->
							         			<img class="imgis" src="assets/img/Spamrecycle-bin-SNicon.png">
							         		</div>
							         	</div>
										<div class="card-body text-center">
											<p class="h3 text-thin"><?php
											echo $countm4;
											?></p>
										</div>
									 </div>
					            </div>
					        </div>
					    </div>
					</div>
                    
                    <div class="card card-dark modules_stat">
						<div class="card-header">
								<h3 class="card-title"><i class="fas fa-stream"></i> Modules Status</h3>
						</div>
						<div class="card-body">
				<div class="row modules">
					<div class="col-md-4">
                        <div class="card card-body bg-light">
						    <center>
							<h5><img src="assets/img/pro_module.jfif" class="wi-25"></i> &nbsp;Protection Modules</h5>
                            </center>
						</div>
					</div>
					<div class="col-md-2">
                        <div class="card card-body bg-light">
						    <center>
							<strong><img class="imgis" src="assets/img/time-based-sql-injectionSNicon.png"> SQL Attacks</strong><br />Protection<hr />
<?php
$table = $prefix . 'sqli-settings';
$query = $mysqli->query("SELECT * FROM `$table`");
$row   = $query->fetch_assoc();
if ($row['protection'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>							
						</div>
					</div>
					<div class="col-md-2">
                        <div class="card card-body bg-light">
						    <center>
							<strong><img class="imgis" src="assets/img/Botbender.png"> Bot Attacks </strong><br />Protection<hr />
<?php
$table = $prefix . 'badbot-settings';
$query = $mysqli->query("SELECT * FROM `$table`");
$row   = $query->fetch_assoc();
if ($row['protection'] == 1 OR $row['protection2'] == 1 OR $row['protection3'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>
						</div>
					</div>
					<div class="col-md-2">
                        <div class="card card-body bg-light">
						    <center>
							<strong><img class="imgis" src="assets/img/proxy.png"> Proxy Attacks</strong><br />Protection<br /><hr />
<?php
$table = $prefix . 'proxy-settings';
$query = $mysqli->query("SELECT * FROM `$table`");
$row   = $query->fetch_assoc();
if ($row['protection'] == 1 OR $row['protection2'] == 1 OR $row['protection3'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>
						</div>
					</div>
					<div class="col-md-2">
                        <div class="card card-body bg-light">
						    <center>
							<strong><img class="imgis" src="assets/img/Spamrecycle-bin-SNicon.png"> Spam Overload</strong><br />Protection<br /><hr />
<?php
$table = $prefix . 'spam-settings';
$query = $mysqli->query("SELECT * FROM `$table`");
$row   = $query->fetch_assoc();
if ($row['protection'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>
						</div>
					</div>
					</div>
					
					<div class="row modules">
					<div class="col-md-4">
                        <div class="card card-body bg-light">
						    <center>
							<h5> <img src="assets/img/logSNicon.png" class="wi-25"> &nbsp;Logging Settings</h5>
                            </center>
						</div>
					</div>
					<div class="col-md-2">
                        <div class="card card-body bg-light">
						    <center>
							<strong><img class="imgis" src="assets/img/time-based-sql-injectionSNicon.png"> SQL Attacks</strong><br />Logging<hr />
<?php
$table = $prefix . 'sqli-settings';
$query = $mysqli->query("SELECT * FROM `$table`");
$row   = $query->fetch_assoc();
if ($row['logging'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>							
						</div>
					</div>
					<div class="col-md-2">
                        <div class="card card-body bg-light">
						    <center>
							<strong><img class="imgis" src="assets/img/Botbender.png"> Bot Attacks </strong><br />Logging<hr />
<?php
$table = $prefix . 'badbot-settings';
$query = $mysqli->query("SELECT * FROM `$table`");
$row   = $query->fetch_assoc();
if ($row['logging'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>
						</div>
					</div>
					<div class="col-md-2">
                        <div class="card card-body bg-light">
						    <center>
							<strong><img class="imgis" src="assets/img/proxy.png"> Proxy Attacks</strong><br />Logging <br /><hr />
<?php
$table = $prefix . 'proxy-settings';
$query = $mysqli->query("SELECT * FROM `$table`");
$row   = $query->fetch_assoc();
if ($row['logging'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>
						</div>
					</div>
					<div class="col-md-2">
                        <div class="card card-body bg-light">
						    <center>
							<strong><img class="imgis" src="assets/img/Spamrecycle-bin-SNicon.png"> Spam Overload</strong><br />Logging<br /><hr />
<?php
$table = $prefix . 'spam-settings';
$query = $mysqli->query("SELECT * FROM `$table`");
$row   = $query->fetch_assoc();
if ($row['logging'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>
						</div>
					</div>
					</div>
					
					<div class="row modules">
					<div class="col-md-4">
                        <div class="card card-body bg-light">
						    <center>
							<h5><img src="assets/img/banicon.png" class="wi-25"> &nbsp;AutoBan Settings</h5>
                            </center>
						</div>
					</div>
					<div class="col-md-2">
                        <div class="card card-body bg-light">
						    <center>
							<strong><img class="imgis" src="assets/img/time-based-sql-injectionSNicon.png"></i> SQL Attacks</strong><br />AutoBan<hr />
<?php
$table = $prefix . 'sqli-settings';
$query = $mysqli->query("SELECT * FROM `$table`");
$row   = $query->fetch_assoc();
if ($row['autoban'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>							
						</div>
					</div>
                    <div class="col-md-2">
                        <div class="card card-body bg-light">
						    <center>
							<strong><img class="imgis" src="assets/img/Botbender.png"> Bot Attacks </strong><br />AutoBan<hr />
<?php
$table = $prefix . 'badbot-settings';
$query = $mysqli->query("SELECT * FROM `$table`");
$row   = $query->fetch_assoc();
if ($row['autoban'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>
						</div>
					</div>
					<div class="col-md-2">
                        <div class="card card-body bg-light">
						    <center>
							<strong><img class="imgis" src="assets/img/proxy.png"> Proxy Attacks</strong><br />AutoBan<br /><hr />
<?php
$table = $prefix . 'proxy-settings';
$query = $mysqli->query("SELECT * FROM `$table`");
$row   = $query->fetch_assoc();
if ($row['autoban'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>
						</div>
					</div>
					<div class="col-md-2">
                        <div class="card card-body bg-light">
						    <center>
							<strong><img class="imgis" src="assets/img/Spamrecycle-bin-SNicon.png"> Spam Overload</strong><br />AutoBan<br /><hr />
<?php
$table = $prefix . 'spam-settings';
$query = $mysqli->query("SELECT * FROM `$table`");
$row   = $query->fetch_assoc();
if ($row['autoban'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>
						</div>
					</div>
					</div>   
						</div>
				   </div>
				   
				   <div class="row">
<?php
$url = 'http://extreme-ip-lookup.com/json/127.0.0.1';
$ch  = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60');
curl_setopt($ch, CURLOPT_REFERER, "https://google.com");
$ipcontent = curl_exec($ch);
curl_close($ch);

$ip_data = @json_decode($ipcontent);
if ($ip_data && $ip_data->{'status'} == 'success') {
    $gstatus = '<font color="green">Online</font>';
} else {
    $gstatus = '<font color="red">Offline</font>';
}
?>
				        <div class="col-md-6">
						    <div class="info-box">
            			    <span class="info-box-icon bg-dark"><img src="assets/img/logo.png" class="wi-25"></span>
            			    <div class="info-box-content">
            			      <span class="info-box-text">GeoIP API Status</span>
            			      <span class="info-box-number"><?php
echo $gstatus;
?></span>
            			    </div>
          			        </div>
						</div>
<?php
$tablepd = $prefix . 'proxy-settings';
$querypd = $mysqli->query("SELECT * FROM `$tablepd`");
$rowpd   = mysqli_fetch_array($querypd);

$proxy_check = 0;

if ($rowpd['protection'] > 0 && $rowpd['protection'] != 4) {
    $apik = 'api' . $rowpd['protection'];
    $key  = $rowpd[$apik];
}

if ($rowpd['protection'] == 1) {
    //Invalid API Key ==> Offline
    $ch  = curl_init();
    $url = "http://v2.api.iphub.info";
    curl_setopt_array($ch, [
		CURLOPT_URL => $url,
		CURLOPT_CONNECTTIMEOUT => 30,
		CURLOPT_RETURNTRANSFER => true,
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);
    
    if ($httpCode >= 200 && $httpCode < 300) {
        $proxy_check = 1;
    }
    
} else if ($rowpd['protection'] == 2) {
    
    $ch = curl_init('http://proxycheck.io/v2/8.8.8.8');
    $curl_options = array(
        CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $curl_options);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);
    
    if ($httpCode >= 200 && $httpCode < 300) {
        $proxy_check = 1;
    }
    
} else if ($rowpd['protection'] == 3) {
    //Invalid API Key ==> Offline
    $headers = [
		'X-Key: '.$key.'',
    ];
    $ch = curl_init("https://www.iphunter.info:8082/v1/ip/8.8.8.8");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);
    
    if ($httpCode >= 200 && $httpCode < 300) {
        $proxy_check = 1;
    }

} else if ($rowpd['protection'] == 4) {
	$ch  = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://blackbox.ipinfo.app/lookup/8.8.8.8');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
	curl_setopt($ch, CURLOPT_REFERER, "https://google.com");
	$proxyresponse = curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
	curl_close($ch);
    
    if ($httpCode >= 200 && $httpCode < 300) {
        $proxy_check = 1;
    }
    
} else {
	$proxy_check = -1;
}

if ($proxy_check == 1) {
    $pstatus = '<font color="green">Online</font>';
} else if ($proxy_check == 0) {
    $pstatus = '<font color="red">Offline</font>';
} else {
	$pstatus = '<font color="red">Disabled</font>';
}
?>
				        <div class="col-md-6">
						    <div class="info-box">
            			    <span class="info-box-icon bg-dark"><img src="assets/img/proxy.png" class="wi-25"></span>
            			    <div class="info-box-content">
            			      <span class="info-box-text">Proxy Attacks Detection API Status</span>
            			      <span class="info-box-number"><?php
echo $pstatus;
?></span>
            			    </div>
          			        </div>
						</div>
				   </div>
				   
				   <div class="row">
				        <div class="col-md-4">
						    <div class="card card-dark">
             			        <div class="card-header with-border">
            			            <h3 class="card-title">Recent Logs</h3>
             			        </div>
            			        <div class="card-body">
<?php
$table = $prefix . 'logs';
$query = $mysqli->query("SELECT * FROM `$table` ORDER BY id DESC LIMIT 2");
$count = mysqli_num_rows($query);
if ($count > 0) {
    while ($row = $query->fetch_assoc()) {
        echo '
							<h4 style="background-color:#f7f7f7; font-size: 16px; text-align: center; padding: 7px 10px; margin-top: 0;"><i class="fas fa-user pull-left"></i> ' . $row['ip'] . '</h4>
													
							<div class="media">
                            <div class="mr-3">
                                <i class="fas fa-user-secret fa-3x"></i>
                            </div>
                            <div class="media-body">

                                    <p><img src="assets/img/hacker.png" class="wi-25"> Threat Type:
';
        if ($row['type'] == 'SQLi') {
            echo '<button class="btn btn-sm btn-primary btn-flat"><i class="fas fa-code"></i> <b>' . $row['type'] . '</b></button>';
        } elseif ($row['type'] == 'Bad Bot' || $row['type'] == 'Fake Bot' || $row['type'] == 'Missing User-Agent header' || $row['type'] == 'Missing header Accept' || $row['type'] == 'Invalid IP Address header') {
            echo '<button class="btn btn-sm btn-danger btn-flat"><i class="fas fa-robot"></i> <b>' . $row['type'] . '</b></button>';
        } elseif ($row['type'] == 'Proxy') {
            echo '<button class="btn btn-sm btn-success btn-flat"><i class="fas fa-globe"></i> <b>' . $row['type'] . '</b></button>';
        } elseif ($row['type'] == 'Spammer') {
            echo '<button class="btn btn-sm btn-warning btn-flat"><i class="fas fa-keyboard"></i> <b>' . $row['type'] . '</b></button>';
        } else {
            echo '<button class="btn btn-sm btn-success btn-flat"><i class="fas fa-user-secret"></i> <b>Other</b></button>';
        }
        echo '
		                    </p>
							<p><i class="fas fa-calendar"></i> ' . $row['date'] . ' at ' . $row['time'] . '</p>
							
                            </div>
							<p class="ml-3">
                                        
										<a href="log-details.php?id=' . $row['id'] . '" class="btn btn-sm btn-flat btn-block btn-primary"><i class="fas fa-tasks"></i> Details</a>
                            			';
        if (get_banned($row['ip']) == 1) {
            echo '
									                <a href="bans-ip.php?delete-id=' . get_bannedid($row['ip']) . '" class="btn btn-sm btn-flat btn-block btn-success"><i class="fas fa-trash"></i> Unban</a>
								                	';
        } else {
            echo '
									                <a href="bans-ip.php?ip=' . $row['ip'] . '&reason=' . $row['type'] . '" class="btn btn-sm btn-flat btn-block btn-warning"><i class="fas fa-ban"></i> Ban</a>
								                    ';
        }
        echo '
							                        <a href="all-logs.php?delete-id=' . $row['id'] . '" class="btn btn-sm btn-flat btn-block btn-danger"><i class="fas fa-times"></i> Delete</a>       

                                    </p>
                            </div>
							<hr>
';
    }
    echo '<center><a href="all-logs.php" class="btn btn-flat btn-block btn-primary"><i class="fas fa-search"></i> View All</a></center>';
} else {
    echo '<div class="alert alert-info"><p>There are no recent <b>Logs</b></p></div>';
}
?>
            			        </div>
            			    </div>
						</div>
						
						<div class="col-md-4">
						    <div class="card card-dark">
             			        <div class="card-header with-border">
            			            <h3 class="card-title">Recent IP Bans</h3>
             			        </div>
            			        <div class="card-body">
<?php
$table = $prefix . 'bans';
$query = $mysqli->query("SELECT * FROM `$table` ORDER BY id DESC LIMIT 2");
$count = mysqli_num_rows($query);
if ($count > 0) {
    while ($row = $query->fetch_assoc()) {
        echo '	
							<h4 style="background-color:#f7f7f7; font-size: 16px; text-align: center; padding: 7px 10px; margin-top: 0;"><i class="fas fa-user pull-left"></i> ' . $row['ip'] . '</h4>
													
							<div class="media">
                            <div class="mr-3">
                                <i class="fas fa-ban fa-3x"></i>
                            </div>
                            <div class="media-body">

									<p><i class="fas fa-file-alt"></i> ' . $row['reason'] . '</p>
									<p><i class="fas fa-calendar"></i> ' . $row['date'] . ' at ' . $row['time'] . '</p>

                                    <p style="margin-bottom: 0">
                                        <button class="btn btn-sm btn-flat btn-danger"><i class="fas fa-magic"></i> Autobanned: <b>';
        if ($row['autoban'] == 1) {
            echo 'Yes';
        } else {
            echo 'No';
        }
        echo '</b></button>
                                    </p>
                            </div>
							<p class="ml-3">
                                        
										<a href="bans-ip.php?edit-id=' . $row['id'] . '" class="btn btn-sm btn-flat btn-block btn-primary"><i class="fas fa-edit"></i> Edit</a>
                            			<a href="bans-ip.php?delete-id=' . $row['id'] . '" class="btn btn-sm btn-flat btn-block btn-success"><i class="fas fa-trash"></i> Unban</a>
                                    </p>
                            </div>
							<hr />
';
    }
    echo '<center><a href="bans-ip.php" class="btn btn-flat btn-block btn-primary"><i class="fas fa-search"></i> View All</a></center>';
} else {
    echo '<div class="alert alert-light"><p>There are no recent <b>IP Bans</b></p></div>';
}
?>
            			        </div>
            			    </div>
						</div>
						
				        <div class="col-md-4">
						    <div class="card card-dark">
             			        <div class="card-header with-border">
            			            <h3 class="card-title">Statistics</h3>
             			        </div>
            			        <div class="card-body">
<table class="table table-bordered table-hover">
                 <thead class="thead-light">
				    <tr class="active">
                      <th><i class="fas fa-list"></i> Threat Logs</th>
                      <th>Value</th>
                    </tr>
				</thead>
				<tbody>
<?php
$table = $prefix . 'logs';
@$query = $mysqli->query("SELECT id FROM `$table`");
@$count = mysqli_num_rows($query);
?>
                    <tr>
                      <td>Total</td>
                      <td><?php
echo $count;
?></td>
                    </tr>
<?php
$table  = $prefix . 'logs';
$date2  = date("d F Y");
$query2 = $mysqli->query("SELECT id FROM `$table` WHERE `date`='$date2'");
$count2 = mysqli_num_rows($query2);
?>
                    <tr>
                      <td>Today</td>
                      <td><?php
echo $count2;
?></td>
                    </tr>
<?php
$table  = $prefix . 'logs';
$date3  = date("F Y");
$query3 = $mysqli->query("SELECT id FROM `$table` WHERE `date` LIKE '% $date3'");
$count3 = mysqli_num_rows($query3);
?>
					<tr>
                      <td>This month</td>
                      <td><?php
echo $count3;
?></td>
                    </tr>
<?php
$table  = $prefix . 'logs';
$date4  = date("Y");
$query4 = $mysqli->query("SELECT id FROM `$table` WHERE `date` LIKE '% $date4'");
$count4 = mysqli_num_rows($query4);
?>
					<tr>
                      <td>This year</td>
                      <td><?php
echo $count4;
?></td>
                    </tr>
				</tbody>
				<thead class="thead-light">
					<tr class="active">
                      <th><i class="fas fa-ban"></i> IP Bans</th>
                      <th>Value</th>
                    </tr>
				</thead>
				<tbody>
<?php
$table  = $prefix . 'bans';
$query5 = $mysqli->query("SELECT id FROM `$table`");
$count5 = mysqli_num_rows($query5);
?>
                    <tr>
                      <td>Total</td>
                      <td><?php
echo $count5;
?></td>
                    </tr>
<?php
$table  = $prefix . 'bans';
$date6  = date("d F Y");
$query6 = $mysqli->query("SELECT id FROM `$table` WHERE `date`='$date6'");
$count6 = mysqli_num_rows($query6);
?>
                    <tr>
                      <td>Today</td>
                      <td><?php
echo $count6;
?></td>
                    </tr>
<?php
$table  = $prefix . 'bans';
$date7  = date("F Y");
$query7 = $mysqli->query("SELECT id FROM `$table` WHERE `date` LIKE '% $date7'");
$count7 = mysqli_num_rows($query7);
?>
					<tr>
                      <td>This month</td>
                      <td><?php
echo $count7;
?></td>
                    </tr>
<?php
$table  = $prefix . 'bans';
$date8  = date("Y");
$query8 = $mysqli->query("SELECT id FROM `$table` WHERE `date` LIKE '% $date8'");
$count8 = mysqli_num_rows($query8);
?>
					<tr>
                      <td>This year</td>
                      <td><?php
echo $count8;
?></td>
                    </tr>
				   </tbody>
                  </table>
            			        </div>
            			    </div>
						</div>
				    </div>
                    
                    <div class="card card-dark">
						<div class="card-header">
								<h3 class="card-title">Threats by Country</h3>
						</div>
						<div class="card-body">
					        <div class="col-md-12">

<table id="dt-basic" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
								          <th><i class="fas fa-globe"></i> Country</th>
						                  <th><i class="fas fa-bug"></i> Threats</th>
										</tr>
									</thead>
									<tbody>
<?php
$table     = $prefix . 'logs';
$countries = array(
    "Afghanistan",
    "Albania",
    "Algeria",
    "Andorra",
    "Angola",
    "Antigua and Barbuda",
    "Argentina",
    "Armenia",
    "Australia",
    "Austria",
    "Azerbaijan",
    "Bahamas",
    "Bahrain",
    "Bangladesh",
    "Barbados",
    "Belarus",
    "Belgium",
    "Belize",
    "Benin",
    "Bhutan",
    "Bolivia",
    "Bosnia and Herzegovina",
    "Botswana",
    "Brazil",
    "Brunei",
    "Bulgaria",
    "Burkina Faso",
    "Burundi",
    "Cambodia",
    "Cameroon",
    "Canada",
    "Cape Verde",
    "Central African Republic",
    "Chad",
    "Chile",
    "China",
    "Colombi",
    "Comoros",
    "Congo (Brazzaville)",
    "Congo",
    "Costa Rica",
    "Cote d\'Ivoire",
    "Croatia",
    "Cuba",
    "Cyprus",
    "Czech Republic",
    "Denmark",
    "Djibouti",
    "Dominica",
    "Dominican Republic",
    "East Timor (Timor Timur)",
    "Ecuador",
    "Egypt",
    "El Salvador",
    "Equatorial Guinea",
    "Eritrea",
    "Estonia",
    "Ethiopia",
    "Fiji",
    "Finland",
    "France",
    "Gabon",
    "Gambia, The",
    "Georgia",
    "Germany",
    "Ghana",
    "Greece",
    "Grenada",
    "Guatemala",
    "Guinea",
    "Guinea-Bissau",
    "Guyana",
    "Haiti",
    "Honduras",
    "Hungary",
    "Iceland",
    "India",
    "Indonesia",
    "Iran",
    "Iraq",
    "Ireland",
    "Israel",
    "Italy",
    "Jamaica",
    "Japan",
    "Jordan",
    "Kazakhstan",
    "Kenya",
    "Kiribati",
    "Korea, North",
    "Korea, South",
    "Kuwait",
    "Kyrgyzstan",
    "Laos",
    "Latvia",
    "Lebanon",
    "Lesotho",
    "Liberia",
    "Libya",
    "Liechtenstein",
    "Lithuania",
    "Luxembourg",
    "Macedonia",
    "Madagascar",
    "Malawi",
    "Malaysia",
    "Maldives",
    "Mali",
    "Malta",
    "Marshall Islands",
    "Mauritania",
    "Mauritius",
    "Mexico",
    "Micronesia",
    "Moldova",
    "Monaco",
    "Mongolia",
    "Morocco",
    "Mozambique",
    "Myanmar",
    "Namibia",
    "Nauru",
    "Nepal",
    "Netherlands",
    "New Zealand",
    "Nicaragua",
    "Niger",
    "Nigeria",
    "Norway",
    "Oman",
    "Pakistan",
    "Palau",
    "Panama",
    "Papua New Guinea",
    "Paraguay",
    "Peru",
    "Philippines",
    "Poland",
    "Portugal",
    "Qatar",
    "Romania",
    "Russia",
    "Rwanda",
    "Saint Kitts and Nevis",
    "Saint Lucia",
    "Saint Vincent",
    "Samoa",
    "San Marino",
    "Sao Tome and Principe",
    "Saudi Arabia",
    "Senegal",
    "Serbia and Montenegro",
    "Seychelles",
    "Sierra Leone",
    "Singapore",
    "Slovakia",
    "Slovenia",
    "Solomon Islands",
    "Somalia",
    "South Africa",
    "Spain",
    "Sri Lanka",
    "Sudan",
    "Suriname",
    "Swaziland",
    "Sweden",
    "Switzerland",
    "Syria",
    "Taiwan",
    "Tajikistan",
    "Tanzania",
    "Thailand",
    "Togo",
    "Tonga",
    "Trinidad and Tobago",
    "Tunisia",
    "Turkey",
    "Turkmenistan",
    "Tuvalu",
    "Uganda",
    "Ukraine",
    "United Arab Emirates",
    "United Kingdom",
    "United States",
    "Uruguay",
    "Uzbekistan",
    "Vanuatu",
    "Vatican City",
    "Venezuela",
    "Vietnam",
    "Yemen",
    "Zambia",
    "Zimbabwe"
);

foreach ($countries as $country) {
    $log_result = $mysqli->query("SELECT * FROM `$table` WHERE `country` LIKE '%$country%'");
    $log_rows   = mysqli_num_rows($log_result);
    $lgrow      = mysqli_fetch_assoc($log_result);
    
    if ($log_rows > 0) {
        echo '<tr>';
        echo '<td><img src="assets/plugins/flags/blank.png" class="flag flag-' . strtolower($lgrow['country_code']) . '"/>&nbsp; ' . $country . '</td>';
        echo '<td>' . $log_rows . '</td>';
        echo '</tr>';
    }
}
?>
</tbody>
</table>
							
                            </div>
                        </div>
                    </div>
                    
				</div>
				</div>
				<!--===================================================-->
				<!--End page content-->

			</div>
			<!--===================================================-->
			<!--END CONTENT CONTAINER-->
</div>
<script>
var barChartData = {
			labels: [
<?php
$i = 1;
while ($i <= 12) {
    $date = date('F', mktime(0, 0, 0, $i, 1));
    echo "'$date'";
    if ($i != 12) {
        echo ',';
    }
    $i++;
}
?>
			],
			datasets: [{
				label: 'SQLi',
				backgroundColor: '#007bff',
				stack: '1',
				data: [
<?php
$table = $prefix . 'logs';
$i     = 1;
while ($i <= 12) {
    $date   = date('F Y', mktime(0, 0, 0, $i, 1));
    $tquery = $mysqli->query("SELECT * FROM `$table` WHERE `date` LIKE '%$date' AND `type`='SQLi'");
    $tcount = mysqli_num_rows($tquery);
    echo "'$tcount'";
    if ($i != 12) {
        echo ',';
    }
    $i++;
}
?>
				]
			}, {
				label: 'Bot Attacks ',
				backgroundColor: '#dc3545',
				stack: '2',
				data: [
<?php
$table = $prefix . 'logs';
$i     = 1;
while ($i <= 12) {
    $date   = date('F Y', mktime(0, 0, 0, $i, 1));
    $tquery = $mysqli->query("SELECT * FROM `$table` WHERE `date` LIKE '%$date' AND (`type`='Bad Bot' or `type`='Fake Bot' or type='Missing User-Agent header' or type='Missing header Accept' or type='Invalid IP Address header')");
    $tcount = mysqli_num_rows($tquery);
    echo "'$tcount'";
    if ($i != 12) {
        echo ',';
    }
    $i++;
}
?>
				]
			}, {
				label: 'Proxy Attacks',
				backgroundColor: '#28a745',
				stack: '3',
				data: [
<?php
$table = $prefix . 'logs';
$i     = 1;
while ($i <= 12) {
    $date   = date('F Y', mktime(0, 0, 0, $i, 1));
    $tquery = $mysqli->query("SELECT * FROM `$table` WHERE `date` LIKE '%$date' AND `type`='Proxy'");
    $tcount = mysqli_num_rows($tquery);
    echo "'$tcount'";
    if ($i != 12) {
        echo ',';
    }
    $i++;
}
?>
				]
			}, {
				label: 'Spam Overload',
				backgroundColor: '#ffc107',
				stack: '4',
				data: [
<?php
$table = $prefix . 'logs';
$i     = 1;
while ($i <= 12) {
    $date   = date('F Y', mktime(0, 0, 0, $i, 1));
    $tquery = $mysqli->query("SELECT * FROM `$table` WHERE `date` LIKE '%$date' AND `type`='Spammer'");
    $tcount = mysqli_num_rows($tquery);
    echo "'$tcount'";
    if ($i != 12) {
        echo ',';
    }
    $i++;
}
?>
				]
			}]

		};
		window.onload = function() {
			var ctx = document.getElementById('log-stats').getContext('2d');
			window.myBar = new Chart(ctx, {
				type: 'bar',
				data: barChartData,
				options: {
					legend: {
		                labels: {
		                    fontColor: '#fff',
		                }
		            },
					tooltips: {
						mode: 'index',
						intersect: false
					},
					responsive: true,
					scales: {
						xAxes: [{
							ticks: {
		                        fontColor: '#fff'
		                    },
							stacked: true,
						}],
						yAxes: [{
							ticks: {
		                        fontColor: '#fff'
		                    },
							stacked: true
						}]
					}
				}
			});
		};
		
$(document).ready(function() {

	$('#dt-basic').dataTable( {
		"responsive": true,
        "order": [[ 1, "desc" ]],
		"language": {
			"paginate": {
			  "previous": '<i class="fas fa-angle-left"></i>',
			  "next": '<i class="fas fa-angle-right"></i>'
			}
		}
	} );
} );
</script>
<?php
footer();
?>