<?php
include('sessiontest.inc.php');
$posterID =$s_user_id;
$schuelerID =$_POST['schuelerid'];
$eintrag =$_POST['eintrag'];

if ($eintrag<>''){
	$eintragstext = $eintrag;
	$eintrag = "INSERT INTO poebel_eintraege_neu (schuelerID, posterID, eintragstext, freigeschaltet) VALUES ('$schuelerID', '$posterID','$eintrag',1)";
 
	mysql_query($eintrag);
	$aendern = "UPDATE poebel_eigenschaften Set anzahl_eintraege=anzahl_eintraege+1 WHERE SCHUELER_ID = '$schuelerID'";
	mysql_query($aendern); 
	
	//mail versenden
	$abfrage = "SELECT Name_ganz FROM user WHERE SCHUELER_ID='$schuelerID'";
	$ergebnis = mysql_query($abfrage);
	$row = mysql_fetch_object($ergebnis);
	$schueler = $row->Name_ganz;	
	
	$nachricht = '
		<p>Hallo '.$schueler.'!</p>
		<p>Du hast einen neuen Pöbelbucheintrag im Stufenforum erhalten.</b></br>Sollte der Kommentar anstößig sein, oder du möchtest nicht, dass er in der Abizeitung erscheint, dann melde diesen Eintrag einfach.</br></br>Folgender Eintrag wurde gemacht:</p><b>'.$eintragstext.'</b>
		<p>Liebe Grüße, </br>Stufenforum Mailserver</p>';
		
    $header  = "MIME-Version: 1.0\r\n"; 
	$header .= "Content-type: text/html; charset=utf-8\r\n"; 
	$header .= "From: $admin_mail\r\n";
	$header .= "X-Mailer: PHP ". phpversion();  
	$subject = "Neuer Pöbelbucheintrag | Stufenforum";
	
	/*mail Adresse des Betroffenen holen*/
	$abfrage3 = "SELECT EMail FROM user WHERE SCHUELER_ID='$schuelerID'";
	$ergebnis3 = mysql_query($abfrage3);
	$row3 = mysql_fetch_object($ergebnis3);
	$mailaddress = $row3->EMail;
	//mail senden
	@mail($mailaddress, $subject, $nachricht, $header); 	
}
  header("Location: ./framework.php?id=poebel&aktion=anschauen&schuelerid=$schuelerID");
?>
