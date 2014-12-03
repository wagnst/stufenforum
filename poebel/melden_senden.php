<?php
include('sessiontest.inc.php');
$posterID =$s_user_id;
$schuelerID =$_POST['schuelerid'];
$eintragsID= $_POST['eintragsid'];
$kommentar =$_POST['kommentar'];

//get eintragstext
$abfrage = "SELECT * FROM poebel_eintraege_neu WHERE EintragsID=$eintragsID";
$ergebnis = mysql_query($abfrage);
$row = mysql_fetch_object($ergebnis);
$poebeleintrag =$row->eintragstext;

if ($kommentar!='')
  {
  //$eintrag = "INSERT INTO poebel_beschwerden (Poebel_ID, Schueler_ID, Kommentar, Status) VALUES ('$eintragsID', '$schuelerID','$kommentar', 1)";
	$eintrag = "INSERT INTO `poebel_beschwerden` (
	  `Poebel_ID` ,
	  `Schueler_ID`,
	  `Kommentar`,
	  `Status`
	   )
	   VALUES ('" . $eintragsID . "', '" . $schuelerID . "', '" . $kommentar . "', '1');";
	mysql_query($eintrag) OR die(mysql_error());

	$abfrage = "SELECT Name_ganz FROM user WHERE SCHUELER_ID='$schuelerID'";
	$ergebnis = mysql_query($abfrage);
	$row = mysql_fetch_object($ergebnis);
	$schueler = $row->Name_ganz;

	$nachricht = '
		<p>Hallo Admin!</p>
		<p>'.$schueler.' hat sich über folgenden Eintrag beschwert: </br></br><b>'.$poebeleintrag.'</b></br>Bitte schnellstmöglich überprüfen!</br></br>Folgender Kommentar wurde angegeben:</p><b>'.$kommentar.'</b>
		<p>Liebe Grüße, </br>Stufenforum Mailserver</p>';
		
    $header  = "MIME-Version: 1.0\r\n"; 
	$header .= "Content-type: text/html; charset=utf-8\r\n"; 
	$header .= "From: $admin_mail\r\n";
	$header .= "X-Mailer: PHP ". phpversion();  
	$subject = "Neue Pöbelbeschwerde";
	
	/*Admins holen*/
	$abfrage2 = "SELECT SchuelerID FROM admin WHERE poebel=1";
	$ergebnis2 = mysql_query($abfrage2);
	while ($row2 = mysql_fetch_object($ergebnis2)) 
	{     
		$admin_id = $row2->SchuelerID;
		//get adminmails
		$abfrage3 = "SELECT EMail FROM user WHERE SCHUELER_ID='$admin_id'";
		$ergebnis3 = mysql_query($abfrage3);
		$row3 = mysql_fetch_object($ergebnis3);
		$mailaddress = $row3->EMail;
		//mail senden
		@mail($mailaddress, $subject, $nachricht, $header); 
		//$bla .= "$mailaddress"; 
	}	
	//@mail($admin_mail, $subject, $nachricht, $header); 
	//echo $bla;
	header("Location:framework.php?id=poebel&aktion=beschwerde_erfolg");
	}
else
{
header("Location:framework.php?id=poebel&aktion=beschwerde_fehler");
}
?>