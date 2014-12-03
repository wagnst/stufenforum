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
  
 	if(empty($fehler)) 
		{ 
			$abfrage = "UPDATE `teams` SET `team_name` = '".$name."' WHERE `TEAM_ID` =".$team_id." LIMIT 1 ;";
			if (mysql_query($abfrage, $sql) == true)
			{
				header('Location: ./teams.php?show=1&msg=erfolg');
			}
			else
			{
				header('Location: ./teams.php?show=1&msg=fehler');
			}  	
		}else
		{
			header('Location: ./teams.php?show=1&msg=fehler');
		}
}
else
{
	header('Location: admin.php?berechtigung=0');
}
		 
?>
