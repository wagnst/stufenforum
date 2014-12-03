<?php
$suchwort = $_GET['suchwort'];

if (!empty($suchwort)){
$suchwort = str_replace(array("*","?"), array("%","_"), $suchwort);
$abfrage = "SELECT * FROM user WHERE Name_ganz LIKE '%$suchwort%'  AND Deleted='0' ORDER BY Nachname LIMIT 20 ";
$ergebnis = mysql_query($abfrage);
echo '<title>'.$main_site_title.'Suche nach "'.$suchwort.'"</title>';
if (mysql_num_rows($ergebnis)==1)
{
	$rows = mysql_fetch_object($ergebnis);
     $user_id = $rows->SCHUELER_ID;
     header('Location: ./framework.php?id=profil&schuelerid='.$user_id);
}


echo '<div class="profilkopf">Suchergebnisse</div><br>';

if (mysql_num_rows($ergebnis)==0)   
     echo '<div class="suchergebnis" style="text-align:center">Es konnte leider kein Schüler mit "'.$suchwort.'" im Namen gefunden werden.</div>';


if (mysql_num_rows ($ergebnis) > 1) // mehr als ein Schüler
{
	echo '<table class="altertable">';
	echo '<tr><th colspan="2">Schüler mit "'.$suchwort.'" im Namen</th></tr>';
	$linecounter=0;
	while($row = mysql_fetch_object ($ergebnis))
	{
		if (file_exists("./images/profil/".$row->SCHUELER_ID.".jpg"))
			$profilbild="./images/profil/".$row->SCHUELER_ID.".jpg";
		else
			$profilbild="./images/profil/default.jpg";
	echo '<tr';
	if ($linecounter % 2 == 1)
		echo ' style="background-color: #D6D6D6"';
	echo '><td style="width: 112px"><a class="nohlimg" href="framework.php?id=poebel&aktion=anschauen&amp;schuelerid='.$id.'"><span><div class="profileimage_small" style="background-image: url('.$profilbild.');" ></div></span></a></td><td><a class="nohl" href="profil.php?schuelerid='.$row->SCHUELER_ID.'">'. $row->Name_ganz.'</a></td>';
	$linecounter++;
	}
	echo "</table>";
	
}
}

else
     echo "<title>".$main_site_title."Leere Suche</title><div class='profilkopf'>Suchergebnisse</div><br><div class='suchergebnis' style='text-align:center'>Es konnte keine Eingabe erkannt werden.</div>";
?>

 