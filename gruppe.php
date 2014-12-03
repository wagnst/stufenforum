<?php
$gid=$_GET['gid'];
$typ=$_GET['typ'];
if(!isset ($_GET['typ'])||!isset ($_GET['gid']))
  {
  header("Location: ./framework.php?id=index");
  }
if($typ=="k") //kurs
  {
  $abfrage = "SELECT * FROM kurse WHERE FACH_ID='$gid'";
  $ergebnis = mysql_query($abfrage);
  $row = mysql_fetch_object($ergebnis);
  $anzahl = mysql_num_rows($ergebnis);
  if ($anzahl==0)
    {
	header("Location: ./framework.php?id=index");
	}
  $gruppenname=$row->fach_lang;
  $gruppe_kurz=$row->fach_kurz;
  
  $abfrage = "SELECT SCHUELER_ID FROM user WHERE Kurse LIKE '%$gruppe_kurz%' AND SCHUELER_ID='$s_user_id' ORDER BY Nachname";//überprüfen ob man selbst mitglied ist
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
  $anzahl = mysql_num_rows($ergebnis);
  if ($anzahl==0)
    {
	header("Location: ./framework.php?id=index");
	}
  $gruppenname=$row->team_name;
  $gruppe_kurz=$gruppenname;
  $abfrage = "SELECT SCHUELER_ID FROM user WHERE Teams LIKE '%$gruppenname%' AND SCHUELER_ID='$s_user_id' ORDER BY Nachname";//überprüfen ob man selbst mitglied ist
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
 else header("Location: ./framework.php?id=index");

echo '<div class="profilkopf">'.$gruppenname.'</div>';
if ($mitglied==TRUE)
  echo '<p>Du bist Mitglied dieser Gruppe.</p>';
else
  echo '<p>Du bist nicht Mitglied dieser Gruppe.</p>';  
echo '<table class="altertable"><tr><th>Mitglieder</th></tr><tr><td style="padding: 10px 0px !important; border-bottom: 1px solid #A0A0A0"><table width="100%" style="border-spacing:0px;"><tr>';
if ($typ=='k')
  $abfrage = "SELECT Name_ganz,SCHUELER_ID FROM user WHERE Kurse LIKE '%$gruppe_kurz%' ORDER BY Nachname";
elseif ($typ=='o')
  $abfrage = "SELECT Name_ganz,SCHUELER_ID FROM user WHERE Teams LIKE '%$gruppenname%' ORDER BY Nachname";  
$ergebnis = mysql_query($abfrage);
$anzahl = mysql_num_rows($ergebnis);
if ($anzahl>0)
  {
  $i=1;
  while($row = mysql_fetch_object($ergebnis))
    {
  /*  if ($i % 5 == 0)
      echo "<tr>";*/
    if (file_exists("./images/profil/".$row->SCHUELER_ID.".jpg"))
      {
      $profilbild='/images/profil/'.$row->SCHUELER_ID.'.jpg';
      }
    else
      {
      $profilbild='/images/profil/default.jpg';
      }
    echo '<td style="text-align:center;"><div class="profillink_klein"><a class="nohlimg" href="framework.php?id=profil&amp;schuelerid='.$row->SCHUELER_ID.'"><span><div class="profileimage_small_flex" style="background-image: url('.$profilbild.');" ></div></span></a><br /><a class="nohl" href="framework.php?id=profil&schuelerid='.$row->SCHUELER_ID.'">'.$row->Name_ganz."</a></div></td>";
    if ($i % 7 == 0)
      echo "</tr><tr>";
    $i++;	
    }
  if ($i % 5 != 0)
    {
    for ($i; $i %5>0; $i++)
      echo "<td></td>";
    echo "</tr>";
    }
  }
else
  {
  echo '<tr><td class="suchergebnis">Keine Mitglieder</td></tr>';
  }  

?>
</table>
</td></tr>
<title>
<?php
	echo $main_site_title.$gruppenname;
?>
</title>
<?php
if ($mitglied==TRUE)
  {
?>




<tr><th>Diskussionen
<?php
  //alle Diskussionen der Gruppe abfragen
  echo '<a href="framework.php?id=thema_neu&gid='.$gid.'&amp;typ='.$typ.'"><img src="./styles/img/neu_klein.png" class="neubutton_small" style="margin-top:1px"></a></th></tr><tr><td style="border-bottom: 1px solid #A0A0A0">';
  $abfrage = "SELECT * FROM foren_themen WHERE Gruppen_ID='$typ$gid' ORDER BY letzter_Beitrag_Zeit DESC";
  $ergebnis = mysql_query($abfrage);
  $anzahl = mysql_num_rows($ergebnis);
  if ($anzahl>0)
    {
    while($row = mysql_fetch_object($ergebnis))
	  {
	  if ($row->Anzahl_Beitraege==1)
	    $ab='1 Beitrag';
	  else
	    $ab=$row->Anzahl_Beitraege.' Beiträge';
	  echo '<div class="suchergebnis"><b><a href="framework.php?id=thema&tid='.$row->Themen_ID.'">'.$row->Thema.' ('.$ab.')</a></b>';
	  $abfrage2 = "SELECT Name_ganz FROM user WHERE SCHUELER_ID='$row->letzter_Beitrag_ID'";
	  $ergebnis2 = mysql_query($abfrage2);
	  $row2 = mysql_fetch_object($ergebnis2);
	  echo '<div class="themendetails"> letzter Beitrag von '.$row2->Name_ganz.' ('.humanTime($row->letzter_Beitrag_Zeit).')</div></div>';
	  }
    }
  else
    echo '<div class="suchergebnis">Keine Diskussionsthemen</div>';   
  	
?>
</td></tr>
<br />
<?php if ($typ=='o') //bei orga-teams nachrichten von andren anzeigen
{?>
  <tr><th>Nachrichten von anderen</th></tr><tr><td>
<?php
  $abfrage = "SELECT * FROM kontakt_nachrichten WHERE Gruppen_ID='$gid' ORDER BY Zeit DESC";
  $ergebnis = mysql_query($abfrage);
  $anzahl = mysql_num_rows($ergebnis);
  if ($anzahl>0)
    {
    while($row = mysql_fetch_object($ergebnis))
	  {	  
	  $abfrage2 = "SELECT Name_ganz FROM user WHERE SCHUELER_ID='$row->Poster_ID'";
	  $ergebnis2 = mysql_query($abfrage2);
	  $row2 = mysql_fetch_object($ergebnis2);
	  echo '<div class="suchergebnis"> <div class="themendetails"> Nachricht von '.$row2->Name_ganz.' ('.humanTime($row->Zeit).')</div>'.$row->Beitrag;

	  echo '</div>';
	  }
    }
  else
    echo '<div class="suchergebnis">Keine Nachrichten</div>';
  echo '</td></tr>';
}	
  }	
?>
</table>


