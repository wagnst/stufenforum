<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
if (check_login("teams") == true)
{
	if(empty($_POST['fach_kurz'])) {
		$fehler .= "<li>Der kurze Fachname fehlt</li>";
	}
	if(empty($_POST['fach_lang'])) {
		$fehler .= "<li>Der lange Fachname fehlt</li>";
	}
	if(empty($_POST['lehrer'])) {
		$fehler .= "<li>Der Lehrer fehlt</li>";
	}	
	include('mysql.inc.php');
	$course_id = (int)$_POST["id"];
	$fach_kurz = $_POST["fach_kurz"];
	$fach_lang = $_POST["fach_lang"];
	$lehrer = $_POST["lehrer"];
	
	if(empty($fehler)) 
	{ 
		$abfrage = "UPDATE `kurse` SET `fach_kurz` = '".$fach_kurz."', `fach_lang` = '".$fach_lang."', `lehrer` = '".$lehrer."' WHERE `FACH_ID` =".$course_id." LIMIT 1 ;";
		if (mysql_query($abfrage, $sql) == true)
		{
			header('Location: ./teams.php?showcourse=1&msg=erfolg');
		}
		else
		{
			header('Location: ./teams.php?showcourse=1&msg=fehler&errordesc=SQL Fehler');
		}  	
	}else
	{
		header('Location: ./teams.php?showcourse=1&msg=fehler&errordesc='.$fehler.'');
	}	
}			
else
{
	header('Location: admin.php?berechtigung=0');
}
		 
?>
