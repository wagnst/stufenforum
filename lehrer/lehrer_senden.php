<?php
include('sessiontest.inc.php');
$posterID =$s_user_id;
$lehrerID =$_POST['lehrerid'];
$eintrag =$_POST['eintrag'];

if ($eintrag<>''){
	$eintrag=addslashes($eintrag);
  $eintrag = "INSERT INTO lehrer_eintraege_neu (LEHRER_ID, Poster_ID, eintragstext) VALUES ('$lehrerID', '$posterID','$eintrag')";
 mysql_query($eintrag);
  $aendern = "UPDATE lehrer_neu Set Eintraege=Eintraege+1 WHERE LEHRER_ID = '$lehrerID'";
  mysql_query($aendern); 
  $aendern = "UPDATE lehrer_neu Set letzter_Eintrag_Zeit=NOW() WHERE LEHRER_ID = '$lehrerID'";
  mysql_query($aendern); 
  }
  header("Location: ./framework.php?id=lehrer&aktion=anschauen&lehrerid=$lehrerID");
?>