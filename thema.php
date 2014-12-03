<?php
$tid=$_GET['tid'];
$abfrage = "SELECT * FROM foren_themen WHERE Themen_ID='$tid'";
$ergebnis = mysql_query($abfrage);
$row = mysql_fetch_object($ergebnis);
$gruppen_id=$row->Gruppen_ID;
$thema=$row->Thema;
$gid=substr($gruppen_id,1);
$typ=substr($gruppen_id,0,1);
if($typ=="k") //kurs
  {
  $abfrage = "SELECT * FROM kurse WHERE FACH_ID='$gid'";
  $ergebnis = mysql_query($abfrage);
  $row = mysql_fetch_object($ergebnis);
  $gruppenname=$row->fach_lang;
  $gruppe_kurz=$row->fach_kurz;
  
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
  }
?>

<title><?php echo $main_site_title.$thema; ?></title>
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
$abfrage = "SELECT * FROM foren_beitraege WHERE Themen_ID='$tid' ORDER BY Zeit ASC";
$ergebnis = mysql_query($abfrage);
$anzahl_beitraege = mysql_num_rows($ergebnis);
$anzahl_seiten=round(($anzahl_beitraege+4.5)/10);//anzahl seiten bestimmen
if (isset($_GET['page']))
  $page=$_GET['page'];
else
  $page=1;
  
$forumnav='<div style="text-align: center; font-size: 14px; color: #404040;margin-bottom: 10px;">';  
for($j=1;$j<=$anzahl_seiten;$j++)  
  {
	if($page <> $j)
		$forumnav.= '<a href="framework.php?id=thema&tid='.$tid.'&amp;page='.($j).'"> '.$j.' </a>';
	else
		$forumnav.= ' '.$j.' ';
	
  }
$forumnav.='</div>';


  
echo $forumnav;  
  
echo '<div class="profilkopf">'.$thema.'</div>';

//beiträge anzeigen
$abfrage = "SELECT * FROM foren_beitraege WHERE Themen_ID='$tid' ORDER BY Zeit ASC LIMIT ".($page*10-10).",10";
$ergebnis = mysql_query($abfrage);
while($row = mysql_fetch_object($ergebnis))
  {
  $abfrage2 = "SELECT Name_ganz FROM user WHERE SCHUELER_ID='$row->Poster_ID'";
  $ergebnis2 = mysql_query($abfrage2);
  $row2 = mysql_fetch_object($ergebnis2);
  if (file_exists("./images/profil_small/".$row->Poster_ID.".jpg"))
    {
    $profilbild='<a  href="framework.php?id=profil&schuelerid='.$row->Poster_ID.'"><div class="forumposterimage" style="background-image: url(./images/profil/'.$row->Poster_ID.'.jpg);" /></div></a>';
    }
  else
    {
    $profilbild='<a  href="framework.php?id=profil&schuelerid='.$row->Poster_ID.'"><div class="forumposterimage" style="background-image: url(./images/profil/default.jpg);" /></div></a>';
    }
  echo '<table class="altertable thematable"><tr>';
  echo '<td class="forumpostertab">'.$profilbild.'<br /><a class="nohl" href="framework.php?id=profil&schuelerid='.$row->Poster_ID.'">'.$row2->Name_ganz.'</a> <br />'.humanTime($row->Zeit)."</td>\n";
  echo '<td class="forum_beitrag">'.$row->Beitrag;
  echo '</td></tr>';
  
  $admin_controls = '';
  if ($is_admin) {
	  $admin_controls = '<div class="admin-controls">';
	  $admin_controls .= '<a href="thema_beitrag_delete.php?id=' . $row->Beitrags_ID . '">Beitrag löschen</a>';
	  $admin_controls .= '</div>'; 
  } 
  
  
  echo '</table>';
  }
?>
<br />
<?php
if ($page==$anzahl_seiten)
{
?>
<table class="edittable"><tr><th>Neuer Beitrag</th></tr><tr><td>

<form action="thema_absenden.php" method="post">

<textarea name="beitrag" wrap="soft" style="width:100%; padding:0; margin:0;" rows="15">
</textarea>
</td></tr><tr style="background-color: #BBBBBB"><td>

<?php
  echo '<input type="hidden" name="tid" value="'.$tid.'"/>';
  echo '<input type="hidden" name="page" value="'.$page.'"/>';
  echo '<input class="button" style="margin-bottom:10px;  margin-top:10px;" type="submit" value="Absenden"/></form>';
?>

</td></tr></table>
<?php
}
echo '<br>'.$forumnav;
?>
</div>
<?php
  }
else
  echo "Du darfst dieses Thema nicht anschauen.";
echo "</div>";
?>
