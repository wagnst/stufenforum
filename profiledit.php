<title><?php echo $main_site_title; ?>Profil bearbeiten</title>
<div class="profilkopf">Profil bearbeiten</div>
<?php
if ($_GET["updated"]=="true")//Wenn Profil aktualisiert wurde, Hinweis ausgeben
  {
  $hinweis="<p>Das Profil wurde aktualisiert.</p>";
  }
else
  {
  $hinweis="";
  }  

if (isset($_GET['section']))//Section ausgeben
  {
  switch ($_GET['section'])
    {
	case "kontakt":
      $section="kontakt";
      break;
	case "kurse":
      $section="kurse";
      break;
    case "persoenliches":
      $section="persoenliches";
      break;
    case "foto":
	  $section="foto";
      break;
	case "passwort":
      $section="passwort";
      break;
	case "schule":
      $section="schule";
	}
  }	
else
  {
  $section="kontakt";
  }
echo '<ul id="submenu">';  
if ($section=='kontakt')
	echo '<li class="selectedmenuitem">Kontakt</li>';
else
	echo '<li><a href="framework.php?id=profiledit&section=kontakt">Kontakt</a></li>';
	
if ($section=='kurse')
	echo '<li class="selectedmenuitem">Kurse</li>';
else
	echo '<li><a href="framework.php?id=profiledit&section=kurse">Kurse</a></li>';
	
if ($section=='schule')
	echo '<li class="selectedmenuitem">Schule</li>';
else
	echo '<li><a href="framework.php?id=profiledit&section=schule">Schule</a></li>';
	
if ($section=='persoenliches')
	echo '<li class="selectedmenuitem">Persönliches</li>';
else
	echo '<li><a href="framework.php?id=profiledit&section=persoenliches">Persönliches</a></li>';
	
if ($section=='foto')
	echo '<li class="selectedmenuitem">Profilbild</li>';
else
	echo '<li><a href="framework.php?id=profiledit&section=foto">Profilbild</a></li>';
	
if ($section=='passwort')
	echo '<li class="selectedmenuitem">Passwort</li>';
else
	echo '<li><a href="framework.php?id=profiledit&section=passwort">Passwort</a></li>';
echo '</ul>';
//AUSGABE der entsprechenden Section
if($section=="kontakt")
{
$abfrage = "SELECT * FROM user WHERE SCHUELER_ID='$s_user_id'";
$ergebnis = mysql_query($abfrage);
$row= mysql_fetch_object($ergebnis);
$e_mail=$row->EMail;
$icq=$row->ICQ;
$strasse=$row->Strasse;
$plz=$row->PLZ;
$ort=$row->Ort;
$tel=$row->Telefon;
$handy=$row->Handy;
if ($icq=="0")
  {
  $icq="";
  }
if ($plz=="0")
  {
  $plz="";
  }
echo 
$hinweis.  
'<form method="post" action="profiledit_ausfuehren.php">  
<table class="tabelle_randlos">
<tr><td>E-Mail</td><td><input name="e_mail" type="text" value="'.$e_mail.'" readonly/></td></tr>
<tr><td>ICQ</td><td><input name="icq" type="text" value="'.$icq.'"/></td></tr>
<tr><td>Telefon</td><td><input name="tel" type="text" value="'.$tel.'"/></td></tr>
<tr><td>Handy</td><td><input name="handy" type="text" value="'.$handy.'"/></td></tr>
<tr><td>Straße</td><td><input name="strasse" type="text" value="'.$strasse.'"/></td></tr>
<tr><td>Postleitzahl</td><td><input name="plz" type="text" value="'.$plz.'"/></td></tr>
<tr><td>Ort</td><td><input name="ort" type="text" value="'.$ort.'"/></td></tr>

</table>
<input type="submit" class="button" value="Speichern"/>
<input type="hidden" name="section" value="'.$section.'"/>
</form>';
}

