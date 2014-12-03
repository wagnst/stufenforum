<?php
include('sessiontest.inc.php');
if($s_user_id!=0)
{
$abfrage="INSERT INTO kuchen_baecker(KuchenID,Schueler_ID) VALUES('".$_GET['id']."','$s_user_id')";
mysql_query($abfrage);
header('Location: ./framework.php?id=umfragen&kat=k1');
}
else
{
echo "Es ist ein Fehler aufgetreten. Bitte melde dich nochmal an. Damit die Seite richtig funktioniert müssen Cookies aktiviert sein.<br/>Getestet mit Firefox 2+; Internet Explorer 7+; Opera 10";
}
?>