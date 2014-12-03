<?php
session_start();
require_once("mysql.inc.php");
require_once("functions.inc.php");

$user = $_POST["name"];
$pw = $_POST["password"];

if (!empty($user) AND !empty($pw))
{
		$query = "SELECT * FROM user WHERE (Name_ganz LIKE '$user' OR Name_kurz LIKE '$user' OR Email LIKE '$user') AND freigeschaltet='1' AND admin='1'";
		$ergebnis = mysql_query($query, $sql);
		if (mysql_num_rows($ergebnis)>0)
		{
			$row=mysql_fetch_object($ergebnis);
			if (md5($pw)==$row->Passwort)//Passwort-Prüfsumme vergleichen; wenn gültig zur indexseite
			{
				$_SESSION["user_id"]=$row->SCHUELER_ID;
				$_SESSION["user_name"]=$row->Name_ganz;
				$_SESSION["logged_in"]=TRUE;			
				/*$userpw = md5($user . md5($pw));
				setcookie("stufenadmin", $userpw, time() + 60*60*24*1); // 1 Tag
				setcookie("stufenuser", $user, time() + 60*60*24*1);*/
				Header("Location: ./admin.php");
			}
			else//ungültige login-kombi
			{
				Header("Location: ./login.php?msg=fehlgeschlagen");
			}
		}
		else//benutzername fehlerhaft
		{
			Header("Location: ./login.php?msg=fehlgeschlagen");
		}
}
else
{
	Header("Location: ./login.php?msg=ausfuellen");
}

?>