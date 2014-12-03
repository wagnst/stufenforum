<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
if (check_login("news") == true)
{
		include('mysql.inc.php');
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>News</title>
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
<div class="profilkopf"><img src="./img/nachricht.png"> Mitteilungen</></div>
<div id="loading"><img src="img/wait.gif" alt="Loading..." /></div>
<div id="userStats" class="clearfix">
		<?php    
    if (!empty($_GET["manage"]))
		{ 
		if ($_GET["msg"] == "erfolg")
		{
		echo '<div class="success">Aktion war erfolgreich!</div>';
		}elseif ($_GET["msg"] == "fehler")
		{
		echo '<div class="error">'.$_GET["errordesc"].'</div>';
		}
		$abfrage = "SELECT Thema,Text,Name_ganz,Postzeit,poster_ID,news_ID, Bearbeitung FROM news,user WHERE SCHUELER_ID=Poster_ID ORDER BY Postzeit DESC";
		$ergebnis = mysql_query($abfrage, $sql);

		while ($row = mysql_fetch_object($ergebnis)) 
		{     

			$edit=' <a class="btn btn-small" title="Mitteilung editieren" href="update-news.php?edit='.$row->news_ID.'"><i class="icon-pencil"></i></a><a class="btn btn-small btn-danger" title="Mitteilung löschen" href="update-news.php?del='.$row->news_ID.'"><i class="icon-remove icon-white"></i></a>';
			echo '<div class="suchergebnis"><div class="profilkategorie">'.$row->Thema.$edit.'</div>'.$row->Text.'<div class="poebel_kopf">'.$row->Name_ganz.' '.$row->Postzeit.$edited.'</div></div>'; 
		}
		echo '</div></div></div>';     
		include('footer.inc.php');	     
		}
}
else
{
	header('Location: admin.php?berechtigung=0');
}

?>
