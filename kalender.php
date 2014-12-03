<?php
include('sessiontest.inc.php');
function date_german2mysql($date) {
    $d    =    explode(".",$date);
    
    return    sprintf("%04d-%02d-%02d", $d[2], $d[1], $d[0]);
}//irgendwo im netz geklaut....

$aktion=$_GET["aktion"];
if(isset($_POST["thema"]))//Wenn Daten zum Eintragen über POST übergeben wurden--> Termin in DB schreiben
  {
  $thema=$_POST["thema"];
  $text=$_POST["text"];
  $datum=date_german2mysql($_POST["datum"]);
  $betrifft=$_POST["betrifft"];
  if ($bearbeiten=='j')
    {
	$news_id=$_POST['news_id'];
	$abfrage="SELECT * FROM news WHERE news_ID=".$news_id;
    $ergebnis=mysql_query($abfrage);
    $row=mysql_fetch_object($ergebnis);
    if ($row->poster_ID==$s_user_id)
	  $abfrage = "UPDATE news SET Thema='$thema', Text='$text', Bearbeitung=Bearbeitung+1, Bearbeitungszeit=CURRENT_TIMESTAMP";
	else
      $abfrage='';	
	}
  else  
    $abfrage = "INSERT INTO kalender (Poster_ID, Titel, Beschreibung,Betrifft,Datum) VALUES ('$s_user_id','$thema', '$text','$betrifft','$datum')";
  mysql_query($abfrage);
  header("Location: ./framework.php?id=index");
  }
  
elseif($aktion=="schreiben")//neuen Termin eintragen
{
?>
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

<script type="text/javascript">

function TestDatum( nTag, nMaxTag ) {
if( nTag >= 1 && nTag <= nMaxTag )
  return true
else
  return false
}

function IstSchaltjahr( nJahr ) {
if (( nJahr % 100 != 0 ) &&
  ( nJahr % 4 == 0 )
  ( nJahr % 400 == 0 )) {
   return true;
  }
return false;
}

function DatumGueltigEx( nTag, nMonat, nJahr ) {
var ok;
ok=false;

switch( nMonat ) {

  case 1:
   ok= TestDatum( nTag, 31 );
   break;
  case 2:
   if( IstSchaltjahr( nJahr ) ) {
    ok= TestDatum( nTag, 29 )
   } else {
    ok= TestDatum( nTag, 28 )
   }
   break;
  
  case 3:
   ok= TestDatum( nTag, 31 );
   break;
  case 4:
   ok= TestDatum( nTag, 30 );
   break;
  case 5:
   ok= TestDatum( nTag, 31 );
   break;
  case 6:
   ok= TestDatum( nTag, 30 );
   break;
  case 7:
   ok= TestDatum( nTag, 31 );
   break;
  case 8:
   ok= TestDatum( nTag, 31 );
   break;
  case 9:
   ok= TestDatum( nTag, 30 );
   break;
  case 10:
   ok= TestDatum( nTag, 31 );
   break;
  case 11:
   ok= TestDatum( nTag, 30 );
   break;
  case 12:
   ok= TestDatum( nTag, 31 );
   break;
}

return ok;
}

function DatumGueltig( strDatum )
{
var nTag, nMonat, nJahr;
var punkt1,punkt2;
var gueltig;
if (strDatum=="") return true;
gueltig=false
// auseinandernehmen
punkt1=strDatum.indexOf(".");
punkt2=punkt1+1+strDatum.indexOf(".",punkt1);
punkt2=strDatum.lastIndexOf(".")
nTag=strDatum.slice(0,punkt1);
nMonat=strDatum.slice(punkt1+1,punkt2)
nJahr=strDatum.slice(punkt2+1);
if (nJahr.length != 4 ) {
  alert("Ungültiges Datum! Bitte gib ein gültiges Datum ein (tt.mm.jjjj) ! " );
  return false;
}

gueltig=DatumGueltigEx( Number(nTag), Number(nMonat), Number(nJahr) );
if (gueltig==false){
 alert("Ungültiges Datum! Bitte gib ein gültiges Datum ein (tt.mm.jjjj) ! " );
 }

return gueltig;

}

function ButtonClick() {
date=document.getElementById("datum").value;
if(DatumGueltig(date)==true){
document.input.submit()
}
}

</script>
<?php
echo '<title>'.$main_site_title.'Termin erstellen</title>';
?>
<div class="profilkopf">Neuer Kalendereintrag</div>


<form action="kalender.php" name="input" id="input" method="post">
Titel:<br /><input name="thema" size="50" type="text"/><br /><br />
Datum (TT.MM.JJJJ):<br />
<input name="datum" type="text" id="datum"/><br /><br />
Betrifft: <br />
<select name="betrifft">
<option value="0">Alle</option>
<?php
$abfrage = "SELECT * FROM teams ORDER BY team_name";
$ergebnis = mysql_query($abfrage);
while ($row=mysql_fetch_object($ergebnis))
  {
  echo '<option value="o'.$row->TEAM_ID.'">'.$row->team_name.'</option>';
  }
  
$abfrage = "SELECT * FROM kurse ORDER BY fach_kurz";
$ergebnis = mysql_query($abfrage);
while ($row=mysql_fetch_object($ergebnis))
  {
  echo '<option value="k'.$row->FACH_ID.'">'.$row->fach_kurz.'</option>';
  }
?>
</select>
<br /><br />
Beschreibung: <br />
<textarea name="text" wrap="soft" cols="50" rows="20">
</textarea>
<br />

<input type="button" onClick="ButtonClick()" value="Termin erstellen" class="button"/></form>

</div>
<?php
}



