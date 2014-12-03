<title><?php echo $main_site_title.'Startseite'; ?></title>	
<div class="profilkopf"><?php
if ((date("H") <= 16)&&(date("H") >= 5)) {
echo "Buon giorno, ";
} elseif (date("H") <= 19) {
echo "	Buona sera, ";
} else {
echo "Buona notte, ";
}

$abfrage="SELECT Geschlecht FROM user WHERE SCHUELER_ID='$s_user_id'";
$ergebnis = mysql_query($abfrage);
$row=mysql_fetch_object($ergebnis);

if ($row->Geschlecht=='w')
	echo 'mafiosa!';
else
	echo 'mafioso!';

?></div>
	<table class="startseite" width="100%">
	<tr width="100%"><td valign="top" width="50%">
	<?php
	  //neueste Forenbeiträge aus den Gruppen, in denen User Mitglied ist anzeigen
	  $gruppen=array();//array um Forenbeiträge zu suchen
	  $gruppen2=array();//Kalendereinträge suchen
	  $gruppen[]='Gruppen_ID="a0"';
	  $gruppen[]='Gruppen_ID="a1"';//jeder ist in a0 und a1 (Allgemein)
	  echo '<div class="profilkopf">Neuste Forenbeiträge</div><table class="altertable"><tr><th>Thema</th><th>Gruppe</th><th>Letzter Beitrag</th></tr>'; 
	  //Teams in denen User ist abfragen (o==Organisationsteams)
	  $abfrage = "SELECT teams.TEAM_ID FROM teams,user WHERE user.Teams LIKE CONCAT('%',teams.team_name,'%') AND user.SCHUELER_ID='$s_user_id'";
	  $ergebnis=mysql_query($abfrage);
	  while ($row = mysql_fetch_object($ergebnis))
		{
		$gruppen[]='Gruppen_ID="o'.$row->TEAM_ID.'"';
		$gruppen2[]='Betrifft="o'.$row->TEAM_ID.'"';
		}
	  //Kurse in denen User ist abfragen
	  $abfrage = "SELECT kurse.FACH_ID FROM kurse,user WHERE user.Kurse LIKE CONCAT('%',kurse.fach_kurz,'%') AND user.SCHUELER_ID='$s_user_id'";
	  $ergebnis=mysql_query($abfrage);
	  while ($row = mysql_fetch_object($ergebnis))
		{
		$gruppen[]='Gruppen_ID="k'.$row->FACH_ID.'"';
		$gruppen2[]='Betrifft="k'.$row->FACH_ID.'"';
		}	

		
	  $gruppenstring=implode (' OR ', $gruppen);//String für SQL-abfrage zusammensetzen
	  $abfrage = "SELECT * FROM foren_themen WHERE $gruppenstring ORDER BY letzter_Beitrag_Zeit DESC LIMIT 0,5";
	  $ergebnis = mysql_query($abfrage);
	  $linecounter=0;
	  while ($row = mysql_fetch_object($ergebnis))//Ausgabe der neuesten Beiträge
		{
		if($linecounter % 2 == 0){
			$rowstyle="style='background-color:#FFFFFF;'";
		}
		else{
			$rowstyle="style='background-color:#D6D6D6;'";
		}
		
		echo '<tr '.$rowstyle.'><td><a href="framework.php?id=thema&tid='.$row->Themen_ID.'">'.$row->Thema.'</a></td>';
		$gtyp=substr($row->Gruppen_ID,0,1);//Trennen in Gruppentyp und ID (Team-ID bzw. Kurs-ID)
		$gid=substr($row->Gruppen_ID,1);
		if ($gtyp=='a')
		  echo '<td><a href="framework.php?id=forum">Allgemein</a></td>';
		elseif ($gtyp=='o')//Orgateam-->Teamnamen abfragen
		  {
		  $abfrage2="SELECT team_name FROM teams WHERE TEAM_ID='$gid'";
		  $ergebnis2 = mysql_query($abfrage2);
		  $row2 = mysql_fetch_object($ergebnis2);
		  echo '<td><a href="framework.php?id=gruppe&typ=o&amp;gid='.$gid.'">'.$row2->team_name.'</a></td>';
		  }
		elseif ($gtyp=='k')//Kurs -->Kursnamen abfragen
		  {
		  $abfrage2="SELECT fach_lang FROM kurse WHERE FACH_ID='$gid'";
		  $ergebnis2 = mysql_query($abfrage2);
		  $row2 = mysql_fetch_object($ergebnis2);
		  echo '<td><a href="framework.php?id=gruppe&typ=k&amp;gid='.$gid.'">'.$row2->fach_lang.'</a></td>';
		  }
		  
		///// REDUNDANZ-FIX
		  $letzter_beitrag_obj = mysql_query('SELECT * FROM foren_beitraege WHERE Themen_ID = ' . $row->Themen_ID .' ORDER BY Zeit DESC');
		  $letzter_beitrag_obj = mysql_fetch_object($letzter_beitrag_obj);
		  $_letzter_beitrag_user = $letzter_beitrag_obj->Poster_ID;
		  $_letzter_beitrag_id = $letzter_beitrag_obj->Beitrags_ID;
		  
		  $abfrage2 = "SELECT Name_ganz FROM user WHERE SCHUELER_ID='$_letzter_beitrag_user'";
		  $ergebnis2 = mysql_query($abfrage2);
		  $row2 = mysql_fetch_object($ergebnis2);
		  
		  
		  $beitrag = mysql_query('SELECT * FROM foren_beitraege WHERE Beitrags_ID = ' . $_letzter_beitrag_id . ' LIMIT 1');
		  $beitrag = mysql_fetch_object($beitrag);  
		  
		
		
		$abfrage2="SELECT Name_ganz FROM user WHERE SCHUELER_ID='".$beitrag->Poster_ID."'";
		$ergebnis2 = mysql_query($abfrage2);
		$row2 = mysql_fetch_object($ergebnis2);
		
		
		
		
		echo '<td>'.humanTime($beitrag->Zeit).' von '.$row2->Name_ganz.'</td>';
		$linecounter=$linecounter+1;
		}
	  echo '</table>';	

	  
	?>
	<br />

	<div class="profilkopf">Kalender<a href="framework.php?id=kalender&aktion=anzeigen"><img src="./styles/img/view_klein.png" class="neubutton_small"></a><a href="framework.php?id=kalender&aktion=schreiben"><img src="./styles/img/neu_klein.png" class="neubutton_small"></a><br /></div>
	
	<?php
	$termine=array();
	$i=0;
	//Geburtstage in nächsten 2 Wochen abfragen
	$abfrage="SELECT Name_ganz, `geb_d`, `geb_m`, Date(Concat(`geb_y`,'-',`geb_m`,'-',`geb_d`)) AS Gebutsdatum, ROUND((TO_DAYS(CURDATE())-To_Days(Concat(`geb_y`,'-',`geb_m`,'-', `geb_d`)))/365.25) AS age FROM `user` WHERE ((TO_DAYS(Date(Concat(YEAR(now()),'-',`geb_m`,'-',`geb_d`)))-TO_DAYS(CURDATE()))>=0 AND (TO_DAYS(Date(Concat(YEAR(now()),'-',`geb_m`,'-',`geb_d`)))-TO_DAYS(CURDATE()))<=14) OR ((TO_DAYS(Date(Concat(YEAR(now())+1,'-',`geb_m`,'-',`geb_d`)))-TO_DAYS(CURDATE()))>=0 AND (TO_DAYS(Date(Concat(YEAR(now())+1,'-',`geb_m`,'-',`geb_d`)))-TO_DAYS(CURDATE()))<=14)";
	$ergebnis=mysql_query($abfrage);
	
	while($row=mysql_fetch_object($ergebnis))
	  {
	  $termine[$i]['betreff']='<img src="icon_birthday.gif"/> '.$row->Name_ganz. ' ('.$row->age.')';
	  $termine[$i]['tage']=ceil(((strtotime(date("Y",time()).'-'.$row->geb_m.'-'.$row->geb_d))-time())/86400);
	  if ($termine[$i]['tage']<0)
		$termine[$i]['tage']=ceil((strtotime(date("Y",time()+(86400*365)).'-'.$row->geb_m.'-'.$row->geb_d)-time())/86400);
	  $i++;
	  }
	$gruppen2[]='Betrifft="0"';//Gruppenarray um betrifft=0 (Termine, die alle betreffen) ergänzen
	$gruppenstring=implode (' OR ', $gruppen2);//analog zu Foren-->Termine für Nutzer abfragen
	$abfrage="SELECT Datum,Titel,Termin_ID FROM kalender WHERE ((TO_DAYS(Datum)-TO_DAYS(CURDATE()))>=0 AND (TO_DAYS(Datum)-TO_DAYS(CURDATE()))<=14) AND ($gruppenstring)";  
	$ergebnis=mysql_query($abfrage);
	echo '<table class="altertable"><tr><th>Datum</th><th>Betreff</th></tr>'; 
	while($row=mysql_fetch_object($ergebnis))
	  {
	  $termine[$i]['betreff']='<a href="framework.php?id=kalender&aktion=details&amp;kid='.$row->Termin_ID.'">'.$row->Titel. '</a>';
	  $termine[$i]['tage']=ceil(((strtotime($row->Datum)-time())/86400));
	  $i++;
	  }
	if(count($termine>0))//wenn Termine gefunden wurden
	  {
	  $zaehler=array();//Array zaehler[TAG]=Anzahl_Termine_an_diesem_Tag
	  foreach($termine as $t)
		{
		$zaehler[$t['tage']]++;
		}
	  }
	$linecounter=0;
	if($zaehler[0]>0)//wenn heute Termine-->Ausgeben e
	  {
	  $linecounter++;
	  if ( $linecounter % 2 == 0)
		echo "<tr style='background-color: #D6D6D6;'>";
	  else 
		echo "<tr>";
	  echo "<td>Heute</td><td>";
	  foreach ($termine as $t)
		{
		if ($t['tage']==0)
		  echo $t['betreff'].'<br />';
		}
		echo "</td></tr>";
	  }  
	 if($zaehler[1]>0)
	  {
	  $linecounter++;
	  if ( $linecounter % 2 == 0)
		echo "<tr style='background-color: #D6D6D6;'>";
	  else 
		echo "<tr>";
	  echo "<td>Morgen</td><td>";
	  foreach ($termine as $t)
		{
		if ($t['tage']==1)
		  echo $t['betreff'].'<br />';
		}
		echo "</td></tr>";
	  } 
	 if($zaehler[2]>0)
	  {
	  $linecounter++;
	  if ( $linecounter % 2 == 0)
		echo "<tr style='background-color: #D6D6D6;'>";
	  else 
		echo "<tr>";
	  echo "<td>Übermorgen</td><td>";
	  foreach ($termine as $t)
		{
		if ($t['tage']==2)
		  echo $t['betreff'].'<br />';
		}
		echo "</td></tr>";
	  }  
	  
	for ($i=3; $i<=14;$i++)
	{
	 if($zaehler[$i]>0)
	  {
	  $linecounter++;
	  if ( $linecounter % 2 == 0)
		echo "<tr style='background-color: #D6D6D6;'>";
	  else 
		echo "<tr>";
	  echo "<td>".date("d.m.Y",time()+$i*86400)."</td><td>";
	  foreach ($termine as $t)
		{
		if ($t['tage']==$i)
		  echo $t['betreff'].'<br />';
		}
		echo "</td></tr>";
	  }
	}
	echo "</table>";
	?>

		


	</td>


	<td width='50%' valign="top"  class="frameless">
	<div class="profilkopf">Mitteilungen<a href="framework.php?id=news&aktion=schreiben"><img src="./styles/img/neu_klein.png" class="neubutton_small"></a></div>
	
	<?php
	//neueste 5 Mitteilungen anzeigen
	$abfrage="SELECT Thema,Text,Name_ganz,Postzeit,poster_ID,news_ID, Bearbeitung FROM news,user WHERE SCHUELER_ID=Poster_ID ORDER BY Postzeit DESC LIMIT 0,5";
	$ergebnis=mysql_query($abfrage);
	echo '<table class="messagetable">';
	while($row=mysql_fetch_object($ergebnis))
	  {
	  if ($row->Bearbeitung=='0')
		$edited='';
	  else
		$edited=' ('. $row->Bearbeitung. ' mal bearbeitet)';
		
	  if ($s_user_id==$row->poster_ID)
		$edit='<a href="framework.php?id=news&aktion=bearbeiten&newsid='.$row->news_ID.'"><img src="./styles/img/bearbeiten_klein.png" class="editbutton_small"></a>';
	  else
		$edit='';  
	  echo '<tr class="messageheader"><td>'.$row->Thema.$edit.'</td></tr><tr class="messagebody"><td>'.$row->Text.'</td></tr><tr class="messagefooter"><td>'.humanTime($row->Postzeit).' von '.$row->Name_ganz.$edited.'</td></tr><tr><td></td></tr>';
	  }
	 echo '</table>';
	?>

	</td>

	</tr></table>
