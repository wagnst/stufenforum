
<title><?php echo $main_site_title; ?>Pöbelbuch</title>
<script src="sorttable.js"></script>
<div class="profilkopf">Pöbelbuch</div>
<table class="altertable sortable">
<tr><th></th><th>Name</th><th>Anzahl</th><th>letzter Eintrag</th></tr>
<?php
  $abfrage = "SELECT Name_ganz, SCHUELER_ID FROM user WHERE DELETED=0 ORDER BY Nachname";
  $ergebnis = mysql_query($abfrage);
  $linecounter=0;
  while($row = mysql_fetch_object($ergebnis))
    {
	$abfrage2 = "SELECT letzter_eintrag, anzahl_eintraege FROM  poebel_eigenschaften WHERE SCHUELER_ID='$row->SCHUELER_ID'";
	$ergebnis2 = mysql_query($abfrage2);
	$row2 = mysql_fetch_object($ergebnis2);
	$id=$row->SCHUELER_ID;
	if($row2->letzter_eintrag!="0000-00-00 00:00:00")
	  {
	  $letzter_eintrag=humanTime($row2->letzter_eintrag);
	  }
	else
      {
	  $letzter_eintrag="---";
	  }	  
	
    if (file_exists("./images/profil/".$id.".jpg"))
      {
	  $profilbild="./images/profil/".$id.".jpg";
	  }
    else
	  {
	  $profilbild="./images/profil/default.jpg";
	  }
	
	echo '<tr';
	if ($linecounter % 2 == 1)
		echo ' style="background-color: #D6D6D6"';
	echo '><td class="profilbild-column"><a class="nohlimg" href="framework.php?id=poebel&aktion=anschauen&amp;schuelerid='.$id.'"><span><div class="profileimage_small" style="background-image: url('.$profilbild.');" ></div></span></a></td><td><a class="nohl" href="framework.php?id=poebel&aktion=anschauen&amp;schuelerid='.$id.'">'. $row->Name_ganz.'</a></td><td>'.$row2->anzahl_eintraege.'</td><td>'.$letzter_eintrag.'</td> </tr>';         
	$linecounter++;
	}
?>
</table>
</div>
