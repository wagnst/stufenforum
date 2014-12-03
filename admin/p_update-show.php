<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
require_once('mysql.inc.php');
if (check_login("show") == true)
{
$SCHUELER_ID = (int)$_POST["id"];
//entsprechende änderungen ausführen
if (isset($_POST['section']))
  {
  switch ($_POST['section'])
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
      break;
	case "admin":
		if (check_login("berechtigungen") == true)
		{
			$section="admin";
		}else{
			header('Location: admin.php?berechtigung=0');
		}
		break;	  
	}
  }	
else
  {
  $section="kontakt";
  }

if($section=="kontakt")
  {
  $e_mail=strip_tags($_POST["e_mail"]);
  $icq=strip_tags($_POST["icq"]);
  $icq= preg_replace('![^0-9]!', '', $icq);
  $strasse=strip_tags($_POST["strasse"]);
  $plz=strip_tags($_POST["plz"]);
  $ort=strip_tags($_POST["ort"]);
  $tel=strip_tags($_POST["tel"]);
  $handy=strip_tags($_POST["handy"]);
  $abfrage="UPDATE user SET EMail='$e_mail', ICQ='$icq', Telefon='$tel', Handy='$handy', Strasse='$strasse', PLZ='$plz', Ort='$ort' WHERE SCHUELER_ID='$SCHUELER_ID'";
  mysql_query($abfrage);
  header('Location: ./update-show.php?edit='.$SCHUELER_ID.'&section=kontakt&updated=true');
  }

  
if($section=="kurse")
  {
  $kurse=$_POST["kurse"];
  if ($kurse!=NULL)
    {
    $string=implode(';',$kurse);
	}
  $abfrage="UPDATE user SET Kurse='$string' WHERE SCHUELER_ID='$SCHUELER_ID'";
  mysql_query($abfrage);
	
 header('Location: ./update-show.php?edit='.$SCHUELER_ID.'&section=kurse&updated=true');
  }

if($section=="schule")
  {
  $teams=$_POST["teams"];
  if ($teams!=NULL)
    {
    $string=implode(';',$teams);
	}
  $abfrage="UPDATE user SET Teams='$string' WHERE SCHUELER_ID='$SCHUELER_ID'";
  mysql_query($abfrage);
  
  header('Location: ./update-show.php?edit='.$SCHUELER_ID.'&section=schule&updated=true');
  }
  
if($section=="persoenliches")
  {
  $geb_d=$_POST["geb_d"];
  $geb_m=$_POST["geb_m"];
  $geb_y=$_POST["geb_y"];
  $hobbies=strip_tags($_POST["hobbies"],'<a>');
  $musik=strip_tags($_POST["musik"],'<a>');
  $buecher=strip_tags($_POST["buecher"],'<a>');
  $filme=strip_tags($_POST["filme"],'<a>');
  $sendungen=strip_tags($_POST["sendungen"],'<a>');
  $mag=nl2br(strip_tags($_POST["mag"],'<a>'));
  $mag_nicht=nl2br(strip_tags($_POST["mag_nicht"],'<a>'));
  $abfrage="UPDATE user SET geb_d='$geb_d', geb_m='$geb_m', geb_y='$geb_y', Hobbies='$hobbies', Lieblingsmusik='$musik', Lieblingsbuecher='$buecher', Lieblingsfilme='$filme', Lieblingssendungen='$sendungen', mag='$mag', mag_nicht='$mag_nicht' WHERE SCHUELER_ID='$SCHUELER_ID'";
  mysql_query($abfrage);
  header('Location: ./update-show.php?edit='.$SCHUELER_ID.'&section=persoenliches&updated=true');
  }  
  
  
