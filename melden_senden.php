<?php
$posterID =$s_user_id;
$schuelerID =$_POST['schuelerid'];
$eintragsID= $_POST['eintragsid'];
$kommentar =$_POST['kommentar'];
if ($kommentar!='')
  {
  $eintrag = "INSERT INTO poebel_beschwerden (Poebel_ID, Schueler_ID, Kommentar, Status) VALUES ('$eintragsID', '$schuelerID','$kommentar', 1)";
  mysql_query($eintrag) OR die(mysql_error());
  
  $abfrage = "SELECT Name_ganz FROM user WHERE SCHUELER_ID='$schuelerID'";
  $ergebnis = mysql_query($abfrage);
  $row = mysql_fetch_object($ergebnis);
  $schueler = $row->Name_ganz;
  
  $nachricht = "$schueler hat sich ueber Poebeleintrag $eintragsID beschwert.\r\n\r\nZum Admininterface: http://ohg2013.de/admin/poebel.php";
	$header = 'From: admin@ohg2013.de' . "\r\n" .
	 'Reply-To: admin@ohg2013.de' . "\r\n" .
	 'X-Mailer: PHP/' . phpversion();
	 
  mail('admin@ohg2013.de', 'Poebel Beschwerde', $nachricht, $header); 
  mail('ashvin@gmx.de', 'Poebel Beschwerde', $nachricht, $header);
  header("Location: framework.php?id=poebel&aktion=beschwerde_erfolg");
  }
else
{
header("Location: framework.php?id=poebel&aktion=beschwerde_fehler");
}
?>