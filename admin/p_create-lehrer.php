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
	$anrede = $_POST["anrede"];
	$vorname = $_POST["vorname"];
	$nachname = $_POST["nachname"];
	$geschlecht = $_POST["geschlecht"];
	
	include('mysql.inc.php');

	if(empty($fehler)) 
	{ 
		$eintrag = "INSERT INTO `$sql_db`.`lehrer_neu` (
		  `Anrede` ,
		  `Vorname` ,
		  `Nachname` ,
		  `Geschlecht`
		   )
		   VALUES ('" . $anrede . "', '" . $vorname . "', '" . $nachname . "', '" . $geschlecht . "');";

		$eintragen = mysql_query( $eintrag, $sql );

		if ( $eintragen == true )
		{
			header('Location: ./lehrer.php?showteacher=1&msg=erfolg');
		}
		else
		{
			header('Location: ./lehrer.php?showteacher=1&msg=fehler');
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