if($section=="foto")//profilbild verkleinern und in entsprechende ordner schieben
  {
  move_uploaded_file($_FILES['datei']['tmp_name'],"../images/profil_full/$SCHUELER_ID.jpg");
  $Grafikdatei = "../images/profil_full/$s_user_id.jpg";
  $Bilddaten = getimagesize($Grafikdatei);
  $OriginalBreite = $Bilddaten[0];
  $OriginalHoehe = $Bilddaten[1];
  $ThumbnailBreite = 200;
  $ThumbnailHoehe = 300;
  $Thumbnail2Breite = 100;
  $Thumbnail2Hoehe = 150;
  $Thumbnail3Breite = 60;
  $Thumbnail3Hoehe = 60;
  if($OriginalBreite < $ThumbnailBreite)
  {
    $ThumbnailBreite=$OriginalBreite;
  }
  if($OriginalHoehe < $ThumbnailHoehe)
  {
    $ThumbnailHoehe=$OriginalHoehe;
  }

  $SkalierungsfaktorH = $OriginalHoehe/$ThumbnailHoehe;
  $SkalierungsfaktorB = $OriginalBreite/$ThumbnailBreite;
  if ($SkalierungsfaktorB>$SkalierungsfaktorH)
    {
	$Skalierungsfaktor=$SkalierungsfaktorB;
	}
  else
    {
	$Skalierungsfaktor=$SkalierungsfaktorH;
    }	  

  if($OriginalBreite < $Thumbnail2Breite)
  {
    $Thumbnail2Breite=$OriginalBreite;
  }
  if($OriginalHoehe < $Thumbnail2Hoehe)
  {
    $Thumbnail2Hoehe=$OriginalHoehe;
  }

  $SkalierungsfaktorH2 = $OriginalHoehe/$Thumbnail2Hoehe;
  $SkalierungsfaktorB2 = $OriginalBreite/$Thumbnail2Breite;
  if ($SkalierungsfaktorB2>$SkalierungsfaktorH2)
    {
	$Skalierungsfaktor2=$SkalierungsfaktorB2;
	}
  else
    {
	$Skalierungsfaktor2=$SkalierungsfaktorH2;
    }	
	
  if($OriginalBreite < $Thumbnail3Breite)
  {
    $Thumbnail3Breite=$OriginalBreite;
  }
  if($OriginalHoehe < $Thumbnail3Hoehe)
  {
    $Thumbnail3Hoehe=$OriginalHoehe;
  }

  $SkalierungsfaktorH3 = $OriginalHoehe/$Thumbnail3Hoehe;
  $SkalierungsfaktorB3 = $OriginalBreite/$Thumbnail3Breite;
  if ($SkalierungsfaktorB3>$SkalierungsfaktorH3)
    {
	$Skalierungsfaktor3=$SkalierungsfaktorB3;
	}
  else
    {
	$Skalierungsfaktor3=$SkalierungsfaktorH3;
    }	
	
  $ThumbnailHoehe = intval($OriginalHoehe/$Skalierungsfaktor);
  $Thumbnail2Hoehe = intval($OriginalHoehe/$Skalierungsfaktor2);
  $Thumbnail3Hoehe = intval($OriginalHoehe/$Skalierungsfaktor3);
  $ThumbnailBreite = intval($OriginalBreite/$Skalierungsfaktor);
  $Thumbnail2Breite = intval($OriginalBreite/$Skalierungsfaktor2);
  $Thumbnail3Breite = intval($OriginalBreite/$Skalierungsfaktor3);

  if($Bilddaten[2] == 1)
  {
    $Originalgrafik = ImageCreateFromGIF($Grafikdatei);
    $Thumbnailgrafik = ImageCreateTrueColor($ThumbnailBreite, $ThumbnailHoehe);
    ImageCopyResized($Thumbnailgrafik, $Originalgrafik, 0, 0, 0, 0, $ThumbnailBreite, $ThumbnailHoehe, $OriginalBreite, $OriginalHoehe);
    ImageJPEG($Thumbnailgrafik,  "../images/profil/$SCHUELER_ID.jpg");
    $Thumbnailgrafik2 = ImageCreateTrueColor($Thumbnail2Breite, $Thumbnail2Hoehe);
    ImageCopyResized($Thumbnailgrafik2, $Originalgrafik, 0, 0, 0, 0, $Thumbnail2Breite, $Thumbnail2Hoehe, $OriginalBreite, $OriginalHoehe);
    ImageJPEG($Thumbnailgrafik2,  "../images/profil_medium/$SCHUELER_ID.jpg");
	$Thumbnailgrafik3 = ImageCreateTrueColor($Thumbnail3Breite, $Thumbnail3Hoehe);
    ImageCopyResized($Thumbnailgrafik3, $Originalgrafik, 0, 0, 0, 0, $Thumbnail3Breite, $Thumbnail3Hoehe, $OriginalBreite, $OriginalHoehe);
    ImageJPEG($Thumbnailgrafik3,  "../images/profil_small/$SCHUELER_ID.jpg");
  }
elseif($Bilddaten[2] == 2)
{
    $Originalgrafik = ImageCreateFromJPEG($Grafikdatei);
    $Thumbnailgrafik = ImageCreateTrueColor($ThumbnailBreite, $ThumbnailHoehe);
    ImageCopyResized($Thumbnailgrafik, $Originalgrafik, 0, 0, 0, 0, $ThumbnailBreite, $ThumbnailHoehe, $OriginalBreite, $OriginalHoehe);
    ImageJPEG($Thumbnailgrafik, "../images/profil/$SCHUELER_ID.jpg");
	$Thumbnailgrafik2 = ImageCreateTrueColor($Thumbnail2Breite, $Thumbnail2Hoehe);
    ImageCopyResized($Thumbnailgrafik2, $Originalgrafik, 0, 0, 0, 0, $Thumbnail2Breite, $Thumbnail2Hoehe, $OriginalBreite, $OriginalHoehe);
    ImageJPEG($Thumbnailgrafik2,  "../images/profil_medium/$SCHUELER_ID.jpg");
	$Thumbnailgrafik3 = ImageCreateTrueColor($Thumbnail3Breite, $Thumbnail3Hoehe);
    ImageCopyResized($Thumbnailgrafik3, $Originalgrafik, 0, 0, 0, 0, $Thumbnail3Breite, $Thumbnail3Hoehe, $OriginalBreite, $OriginalHoehe);
    ImageJPEG($Thumbnailgrafik3,  "../images/profil_small/$SCHUELER_ID.jpg");
}
elseif($Bilddaten[2] == 3)
{
    $Originalgrafik = ImageCreateFromPNG($Grafikdatei);
    $Thumbnailgrafik = ImageCreateTrueColor($ThumbnailBreite, $ThumbnailHoehe);
    ImageCopyResized($Thumbnailgrafik, $Originalgrafik, 0, 0, 0, 0, $ThumbnailBreite, $ThumbnailHoehe, $OriginalBreite, $OriginalHoehe);
    ImageJPEG($Thumbnailgrafik,  "../images/profil/$SCHUELER_ID.jpg");
	$Thumbnailgrafik2 = ImageCreateTrueColor($Thumbnail2Breite, $Thumbnail2Hoehe);
    ImageCopyResized($Thumbnailgrafik2, $Originalgrafik, 0, 0, 0, 0, $Thumbnail2Breite, $Thumbnail2Hoehe, $OriginalBreite, $OriginalHoehe);
    ImageJPEG($Thumbnailgrafik2,  "../images/profil_medium/$SCHUELER_ID.jpg");
	$Thumbnailgrafik3 = ImageCreateTrueColor($Thumbnail3Breite, $Thumbnail3Hoehe);
    ImageCopyResized($Thumbnailgrafik3, $Originalgrafik, 0, 0, 0, 0, $Thumbnail3Breite, $Thumbnail3Hoehe, $OriginalBreite, $OriginalHoehe);
    ImageJPEG($Thumbnailgrafik3,  "../images/profil_small/$SCHUELER_ID.jpg");
}
sleep(5);
header('Location: ./update-show.php?edit='.$SCHUELER_ID.'&section=foto&updated=true');  
}

