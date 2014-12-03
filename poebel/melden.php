<?php
$fehler = "";
if (!empty($_GET['msg'])) {
	if ($_GET['msg'] == "erfolg") 
	{ 
		$msg = 'Die Meldung wurde erfolgreich übermittelt und wird durch einen Admin geprüft. Bitte habe etwas Geduld!'; 
	}elseif($_GET['msg'] == "fehler")
	{ 
		$msg = 'Du musst die Meldung Begründen! Eine Meldung ist sonst nicht möglich!</br><a href="javascript:history.back()">Zurück</a>';
	}
}else{
$schuelerID = $s_user_id;
$eintragsID = $_GET['eintragsid'];

$abfrage = "SELECT SchuelerID FROM poebel_eintraege_neu WHERE EintragsID=$eintragsID";
$ergebnis = mysql_query($abfrage) OR die(mysql_error());
$row = mysql_fetch_object($ergebnis);
if ($row->SchuelerID!=$schuelerID)
	header('Location: ./framework.php?id=index');

$abfrage = "SELECT Name_ganz FROM user WHERE SCHUELER_ID=$schuelerID";
$ergebnis = mysql_query($abfrage) OR die(mysql_error());
$row = mysql_fetch_object($ergebnis);
$Name_ganz = $row->Name_ganz;

$abfrage = "SELECT anzahl_eintraege FROM poebel_eigenschaften WHERE SCHUELER_ID=$schuelerID";
$ergebnis = mysql_query($abfrage) OR die(mysql_error());
$row = mysql_fetch_object($ergebnis);
$eintraege = $row->anzahl_eintraege;

$abfrage = "SELECT Status FROM poebel_beschwerden WHERE Poebel_ID=$eintragsID";
$ergebnis = mysql_query($abfrage) OR die(mysql_error());
//$row = mysql_fetch_object($ergebnis);
//$status = $row->Status;

if ( mysql_num_rows($ergebnis) == 0 ) 
{
   echo "";
} else 
{
	$row = mysql_fetch_object($ergebnis);
	$status = $row->Status;
	if ($status == 1)
	{
	$fehler = "Beschwerde wurde schon eingereicht! Bitte etwas Geduld haben, bis der Eintrag geprüft wurde.";
	}elseif ($status == 2)  
	{
	$fehler = "Beschwerde wurde schon vom Admin abgelehnt!";
	}elseif ($status == 3)  
	{
	$fehler = "Pöbeleintrag wurde schon gelöscht!"; //nie erreichbar...
	}
}
}

?>
<title><?php echo $main_site_title; ?>Eintrag melden</title>
<script language="javascript" type="text/javascript" src="./tinymce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	language: "de",
	theme : "advanced",
	plugins : "emotions",
	theme_advanced_buttons1 :"bold,italic,underline,strikethrough,|,sub,sup,|,charmap,emotions,|,cleanup,help",
	theme_advanced_buttons2 :"",
	theme_advanced_buttons3 :""
});
</script>

<?php
if(empty($fehler)) //wenn fehler leer
{
  $eintragsID = $_GET['eintragsid'];
  $schuelerID = $_GET['schuelerid'];
  $abfrage = "SELECT * FROM poebel_eintraege_neu WHERE EintragsID=$eintragsID";
  $ergebnis = mysql_query($abfrage);
  $row = mysql_fetch_object($ergebnis);
  echo "<div class='profilkopf'>Pöbelbucheintrag melden</div><p style='color: #6A0000'><br><b>Du möchtest diesen Eintrag melden:</b></p><div class='suchergebnis' style='margin:0px!important'><p>$row->eintragstext</p></div><br /><br>";
  $inhalt .='<form action="framework.php?id=poebel&aktion=melden_senden" method="post">';
  $inhalt .='<table class="edittable"><tr><th>Begründung</th></tr><tr><td><input name="eintragsid" value="'.$eintragsID.'" type="hidden" />';
  $inhalt .='<input name="schuelerid" value="'.$s_user_id.'" type="hidden" />';
  $inhalt .='<textarea name="kommentar" rows="15" style="width:100%"></textarea></td></tr><tr style="background-color:#BBBBBB"><td><input class="button" style="margin: 10px auto" type="submit" value="Absenden" /></td></tr></table></form>';
  echo $inhalt;
}else //Fehler anzeigen
{
  echo "<p><b>Fehler: </b>$fehler</p><br /><hr />";
  exit;
}

?>
</div>