elseif($aktion=='details')//Termindetails anzeigen
{
?>

<?php
$abfrage="SELECT * FROM kalender WHERE Termin_ID='".$_GET['kid']."'";
$ergebnis=mysql_query($abfrage);
$row=mysql_fetch_object($ergebnis);
echo '<title>'.$main_site_title.$row->Titel.'</title>';
?>
<div class="profilkopf">

<?php 
	
	echo $row->Titel.' ('.date('d.m.Y', strtotime($row->Datum)).')'; ?></div>
	<p style="font-weight:bold; color:#6A0000">Details:</p><p>
<?php echo $row->Beschreibung ?></p><br /><br />
<?php
$abfrage="SELECT Name_ganz FROM user WHERE SCHUELER_ID='".$row->poster_ID."'";
$ergebnis=mysql_query($abfrage);
$row=mysql_fetch_object($ergebnis);
echo "eingetragen von ".$row->Name_ganz;
?>
</div>
<?php
}



else//Monatsübersicht anzeigen
{
?>
<?php
function schaltjahr($jahr)
{
  if($jahr % 400 == 0)
    {
    return true;
    }
  elseif($jahr % 4 == 0 && $jahr % 100 != 0)
    {
    return true;
    }
  else
    {
    return false;
    }
}
echo '<title>'.$main_site_title.'Kalender</title>';
?>
<div class="profilkopf">Kalender<a href="framework.php?id=kalender&aktion=schreiben"><img src="./styles/img/neu_klein.png" class="neubutton_small"></a></div>
<?php
$m=$_GET['m'];
if ($m=='')
  $m=date("n");
  
$y=$_GET['y'];
if ($y=='')
  $y=date("Y");
  
$monate=array(1=>'Januar',2=>'Februar',3=>'März',4=>'April',5=>'Mai',6=>'Juni',7=>'Juli',8=>'August',9=>'September',10=>'Oktober', 11=>'November', 12=>'Dezember');
$wochentag=date("w",strtotime("$y-$m-01"));
if ($wochentag==0)
  $wochentag=7;
if(($m==1)or($m==3)or($m==5)or($m==7)or($m==8)or($m==10)or($m==12))
  $maxtag=31;
elseif (($m==4)or($m==6)or($m==9)or($m==11))
  $maxtag=30;
elseif (($m==2)and (schaltjahr($y)))
  $maxtag=29;
elseif (($m==2)and (!schaltjahr($y)))
  $maxtag=28;
  
  
$termine=array();
$i=0;
$abfrage="SELECT Name_ganz, `geb_d`, `geb_m`, Date(Concat(`geb_y`,'-',`geb_m`,'-',`geb_d`)) AS Gebutsdatum, ROUND((TO_DAYS(CONCAT($y,'-',$m,'-','1'))-To_Days(Concat(`geb_y`,'-',`geb_m`,'-', `geb_d`)))/365.25) AS age FROM `user` WHERE `geb_m`=$m";
$ergebnis=mysql_query($abfrage);
while($row=mysql_fetch_object($ergebnis))
  {
  $termine[$i]['betreff']='<img src="icon_birthday.gif"/> '.$row->Name_ganz. ' ('.$row->age.')';
  $termine[$i]['tag']=$row->geb_d;
  $i++;
  }
  $abfrage = "SELECT teams.TEAM_ID FROM teams,user WHERE user.Teams LIKE CONCAT('%',teams.team_name,'%') AND user.SCHUELER_ID='$s_user_id'";
  $ergebnis=mysql_query($abfrage);
  while ($row = mysql_fetch_object($ergebnis))
    {
	$gruppen2[]='Betrifft="o'.$row->TEAM_ID.'"';
    }
	
  $abfrage = "SELECT kurse.FACH_ID FROM kurse,user WHERE user.Kurse LIKE CONCAT('%',kurse.fach_kurz,'%') AND user.SCHUELER_ID='$s_user_id'";
  $ergebnis=mysql_query($abfrage);
  while ($row = mysql_fetch_object($ergebnis))
    {
	$gruppen2[]='Betrifft="k'.$row->FACH_ID.'"';
    }	
 
  
$gruppen2[]='Betrifft="0"'; 
$gruppenstring=implode (' OR ', $gruppen2);
$abfrage="SELECT Day(Datum)as Tag, Datum,Titel,Termin_ID FROM kalender WHERE Month(Datum)=$m AND Year(Datum)=$y AND ($gruppenstring)";  
$ergebnis=mysql_query($abfrage);
while($row=mysql_fetch_object($ergebnis))
  {
  $termine[$i]['betreff']='<a href="framework.php?id=kalender&aktion=details&amp;kid='.$row->Termin_ID.'">'.$row->Titel. '</a>';
  $termine[$i]['tag']=$row->Tag;;
  $i++;
  }
echo '<table class="kalenderkopf"><tr><td>';
if ($m==1)
  echo '<a href="framework.php?id=kalender&aktion=anzeigen&amp;m=12&amp;y='.($y-1).'">&lt;&lt; Dezember '.($y-1).'</a>';
else
  echo '<a href="framework.php?id=kalender&aktion=anzeigen&amp;m='.($m-1).'&amp;y='.($y).'">&lt;&lt; '.$monate[$m-1].' '.($y).'</a>'; 

echo '</td><td>';
echo '<h1>'.$monate[$m].' '.($y).'</h1>';
echo '</td><td>';
if ($m==12)
  echo '<a href="framework.php?id=kalender&aktion=anzeigen&amp;m=1&amp;y='.($y+1).'">Januar '.($y+1).' &gt;&gt;</a>';
else
  echo '<a href="framework.php?id=kalender&aktion=anzeigen&amp;m='.($m+1).'&amp;y='.($y).'">'.$monate[$m+1].' '.($y).' &gt;&gt;</a>'; 
  
echo '</td></tr></table>';  
echo "<table class='kalender' width='100%'>";
echo "<tr><th>Montag</th><th>Dienstag</th><th>Mittwoch</th><th>Donnerstag</th><th>Freitag</th><th>Samstag</th><th>Sonntag</th></tr>";
echo "<tr valign='top' min-height='100px'>";
for ($i=1; $i<$wochentag; $i++)
  {
  echo "<td class='kal_unsichtbar'></td>";
  };
$j=$wochentag;
for ($i=1; $i<=$maxtag; $i++)
  {
  if (($j % 7)==0)
    {
    echo '<td><div class="profilkategorie kleiner';
	
	if (date('Ymj')==($y.$m.$i)){
		echo ' inverted';
	}
	echo '">'.$i.'</div>';
	foreach($termine as $t)
	  {
	  if ($t['tag']==$i)
	    echo '<div class="kleiner">'.$t['betreff'].'</div>';
	  }
	echo "</td></tr>\n<tr valign='top'>";
	}
  else
    {
	echo '<td><div class="profilkategorie kleiner';
	
	if (date('Ymj')==($y.$m.$i)){
		echo ' inverted';
	}
	echo '">'.$i.'</div>';
	foreach($termine as $t)
	  {
	  if ($t['tag']==$i)
	    echo '<div class="kleiner">'.$t['betreff'].'</div>';
	  }
	echo "</td>";
	}
  $j++;	
  }
while (($j % 7)!=1)
  {
  echo "<td class='kal_unsichtbar'></td>";
  $j++;
  }  
  echo "</tr>";
echo "</table>";
?>
</div>
<?php
}
?>