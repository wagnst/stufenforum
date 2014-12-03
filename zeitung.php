<?php
include('sessiontest.inc.php');
if($s_user_id!=0)
{
$abfrage="INSERT INTO zeitung(Schreiber_ID,Artikel) VALUES('$s_user_id','".$_GET['id']."')";
mysql_query($abfrage);
header('Location: ./framework.php?id=umfragen&kat=z1');
}
else
{
echo "Es ist ein Fehler aufgetreten. Bitte melde dich nochmal an. Damit die Seite richtig funktioniert müssen Cookies aktiviert sein.<br/>Getestet mit Firefox 2+; Internet Explorer 7+; Opera 10";
}
?>