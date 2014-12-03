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
	$fach_kurz = $_POST["fach_kurz"];
	$fach_lang = $_POST["fach_lang"];
	$lehrer = $_POST["lehrer"];

	$query = mysql_query( "SELECT fach_kurz, fach_lang FROM kurse WHERE fach_kurz LIKE '" . $fach_kurz . "' OR fach_lang LIKE '" . $fach_lang . "'", $sql );
	$menge = mysql_num_rows( $query );

	if ( $menge == 0 )
	{		
		if(empty($fehler)) 
		{ 
			// get full teacher name
			$abfrage="SELECT LEHRER_ID,Nachname FROM lehrer_neu WHERE LEHRER_ID = $lehrer ORDER BY Nachname";
			$ergebnis = mysql_query($abfrage);		
			$row = mysql_fetch_object($ergebnis);			
			$lehrer_name = $row->Nachname;
			
			$eintrag = "INSERT INTO `$sql_db`.`kurse` (
			  `fach_kurz` ,
			  `fach_lang` ,
			  `lehrer`
			   )
			   VALUES ('" . $fach_kurz . "', '" . $fach_lang . "', '" . $lehrer_name . "');";

			$eintragen = mysql_query( $eintrag, $sql );

			if ( $eintragen == true )
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
		header('Location: ./teams.php?showcourse=1&msg=fehler&errordesc=Das Fach existiert bereits');
	} 		
}
else
{
	header('Location: admin.php?berechtigung=0');
}
		 
?>