if($section=="kurse")
{
$abfrage = "SELECT Kurse FROM user WHERE SCHUELER_ID='$s_user_id'";
$ergebnis = mysql_query($abfrage);
$row = mysql_fetch_object($ergebnis);
$kurse=$row->Kurse;
$kurse=explode(";",$kurse);

$abfrage = "SELECT * FROM kurse WHERE fach_lang LIKE '%LK _' ORDER BY fach_kurz";
$ergebnis = mysql_query($abfrage);
$anzahl = mysql_num_rows($ergebnis);
echo $hinweis.  
'<form method="post" action="profiledit_ausfuehren.php">  
<br />
<div class="profilkategorie">Leistungskurse:</div>

<table class="tabelle_randlos"> 
<p>xxxb LKx sind Beifächer!</p> 
<tr>
<td>';
for($i=0; $i<($anzahl/3);$i++)//Kurse in Tabelle mit je 3 kursen pro zeile ausgeben
  {  
  $row = mysql_fetch_object($ergebnis);
  $kurz=$row->fach_kurz;
  $belegt=false;
  foreach($kurse as $k)
    {
	if($k==$kurz)
	  {
	  $belegt=true;
	  }
	}
  
  $lehrer=$row->lehrer;
  if ($belegt==true)
    {
	echo'<input type="checkbox" name="kurse[]" value="'.$kurz.'" checked="checked"/>';
	}
  else
    {  
    echo'<input type="checkbox" name="kurse[]" value="'.$kurz.'"/>';
	}
  echo "$kurz ($lehrer) <br />";
  }
echo "</td><td>";
for($i=$i; $i<(2*$anzahl/3);$i++)
  {
  $row = mysql_fetch_object($ergebnis);
  $kurz=$row->fach_kurz;
  $belegt=false;
  foreach($kurse as $k)
    {
	if($k==$kurz)
	  {
	  $belegt=true;
	  }
	}
  
  $lehrer=$row->lehrer;
  if ($belegt==true)
    {
	echo'<input type="checkbox" name="kurse[]" value="'.$kurz.'" checked="checked"/>';
	}
  else
    {  
    echo'<input type="checkbox" name="kurse[]" value="'.$kurz.'"/>';
	}
  echo "$kurz ($lehrer) <br />";
  }  
echo "</td><td>";
for($i=$i; $i<($anzahl);$i++)
  {
  $row = mysql_fetch_object($ergebnis);
  $kurz=$row->fach_kurz;
  $belegt=false;
  foreach($kurse as $k)
    {
	if($k==$kurz)
	  {
	  $belegt=true;
	  }
	}
  
  $lehrer=$row->lehrer;
  if ($belegt==true)
    {
	echo'<input type="checkbox" name="kurse[]" value="'.$kurz.'" checked="checked"/>';
	}
  else
    {  
    echo'<input type="checkbox" name="kurse[]" value="'.$kurz.'"/>';
	}
  echo "$kurz ($lehrer) <br />";
  } 
echo '</td></tr></table><div class="profilkategorie">Grundkurse:</div><table class="tabelle_randlos"><tr><td>';
$abfrage = "SELECT * FROM kurse WHERE fach_lang LIKE '%GK _' ORDER BY fach_kurz";
$ergebnis = mysql_query($abfrage);
$anzahl = mysql_num_rows($ergebnis);

for($i=0; $i<($anzahl/3);$i++)
  {
  $row = mysql_fetch_object($ergebnis);
  $kurz=$row->fach_kurz;
  $belegt=false;
  foreach($kurse as $k)
    {
	if($k==$kurz)
	  {
	  $belegt=true;
	  }
	}
  
  $lehrer=$row->lehrer;
  if ($belegt==true)
    {
	echo'<input type="checkbox" name="kurse[]" value="'.$kurz.'" checked="checked"/>';
	}
  else
    {  
    echo'<input type="checkbox" name="kurse[]" value="'.$kurz.'"/>';
	}
  echo "$kurz ($lehrer) <br />";
  }
echo "</td><td>";
for($i=$i; $i<(2*$anzahl/3);$i++)
  {
  $row = mysql_fetch_object($ergebnis);
  $kurz=$row->fach_kurz;
  $belegt=false;
  foreach($kurse as $k)
    {
	if($k==$kurz)
	  {
	  $belegt=true;
	  }
	}
  
  $lehrer=$row->lehrer;
  if ($belegt==true)
    {
	echo'<input type="checkbox" name="kurse[]" value="'.$kurz.'" checked="checked"/>';
	}
  else
    {  
    echo'<input type="checkbox" name="kurse[]" value="'.$kurz.'"/>';
	}
  echo "$kurz ($lehrer) <br />";
  }  
echo "</td><td>";
for($i=$i; $i<($anzahl);$i++)
  {
  $row = mysql_fetch_object($ergebnis);
  $kurz=$row->fach_kurz;
  $belegt=false;
  foreach($kurse as $k)
    {
	if($k==$kurz)
	  {
	  $belegt=true;
	  }
	}
  
  $lehrer=$row->lehrer;
  if ($belegt==true)
    {
	echo'<input type="checkbox" name="kurse[]" value="'.$kurz.'" checked="checked"/>';
	}
  else
    {  
    echo'<input type="checkbox" name="kurse[]" value="'.$kurz.'"/>';
	}
  echo "$kurz ($lehrer) <br />";
  }   
echo '</td>
</tr>
</table>
<input type="submit" class="button" value="Speichern"/>
<input type="hidden" name="section" value="'.$section.'"/>
</form>';
}



