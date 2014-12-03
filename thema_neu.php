<?php
$gid=$_GET['gid'];
$typ=$_GET['typ'];
if(!isset ($_GET['typ']))
  {
  $typ='g';
  }
if($typ=="k") //kurs
  {
  $abfrage = "SELECT * FROM kurse WHERE FACH_ID='$gid'";
  $ergebnis = mysql_query($abfrage);
  $row = mysql_fetch_object($ergebnis);
  $gruppenname=$row->fach_lang;
  $gruppe_kurz=$row->fach_kurz;
  echo '<div class="profilkopf">Neues Thema in '.$gruppenname.'</div>';
  $abfrage = "SELECT SCHUELER_ID FROM user WHERE Kurse LIKE '%$gruppe_kurz%' AND SCHUELER_ID='$s_user_id' ORDER BY Nachname";
  $ergebnis = mysql_query($abfrage);
  $anzahl = mysql_num_rows($ergebnis);
  if ($anzahl==1)
    {
	$mitglied=TRUE;
	}
  else	
    {
	$mitglied=FALSE;
	}
  }
elseif($typ=="o") //Orgateam
  {
  $abfrage = "SELECT * FROM teams WHERE TEAM_ID='$gid'";
  $ergebnis = mysql_query($abfrage);
  $row = mysql_fetch_object($ergebnis);
  $gruppenname=$row->team_name;
  echo '<div class="profilkopf">Neues Thema in '.$gruppenname.'</div>';
  $abfrage = "SELECT SCHUELER_ID FROM user WHERE Teams LIKE '%$gruppenname%' AND SCHUELER_ID='$s_user_id' ORDER BY Nachname";
  $ergebnis = mysql_query($abfrage);
  $anzahl = mysql_num_rows($ergebnis);
  if ($anzahl==1)
    {
	$mitglied=TRUE;
	}
  else	
    {
	$mitglied=FALSE;
	}
  }
elseif($typ=='a')
  {
  $mitglied=true;
	if ($gid=='1'){
		echo '<div class="profilkopf">Neues Thema in Klatsch und Tratsch</div>';
	}
	else if ($gid=='0'){
		echo '<div class="profilkopf">Neues Thema in Schule/Organisation</div>';
	}
  }
?>
<title><?php echo $main_site_title; ?>Neues Thema erstellen</title>
<script language="javascript" type="text/javascript" src="./tinymce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">

tinyMCE.init({
	mode : "textareas",
	language: "de",
	theme : "advanced",
	plugins : "emotions,media",
	theme_advanced_buttons1 :"bold,italic,underline,strikethrough,|,sub,sup,|,blockquote",
	theme_advanced_buttons2 :"charmap,emotions,image,media,|,cleanup,help",
	theme_advanced_buttons3 :"",
	verify_html : true
});
</script>

<?php

if ($mitglied==TRUE)
  {
?>
<form action="thema_neu_absenden.php" method="post">

<table class="edittable">
<tr><th>Thema</th></tr>

<tr><td style="padding:10px !important; background-color: #D6D6D6"><input name="thema" style="width:893px" type="text"/></td></tr>
<tr><th>Beitrag</th></tr>
<tr><td><textarea name="beitrag" wrap="soft" style="width:100%; padding:0px;" rows="20"></textarea></td></tr>
<tr style="background-color:#BBBBBB"><td>
<?php
  echo '<input type="hidden" name="gid" value="'.$gid.'"/>';
  echo '<input type="hidden" name="typ" value="'.$typ.'"/>';
  echo '<input class="button" style="margin:10px auto" type="submit" value="Thema erstellen"/></td></tr></table></form>';
  }	
else
  {
  echo "Du bist nicht in dieser Gruppe";
  }
?>
</div>