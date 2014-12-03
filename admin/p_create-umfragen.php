<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
if (check_login("umfragen") == true)
{
	include('mysql.inc.php');
	
	if(empty($_POST['typ'])) {
		$fehler .= "<li>Der Umfragetyp fehlt</li>";
	}
	if(empty($_POST['text'])) {
		$fehler .= "<li>Der Fragetext fehlt</li>";
	}
	if(empty($_POST['max_stimmen'])) {
		$fehler .= "<li>Maximale Stimmen fehlen</li>";
	}
	if(empty($_POST['antworten'])) {
		$fehler .= "<li>Antwortmöglichkeiten fehlen</li>";             
	}
		
	if(empty($fehler)) 
	{ 
			$umfrage_id = (int)$_POST["id"];
			$typ = mysql_real_escape_string($_POST["typ"]);
			$text = mysql_real_escape_string($_POST["text"]);
			$max_stimmen = mysql_real_escape_string($_POST["max_stimmen"]);
			$antworten = mysql_real_escape_string($_POST["antworten"]);
		
			$query = mysql_query( "SELECT Umfrage_ID FROM umfragen WHERE Umfrage_ID LIKE '" . $umfrage_id . "'", $sql );
			$menge = mysql_num_rows( $query );

			if ( $menge == 0 )
			{
					$eintrag = "INSERT INTO `$sql_db`.`umfragen` (
						`Typ` ,
						`Text` ,
						`max_stimmen` ,
						`Antworten`
						)
						VALUES ('" . $typ . "', '" . $text . "', '" . $max_stimmen . "', '" . $antworten . "');";

					$eintragen = mysql_query( $eintrag, $sql );

					if ( $eintragen == true )
					{
						header('Location: ./umfragen.php?manage=1&msg=erfolg');
					}
					else
					{
						header('Location: ./umfragen.php?manage=1&msg=fehler&errordesc=Aktion war nicht erfolgreich');
					}
			}

			else
			{
				echo mysql_error();			
				header('Location: ./umfragen.php?manage=1&msg=fehler&errordesc=Die Umfrage existiert schon');
			}  
	}
	else header('Location: ./umfragen.php?manage=1&msg=fehler&errordesc='.$fehler.'');			

}
else
{
	header('Location: admin.php?berechtigung=0');
}
		 
?>