if($section=="schule")
{
$abfrage = "SELECT * FROM user WHERE SCHUELER_ID='$s_user_id'";
$ergebnis = mysql_query($abfrage);
$row= mysql_fetch_object($ergebnis);
 
echo $hinweis.  
'<form method="post" action="profiledit_ausfuehren.php">  
<div class="profilkategorie">Organisationsteams</div>';

$abfrage = "SELECT Teams FROM user WHERE SCHUELER_ID='$s_user_id'";
$ergebnis = mysql_query($abfrage);
$row = mysql_fetch_object($ergebnis);
$teams=$row->Teams;
$teams=explode(";",$teams);

$abfrage = "SELECT * FROM teams ORDER BY team_name";
$ergebnis = mysql_query($abfrage);
$anzahl = mysql_num_rows($ergebnis);
for($i=0; $i<($anzahl);$i++)
  {
  $row = mysql_fetch_object($ergebnis);
  $team_name=$row->team_name;
  $belegt=false;
  foreach($teams as $t)
    {
	if($t==$team_name)
	  {
	  $belegt=true;
	  }
	}
  
  if ($belegt==true)
    {
	echo'<input type="checkbox" name="teams[]" value="'.$team_name.'" checked="checked"/>';
	}
  else
    {  
    echo'<input type="checkbox" name="teams[]" value="'.$team_name.'"/>';
	}
  echo "$team_name <br />";
  }

echo '<input type="submit" class="button" value="Speichern"/><input type="hidden" name="section" value="'.$section.'"/></form>';
}



