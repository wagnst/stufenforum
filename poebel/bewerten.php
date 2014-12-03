<?php
$schuelerID=$_GET['schuelerid'];
$posterID =$s_user_id;
$eintrags_ID =$_GET['e'];
if ($_GET['v']=='n')
  $stimme=-1;
else
  $stimme=1;  
  
$query2="SELECT stimme as summe FROM poebel_votes WHERE Eintrags_ID='$eintrags_ID' AND Voter_ID='$posterID'";
//echo $query2;
$result2=mysql_query($query2);
$gevotet=mysql_num_rows($result2);
if ($gevotet==0)
  {
  $eintrag = "INSERT INTO poebel_votes (Voter_ID, Eintrags_ID, stimme) VALUES ('$posterID', '$eintrags_ID','$stimme')";
  mysql_query($eintrag);
  }
else
  {
  $eintrag = "UPDATE poebel_votes SET stimme=$stimme WHERE Voter_ID='$posterID' AND Eintrags_ID='$eintrags_ID'";
  mysql_query($eintrag);
  }
$query2="SELECT SUM(stimme) as summe FROM poebel_votes WHERE Eintrags_ID='$eintrags_ID'";
$result2=mysql_query($query2);
$row2=mysql_fetch_object($result2);
$anzahl_stimmen=$row2->summe;
if ($anzahl_stimmen==NULL)
  $anzahl_stimmen=0;
  
$eintrag = "UPDATE poebel_eintraege_neu SET votes='$anzahl_stimmen' WHERE EintragsID='$eintrags_ID'";
mysql_query($eintrag);
header("Location: ./framework.php?id=poebel&aktion=anschauen&schuelerid=$schuelerID");
?>