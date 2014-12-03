<?php
	echo '<title>'.$main_site_title.'Lehrersprüche</title>';
?>
<script src="sorttable.js"></script>
<div class="profilkopf">Lehrersprüche</div>
<table class="altertable sortable">
<tr class="tabelle_kopf"><th>Name</th><th>Anzahl</th><th>letzter Eintrag</th></tr>
<?php
  $abfrage = "SELECT * FROM lehrer_neu ORDER BY Nachname";
  $ergebnis = mysql_query($abfrage);
  $linecounter=0;
  
  while($row = mysql_fetch_object($ergebnis))
    {
	$abfrage2 = "SELECT * FROM lehrer_eintraege_neu WHERE LEHRER_ID=$row->LEHRER_ID ORDER BY Zeit DESC";
	$ergebnis2 = mysql_query($abfrage2);
	$row2 = mysql_fetch_object($ergebnis2);
	$aendern = "UPDATE lehrer_neu Set letzter_Eintrag_Zeit='".$row2->Zeit."' WHERE LEHRER_ID = '".$row->LEHRER_ID."'";
	mysql_query($aendern); 
	
  $linecounter=0;
	$id=$row->LEHRER_ID;
	if($row->letzter_Eintrag_Zeit!="0000-00-00 00:00:00")
	  {
	  $letzter_eintrag=humanTime($row->letzter_Eintrag_Zeit);
	  }
	else
      {
	  $letzter_eintrag="---";
	  }	  
	
	echo '<tr';
	if ($linecounter % 2 == 1)
		echo ' style="background-color: #D6D6D6"';
	echo '><td><a class="nohl" href="framework.php?id=lehrer&aktion=anschauen&amp;lehrerid='.$id.'">'. $row->Nachname.'</a></td><td>'.$row->Eintraege.'</td><td>'.$letzter_eintrag.'</td> </tr>';   
	$linecounter++;
	}
?>
</table>