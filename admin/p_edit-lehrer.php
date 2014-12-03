<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
if (check_login("lehrer") == true)
{
		include('mysql.inc.php');
		$entry_id = (int)$_POST["id"];
		$text = $_POST["text"];
      
		$abfrage = "UPDATE `lehrer_eintraege_neu` SET `eintragstext` = '".$text."' WHERE `Eintrags_ID` =".$entry_id." LIMIT 1 ;";
		if (mysql_query($abfrage, $sql) == true)
		{
			header('Location: ./lehrer.php?show=1&msg=erfolg');  
		}
		else
		{
			header('Location: ./lehrer.php?show=1&msg=fehler');
		}  	

}
else
{
	header('Location: admin.php?berechtigung=0');
}
		 
?>
