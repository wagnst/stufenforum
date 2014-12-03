<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
if (check_login("kalender") == true)
{
	include('mysql.inc.php');
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Kalender</title>
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
	<script src="js/jquery-1.7.2.js"></script>
	<script src="js/lightbox.js"></script>
</head>	
<body>
<?php include('menu.inc.php'); ?>
<div id="inhalt">
<div id="layout_canvas">
<div class="profilkopf">Kalender</div>
		<?php     
    if (!empty($_GET["manage"]))
		{   
		if ($_GET["msg"] == "erfolg")
		{
			echo '<div class="suchergebnis">Aktion war erfolgreich!</div>';
		}elseif ($_GET["msg"] == "fehler")
		{
			echo '<div class="suchergebnis">Fehler! Aktion war nicht erfolgreich!</div>';
		}
		$abfrage = "SELECT * FROM kalender";
		$ergebnis = mysql_query($abfrage, $sql);
		echo '<table class="tdstyle">';
		echo '<tr><td><b>ID</b></td><td><b>Autor</b></td><td><b>Datum</b></td><td><b>Titel</b></td><td><b>Beschreibung</b></td><td><b>Betrifft</b></td><td><b>Edit</b></td><td><b>Löschen</b></td></tr>'; 
		while ($row = mysql_fetch_object($ergebnis)) 
		{     
			$date_id=$row->Termin_ID;
			$poster=$row->poster_ID;
			$date=$row->Datum;	
			$title=$row->Titel;
			$descr=$row->Beschreibung;
			$con=$row->Betrifft;
         
			$abfrage1 = "Select `Name_ganz` From user WHERE SCHUELER_ID='$poster'";
			$ergebnis1 = mysql_query($abfrage1, $sql);
			$row1 = mysql_fetch_object($ergebnis1);
			$author = $row1->Name_ganz; 
			$target = $con; /*aus tabelle kurse die ids und fach_lang holen und umwandeln*/
			           
		    echo '<tr>
			<td><div>'.$date_id.'</div></td>
			<td><div>'.$author.'</div></td>
			<td><div>'.$date.'</div></td>
			<td><div>'.$title.'</div></td>
			<td><div>'.$descr.'</div></td>
			<td><div>'.$target.'</div></td>
			<td><div align="center"><a href="update-kalender.php?edit=' . $date_id . '"><img src="_edit.gif" border="0"></a></div></td>
			<td><div align="center"><a href="update-kalender.php?del=' . $date_id . '"><img src="_del.gif" border="0"></a></div></td>
			</tr>';
		}
     	echo '</table></div></div>';
        include('footer.inc.php');       
     exit;         
    }
}
else
{
	header('Location: admin.php?berechtigung=0');
}

?>
