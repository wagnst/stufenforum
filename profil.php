<?php
$schuelerid=$_GET['schuelerid'];
if(!isset($_GET['schuelerid']))//wenn keine Schüler_ID übergeben-->eigenes Profil anzeigen
  {
  $schuelerid=$s_user_id;
  }
$abfrage = "SELECT * FROM user WHERE SCHUELER_ID='$schuelerid'";
$ergebnis = mysql_query($abfrage);
$anzahl = mysql_num_rows($ergebnis);
$row = mysql_fetch_object($ergebnis);
$Name_ganz=$row->Name_ganz;
$vorname=$row->Vorname;
$userid=$row->SCHUELER_ID;
$plan=$row->Plan;
$geb=$row->geb_d.'.'.$row->geb_m.'.'.$row->geb_y;
$__user = $row;
$persoenliches = "";
$mag = $row->mag;
$mag_nicht = $row->mag_nicht;
$musik = $row->Lieblingsmusik;
$filme = $row->Lieblingsfilme;
$hobbies = $row->Hobbies;
$sendungen = $row->Lieblingssendungen;
$buecher = $row->Lieblingsbuecher;
if ($row->geb_d==0)
  {
  $geb="";
  }

if ($mag != "")
	$persoenliches.='<tr><td width="150px">Ich mag:</td><td>'.$mag.'</td></tr>';


if ($mag_nicht != "")
	$persoenliches.='<tr><td width="150px">Ich mag nicht:</td><td>'.$mag_nicht.'</td></tr>';


if ($hobbies != "")
	$persoenliches.='<tr><td width="150px">Meine Hobbies:</td><td>'.$hobbies.'</td></tr>';


if ($filme != "")
	$persoenliches.='<tr><td width="150px">Lieblingsfilme:</td><td>'.$filme.'</td></tr>';


if ($sendungen != "")
	$persoenliches.='<tr><td width="150px">Lieblingssendungen:</td><td>'.$sendungen.'</td></tr>';
	
if ($buecher != "")
	$persoenliches.='<tr><td width="150px">Lieblingsbücher:</td><td>'.$buecher.'</td></tr>';
	
if ($musik != "")
	$persoenliches.='<tr><td width="150px">Lieblingsmusik:</td><td>'.$musik.'</td></tr>';
  
  
//KONTAKT-Daten zu HTML zusammenbauen

$e_mail=$row->EMail;
if ($e_mail=="")
  {
  }
else
  {
  $kontakt= '<tr><td width="150px">E-Mail:</td><td><a href="mailto:'.$e_mail.'">'.$e_mail.'</a></td></tr>';
  }  

$icq=$row->ICQ;
if ($icq==0)
  {
  }
else
  {
  $kontakt.='<tr><td width="150px">ICQ:</td><td><img src="http://web.icq.com/whitepages/online?icq='.$icq.'&img=27" />'.$icq.'</td></tr>';
  }  

$tel=$row->Telefon;
if ($tel=="")
  {
  
  }
else
  {
  $kontakt.='<tr><td width="150px">Telefon:</td><td>'.$tel.'</td></tr>';
  }  

$handy=$row->Handy;
if ($handy=="")
  {
  }
else
  {
  $kontakt.='<tr><td width="150px">Handy:</td><td>'.$handy.'</td></tr>';
  }  
  
  
if ($row->Strasse=="")
  {
  }
else
  {
  $kontakt.='<tr><td width="150px">Adresse:</td><td>'.$row->Strasse."<br />".$row->PLZ." ".$row->Ort.'</td></tr>';
  }
  
  
if ($kontakt=='')
  {
  $kontakt='<tr><td>'.$vorname.' hat keine Kontaktdaten angegeben</td></tr>';
  }
  
if (file_exists("./images/profil/".$userid.".jpg"))//wenn Profilbild existiert, dieses übernehemn, andernfalls standard anzeigen
  {
  $profilbild="./images/profil/".$userid.".jpg";
  }
else
  {
  $profilbild="./images/profil/default.jpg";
  }
  
$abfrage = "SELECT Kurse FROM user WHERE SCHUELER_ID='$s_user_id'";//Kurse des angemeldeten nutzers
$ergebnis = mysql_query($abfrage);
$row = mysql_fetch_object($ergebnis);
$eigenekurse=$row->Kurse;
if ($eigenekurse!='')
  {
  $eigenekurse=explode(";",$eigenekurse);
  }
else
  {
  $eigenekurse=NULL;
  }  

