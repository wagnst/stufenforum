<?php
include('sessiontest.inc.php');
$tid=$_POST['tid'];
$page=$_POST['page'];
$beitrag=$_POST['beitrag'];
  $abfrage = "UPDATE foren_themen SET letzter_Beitrag_ID='$s_user_id', Anzahl_Beitraege=Anzahl_Beitraege+1 WHERE Themen_ID='$tid'";
  mysql_query($abfrage);
  $abfrage = "INSERT INTO foren_beitraege (Themen_ID, Poster_ID, Beitrag) VALUES ('$tid','$s_user_id','$beitrag')";
  mysql_query($abfrage);
  header("Location: ./framework.php?id=thema&tid=$tid&page=$page"); 
?>
