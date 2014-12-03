<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
if (check_login("kalender") == true)
{
		function date_german2mysql($date) {
			$d    =    explode(".",$date);
			return    sprintf("%04d-%02d-%02d", $d[2], $d[1], $d[0]);
		}//irgendwo im netz geklaut....
		
		include('mysql.inc.php');
		
		if(empty($_POST['id'])) {
			$fehler .= "<li>Die ID fehlt</li>";
		}
		if(empty($_POST['topic'])) {
			$fehler .= "<li>Der Titel fehlt!</li>";
		}
		if(empty($_POST['text'])) {
			$fehler .= "<li>Die Beschreibung fehlt</li>";
		}
		if(empty($_POST['date'])) {
			$fehler .= "<li>Das Datum fehlt</li>";
		}		

		if(empty($fehler)) 
		{ 
				$date_id = (int)$_POST["id"];
				$topic = mysql_real_escape_string($_POST["topic"]);
				$text = mysql_real_escape_string($_POST["text"]);
				$betrifft = mysql_real_escape_string($_POST["betrifft"]);
				$date = mysql_real_escape_string(date_german2mysql($_POST["date"]));	
			
				$eintrag = "UPDATE `kalender` SET `Titel` =  '".$topic."',`Beschreibung` = '".$text."',`Datum` = '".$date."',`Betrifft` = '".$betrifft."' WHERE `kalender`.`Termin_ID` =".$date_id." LIMIT 1 ;";
				$eintragen = mysql_query( $eintrag, $sql );
				if ( $eintragen == true )
				{
					header('Location: ./kalender.php?aktion=anzeigen&msg=erfolg');
				}
				else
				{
					header('Location: ./kalender.php?aktion=anzeigen&msg=fehler&errordesc=Aktion war nicht erfolgreich!');
				} 
		}
		else header('Location: ./kalender.php?aktion=anzeigen&msg=fehler&errordesc='.$fehler.'');			

	}
	else
	{
		header('Location: admin.php?berechtigung=0');
	}
?>		
