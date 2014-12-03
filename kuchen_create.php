<?php
include('sessiontest.inc.php');
if($s_user_id!=0)
{
	$kuchenname = $_POST['kuchenname'];
	if ($kuchenname!='')
	{
		//kuchen eintragen
		$abfrage="INSERT INTO kuchen(kuchen_name) VALUES ('$kuchenname')";
		mysql_query($abfrage);
		
		//id vom eingetragenen kuchen holen
		$abfrage2="SELECT * FROM kuchen WHERE kuchen_name='$kuchenname'";
		$ergebnis2=mysql_query($abfrage2);
		$row2=mysql_fetch_object($ergebnis2);
		$kuchen_id=$row2->Kuchen_ID;
		  
		//schueler zum baecker machen
		$abfrage3="INSERT INTO kuchen_baecker(KuchenID,Schueler_ID) VALUES ('$kuchen_id','$s_user_id')";
		mysql_query($abfrage3);		
		
		//eintragung wurde gemacht
		$msg='Eintragung war erfolgreich.';
	}
	else
	{
		//eintragung fehlerhaft
		$msg='Es ist ein Fehler aufgetreten.<br /> Du hast nicht alle Felder ausgefüllt! Bitte nochmal absenden!';
	}
}
header('Location: ./framework.php?id=umfragen&kat=k1');
?>
