<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
if ((check_login("umfragen") == true) OR (check_login("umfrageauswertung") == true))
{
	include('mysql.inc.php');
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Umfragenverwaltung</title>
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
<?php include('menu.inc.php'); ?>
<div id="inhalt">
<div id="layout_canvas">
<?php
	echo '<div class="profilkopf"><img src="img/umfrageverwaltung.png"> Umfrageverwaltung</></div>
	<div id="loading"><img src="img/wait.gif" alt="Loading..." /></div>';	
	if ($_GET["msg"] == "erfolg")
	{
	echo '<div class="success">Aktion war erfolgreich!</div>';
	}elseif ($_GET["msg"] == "fehler")
	{
	echo '<div class="error">'.$_GET["errordesc"].'</div>';
	}	
    if (!empty($_GET["motto"]))
		{    		
			$abfrage = "SELECT * FROM umfragen WHERE Typ=10 ORDER BY Umfrage_ID ASC";
      		$ergebnis = mysql_query($abfrage, $sql);
			$row=mysql_fetch_object($ergebnis);
			$umf_id=$row->Umfrage_ID;	
			$auswahl=$row->Antworten;
			$antworten=explode(";", $auswahl);
			echo '<div id="userStats" class="clearfix">';
			echo '<h3>Mottoumfrage</h3>';			
			echo '<table class="table table-bordered table-striped table-hover">';
			echo '<thead>
					<tr>
						<th>Motto</th>
						<th>Anzahl</th>
					</tr>
				 </thead>
				 <tbody>';
			foreach ($antworten as $a)
			{
				$abfrage2='SELECT * FROM mottoergebnisse2 WHERE Motto1="'.$a.'" OR Motto2="'.$a.'"';
				$ergebnis2 = mysql_query($abfrage2, $sql);
				$anzahl2 = mysql_num_rows($ergebnis2);
				echo '<tr><td>'.$a.'</td><td>'.$anzahl2.'</td></tr>';
				$i++;
			}
			echo"</tbody></table></div></div>"; 		                   
    }elseif (!empty($_GET["manage"]))
	{  
		if (isset($_GET['section']))//Section ausgeben
		{
			switch ($_GET['section'])
			{
			case "aktiv":
				$section="aktiv";
				break;
			case "inaktiv":
				$section="inaktiv";
				break;
			case "alle":
				$section="alle";
				break;
			}
		}	
		else
		{
			$section="alle";
		} 
		//Wenn alle angezeigt werden sollen
		if($section=="alle")
		{ 	
		$abfrage4='SELECT `Text`,`Umfrage_ID`,`Typ`,`anzahl_stimmen`,`beendet` FROM umfragen';
		$ergebnis4 = mysql_query($abfrage4, $sql);
		echo ' 
			<ul id="submenu">
				<li class="selectedmenuitem"><a href="umfragen.php?manage=1&section=alle">Alle</a></li>
				<li><a href="umfragen.php?manage=1&section=aktiv">Aktiv</a></li>
				<li><a href="umfragen.php?manage=1&section=inaktiv">Inaktiv</a></li>
			</ul>
			<div class="clearfix">	
			<div id="userStats" class="clearfix">			
		';
		if (mysql_num_rows($ergebnis4) == "0")
		{
			echo '<div class="error">Es sind keine Daten verfügbar!</div>';
		}
		else{			
			while ($row = mysql_fetch_object($ergebnis4)) 
			{  
				switch ($row->Typ) {
					case 1: 
						$type = 'Alle Schüler';
						break;
					case 2: 
						$type = 'Weibliche Schüler';
						break;
					case 3: 
						$type = 'Männliche Schüler';
						break;
					case 4: 
						$type = 'Weibliche Lehrer';
						break;
					case 5: 
						$type = 'Männliche Lehrer';
						break;
					case 6: 
						$type = 'Alle Lehrer';
						break;
					case 7: 
						$type = 'Eigene Antwortmöglichkeiten';
						break;
					case 8: 
						$type = 'Eigene Antwortmöglichkeiten mit Kommentar';
						break;
					case 25: 
						$type = 'Alle Schüler (testing)';
						break;
					case 10: 
						$type = 'Abimotto';
						break;		
					default: 
						$type='Typ Fehler!';
						break;		
				}
				if ($row->beendet == 1)
				{
							$check = "JA";
				}
				else
				{
							$check = "NEIN";
				}			
				echo '
					<div class="data">
						<h5>' . $type . '</h5>
						<h4>' . $row->Text . '</h4>
						<div class="socialMediaLinks">					
							<a class="btn btn-small" title="Ergebnisse anzeigen" href="update-umfragen.php?auswertung=' . $row->Umfrage_ID . '"><i class="icon-eye-open"></i></a>
							<a class="btn btn-small" title="Umfrage editieren" href="update-umfragen.php?edit=' . $row->Umfrage_ID . '"><i class="icon-pencil"></i></a>
							<a class="btn btn-small btn-danger" title="Umfrage löschen" href="update-umfragen.php?del=' . $row->Umfrage_ID . '"><i class="icon-remove icon-white"></i></a>							
						</div>
						<div class="sep"></div>
						<ul class="numbers clearfix">
							<li>Beendet?<strong><a href="update-umfragen.php?toogle=' . $row->Umfrage_ID . '">' . $check . '</a></strong></li>
							<li>Stimmenanzahl<strong>' . $count=$row->anzahl_stimmen . '</strong></li>
							<li class="nobrdr">Umfrage ID<strong>' . $row->Umfrage_ID . '</strong></li>
						</ul>
					</div>			
				';
			} 
		}
		}
		//wenn nur aktive angezeit werden sollen
		if($section=="aktiv")
		{ 	
		$abfrage4='SELECT `Text`,`Umfrage_ID`,`Typ`,`anzahl_stimmen`,`beendet` FROM umfragen WHERE beendet=0';
		$ergebnis4 = mysql_query($abfrage4, $sql);
		echo ' 
			<ul id="submenu">
				<li><a href="umfragen.php?manage=1&section=alle">Alle</a></li>
				<li class="selectedmenuitem"><a href="umfragen.php?manage=1&section=aktiv">Aktiv</a></li>
				<li><a href="umfragen.php?manage=1&section=inaktiv">Inaktiv</a></li>
			</ul>
			<div class="clearfix">		
		';		
		echo '<div id="userStats" class="clearfix">';
		if ($_GET["msg"] == "erfolg")
		{
			echo '<div class="success">Aktion war erfolgreich!</div>';
		}elseif ($_GET["msg"] == "fehler")
		{
			echo '<div class="suchergebnis">Fehler! Aktion war nicht erfolgreich!</div>';
		}
		if (mysql_num_rows($ergebnis4) == "0")
		{
			echo '<div class="error">Es sind keine Daten verfügbar!</div>';
		}
		else{		
			while ($row = mysql_fetch_object($ergebnis4)) 
			{  
				switch ($row->Typ) {
					case 1: 
						$type = 'Alle Schüler';
						break;
					case 2: 
						$type = 'Weibliche Schüler';
						break;
					case 3: 
						$type = 'Männliche Schüler';
						break;
					case 4: 
						$type = 'Weibliche Lehrer';
						break;
					case 5: 
						$type = 'Männliche Lehrer';
						break;
					case 6: 
						$type = 'Alle Lehrer';
						break;
					case 7: 
						$type = 'Eigene Antwortmöglichkeiten';
						break;
					case 8: 
						$type = 'Eigene Antwortmöglichkeiten mit Kommentar';
						break;
					case 25: 
						$type = 'Alle Schüler (testing)';
						break;
					case 10: 
						$type = 'Abimotto';
						break;		
					default: 
						$type='Typ Fehler!';
						break;		
				}
				if ($row->beendet == 1)
				{
							$check = "JA";
				}
				else
				{
							$check = "NEIN";
				}			
				echo '
					<div class="data">
						<h5>' . $type . '</h5>
						<h4>' . $row->Text . '</h4>
						<div class="socialMediaLinks">
							<a class="btn btn-small" title="Ergebnisse anzeigen" href="update-umfragen.php?auswertung=' . $row->Umfrage_ID . '"><i class="icon-eye-open"></i></a>
							<a class="btn btn-small" title="Umfrage editieren" href="update-umfragen.php?edit=' . $row->Umfrage_ID . '"><i class="icon-pencil"></i></a>
							<a class="btn btn-small btn-danger" title="Umfrage löschen" href="update-umfragen.php?del=' . $row->Umfrage_ID . '"><i class="icon-remove icon-white"></i></a>
						</div>
						<div class="sep"></div>
						<ul class="numbers clearfix">
							<li>Beendet?<strong><a href="update-umfragen.php?toogle=' . $row->Umfrage_ID . '">' . $check . '</a></strong></li>
							<li>Stimmenanzahl<strong>' . $count=$row->anzahl_stimmen . '</strong></li>
							<li class="nobrdr">Umfrage ID<strong>' . $row->Umfrage_ID . '</strong></li>
						</ul>
					</div>			
				';
			} 
		}
		}
		//wenn nur inaktive angezeit werden sollen
		if($section=="inaktiv")
		{ 	
		$abfrage4='SELECT `Text`,`Umfrage_ID`,`Typ`,`anzahl_stimmen`,`beendet` FROM umfragen WHERE beendet=1';
		$ergebnis4 = mysql_query($abfrage4, $sql);
		echo ' 
			<ul id="submenu">
				<li><a href="umfragen.php?manage=1&section=alle">Alle</a></li>
				<li><a href="umfragen.php?manage=1&section=aktiv">Aktiv</a></li>
				<li class="selectedmenuitem"><a href="umfragen.php?manage=1&section=inaktiv">Inaktiv</a></li>
			</ul>
			<div class="clearfix">		
		';			
		echo '<div id="userStats" class="clearfix">';
		if ($_GET["msg"] == "erfolg")
		{
			echo '<div class="suchergebnis">Aktion war erfolgreich!</div>';
		}elseif ($_GET["msg"] == "fehler")
		{
			echo '<div class="suchergebnis">Fehler! Aktion war nicht erfolgreich!</div>';
		}
		if (mysql_num_rows($ergebnis4) == "0")
		{
			echo '<div class="error">Es sind keine Daten verfügbar!</div>';
		}
		else{
			while ($row = mysql_fetch_object($ergebnis4)) 
			{  
				switch ($row->Typ) {
					case 1: 
						$type = 'Alle Schüler';
						break;
					case 2: 
						$type = 'Weibliche Schüler';
						break;
					case 3: 
						$type = 'Männliche Schüler';
						break;
					case 4: 
						$type = 'Weibliche Lehrer';
						break;
					case 5: 
						$type = 'Männliche Lehrer';
						break;
					case 6: 
						$type = 'Alle Lehrer';
						break;
					case 7: 
						$type = 'Eigene Antwortmöglichkeiten';
						break;
					case 8: 
						$type = 'Eigene Antwortmöglichkeiten mit Kommentar';
						break;
					case 25: 
						$type = 'Alle Schüler (testing)';
						break;
					case 10: 
						$type = 'Abimotto';
						break;		
					default: 
						$type='Typ Fehler!';
						break;		
				}
				if ($row->beendet == 1)
				{
							$check = "JA";
				}
				else
				{
							$check = "NEIN";
				}			
				echo '
					<div class="data">
						<h5>' . $type . '</h5>
						<h4>' . $row->Text . '</h4>
						<div class="socialMediaLinks">
							<a class="btn btn-small" title="Ergebnisse anzeigen" href="update-umfragen.php?auswertung=' . $row->Umfrage_ID . '"><i class="icon-eye-open"></i></a>
							<a class="btn btn-small" title="Umfrage editieren" href="update-umfragen.php?edit=' . $row->Umfrage_ID . '"><i class="icon-pencil"></i></a>
							<a class="btn btn-small btn-danger" title="Umfrage löschen" href="update-umfragen.php?del=' . $row->Umfrage_ID . '"><i class="icon-remove icon-white"></i></a>
						</div>
						<div class="sep"></div>
						<ul class="numbers clearfix">
							<li>Beendet?<strong><a href="update-umfragen.php?toogle=' . $row->Umfrage_ID . '">' . $check . '</a></strong></li>
							<li>Stimmenanzahl<strong>' . $count=$row->anzahl_stimmen . '</strong></li>
							<li class="nobrdr">Umfrage ID<strong>' . $row->Umfrage_ID . '</strong></li>
						</ul>
					</div>			
				';
			} 
		}	
		}
    }
	echo '</div>
		</div>
		</div>
		</div>
	</div>';
	include('footer.inc.php'); 
}
else
{
	header('Location: admin.php?berechtigung=0');
}
		 
?>