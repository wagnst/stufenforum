<?php
$schuelerID = $_GET['schuelerid'];
$abfrage = "SELECT Name_ganz FROM user WHERE SCHUELER_ID=$schuelerID";
$ergebnis = mysql_query($abfrage);
$row = mysql_fetch_object($ergebnis);
$Name_ganz = $row->Name_ganz;
$abfrage = "SELECT anzahl_eintraege FROM poebel_eigenschaften WHERE SCHUELER_ID=$schuelerID";
$ergebnis = mysql_query($abfrage);
$row = mysql_fetch_object($ergebnis);
$eintraege = $row->anzahl_eintraege;
?>
<title><?php echo $main_site_title.$Name_ganz; ?></title>
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
$eintragsID = $_GET['eintragsid'];
$schuelerID = $_GET['schuelerid'];
$abfrage = "SELECT * FROM poebel_eintraege_neu WHERE EintragsID=$eintragsID";
$ergebnis = mysql_query($abfrage);
$row = mysql_fetch_object($ergebnis);
echo "<p>$row->eintragstext</p><br /><hr />";

echo $inhalt;
?>
<table class="edittable"><tr><th>Neuer Eintrag</th></tr><tr><td>

<form action="framework.php?id=poebel&aktion=untereintrag_senden" method="post">

<textarea name="eintrag" wrap="soft" style="width:100%; padding:0; margin:0;" rows="15">
</textarea>
</td></tr><tr style="background-color: #BBBBBB"><td>

<?php
	echo  '<input name="eintragsid" value="'.$eintragsID.'" type="hidden" />';
	echo '<input name="schuelerid" value="'.$schuelerID.'" type="hidden" />';
	echo '<input class="button" style="margin-bottom:10px;  margin-top:10px;" type="submit" value="Absenden"/></form>';
?>
</table>
</div>
