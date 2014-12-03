<?php
include('sessiontest.inc.php');
$lehrerID = $_GET['lehrerid'];
$abfrage = "SELECT * FROM lehrer_neu WHERE LEHRER_ID=$lehrerID";
$ergebnis = mysql_query($abfrage);
$row = mysql_fetch_object($ergebnis);
$name = $row->Nachname;
$eintraege = $row->Eintraege;
echo '<title>'.$main_site_title.$name.'</title>';
?>
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
echo '<div class="profilkopf">'.$name.'</div>';

if ($eintraege == 0){
  $inhalt = 'Keine Eintr&auml;ge';
  $inhalt .= " \n <br />\n <hr />";

}
else {
 /* if ($hl!='hl')
    {
	$inhalt .= "<a href=\"poebel.php?aktion=anschauen&schuelerid=$schuelerID&hl=hl\">eigenen Beitr&auml;gen Bearbeitungs-Funktion hinzuf&uuml;gen</a>";
	}*/
  $abfrage = "SELECT * FROM lehrer_eintraege_neu WHERE LEHRER_ID=$lehrerID";
  $ergebnis = mysql_query($abfrage);

  while($row = mysql_fetch_object($ergebnis))
    {
		$lastposttime=humanTime($row->Zeit);
	  $inhalt .= '<div class="poebel_eintrag"><div class="poebel_kopf">';
		$abfrage2 = "SELECT * FROM user WHERE SCHUELER_ID=$row->Poster_ID";
		$ergebnis2 = mysql_query($abfrage2);
		$row2 = mysql_fetch_object($ergebnis2);
		$inhalt.= "  eingetragen von $row2->Name_ganz";
	  $inhalt .= "   $lastposttime </div>";
      $inhalt .= '<div class="poebel_inhalt">';
	  $inhalt.= $row->eintragstext.'</div></div>';
      /* if (($hl=='hl') and ($user_id==$row->PosterID))
        {
	    $inhalt .= "<a href=\"poebel.php?aktion=bearbeiten&eintragsid=$row->EintragsID&schuelerid=$schuelerID\"><font color=\"#FF0000\">[bearbeiten]</font></a>";
	    }*/

      
	  $inhalt .= "<hr />";
    }
}

echo $inhalt;
?>
<table class="edittable"><tr><th>Neuer Eintrag</th></tr><tr><td>

<form action="lehrer.php?aktion=senden" method="post">

<textarea name="eintrag" wrap="soft" style="width:100%; padding:0; margin:0;" rows="15">
</textarea>
</td></tr><tr style="background-color: #BBBBBB"><td>

<?php
  echo '<input type="hidden" name="lehrerid" value="'.$lehrerID.'"/>';
  echo '<input class="button" style="margin-bottom:10px;  margin-top:10px;" type="submit" value="Absenden"/></form>';
?>

</td></tr></table>
</div>
