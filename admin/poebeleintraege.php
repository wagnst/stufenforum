<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
require_once('mysql.inc.php');
if (check_login("poebeleintraege") == true)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Pöbelbucheinträge anzeigen</title>
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

		echo '
		<div id="inhalt">
		<div id="layout_canvas">
		<div class="profilkopf"><img src="./img/poebel.png">Pöbelbucheinträge anzeigen</></div>
		<div id="loading"><img src="img/wait.gif" alt="Loading..." /></div>	
		<div class="clearfix">
			<div id="userStats" class="clearfix">';
		$abfrage = "SELECT `SCHUELER_ID`,`Name_ganz` FROM `user` ORDER BY `SCHUELER_ID` DESC";
		$ergebnis = mysql_query($abfrage, $sql);
		while ($row = mysql_fetch_object($ergebnis))
		{
			$userid = $row->SCHUELER_ID;
			$name = $row->Name_ganz;
			echo '<table class="table table-bordered table-striped table-hover">';
			echo '<thead>
					<tr>
						<th>Schülername</th>
						<th>Pöbelbuch-Eintragungen</th>
					</tr>
				 </thead>
				 <tbody>';	
			echo '<tr>
			<td><div>'.$name.'</div></td>			
			<td><div>';			
			$abfrage1 = "SELECT `eintragstext`,`EintragsID`,`PosterID`,`postzeit` FROM `poebel_eintraege_neu` WHERE `freigeschaltet`=1 AND `DELETED`=0 AND `SchuelerID`='$userid' ORDER BY `postzeit` ASC";
			$ergebnis1 = mysql_query($abfrage1, $sql);
			while ($row1 = mysql_fetch_object($ergebnis1))
			{
				
				$eintragstext = $row1->eintragstext;
				$eintragstext_ohnehtml = strip_tags($eintragstext,'');
				echo $eintragstext_ohnehtml.' | ';
	
			}
			echo '</div></td>
			</tr>';
			echo '</tbody></table>'; 


		}
	echo '</div></div></div></div></body>';
	include('footer.inc.php');	
}
else
{
   	header('Location: admin.php?berechtigung=0');
}

?>		