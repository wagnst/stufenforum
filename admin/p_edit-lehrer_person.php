<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
if (check_login("lehrer") == true)
{
	if(empty($_POST['anrede'])) {
		$fehler .= "<li>Die Anrede fehlt</li>";
	}
	if(empty($_POST['vorname'])) {
		$fehler .= "<li>Der Vorname fehlt</li>";
	}
	if(empty($_POST['nachname'])) {
		$fehler .= "<li>Der Nachname fehlt</li>";
	}
	if(empty($_POST['geschlecht'])) {
		$fehler .= "<li>Das Geschlecht fehlt</li>";
	}		
	include('mysql.inc.php');
	$lehrer_id = (int)$_POST["id"];
	$anrede = $_POST["anrede"];
	$vorname = $_POST["vorname"];
	$nachname = $_POST["nachname"];
	$geschlecht = $_POST["geschlecht"];
  
 	if(empty($fehler)) 
		{ 
			$abfrage = "UPDATE `lehrer_neu` SET `Anrede` = '".$anrede."', `Vorname` = '".$vorname."', `Nachname` = '".$nachname."', `Geschlecht` = '".$geschlecht."'  WHERE `LEHRER_ID` =".$lehrer_id." LIMIT 1 ;";
			if (mysql_query($abfrage, $sql) == true)
			{
				header('Location: ./lehrer.php?showteacher=1&msg=erfolg');
			}
			else
			{
				header('Location: ./lehrer.php?showteacher=1&msg=fehler&errordesc=SQL FEHLER');
			}  	
		}else
		{
			header('Location: ./lehrer.php?showteacher=1&msg=fehler&errordesc='.$fehler.'');
		}
}
else
{
	header('Location: admin.php?berechtigung=0');
}
		 
?>
