<?php
include('sessiontest.inc.php');
$motto=addslashes($_POST['motto']);
$anzahl=count($motto);
if(($anzahl<=2)and($anzahl>0))
  {
  //echo $s_user_id."<br/>";
  mysql_query("DELETE FROM mottoergebnisse2 WHERE Voter_ID='$s_user_id'");
 // echo "DELETE FROM mottoergebnisse WHERE Voter_ID='$s_user_id'"."<br>";
  if ($anzahl==2)
    mysql_query("INSERT INTO mottoergebnisse2 (Voter_ID, Motto1, Motto2) VALUES ('$s_user_id','".$motto[0]."','".$motto[1]."')");
  if ($anzahl==1)
    mysql_query("INSERT INTO mottoergebnisse2 (Voter_ID, Motto1, Motto2) VALUES ('$s_user_id','".$motto[0]."','".$motto[0]."')");	
 // echo "INSERT INTO mottoergebnisse (Voter_ID, Motto1, Motto2,Motto3) VALUES ('$s_user_id','".$motto[0]."','".$motto[1]."','".$motto[2]."')";
  }
header('Location: ./framework.php?id=umfragen&kat=m1');
?>