if($section=="passwort")
  {
  $pw_alt=$_POST["pw_alt"];
  $pw_neu=$_POST["pw_neu"];
  $pw_neu2=$_POST["pw_neu2"];
  
  $abfrage = "SELECT Passwort FROM user WHERE SCHUELER_ID='$SCHUELER_ID'";
  $ergebnis = mysql_query($abfrage);
  $row= mysql_fetch_object($ergebnis);
	if (strlen($pw_neu)>=8)
	  {
	  $pw=md5($pw_neu);//Prüfsumme generieren
	  $abfrage="UPDATE user SET Passwort='$pw' WHERE SCHUELER_ID='$SCHUELER_ID'";
      mysql_query($abfrage);
	  header('Location: ./update-show.php?edit=$SCHUELER_ID&section=passwort&updated=true');
	  }
	else
	  {
	  header('Location: ./update-show.php?edit='.$SCHUELER_ID.'&section=passwort&fehler=2');//zu kurzes PW -->Fehler
	  }
	}
if($section=="admin")
{

	$SCHUELER_ID=$_POST["id"];
	if(isset($_POST['mainadmin'])) { $mainadmin = "1"; }	else { $mainadmin = "0"; }	
	
	$sections = get_adminsections($SCHUELER_ID);
	foreach ($sections as $nr => $inhalt) {
		$name[$nr] = $inhalt['name'];
		$value[$nr] = $inhalt['value'];
		$descr[$nr] = $inhalt['descr'];
		
		if(isset($_POST[$name[$nr]])) 
			{ $entry[] = "1"; }	
		else 
			{ $entry[] = "0"; }			
	}	

	/*
	if(isset($_POST['mainadmin'])) { $mainadmin = "1"; }	else { $mainadmin = "0"; }	
	if(isset($_POST['start'])) { $start = "1"; }	else { $start = "0"; }	
	if(isset($_POST['kalender']))	{ $kalender = "1"; }	else { $kalender = "0"; }		
	if(isset($_POST['lehrer']))	{ $lehrer = "1"; }	else { $lehrer = "0"; }	
	if(isset($_POST['show']))	{ $show = "1"; }	else { $show = "0"; }		
	if(isset($_POST['berechtigungen']))	{ $berechtigungen = "1"; }	else { $berechtigungen = "0"; }
	if(isset($_POST['teams']))	{ $teams = "1"; }	else { $teams = "0"; }		
	if(isset($_POST['umfragen']))	{ $umfragen = "1"; }	else { $umfragen = "0"; }	
	if(isset($_POST['poebel']))	{ $poebel = "1"; }	else { $poebel = "0"; }		
	if(isset($_POST['news']))	{ $news = "1"; }	else { $news = "0"; }	
	if(isset($_POST['zungen']))	{ $zungen = "1"; }	else { $zungen = "0"; }	
	*/	
		
	/*$start=$_POST["start"];
	$kalender=$_POST["kalender"];
	$lehrer=$_POST["lehrer"];
	$show=$_POST["show"];
	$teams=$_POST["teams"];
	$umfragen=$_POST["umfragen"];
	$news=$_POST["news"];
	$zungen=$_POST["zungen"];
	$poebel=$_POST["poebel"];*/

	if ($mainadmin == "1") 
	{
		//mainadmin
		$abfrage1="UPDATE user SET admin=1 WHERE SCHUELER_ID='$SCHUELER_ID'";
		mysql_query($abfrage1);		
	
		//sections
		$abfrage = "SELECT * FROM admin WHERE SchuelerID='$SCHUELER_ID'";
		$ergebnis = mysql_query($abfrage);
		if (mysql_num_rows($ergebnis) == 0) {
		//wenn schüler nicht vorhanden, neu anlegen
			$eintrag = "INSERT INTO `admin` (
				`SchuelerID`,
				`start`,
				`kalender`,
				`lehrer`,
				`show`,
				`berechtigungen`,
				`teams`,
				`umfragen` ,
				`poebel` ,
				`news` ,
				`zungen`,
				`suchen`,
				`umfrageauswertung`,
				`poebeleintraege`
				)
				VALUES ('" . $SCHUELER_ID . "', '" . $entry[0] . "', '" . $entry[1] . "', '" . $entry[2] . "', '" . $entry[3] . "', '" . $entry[4] . "', '" . $entry[5] . "', '" . $entry[6] . "', '" . $entry[7] . "', '" . $entry[8] . "', '" . $entry[9] . "', '" . $entry[10] . "', '" . $entry[11] . "', '" . $entry[12] . "');";

			$eintragen = mysql_query($eintrag);

			if ( $eintragen == true )
			{
				header('Location: ./update-show.php?edit='.$SCHUELER_ID.'&section=admin&updated=true');
			}
			else
			{
				header('Location: ./update-show.php?edit='.$SCHUELER_ID.'&section=admin&updated=false');
			}
		}else{
			$abfrage = "UPDATE `admin` SET `start` = '".$entry[0]."', `kalender` = '".$entry[1]."', `lehrer` = '".$entry[2]."',  `show` = '".$entry[3]."', `berechtigungen` = '".$entry[4]."', `teams` = '".$entry[5]."', `umfragen` = '".$entry[6]."', `poebel` = '".$entry[7]."', `news` = '".$entry[8]."', `zungen` = '".$entry[9]."', `suchen` = '".$entry[10]."', `umfrageauswertung` = '".$entry[11]."', `poebeleintraege` = '".$entry[12]."' WHERE `SchuelerID` = ".$SCHUELER_ID." LIMIT 1;";		
			mysql_query($abfrage);
			header('Location: ./update-show.php?edit='.$SCHUELER_ID.'&section=admin&updated=true');
		}
	}
	else
	{
		$abfrage="UPDATE user SET admin=0 WHERE SCHUELER_ID='$SCHUELER_ID'";
		mysql_query($abfrage);		
		header('Location: ./update-show.php?edit='.$SCHUELER_ID.'&section=admin&updated=true');
	}
}		
 ?>
</div>
</body>
</html>
<?php
}
else
{
	header('Location: admin.php?berechtigung=0');
}

?>