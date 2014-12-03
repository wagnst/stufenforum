<?php
$posterID =$s_user_id;
$schuelerID =$_GET['schuelerid'];
$eintragsID =$_GET['e'];

if ($s_user_id==$schuelerID)
  {
  if ($_GET['aufheben']=='aufheben')
    $aendern = "UPDATE poebel_eintraege_neu Set SCHUTZ=0 WHERE EintragsID = '$eintragsID'";
  else	
    $aendern = "UPDATE poebel_eintraege_neu Set SCHUTZ=1 WHERE EintragsID = '$eintragsID'";
  mysql_query($aendern); 
  }
  header("Location: ./framework.php?id=poebel&aktion=anschauen&schuelerid=$schuelerID");
?>