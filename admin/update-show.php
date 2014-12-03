<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
if (check_login("show") == true)
{
	include('mysql.inc.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Benutzerverwaltung</title>
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
	<script src="js/jquery-1.7.2.js"></script>
	<script src="js/lightbox.js"></script>
</head>	
<body>
<?php
    include('menu.inc.php');		
		if (!empty($_GET["toogle"]))
		{
		    $SCHUELER_ID = (int)$_GET["toogle"];
				$abfrage = 'SELECT `freigeschaltet`,`EMail`,`Name_ganz` FROM `'.$sql_db.'` . `user` WHERE `user`.`SCHUELER_ID` = ' . $SCHUELER_ID;
				$ergebnis = mysql_query($abfrage, $sql);
				$row = mysql_fetch_object($ergebnis);				
				$status = $row->freigeschaltet;
				$email = $row->EMail;
				$name = $row->Name_ganz;
				if ($status == 0)
				{
						$abfrage1 = 'UPDATE `'.$sql_db.'`.`user` SET `freigeschaltet` =1 WHERE `user`.`SCHUELER_ID` =' . $SCHUELER_ID . ' LIMIT 1';
						if (mysql_query($abfrage1, $sql) == true)
						{
						    email("$email","Stufenforum: Freischaltung","Hallo $name,\r\n\r\nIhr Account im Stufenforum wurde soeben freigeschaltet.\r\nAb sofort koennen Sie sich im Stufenforum anmelden und alle Funktionen verwenden. ","1");
								header('Location: show.php');
						}
						exit;
				}
				else
				{
						$abfrage2 = 'UPDATE `'.$sql_db.'`.`user` SET `freigeschaltet` =0 WHERE `user`.`SCHUELER_ID` =' . $SCHUELER_ID . ' LIMIT 1';
						if (mysql_query($abfrage2, $sql) == true)
						{
						    email("$email","Stufenforum: Sperrung","Hallo $name,\r\n\r\nIhr Account im Stufenforum wurde gesperrt.\r\nBei Fragen antworten Sie bitte auf diese EMail. ","1");
								header('Location: show.php');
						}
						exit;
				}
		}elseif (!empty($_GET["create"]))
		{
			?>
				<div id="inhalt">
				<div id="layout_canvas">
				<div class="profilkopf"><img src="./img/benutzerverwaltung.png"> Benutzer erstellen</></div>
				<div id="userStats" class="clearfix">
				<form action="p_create-show.php" method="post">
		        <table class="tabelle_randlos">
				<tbody>
					<tr>	
					<p>Nachdem der neue Benutzer angelegt wurde, muss er noch aktiviert werden!</p>					
    	             <td>Vorname:</td>
					 <td><input type="text" size="20" maxlength="20" name="first" value=""></td>
					</tr>
					<tr>
    	             <td>Nachname:</th>
					 <td><input type="text" size="20" maxlength="20" name="last" value=""></td>
					</tr>
					<tr>
    	             <td>E-Mail:</td>
					 <td><input type="text" size="20" maxlength="20" name="mail" value=""></td>
					</tr>
					<tr>
    	             <td>Passwort:</td>
					 <td><input type="password" size="20" maxlength="20" name="pwd" value=""></td>
					</tr>
					<tr>
    	             <td>Passwort wdh.:</td>
					 <td><input type="password" size="20" maxlength="20" name="pwd2" value=""></td>
					</tr>	
					<tr>
					 <td></td>
					 <td>Beim Passwort wird zwischen Groß- und Kleinschreibung unterschieden.<br />Mindestlänge: 8 Zeichen!</td>
					</tr>
				</tbody> 
	            </table><br><input class="button" type="submit" value="Abschicken">
				<a href="javascript:history.back()"><input class="button" type="button" name="cancel" value="Abbrechen" /></a>
				</form>
				</div></div></div>
			<?php
			include('footer.inc.php');			
		}elseif (!empty($_GET["edit"]))
		{
			$SCHUELER_ID = (int)$_GET["edit"];
			$abfrage3 = 'SELECT * FROM `'.$sql_db.'` . `user` WHERE `user`.`SCHUELER_ID` = ' . $SCHUELER_ID;
			$result3 = mysql_query($abfrage3, $sql);
			$row3 = mysql_fetch_object($result3);
			$name_ganz = $row3->Name_ganz;
			echo '
			<div id="inhalt">
			<div id="layout_canvas">
			<div class="profilkopf"><img src="./img/benutzerverwaltung.png"> Daten von '.$name_ganz.' ändern</></div>';
//checken ob nicht superadmin einen superadmin bearbeiten will; true -> verboten
if((check_superadmin($s_user_id) == true) OR (check_superadmin($SCHUELER_ID) == false)){		
if ($_GET["updated"]=="true")//Wenn Profil aktualisiert wurde, Hinweis ausgeben
  {
  $hinweis="<p>Das Profil wurde aktualisiert.</p>";
  }
elseif ($_GET["updated"]=="false")
  {
  $hinweis="<p>Das Profil wurde nicht aktualisiert.</p>";
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
	case "admin":
		if (check_login("berechtigungen") == true)
		{
			$section="admin";
		}else{
			header('Location: admin.php?berechtigung=0');
		}
      break;	  
	case "schule":
      $section="schule";
	}
  }	
else
  {
  $section="kontakt";
  }  
if($section=="kontakt")
{
$abfrage = 'SELECT * FROM `'.$sql_db.'` . `user` WHERE `user`.`SCHUELER_ID`='.$SCHUELER_ID;
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
echo <<<HTML
  <ul id="submenu">
    <li class="selectedmenuitem"><a href="update-show.php?edit=$SCHUELER_ID&section=kontakt">Kontakt</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=kurse">Kurse</a></li>
	<li><a href="update-show.php?edit=$SCHUELER_ID&section=schule">Schule</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=persoenliches">Persönliches</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=foto">Foto</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=passwort">Passwort</a></li>
	<li><a href="update-show.php?edit=$SCHUELER_ID&section=admin">Admin</a></li>
  </ul>
  <div id="userStats" class="clearfix">
$hinweis  
<form method="post" action="p_update-show.php">  
<table class="tabelle_randlos">
<tr><td>E-Mail</td><td><input name="e_mail" type="text" value="$e_mail"/></td></tr>
<tr><td>ICQ</td><td><input name="icq" type="text" value="$icq"/></td></tr>
<tr><td>Telefon</td><td><input name="tel" type="text" value="$tel"/></td></tr>
<tr><td>Handy</td><td><input name="handy" type="text" value="$handy"/></td></tr>
<tr><td>Straße</td><td><input name="strasse" type="text" value="$strasse"/></td></tr>
<tr><td>Postleitzahl</td><td><input name="plz" type="text" value="$plz"/></td></tr>
<tr><td>Ort</td><td><input name="ort" type="text" value="$ort"/></td></tr>

</table>
<input type="submit" class="button" value="Speichern"/>
<a href="show.php"><input class="button" type="button" name="cancel" value="Abbrechen" /></a>
<input type="hidden" name="id" value="$SCHUELER_ID"/>
<input type="hidden" name="section" value="$section"/>
</form>  
HTML;
}		

if($section=="kurse")
{
$abfrage = 'SELECT Kurse FROM `'.$sql_db.'` . `user` WHERE `user`.`SCHUELER_ID`='.$SCHUELER_ID;
$ergebnis = mysql_query($abfrage);
$row = mysql_fetch_object($ergebnis);
$kurse=$row->Kurse;
$kurse=explode(";",$kurse);

$abfrage = "SELECT * FROM kurse WHERE fach_lang LIKE '%LK _' ORDER BY fach_kurz";
$ergebnis = mysql_query($abfrage);
$anzahl = mysql_num_rows($ergebnis);
echo <<<HTML
  <ul id="submenu">
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=kontakt">Kontakt</a></li>
    <li class="selectedmenuitem"><a href="update-show.php?edit=$SCHUELER_ID&section=kurse">Kurse</a></li>
	<li><a href="update-show.php?edit=$SCHUELER_ID&section=schule">Schule</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=persoenliches">Persönliches</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=foto">Foto</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=passwort">Passwort</a></li>
	<li><a href="update-show.php?edit=$SCHUELER_ID&section=admin">Admin</a></li>
  </ul>
  <div id="userStats" class="clearfix">
$hinweis
<form method="post" action="p_update-show.php">  
<br />
<div class="profilkategorie">Leistungskurse:</div>

<table class="tabelle_randlos"> 
<p>xxxb LKx sind Beifächer!</p> 
<tr>
<td>
HTML;
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
echo <<<HTML
</td>
</tr>
</table>
<input type="submit" class="button" value="Speichern"/>
<a href="show.php"><input class="button" type="button" name="cancel" value="Abbrechen" /></a>
<input type="hidden" name="section" value="$section"/>
<input type="hidden" name="id" value="$SCHUELER_ID"/>
</form> 
HTML;
}		
if($section=="schule")
{
$abfrage = 'SELECT * FROM `'.$sql_db.'` . `user` WHERE `user`.`SCHUELER_ID`='.$SCHUELER_ID;
$ergebnis = mysql_query($abfrage);
$row= mysql_fetch_object($ergebnis);
 
echo <<<HTML
  <ul id="submenu">
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=kontakt">Kontakt</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=kurse">Kurse</a></li>
	<li class="selectedmenuitem"><a href="update-show.php?edit=$SCHUELER_ID&section=schule">Schule</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=persoenliches">Persönliches</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=foto">Foto</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=passwort">Passwort</a></li>
	<li><a href="update-show.php?edit=$SCHUELER_ID&section=admin">Admin</a></li>
  </ul>
  <div id="userStats" class="clearfix">
$hinweis  
<form method="post" action="p_update-show.php">  
<br/>
<div class="profilkategorie">Organisationsteams</div>
  
HTML;
$abfrage = 'SELECT `Teams` FROM `'.$sql_db.'` . `user` WHERE `user`.`SCHUELER_ID`='.$SCHUELER_ID;

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

echo '<input type="submit" class="button" value="Speichern"/>
<a href="show.php"><input class="button" type="button" name="cancel" value="Abbrechen" /></a>
<input type="hidden" name="section" value="'.$section.'"/>
<input type="hidden" name="id" value="'.$SCHUELER_ID.'"/></form>';
}

if($section=="persoenliches")
{
$abfrage = 'SELECT * FROM `'.$sql_db.'` . `user` WHERE `user`.`SCHUELER_ID`='.$SCHUELER_ID;
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
    $gebtag.="<option>$i</option>";
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
echo <<<HTML
  <ul id="submenu">
	<li><a href="update-show.php?edit=$SCHUELER_ID&section=kontakt">Kontakt</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=kurse">Kurse</a></li>
	<li><a href="update-show.php?edit=$SCHUELER_ID&section=schule">Schule</a></li>
    <li class="selectedmenuitem"><a href="update-show.php?edit=$SCHUELER_ID&section=persoenliches">Persönliches</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=foto">Foto</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=passwort">Passwort</a></li>
	<li><a href="update-show.php?edit=$SCHUELER_ID&section=admin">Admin</a></li>
  </ul>
  <div id="userStats" class="clearfix">
$hinweis  
<form method="post" action="p_update-show.php">  
<table class="tabelle_randlos">
<tr><td>Geburtstag</td><td>$gebtag</td></tr>
<tr><td>Hobbies</td><td><input name="hobbies" type="text" size="50" value="$hobbies"/></td></tr>
<tr><td>Lieblingsmusik</td><td><input name="musik" type="text" size="50" value="$musik"/></td></tr>
<tr><td>Lieblingsbücher</td><td><input name="buecher" type="text" size="50" value="$buecher"/></td></tr>
<tr><td>Lieblingsfilme</td><td><input name="filme" type="text" size="50" value="$filme"/></td></tr>
<tr><td>Lieblingssendungen</td><td><input name="sendungen" type="text" size="50" value="$sendungen"/></td></tr>
<tr><td>Ich mag</td><td><textarea name="mag" wrap="soft" cols="50" rows="8">$mag</textarea></td></tr>
<tr><td>Ich mag nicht</td><td><textarea name="mag_nicht" wrap="soft" cols="50" rows="8">$mag_nicht</textarea></td></tr>
</table>
<input type="submit" class="button" value="Speichern"/>
<a href="show.php"><input class="button" type="button" name="cancel" value="Abbrechen" /></a>
<input type="hidden" name="section" value="$section"/>
<input type="hidden" name="id" value="$SCHUELER_ID"/>
</form> 
  
HTML;
}

if($section=="foto")
  {
  if (file_exists("../images/profil/".$SCHUELER_ID.".jpg"))
    {
	$profilbild="../images/profil/".$SCHUELER_ID.".jpg";
	}
  else
    {
	$profilbild="../images/profil/default.jpg";
	}
echo <<<HTML
  <ul id="submenu">
	<li><a href="update-show.php?edit=$SCHUELER_ID&section=kontakt">Kontakt</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=kurse">Kurse</a></li>
	<li><a href="update-show.php?edit=$SCHUELER_ID&section=schule">Schule</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=persoenliches">Persönliches</a></li>
    <li class="selectedmenuitem"><a href="update-show.php?edit=$SCHUELER_ID&section=foto">Foto</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=passwort">Passwort</a></li>
	<li><a href="update-show.php?edit=$SCHUELER_ID&section=admin">Admin</a></li>
  </ul>
  <div id="userStats" class="clearfix">
$hinweis  
<form enctype="multipart/form-data" method="post" action="p_update-show.php">  
<table class="tabelle_randlos">
<tr>
<td>
<img alt="Profilbild" src="$profilbild"/> 
</td>
<td>
 <p><strong>Hinweis:</strong> Es kann bis zu mehreren Stunden dauern, bis das neue Bild verarbeitet ist und im Profil angezeigt wird. Wir bitten um euer Verständnis.</p>
 <p>Datei zum Hochladen auswählen: 
<input name="datei" type="file" size="50" accept="text/*" /></p>
<br />
Maximale Größe: 1,5MB; Dateitypen: JPEG, PNG, GIF<br />
<input class="button" type="submit" value="Hochladen"/>
<input name="section" type="hidden" value="$section"/>
<input type="hidden" name="id" value="$SCHUELER_ID"/>
</td>
</tr>
</table>
</form>
HTML;
  }

if($section=="passwort")
{
//check if adminuser is superadmin
$abfrage1 = 'SELECT berechtigungen FROM `'.$sql_db.'` . `admin` WHERE `admin`.`SchuelerID`='.$s_user_id;
$ergebnis1 = mysql_query($abfrage1);

echo <<<HTML
  <ul id="submenu">
	<li><a href="update-show.php?edit=$SCHUELER_ID&section=kontakt">Kontakt</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=kurse">Kurse</a></li>
	<li><a href="update-show.php?edit=$SCHUELER_ID&section=schule">Schule</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=persoenliches">Persönliches</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=foto">Foto</a></li>
    <li class="selectedmenuitem"><a href="update-show.php?edit=$SCHUELER_ID&section=passwort">Passwort</a></li>
	<li><a href="update-show.php?edit=$SCHUELER_ID&section=admin">Admin</a></li>
  </ul>
  <div id="userStats" class="clearfix">
$hinweis  
<form method="post" action="p_update-show.php">  
<p>Es wird zwischen Groß- und Kleinschreibung unterschieden.<br />Mindestlänge: 8 Zeichen</p>
<table class="tabelle_randlos">
<tr><td>neues Passwort</td><td><input name="pw_neu" type="password"/></td></tr>
<tr><td>Wiederholung</td><td><input name="pw_neu2" type="password"/></td></tr>
</table>
<input type="submit" class="button" value="Speichern"/>
<a href="show.php"><input class="button" type="button" name="cancel" value="Abbrechen" /></a>
<input name="section" type="hidden" value="passwort"/>
<input type="hidden" name="id" value="$SCHUELER_ID"/>
</form>
HTML;
	
if($_GET["fehler"]=="2")
  {
  echo "<p>Das Passwort muss mindestens 8 Zeichen lang sein. Es wurde NICHT geändert.</p>";
  }
}
if($section=="admin")
{
echo <<<HTML
  <ul id="submenu">
	<li><a href="update-show.php?edit=$SCHUELER_ID&section=kontakt">Kontakt</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=kurse">Kurse</a></li>
	<li><a href="update-show.php?edit=$SCHUELER_ID&section=schule">Schule</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=persoenliches">Persönliches</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=foto">Foto</a></li>
    <li><a href="update-show.php?edit=$SCHUELER_ID&section=passwort">Passwort</a></li>
	<li class="selectedmenuitem"><a href="update-show.php?edit=$SCHUELER_ID&section=admin">Admin</a></li>
  </ul>
  <div id="userStats" class="clearfix">
$hinweis   
<p>Überlege dir gut, ob dieser Benutzer Administrationsrechte bekommen soll!</p>
<div class="profilkategorie">Administratorrechte</div>
<table class="tabelle_randlos">
<form method="post" action="p_update-show.php"> 
HTML;
  $abfrage = 'SELECT * FROM `'.$sql_db.'` . `user` WHERE `user`.`SCHUELER_ID`='.$SCHUELER_ID;
  $ergebnis = mysql_query($abfrage);
  $row = mysql_fetch_object($ergebnis);
  if ($row->admin == 1)
    {
	echo'<tr><td><input type="checkbox" name="mainadmin" value="1" checked="checked"/>Administrator (Adminpanel Loginrechte)</td></tr>';
	}
  else
    {  
    echo'<td><input type="checkbox" name="mainadmin" value="0"/>Administrator</td>';
	}
echo <<<HTML
</table>
<div class="profilkategorie">Administrationsbereiche</div>
<table class="tabelle_randlos">
HTML;

	$sections = get_adminsections($SCHUELER_ID);
	foreach ($sections as $nr => $inhalt) {
		$name[$nr] = $inhalt['name'];
		$value[$nr] = $inhalt['value'];
		$descr[$nr] = $inhalt['descr'];
		
		if ($value[$nr] == 1) {
			echo'<tr><td><input type="checkbox" name="'.$name[$nr].'" value="'.$value[$nr].'" checked="checked"/>'.$descr[$nr].'<br/></td></tr>';
		} else {
			echo'<tr><td><input type="checkbox" name="'.$name[$nr].'" value="'.$value[$nr].'" />'.$descr[$nr].'<br/></td></tr>';
		}
		
	}	

echo <<<HTML
</table>
<input type="submit" class="button" value="Speichern"/>
<a href="show.php"><input class="button" type="button" name="cancel" value="Abbrechen" /></a>
<input name="section" type="hidden" value="admin"/>
<input type="hidden" name="id" value="$SCHUELER_ID"/>
</form>  
HTML;
}
}else{
// wenn superadmin einen superadmin bearbeiten will; true -> verboten
	header('Location: ./admin.php?berechtigung=0');
}
	echo '</div></div></div>';
	include('footer.inc.php');	
	}elseif (!empty($_GET["del"]))
	{
		$SCHUELER_ID = (int)$_GET["del"];
		$abfrage4 = 'UPDATE `user` SET `Deleted` = 1 WHERE `user`.`SCHUELER_ID` =' . $SCHUELER_ID . ' LIMIT 1 ;';
		if (mysql_query($abfrage4, $sql) == true)
		    {
				header('Location: ./show.php?msg=erfolg');
		    }
		else
			{
				header('Location: ./show.php?msg=fehler&errordesc=SQL Fehler');
			}	
	}
}
else
{
	header('Location: admin.php?berechtigung=0');
}

?>