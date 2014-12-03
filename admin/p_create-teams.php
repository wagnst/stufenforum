<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
if (check_login("teams") == true)
{
	if(empty($_POST['name'])) {
		$fehler .= "<li>Der Teamname fehlt</li>";
	}
	include('mysql.inc.php');
	$team_id = (int)$_POST["id"];
	$name = $_POST["name"];

	$query = mysql_query( "SELECT TEAM_ID FROM teams WHERE TEAM_ID LIKE '" . $team_id . "'", $sql );
	$menge = mysql_num_rows( $query );

	if ( $menge == 0 )
	{
		if(empty($fehler)) 
		{ 
			$eintrag = "INSERT INTO `$sql_db`.`teams` (
			  `TEAM_ID` ,
			  `team_name`
			   )
			   VALUES ('" . $team_id . "', '" . $name . "');";

			$eintragen = mysql_query( $eintrag, $sql );

			if ( $eintragen == true )
			{
				header('Location: ./teams.php?show=1&msg=erfolg');
			}
			else
			{
				header('Location: ./teams.php?show=1&msg=fehler&errordesc=SQL Fehler');
			}
		}else
		{
			header('Location: ./teams.php?show=1&msg=fehler&errordesc='.$fehler.'');
		}

	}
	else
	{
		header('Location: ./teams.php?show=1&msg=fehler&errordesc=Schon vorhanden');
	}  	

}
else
{
	header('Location: admin.php?berechtigung=0');
}
		 
?>