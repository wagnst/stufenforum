<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
if (check_login("start") == true) 
{	
	include('mysql.inc.php');
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Adminpanel</title>
		<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
		<script src="js/jquery-1.7.2.js"></script>
		<script src="js/lightbox.js"></script>
		<script language="Javascript">
		<!--
		   document.getElementById("loading").style.visibility='visible';
		//-->
		</script>			
	</head>	
	<body onLoad="javascript:document.getElementById('loading').style.visibility='hidden';">	
	<?php
	include('menu.inc.php');	
	?>
	<div id="inhalt">
	<div id="layout_canvas">
	<div class="profilkopf"><img src="./img/home.png">Stufenseite: Administrationsinterface</a></div>
	<div id="loading"><img src="img/wait.gif" alt="Loading..." /></div>
	<div id="userStats" class="clearfix">
	<?php
	if ($_GET["berechtigung"] == "0")
	{
		echo '<div class="error"><h3>Sie haben keine Berechtigung, diese Seite zu sehen! Bei Fragen schalten Sie ihren Computer aus und gehen schlafen. :-)</h3></div>';
	}	
	?>
	<p>Hallo <span class="label label-important"><?php echo $s_user_name ?></span><br> Willkommen im Adminpanel!<br/><br/> Allgemeine Information:</p>
	<div class="suchergebnis">
		<p>Wähle im Menü, welchen Bereich du betreten möchtest. Bei Fragen kannst du dich gerne an <b><?php echo $admin_mail ?></b> wenden.</p>
	</div>
	<p>Deine Berechtigungen:</p>
	<div class="suchergebnis">
		<?php
			$rechte = array();
			$rechte = get_rights();
			foreach ($rechte as $r){
				echo '<li>'.$r.'</li>';
			}

		?>
	</div>
		<p>Viel Spaß mit dem Adminpanel!<br/>Gruß <a href="mailto:mail@steffenwagner.com">Steffen Wagner </a> - © 2012</p>
	</div>
	</div>
	</div>
	<?php
	include('footer.inc.php');	
}else
{
	header('Location: login.php?logout=1');
}

?>