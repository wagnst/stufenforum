<title>
<?php
echo $main_site_title."Forum";
?>
</title>
<div class="profilkopf">Diskussionen</div>

<div class="profilkopf">Schule/Organisation

<?php
  $gid='0';
  $typ='a';
  echo '<a href="framework.php?id=thema_neu&gid='.$gid.'&amp;typ='.$typ.'"><img src="./styles/img/neu_klein.png" class="neubutton_small"></a></div>';
  $abfrage = "SELECT * FROM foren_themen WHERE Gruppen_ID='$typ$gid' ORDER BY letzter_Beitrag_Zeit DESC";
  $ergebnis = mysql_query($abfrage);
  $anzahl = mysql_num_rows($ergebnis);
  if ($anzahl>0)
    {
	echo '<table class="altertable forumtable"><tr><th width="300px">Thema</th><th width="200px">Anzahl der Beiträge</th><th>Letzter Beitrag</th></tr>';
	$linecounter=0;
    while($row = mysql_fetch_object($ergebnis))
	  {
	  if ($row->Anzahl_Beitraege==1)
	    $ab='1 Beitrag';
	  else
	    $ab=$row->Anzahl_Beitraege.' Beiträge';
	  echo '<tr';
	  if ($linecounter % 2 ==1)
		echo ' style="background-color:#D6D6D6"';
	  echo '><td><a href="framework.php?id=thema&tid='.$row->Themen_ID.'">'.$row->Thema.'</a></td><td>'.$row->Anzahl_Beitraege.'</td>';

	  $letzter_beitrag_obj = mysql_query('SELECT * FROM foren_beitraege WHERE Themen_ID = ' . $row->Themen_ID .' ORDER BY Zeit DESC');
	  $letzter_beitrag_obj = mysql_fetch_object($letzter_beitrag_obj);
	  $_letzter_beitrag_user = $letzter_beitrag_obj->Poster_ID;
	  $_letzter_beitrag_id = $letzter_beitrag_obj->Beitrags_ID;
	  
	  $abfrage2 = "SELECT Name_ganz FROM user WHERE SCHUELER_ID='$_letzter_beitrag_user'"; 
	  $ergebnis2 = mysql_query($abfrage2);
	  $row2 = mysql_fetch_object($ergebnis2);
	  
	  
	  $beitrag = mysql_query('SELECT * FROM foren_beitraege WHERE Beitrags_ID = ' . $_letzter_beitrag_id . ' LIMIT 1');
	  $beitrag = mysql_fetch_object($beitrag);
	  
	  echo '<td>'.humanTime($beitrag->Zeit).' von '.$row2->Name_ganz.' </td></tr>';
	  $linecounter++;
	  }
	  echo '</table>';
    }
  else
    echo '<div class="suchergebnis">Keine Diskussionsthemen</div>';   
  	
?>
<br />

  <div class="profilkopf">Klatsch und Tratsch

<?php
  $gid='1';
  echo '<a href="framework.php?id=thema_neu&gid='.$gid.'&amp;typ='.$typ.'"><img src="./styles/img/neu_klein.png" class="neubutton_small"></a></div>';
  $abfrage = "SELECT * FROM foren_themen WHERE Gruppen_ID='$typ$gid' ORDER BY letzter_Beitrag_Zeit DESC";
  $ergebnis = mysql_query($abfrage);
  $anzahl = mysql_num_rows($ergebnis);
  if ($anzahl>0)
    {
	echo '<table class="altertable forumtable"><tr><th width="300px">Thema</th><th width="200px">Anzahl der Beiträge</th><th>Letzter Beitrag</th></tr>';
	$linecounter=0;
    while($row = mysql_fetch_object($ergebnis))
	  {
	  if ($row->Anzahl_Beitraege==1)
	    $ab='1 Beitrag';
	  else
	    $ab=$row->Anzahl_Beitraege.' Beiträge';
	  echo '<tr';
	  if ($linecounter % 2 ==1)
		echo ' style="background-color:#D6D6D6"';
	  echo '><td><a href="framework.php?id=thema&tid='.$row->Themen_ID.'">'.$row->Thema.'</a></td><td>'.$row->Anzahl_Beitraege.'</td>';

	  $letzter_beitrag_obj = mysql_query('SELECT * FROM foren_beitraege WHERE Themen_ID = ' . $row->Themen_ID .' ORDER BY Zeit DESC');
	  $letzter_beitrag_obj = mysql_fetch_object($letzter_beitrag_obj);
	  $_letzter_beitrag_user = $letzter_beitrag_obj->Poster_ID;
	  $_letzter_beitrag_id = $letzter_beitrag_obj->Beitrags_ID;
	  
	  $abfrage2 = "SELECT Name_ganz FROM user WHERE SCHUELER_ID='$_letzter_beitrag_user'"; 
	  $ergebnis2 = mysql_query($abfrage2);
	  $row2 = mysql_fetch_object($ergebnis2);
	  
	  
	  $beitrag = mysql_query('SELECT * FROM foren_beitraege WHERE Beitrags_ID = ' . $_letzter_beitrag_id . ' LIMIT 1');
	  $beitrag = mysql_fetch_object($beitrag);
	  
	  echo '<td>'.humanTime($beitrag->Zeit).' von '.$row2->Name_ganz.' </td></tr>';
	  $linecounter++;
	  }
	  echo '</table>';
    }
  else
    echo '<div class="suchergebnis">Keine Diskussionsthemen</div>';   
  	
?>



