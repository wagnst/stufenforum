<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
if (check_login("zungen") == true)
{
		include('mysql.inc.php');
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Böse Zungen</title>
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
<?php include('menu.inc.php'); ?>
<div id="inhalt">
<div id="layout_canvas">
<div class="profilkopf"><img src="./img/zungen.png">Böse Zungen behaupten</></div>
<div id="loading"><img src="img/wait.gif" alt="Loading..." /></div>
<?php    
		if ($_GET["msg"] == "erfolg")
		{
			echo '<div class="success">Aktion war erfolgreich!</div>';
		}elseif ($_GET["msg"] == "fehler")
		{
			echo '<div class="error">Fehler! Aktion war nicht erfolgreich!</div>';
		}
		if (isset($_GET['show']))//Section ausgeben
		{
			switch ($_GET['show'])
			{
				case "schueler":
					$section="schueler";
					break;
				case "lehrer":
					$section="lehrer";
					break;
				case "alle":
					$section="alle";
					break;
			}
		}	
		else
		{
			$section="alle";
		}
		
		if($section=="alle")
		{  
			echo '
				<ul id="submenu">
					<li class="selectedmenuitem"><a href="zungen.php?show=alle">Alle</a></li>
					<li><a href="zungen.php?show=schueler">Schüler</a></li>
					<li><a href="zungen.php?show=lehrer">Lehrer</a></li>
				</ul>
				<div id="userStats" class="clearfix">
				<table class="table table-bordered table-striped table-hover">
				<thead>
						<tr>
							<th>ID</th>
							<th>Behaupter</th>
							<th>Böse Zungen behaupten, dass...</th>
						</tr>
				</thead>
				<tbody>';	
				$abfrage = "SELECT `EintragsID`,`typ`,`PosterID`,`Betroffener`,`zungentext`,`Name_ganz`, `SCHUELER_ID` FROM `zungen_eintraege`,`user` WHERE SCHUELER_ID=PosterID ORDER BY `EintragsID` ASC";
				$ergebnis = mysql_query($abfrage, $sql);
				while ($row = mysql_fetch_object($ergebnis))
				{	
				echo '
					<tr>
						<td>' . $row->EintragsID . '</td>
						<td>'; 
						if (check_superadmin($s_user_id) == true) {
							echo $row->Name_ganz;
						} else {
							echo '<span class="label label-important">Nicht erlaubt!</span>';
						}
						echo '</td>
						<td><span class="label label-info">' . $row->Betroffener . '</span>  ' .$row->zungentext . '</td>
					</tr>';				
				}	
				echo '</tbody></table>';
		}	
		if($section=="schueler")
		{  
			echo '
				<ul id="submenu">
					<li><a href="zungen.php?show=alle">Alle</a></li>
					<li class="selectedmenuitem"><a href="zungen.php?show=schueler">Schüler</a></li>
					<li><a href="zungen.php?show=lehrer">Lehrer</a></li>
				</ul>
				<div id="userStats" class="clearfix">
				<table class="table table-bordered table-striped table-hover">
				<thead>
						<tr>
							<th>ID</th>
							<th>Behaupter</th>
							<th>Böse Zungen behaupten, dass...</th>
						</tr>
				</thead>
				<tbody>';
				$abfrage = "SELECT `EintragsID`,`typ`,`PosterID`,`Betroffener`,`zungentext`,`Name_ganz`, `SCHUELER_ID` FROM `zungen_eintraege`,`user` WHERE SCHUELER_ID=PosterID AND `typ`='s' ORDER BY `EintragsID` ASC";
				//SELECT Thema,Text,Name_ganz,Postzeit,poster_ID,news_ID, Bearbeitung FROM news,user WHERE SCHUELER_ID=Poster_ID ORDER BY Postzeit DESC
				$ergebnis = mysql_query($abfrage, $sql);
				while ($row = mysql_fetch_object($ergebnis))
				{	
				echo '
					<tr>
						<td>' . $row->EintragsID . '</td>
						<td>'; 
						if (check_superadmin($s_user_id) == true) {
							echo $row->Name_ganz;
						} else {
							echo '<span class="label label-important">Nicht erlaubt!</span>';
						}
						echo '</td>
						<td><span class="label label-info">' . $row->Betroffener . '</span>  ' .$row->zungentext . '</td>
					</tr>';				
				}					
				echo '</tbody></table>';
		
		}	
		if($section=="lehrer")
		{  
			echo '
				<ul id="submenu">
					<li><a href="zungen.php?show=alle">Alle</a></li>
					<li><a href="zungen.php?show=schueler">Schüler</a></li>
					<li class="selectedmenuitem"><a href="zungen.php?show=lehrer">Lehrer</a></li>
				</ul>
				<div id="userStats" class="clearfix">
				<table class="tdstyle">
				<table class="table table-bordered table-striped table-hover">
				<thead>
						<tr>
							<th>ID</th>
							<th>Behaupter</th>
							<th>Böse Zungen behaupten, dass...</th>
						</tr>
				</thead>
				<tbody>';	
				$abfrage = "SELECT `EintragsID`,`typ`,`PosterID`,`Betroffener`,`zungentext`,`Name_ganz`, `SCHUELER_ID` FROM `zungen_eintraege`,`user` WHERE SCHUELER_ID=PosterID AND `typ`='l' ORDER BY `EintragsID` ASC";
				$ergebnis = mysql_query($abfrage, $sql);
				while ($row = mysql_fetch_object($ergebnis))
				{	
				echo '
					<tr>
						<td>' . $row->EintragsID . '</td>
						<td>'; 
						if (check_superadmin($s_user_id) == true) {
							echo $row->Name_ganz;
						} else {
							echo '<span class="label label-important">Nicht erlaubt!</span>';
						}
						echo '</td>
						<td><span class="label label-info">' . $row->Betroffener . '</span>  ' .$row->zungentext . '</td>
					</tr>';				
				}	
				echo '</tbody></table>';
		}			
		echo '</div></div></div>';
		include('footer.inc.php');	  
}
else
{
	header('Location: admin.php?berechtigung=0');
}

?>
