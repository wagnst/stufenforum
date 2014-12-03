<?php
$freischalten = $_GET['ok'];
$p_id = $_GET['p_id'];
$query;
if ($freischalten == 0) // nicht freischalten, löschen
	$query = "UPDATE poebel_eintraege_neu SET DELETED = 1 WHERE EintragsID = ".$p_id.";";
else
	$query = "UPDATE poebel_eintraege_neu SET freigeschaltet = 1 WHERE EintragsID = ".$p_id.";";
mysql_query($query); 
header('Location:../framework.php?id=poebel&aktion=anschauen&schuelerid='.$s_user_id);
?>
	