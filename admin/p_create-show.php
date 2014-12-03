<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
if (check_login("show") == true)
{
	include('mysql.inc.php');
       
	   if(empty($_POST['first'])) {
              $fehler .= "<li>Der Vorname fehlt!</li>";
       }
       if(empty($_POST['last'])) {
              $fehler .= "<li>Der Nachname fehlt!</li>";
       }
       if(empty($_POST['mail'])) {
              $fehler .= "<li>Die Mailadresse fehlt!</li>";
       } elseif (preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/",$_POST['mail'])==0) {
			  $fehler .= "<li>Die Mailadresse ist nicht gültig!</li>";
	   }
       if(empty($_POST['pwd'])) {
              $fehler .= "<li>Das Passwort fehlt!</li>";             
       }elseif(strlen($_POST['pwd'])<6) {
			  $fehler .= "<li>Das Passwort ist zu kurz!</li>";
       }elseif($_POST['pwd'] != $_POST['pwd2']){
              $fehler .= "<li>Passwörter stimmen nicht überein!</li>";
      
       }
    $name = mysql_real_escape_string($_POST['first'])." ".mysql_real_escape_string($_POST['last']);
    $sql = "SELECT *
          FROM user
          WHERE Name_ganz = '$name'
          LIMIT 1";
		  
    $result = mysql_query($sql) OR die(mysql_error());
    if ( mysql_num_rows($result) == 0 ) {
               echo "";
    } else {
       $fehler .= "<li>Der Benutzername ist schon vergeben!</li>";
    }
	
    if(empty($fehler)) 
	{
		$query = "INSERT INTO user SET
			Vorname = '".mysql_real_escape_string($_POST['first'])."',
			Nachname = '".mysql_real_escape_string($_POST['last'])."',
			Name_ganz = '".mysql_real_escape_string($_POST['first']." ".$_POST['last'])."', 
			Name_kurz = '".mysql_real_escape_string(strtolower(substr($_POST['first'], 0, 1).$_POST['last']))."',
			EMail = '".mysql_real_escape_string($_POST['mail'])."',
			Passwort = md5('".mysql_real_escape_string($_POST['pwd'])."')";
		$sql = mysql_query($query) or die(mysql_error());
		$lastId = mysql_insert_id();
		$query = "INSERT INTO poebel_eigenschaften SET SCHUELER_ID='$lastId'";
	
		$eintragen = mysql_query($query);
		if ( $eintragen == true )
		{
			header('Location: ./show.php?msg=erfolg');
		}
		else
		{
			header('Location: ./show.php?&msg=fehler&errordesc='.$fehler.'');
		}  	
	}
	else header('Location: ./show.php?&msg=fehler&errordesc='.$fehler.'');
}
else
{
	header('Location: admin.php?berechtigung=0');
}
		 
?>