<?php
include('sessiontest.inc.php');
$gid=$_POST['gid'];
$typ=$_POST['typ'];
$thema=$_POST['thema'];
$beitrag=$_POST['beitrag'];
if($typ=="k") //kurs
  {
  $abfrage = "SELECT * FROM kurse WHERE FACH_ID='$gid'";
  $ergebnis = mysql_query($abfrage);
  $row = mysql_fetch_object($ergebnis);
  $gruppenname=$row->fach_lang;
  $gruppe_kurz=$row->fach_kurz;
  //prüfen ob mitglied
  $abfrage = "SELECT SCHUELER_ID FROM user WHERE Kurse LIKE '%$gruppe_kurz%' AND SCHUELER_ID='$s_user_id' ORDER BY Nachname";
  $ergebnis = mysql_query($abfrage);
  $anzahl = mysql_num_rows($ergebnis);
  if ($anzahl==1)
    {
	$mitglied=TRUE;
	}
  else	
    {
	$mitglied=FALSE;
	}
  }
elseif($typ=="o") //Orgateam
  {
  $abfrage = "SELECT * FROM teams WHERE TEAM_ID='$gid'";
  $ergebnis = mysql_query($abfrage);
  $row = mysql_fetch_object($ergebnis);
  $gruppenname=$row->team_name;
  //Mitgliedstest
  $abfrage = "SELECT SCHUELER_ID FROM user WHERE Teams LIKE '%$gruppenname%' AND SCHUELER_ID='$s_user_id' ORDER BY Nachname";
  $ergebnis = mysql_query($abfrage);
  $anzahl = mysql_num_rows($ergebnis);
  if ($anzahl==1)
    {
	$mitglied=TRUE;
	}
  else	
    {
	$mitglied=FALSE;
	}
  }
elseif($typ=='a')//allgemeines Forum-->jeder ist mitglied
  {
  $mitglied=true;
  }
  
  
  
if ($mitglied==TRUE)
  {
  //in DB eintragen + zur entsprechenden Seite weiterleiten
  $abfrage = "INSERT INTO foren_themen (Gruppen_ID, Thema, Startzeitpunkt, letzter_Beitrag_ID, Anzahl_Beitraege) VALUES ('$typ$gid','$thema', CURRENT_TIMESTAMP, '$s_user_id', '1')";
  mysql_query($abfrage);
  $themen_id = mysql_insert_id();
  $abfrage = "INSERT INTO foren_beitraege (Themen_ID, Poster_ID, Beitrag) VALUES ('$themen_id','$s_user_id','$beitrag')";
  mysql_query($abfrage);
  }
  if ($typ=='a')
    header("Location: ./framework.php?id=forum"); 
  else
  header("Location: ./framework.php?id=gruppe&typ=$typ&gid=$gid"); 

?>