if($section=="persoenliches")
{
$abfrage = "SELECT * FROM user WHERE SCHUELER_ID='$s_user_id'";
$ergebnis = mysql_query($abfrage);
$row= mysql_fetch_object($ergebnis);
$hobbies=$row->Hobbies;
$musik=$row->Lieblingsmusik;
$buecher=$row->Lieblingsbuecher;
$filme=$row->Lieblingsfilme;
$sendungen=$row->Lieblingssendungen;
$geb_d=$row->geb_d;
$geb_m=$row->geb_m;
$geb_y=$row->geb_y;
$mag=preg_replace('/\<br(\s*)?\/?\>/i', "", $row->mag);
$mag_nicht=preg_replace('/\<br(\s*)?\/?\>/i', "",$row->mag_nicht);
$monate=array('Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember');
$gebtag='<select name="geb_d" size="1">';
for($i = 1; $i <= 31; $i++)
  {
  if ($i==$geb_d)
    {
    $gebtag.='<option selected="selected">'.$i.'</option>';
    }
  else  
    {
    $gebtag.="<option>".$i."</option>";
    } 
  }
$gebtag.='</select><select name="geb_m" size="1">';  
for($i = 1; $i <= 12; $i++)
  {
  if ($i==$geb_m)
    {
    $gebtag.='<option value="'.$i.'" selected="selected">'.$monate[$i-1].'</option>';
    }
  else  
    {
    $gebtag.='<option value="'.$i.'">'.$monate[$i-1].'</option>';
    } 
  }
$gebtag.='</select><select name="geb_y" size="1">'; 
for($i = 1989; $i <= 1994; $i++)
  {
  if ($i==$geb_y)
    {
    $gebtag.='<option selected="selected">'.$i.'</option>';
    }
  else  
    {
    $gebtag.="<option>$i</option>";
    } 
  }
  $gebtag.= '</select>';
echo $hinweis.  
'<form method="post" action="profiledit_ausfuehren.php">  
<table class="tabelle_randlos">
<tr><td>Geburtstag</td><td>'.$gebtag.'</td></tr>
<tr><td>Hobbies</td><td><input name="hobbies" type="text" size="50" value="'.$hobbies.'"/></td></tr>
<tr><td>Lieblingsmusik</td><td><input name="musik" type="text" size="50" value="'.$musik.'"/></td></tr>
<tr><td>Lieblingsbücher</td><td><input name="buecher" type="text" size="50" value="'.$buecher.'"/></td></tr>
<tr><td>Lieblingsfilme</td><td><input name="filme" type="text" size="50" value="'.$filme.'"/></td></tr>
<tr><td>Lieblingssendungen</td><td><input name="sendungen" type="text" size="50" value="'.$sendungen.'"/></td></tr>
<tr><td>Ich mag</td><td><textarea name="mag" wrap="soft" cols="50" rows="8">'.$mag.'</textarea></td></tr>
<tr><td>Ich mag nicht</td><td><textarea name="mag_nicht" wrap="soft" cols="50" rows="8">'.$mag_nicht.'</textarea></td></tr>
</table>
<input type="submit" class="button" value="Speichern"/>
<input type="hidden" name="section" value="'.$section.'"/>
</form>';
}


if($section=="foto")
  {
  if (file_exists("./images/profil/".$s_user_id.".jpg"))
    {
	$profilbild="./images/profil/".$s_user_id.".jpg";
	}
  else
    {
	$profilbild="./images/profil/default.jpg";
	}

echo $hinweis.  
'<form enctype="multipart/form-data" method="post" action="profiledit_ausfuehren.php">  
<table class="tabelle_randlos">
<tr>
<td>
<img alt="Profilbild" src="'.$profilbild.'"/> 
</td>
<td>
 
 <p>Datei zum Hochladen auswählen: 
<input name="datei" type="file" size="50" accept="text/*" /></p>
<br />
Maximale Größe: 1,5MB; Dateitypen: JPEG, PNG, GIF<br />
<input class="button" type="submit" value="Hochladen"/>
<input name="section" type="hidden" value="'.$section.'"/>
</td>
</tr>
</table>
</form>';
  }

  
if($section=="passwort")
{

echo $hinweis.  
'<form method="post" action="profiledit_ausfuehren.php">  
<p>Es wird zwischen Groß- und Kleinschreibung unterschieden.<br />Mindestlänge: 8 Zeichen</p>
<table class="tabelle_randlos">
<tr><td>altes Passwort</td><td><input name="pw_alt" type="password"/></td></tr>
<tr><td>neues Passwort</td><td><input name="pw_neu" type="password"/></td></tr>
<tr><td>Wiederholung</td><td><input name="pw_neu2" type="password"/></td></tr>
</table>
<input type="submit" class="button" value="Speichern"/>
<input name="section" type="hidden" value="passwort"/>
</form>';
if($_GET["fehler"]=="1")
  {
  echo "<p>Es ist ein Fehler aufgetreten. Entweder war dein altes Passwort falsch oder die Eingaben waren nicht identisch. Bitte versuche es noch einmal.</p>";
  }
if($_GET["fehler"]=="2")
  {
  echo "<p>Das Passwort muss mindestens 8 Zeichen lang sein. Es wurde NICHT geändert.</p>";
  }
}
?>
</div>
