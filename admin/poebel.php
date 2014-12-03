<?php
include('sessiontest.inc.php');
require_once('mysql.inc.php');
require_once('functions.inc.php');
if (check_login("poebel") == true)
{
	include('mysql.inc.php');
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Pöbelbeschwerden</title>
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
<div class="profilkopf"><img src="./img/poebel.png">Pöbelbeschwerden</></div>
<div id="loading"><img src="img/wait.gif" alt="Loading..." /></div>
<div id="userStats" class="clearfix">
<?php  
if ($_GET["msg"] == "erfolg")
{
	echo '<div class="success">Aktion war erfolgreich!</div>';
}elseif ($_GET["msg"] == "fehler")
{
	echo '<div class="error">Fehler! Aktion war nicht erfolgreich!</div>';
}elseif ($_GET["msg"] == "alreadyinvisible")
{
	echo '<div class="error">Achtung! Der Poebeleintrag wurde schon unsichtbar gemacht!</div>';
}elseif ($_GET["msg"] == "alreadydenied")
{
	echo '<div class="error">Achtung! Dieser Eintrag wurde schon abeglehnt!</div>';
}			
		echo '<table class="table table-bordered table-striped table-hover">';
		echo '<thead>
				<tr>
					<th>ID</th>
					<th>Schüler</th>
					<th>Autor</th>
					<th>Pöbel Eintrag</th>
					<th>Kommentar</th>
					<th>Status</th>
					<th>Aktion</th>
				</tr>
			 </thead>
			 <tbody>';
		$abfrage = "SELECT * FROM `poebel_beschwerden` ORDER BY `Beschwerde_ID` DESC";
		$ergebnis = mysql_query($abfrage, $sql) OR die(mysql_error());
		while ($row = mysql_fetch_object($ergebnis))
		{  
			//schuelername holen
			$schuelerid = $row->Schueler_ID;
			$abfrage1 = "SELECT * FROM user WHERE SCHUELER_ID='$schuelerid'";
			$ergebnis1 = mysql_query($abfrage1) OR die(mysql_error());
			$row1 = mysql_fetch_object($ergebnis1);
			$schueler = $row1->Name_ganz;
		
			//urspruenglichen poebeleintrag holen
			$beschwerdeid = $row->Beschwerde_ID;
			$poebelid = $row->Poebel_ID;
			$abfrage2 = "SELECT eintragstext,PosterID FROM poebel_eintraege_neu WHERE EintragsID='$poebelid'";
			$ergebnis2 = mysql_query($abfrage2)OR die(mysql_error());
			$row2 = mysql_fetch_object($ergebnis2);
			$poster = $row2->PosterID;
			$poebel = $row2->eintragstext; 

			//Autorname holen
			$abfrage3 = "Select `Name_ganz` From user WHERE SCHUELER_ID='$poster'";
			$ergebnis3 = mysql_query($abfrage3, $sql);
			$row3 = mysql_fetch_object($ergebnis3);
			$author = $row3->Name_ganz;		
		
			//Statuscheck
			if ($row->Status == 3)
			{
				$check = '<span class="label label-success">Gelöscht</span>'; //eintrag gelöscht
			}
			elseif ($row->Status == 2) //abgelehnt
			{
				$check = '<span class="label label-important">Abgelehnt</span>';
			}elseif ($row->Status == 1) //noch nichts gemacht
			{
				$check = '<span class="label label-info">Ausstehend</span>';
			}
			echo '
				<tr>
				<td><div>' . $beschwerdeid . '</div></td>
				<td><div>' . $schueler . '</div></td>
				<td><div>'; 
				if (check_superadmin($s_user_id) == true) {
					echo $author;
				} else {
					echo '<span class="label label-important">Nicht erlaubt!</span>';
				}
				echo '</div></td>				
				<td><div>' . $poebel . '</div></td>
				<td><div>' . $row->Kommentar. '</div></td>
				<td><div align="center">' . $check . '</div></td>
				<td>		
					<a class="btn btn-small" title="Beschwerde annehmen" href="update-poebel.php?del=' . $beschwerdeid . '"><i class="icon-ok"></i></a>
					<a class="btn btn-small btn-danger" title="Beschwerde ablehnen" href="update-poebel.php?reject=' . $beschwerdeid . '"><i class="icon-remove icon-white"></i></a>			
				</td>
				</tr>';
		}
		echo '</tbody></table></div></div></div>';
	include('footer.inc.php');	
}
else
{
   	header('Location: admin.php?berechtigung=0');
}

?>