$abfrage = "SELECT Kurse FROM user WHERE SCHUELER_ID='$schuelerid'";//Kurse des besuchten PRofils
$ergebnis = mysql_query($abfrage);
$row = mysql_fetch_object($ergebnis);
$kurse=$row->Kurse;
if ($kurse!='')
  {
  $kurse=explode(";",$kurse);
  }
else
  {
  $kurse=NULL;
  }  
if((count($eigenekurse)>0)and(count($kurse)>0)and($eigenekurse!=NULL)and($kurse!=NULL))//gemeinsame Kurse bestimmen, falls möglich
  {
  foreach($eigenekurse as $ek)
   {
   foreach($kurse as $k)
     {
	 if ($k==$ek)
	   {
	   $gemeinsame_kurse[]=$k;
	   }
	 }
   }
  }
else
  {
  $gemeinsame_kurse=NULL;
  } 
  
?>

<title><?php echo $main_site_title.$Name_ganz; ?></title>

<?php
echo '<div class="profilkopf">'.$Name_ganz;
if ($schuelerid==$s_user_id)
	echo '<a href="framework.php?id=profiledit"><img src="./styles/img/bearbeiten_klein.png" class="neubutton_small"></a>';
echo '<a href="framework.php?id=poebel&aktion=anschauen&amp;schuelerid='.$schuelerid.'"><img src="./styles/img/view_klein.png" class="neubutton_small"></a></div>';
echo '<table class="profiletable">';
echo '<tr><td class="profiletab" width="200px"><div class="profileimage" style="background-image: url('.$profilbild.');" ></div>';

echo '</td><td class="breit"><table class="altertable" style="border: 0px">';
echo '<tr><th>Gemeinsame Kurse</th></tr><tr><td style="border-left: 1px solid #A0A0A0; border-bottom: 1px solid #A0A0A0;">';
$anzahl=count($gemeinsame_kurse);


if ($schuelerid==$s_user_id)
  {
  echo "Das bist du.";
  }
else
{

 
  if ($anzahl>0)
    {
    $i=0;
    foreach($gemeinsame_kurse as $k)
      {
	  $abfrage = "SELECT FACH_ID FROM kurse WHERE fach_kurz='$k'";
      $ergebnis = mysql_query($abfrage);
      $row = mysql_fetch_object($ergebnis);
	  $f_id=$row->FACH_ID;
	  echo '<a href="framework.php?id=gruppe&typ=k&amp;gid='.$f_id.'">'.$k."</a>";
	  $i++;
	  if($i!=$anzahl)
	    {
	    echo "; ";
	    }
	  }	
    }
  else
    {
    echo "Keine gemeinsamen Kurse gefunden.";
    } 
  }
  
echo '</td></tr><tr><th>Persönliches</th></tr><tr><td style="border-left: 1px solid #A0A0A0; border-bottom: 1px solid #A0A0A0;">';
echo '<table class="">';
if ($geb!='')
  echo '<tr><td width="150px">Geburtstag:</td><td>'.$geb.'</td></tr>';
echo $persoenliches;

if (($geb=='') and ($hobbies=='') and ($musik=='') and ($buecher=='') and ($filme=='') and ($sendungen=='') and ($mag=='') and ($mag_nicht==''))
  echo '<tr><td class="">'.$vorname.' hat noch nichts eingetragen.</td></tr>';
echo'</table>';
echo'</td></tr><tr><th>Kontakt</th></tr><tr><td style="border-left: 1px solid #A0A0A0; border-bottom: 1px solid #A0A0A0;">';
echo '<table class="">';
echo $kontakt;
echo'</table></td></tr>';
echo'</td></tr><tr><th>Kurse</th></tr><tr><td style="border-left: 1px solid #A0A0A0;">';
$abfrage = "SELECT Kurse FROM user WHERE SCHUELER_ID='$schuelerid'";
$ergebnis = mysql_query($abfrage);
$row = mysql_fetch_object($ergebnis);
$kurse=$row->Kurse;
if ($kurse!='')
  {
  $kurse=explode(";",$kurse);
  }
if ((count($kurse)>0) and ($kurse!='') and ($kurse!=NULL))
  {
  echo "<ul>";
  foreach($kurse as $k)
    {
	$abfrage2 = "SELECT * FROM kurse WHERE fach_kurz='$k'";
	$ergebnis2 = mysql_query($abfrage2);
	$row2 = mysql_fetch_object($ergebnis2);
	echo '<li><a href="framework.php?id=gruppe&typ=k&amp;gid='.$row2->FACH_ID.'">'.$row2->fach_lang.'</a></li>';
	}
  echo "</ul>";
  }
else
  echo "<p>$vorname hat noch keine Kurse angegeben.</p>"; 
echo'</td></tr>';
echo "</table></td></tr></table>";
?>
</div>
