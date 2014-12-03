<?php
include('sessiontest.inc.php');
//eintragen der Nachricht in DB
$gid=$_POST['gid'];
$beitrag=$_POST['beitrag'];
  $abfrage = "INSERT INTO kontakt_nachrichten (Gruppen_ID,Poster_ID, Beitrag) VALUES ('$gid','$s_user_id','$beitrag')";
  mysql_query($abfrage);
  header("Location: ./framework.php?id=teamliste"); 
?>
