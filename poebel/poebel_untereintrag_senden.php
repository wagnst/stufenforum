<?php
include('sessiontest.inc.php');
$posterID =$s_user_id;
$schuelerID =$_POST['schuelerid'];
$eintragsID= $_POST['eintragsid'];
$eintrag =$_POST['eintrag'];
if ($eintrag!='')
  {
  $eintrag = "INSERT INTO poebel_eintraege_neu (schuelerID, posterID, eintragstext, untereintrag_zu) VALUES ('$schuelerID', '$posterID','$eintrag', '$eintragsID')";
  mysql_query($eintrag);
  $aendern = "UPDATE poebel_eigenschaften Set anzahl_eintraege=anzahl_eintraege+1 WHERE SCHUELER_ID = '$schuelerID'";
  mysql_query($aendern); 
  $aendern = "UPDATE poebel_eintraege_neu Set anzahl_untereintraege=anzahl_untereintraege+1 WHERE EintragsID = '$eintragsID'";
  mysql_query($aendern);
  }
header("Location: ./framework.php?id=poebel&aktion=anschauen&schuelerid=$schuelerID");
?>