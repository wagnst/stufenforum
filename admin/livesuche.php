<?php
include ('sessiontest.inc.php');
include ('functions.inc.php');
include ('mysql.inc.php');
$suchwort = $_GET['suchwort'];
$suchwort = str_replace(array("*","?"), array("%","_"), $suchwort);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Suche</title>
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
	<script src="js/jquery-1.7.2.js"></script>
	<script src="js/lightbox.js"></script>
	<script language="Javascript">
	<!--
	   document.getElementById("loading").style.visibility='visible';
	//-->
	</script>  
</head>
<body onLoad="javascript:document.getElementById('loading').style.visibility='hidden';">
<?php

include ('menu.inc.php');
echo '<div id="inhalt">
		<div id="layout_canvas">
		<div class="profilkopf"><img src="./img/results.png">Suchergebnisse für "'.$suchwort.'"</a></div>
		<div id="loading"><img src="img/wait.gif" alt="Loading..." /></div>
		<div id="userStats" class="clearfix">';

if (!empty($suchwort))
{
	/* START OF SEARCH QUERIES */
	// Suche nach SCHÜLERN
	$abfrage_schueler = "SELECT Name_ganz, SCHUELER_ID FROM user WHERE Name_ganz LIKE '%$suchwort%'  AND Deleted='0' ORDER BY Nachname";
	$ergebnis_schueler = mysql_query($abfrage_schueler);
	//Suche nach UMFRAGEN
	$abfrage_umfragen = "SELECT Text, Umfrage_ID FROM umfragen WHERE Text LIKE '%$suchwort%' ORDER BY Umfrage_ID";
	$ergebnis_umfragen = mysql_query($abfrage_umfragen);
	//Suche nach MITTEILUNGEN
	$abfrage_mitteilungen = "SELECT news_ID, Thema, Text FROM news WHERE Thema LIKE '%$suchwort%' OR Text LIKE '%$suchwort%' AND Deleted='0' ORDER BY news_ID";
	$ergebnis_mitteilungen = mysql_query($abfrage_mitteilungen);
	//Suche nach LEHRERSPRÜCHEN
	$abfrage_lehrer = "SELECT Eintrags_ID, eintragstext FROM lehrer_eintraege_neu WHERE eintragstext LIKE '%$suchwort%' ORDER BY Eintrags_ID";
	$ergebnis_lehrer = mysql_query($abfrage_lehrer);
	//Suche nach TEAMS
	$abfrage_teams = "SELECT * FROM teams WHERE team_name LIKE '%$suchwort%' ORDER BY TEAM_ID";
	$ergebnis_teams = mysql_query($abfrage_teams);
	//Suche nach BÖSE ZUNGEN
	$abfrage_zungen = "SELECT EintragsID, zungentext, Betroffener FROM zungen_eintraege WHERE zungentext LIKE '%$suchwort%' ORDER BY EintragsID";
	$ergebnis_zungen = mysql_query($abfrage_zungen);
	//Suche nach KALENDER
	$abfrage_kalender = "SELECT Termin_ID, Datum, Titel, Beschreibung FROM kalender WHERE Titel LIKE '%$suchwort%' OR Beschreibung LIKE '%$suchwort%' ORDER BY Datum";
	$ergebnis_kalender = mysql_query($abfrage_kalender);
	
	//Gehe direkt zum Schüler, wenn eindeutig 1 Schüler gefunden wurde
	if (mysql_num_rows($ergebnis_schueler)==1)
	{
		$rows = mysql_fetch_object($ergebnis_schueler);
		$user_id = $rows->SCHUELER_ID;
		header('Location: update-show.php?edit='.$user_id);
	}
	
	/* START OF SEARCH OUTPUT */
	//Schüler Ausgabe
	if ((mysql_num_rows($ergebnis_schueler) == 0) and (mysql_num_rows($ergebnis_umfragen) == 0) and (mysql_num_rows($ergebnis_mitteilungen) == 0) and (mysql_num_rows($ergebnis_lehrer) == 0) and (mysql_num_rows($ergebnis_teams) == 0) and (mysql_num_rows($ergebnis_zungen) == 0) and (mysql_num_rows($ergebnis_kalender) == 0))   
	{
		echo '<div class="error">Es wurden leider keine entsprechenden Treffer gefunden.</div>';
	}
	else
	//Schüler Ausgabe
	{	
		if (mysql_num_rows($ergebnis_schueler) > 0)
		{
			echo '<div class="suchergebnisse"><h3>Schüler</h3></div><div class="suchergebnis"><table>';
			while($row = mysql_fetch_object ($ergebnis_schueler))
			{
				if (file_exists("../images/profil_small/".$row->SCHUELER_ID.".jpg"))
					$profilbild="../images/profil_small/".$row->SCHUELER_ID.".jpg";
				else
					$profilbild="../images/profil_small/default.jpg";
			echo '<tr>
					<td>
						<a class="nohlimg" href="update-show.php?edit='.$row->SCHUELER_ID.'">
							<img alt="profilbild" src="'.$profilbild.'" />
						</a>
					</td>
					<td>
						<a class="nohl" href="update-show.php?edit='.$row->SCHUELER_ID.'">'. $row->Name_ganz.'</a>
					</td>';
			}
			echo "</table></div>";
		}
		
		//Umfragen Ausgabe
		if (mysql_num_rows($ergebnis_umfragen) > 0) 
		{
			echo '<div class="suchergebnisse"><h3>Umfragen</h3></div><div class="suchergebnis"><table>';
			while($row1 = mysql_fetch_object ($ergebnis_umfragen))
			{
				echo '<tr>
						<td>
							<li>'. $row1->Text.'</li>
						</td>
						<td>
							<a href="update-umfragen.php?edit='.$row1->Umfrage_ID.'">
								<img width="17" src="img/_edit.gif" heigth="17"/>
							</a>
						</td>
						<td>
							<a href="update-umfragen.php?auswertung='.$row1->Umfrage_ID.'">
								<img width="17" src="img/umfrageverwaltung.png" heigth="17"/>
							</a>
						</td>';
			}
			echo "</tr></table></div>";	
		}

		//Mitteilungen Ausgabe
		if (mysql_num_rows($ergebnis_mitteilungen) > 0) 
		{
			echo '<div class="suchergebnisse"><h3>Mitteilungen</h3></div><div class="suchergebnis"><table>';
			while($row2 = mysql_fetch_object ($ergebnis_mitteilungen))
			{
				echo '<tr>
						<td>
							<li>'. $row2->Thema.'</li>
						</td>
						<td>
							<a href="update-news.php?edit='.$row2->news_ID.'">
								<img width="17" src="img/_edit.gif" heigth="17"/>
							</a>
						</td>';
			}
			echo "</tr></table></div>";	
		}	
		//Lehrersprüche Ausgabe
		if (mysql_num_rows($ergebnis_lehrer) > 0) 
		{
			echo '<div class="suchergebnisse"><h3>Lehrersprüche</h3></div><div class="suchergebnis"><table>';
			while($row3 = mysql_fetch_object ($ergebnis_lehrer))
			{
				echo '<tr>
						<td><li>'; 
						echo substr($row3->eintragstext, 0, 50).'...';
					echo '</li>
						</td>
						<td>
							<a href="update-lehrer.php?edit='.$row3->Eintrags_ID.'">
								<img width="17" src="img/_edit.gif" heigth="17"/>
							</a>
						</td>';
			}
			echo "</tr></table></div>";	
		}	
		//Teams Ausgabe
		if (mysql_num_rows($ergebnis_teams) > 0) 
		{
			echo '<div class="suchergebnisse"><h3>Teams</h3></div><div class="suchergebnis"><table>';
			while($row4 = mysql_fetch_object ($ergebnis_teams))
			{
				echo '<tr>
						<td>
							<li>'. $row4->team_name.'</li>
						</td>
						<td>
							<a href="update-teams.php?edit='.$row4->TEAM_ID.'">
								<img width="17" src="img/_edit.gif" heigth="17"/>
							</a>
						</td>';
			}
			echo "</tr></table></div>";	
		}		
		//Böse Zungen Ausgabe
		if (mysql_num_rows($ergebnis_zungen) > 0) 
		{
			echo '<div class="suchergebnisse"><h3>Böse Zungen behaupten</h3></div><div class="suchergebnis"><table>';
			while($row5 = mysql_fetch_object ($ergebnis_zungen))
			{
				echo '<tr>
						<td><li>'; 
						echo substr($row5->Betroffener . $row5->zungentext, 0, 50).'...';
					echo '</li>
						</td>
						<td>
							<a href="zungen.php">
								<img width="17" src="img/_show.gif" heigth="17"/>
							</a>
						</td>';
			}
			echo "</tr></table></div>";	
		}	
		//Kalender Ausgabe
		if (mysql_num_rows($ergebnis_kalender) > 0) 
		{
			echo '<div class="suchergebnisse"><h3>Kalender</h3></div><div class="suchergebnis"><table>';
			while($row6 = mysql_fetch_object ($ergebnis_kalender))
			{
				echo '<tr>
						<td>
							<li>'. $row6->Titel.'</li>
						</td>
						<td>
							<a href="update-kalender.php?edit='.$row6->Termin_ID.'">
								<img width="17" src="img/_edit.gif" heigth="17"/>
							</a>
						</td>';
			}
			echo "</tr></table></div>";	
		}			
	}
}
else
{
	echo '<div class="error">Bitte geben Sie einen Suchbegriff ein!</div>';
}
?>
	</div>
	</div>
</div>
<?php include('footer.inc.php'); ?>
</html>
 