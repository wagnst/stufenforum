<?php
include('sessiontest.inc.php');
if($s_user_id!=0)
{
$zungentext = $_POST['zungentext'];
$betroffener = $_POST['betroffener'];
$seite = $_POST['seite'];
}
if (($seite!='l') or ($seite!='s'))
{
	if (($zungentext!='') and ($betroffener!=''))
	{
		$abfrage="INSERT INTO zungen_eintraege (PosterID, Betroffener, zungentext, typ) VALUES ('$s_user_id','$betroffener','$zungentext','$seite')";
		mysql_query($abfrage);
		
		//eintragung wurde gemacht
		$msg='Eintragung war erfolgreich.';
	}
	else
	{
		//eintragung fehlerhaft
		$msg='Es ist ein Fehler aufgetreten.<br /> Du hast nicht alle Felder ausgefüllt! Bitte nochmal absenden!';
	}
	header('Location: ./framework.php?id=zungen&kat='.$seite.'&msg='.$msg.'');
}
else
{
	header('Location: ./framework.php?id=zungen');
}
?>