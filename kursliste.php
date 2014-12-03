<title><?php echo $main_site_title; ?>Meine Kurse</title>
<div class="profilkopf">Kursliste</div>
<P>
<?php
$abfrage = "SELECT Kurse FROM user WHERE SCHUELER_ID='$s_user_id'";
$ergebnis = mysql_query($abfrage);
$row = mysql_fetch_object($ergebnis);
$kurse=$row->Kurse;
$kurse=explode(";",$kurse);
if (count($kurse)>0)
  {
  echo '<table class="altertable"><tr><th>Kurse<a href="framework.php?id=profiledit&section=kurse"><img src="./styles/img/bearbeiten_klein.png" class="editbutton_small"></a></th></tr>';
  $linecounter=0;
  foreach($kurse as $k)
    {
	$abfrage2 = "SELECT * FROM kurse WHERE fach_kurz='$k'";
	$ergebnis2 = mysql_query($abfrage2);
	$row2 = mysql_fetch_object($ergebnis2);
	echo '<tr';
		if($linecounter %2 ==1)
			echo ' style="background-color: #D6D6D6"';
	echo '><td><a href="framework.php?id=gruppe&typ=k&amp;gid='.$row2->FACH_ID.'">'.$row2->fach_lang.'</a></td></tr>';
	$linecounter++;
	}
	echo '</table>';
  }
else
  echo "Du hast noch keine Kurse festgelegt.";  
?>
</p>
</div>
