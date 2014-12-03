<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
if (check_login("poebel") == true)
{
	include('mysql.inc.php');
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Pöbelbeschwerden</title
<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
<script src="js/jquery-1.7.2.js"></script>
<script src="js/lightbox.js"></script>
</head>	
<body>
<?php include('menu.inc.php'); ?>
<div id="inhalt">
<div id="layout_canvas">
<div class="profilkopf">Pöbelbeschwerden</div>
		<?php  			
		if (!empty($_GET["reject"]))
		{
			$beschwerdeid = (int)$_GET["reject"];
			$abfrage = 'SELECT * FROM `poebel_beschwerden` WHERE `Beschwerde_ID` = ' . $beschwerdeid;
			$ergebnis = mysql_query($abfrage, $sql) OR die(mysql_error());
			$row = mysql_fetch_object($ergebnis);	
			$poebelid = $row->Poebel_ID;
			$schuelerid = $row->Schueler_ID;
			$status = $row->Status;
			if ($status == '2')
			{
				header('Location: ./poebel.php?msg=alreadydenied');
				exit;
			}elseif ($status == '3')	
			{
				header('Location: ./poebel.php?msg=alreadyinvisible');
				exit;
			}	
			//pöbeleintrag holen
			$abfrage1 = 'SELECT `eintragstext` FROM `poebel_eintraege_neu` WHERE `EintragsID` = ' . $poebelid;
			$ergebnis1 = mysql_query($abfrage1, $sql) OR die(mysql_error());
			$row1 = mysql_fetch_object($ergebnis1);
			$poebel = $row1->eintragstext;             
        
			//Schülername und email holen
			$abfrage2 = 'SELECT `Name_ganz`,`EMail` FROM `user` WHERE `SCHUELER_ID` = ' . $schuelerid;
			$ergebnis2 = mysql_query($abfrage2, $sql) OR die(mysql_error());
			$row2 = mysql_fetch_object($ergebnis2);
			$schueler = $row2->Name_ganz;
			$email = $row2->EMail;

			$abfrage3 = 'UPDATE `'.$sql_db.'`.`poebel_beschwerden` SET `Status` =2 WHERE `poebel_beschwerden`.`Beschwerde_ID` =' . $beschwerdeid . ' LIMIT 1';
			if (mysql_query($abfrage3, $sql) == true)
			{
				$nachricht = '<html>
					<p>Hallo '.$schueler.',</p>
					<p>deine abgegebene Beschwerde zum Eintrag </br></br><b>'.$poebel.'</b></br>wurde abgelehnt!</br>Bei Fragen kannst du gerne auf diese Email antworten.</p>
					<p>Gruss,</br>Stufenforum-Team</p></html>';
					
				$header  = "MIME-Version: 1.0\r\n"; 
				$header .= "Content-type: text/html; charset=utf-8\r\n"; 
				$header .= "From: $admin_mail\r\n";
				$header .= "X-Mailer: PHP ". phpversion();  
				$subject = "Stufenforum Beschwerde";
				@mail($email, $subject, $nachricht, $header); 
				header('Location: ./poebel.php?msg=erfolg');
			}
		}
		elseif (!empty($_GET["del"]))
		{
			$beschwerdeid = (int)$_GET["del"];
			$abfrage = 'SELECT * FROM `poebel_beschwerden` WHERE `Beschwerde_ID` = ' . $beschwerdeid;
			$ergebnis = mysql_query($abfrage, $sql) OR die(mysql_error());
			$row = mysql_fetch_object($ergebnis);	
			$poebelid = $row->Poebel_ID;
			$schuelerid = $row->Schueler_ID;
			$status = $row->Status;
				if ($status == '2')
				{
					header('Location: ./poebel.php?msg=alreadydenied');
					exit;
				}elseif ($status == '3')	
				{
					header('Location: ./poebel.php?msg=alreadyinvisible');
					exit;
				}	
			//pöbeleintrag holen
			$abfrage1 = 'SELECT `eintragstext` FROM `poebel_eintraege_neu` WHERE `EintragsID` = ' . $poebelid;
			$ergebnis1 = mysql_query($abfrage1, $sql) OR die(mysql_error());
			$row1 = mysql_fetch_object($ergebnis1);
			$poebel = $row1->eintragstext;             
			
			//Schülername und email holen
			$abfrage2 = 'SELECT `Name_ganz`,`EMail` FROM `user` WHERE `SCHUELER_ID` = ' . $schuelerid;
			$ergebnis2 = mysql_query($abfrage2, $sql) OR die(mysql_error());
			$row2 = mysql_fetch_object($ergebnis2);
			$schueler = $row2->Name_ganz;
			$email = $row2->EMail;

			$abfrage3 = 'UPDATE `'.$sql_db.'`.`poebel_eintraege_neu` SET `freigeschaltet` =0 WHERE `poebel_eintraege_neu`.`EintragsID` =' . $poebelid . ' LIMIT 1';
			$abfrage4 = 'UPDATE `'.$sql_db.'`.`poebel_beschwerden` SET `Status` =3 WHERE `poebel_beschwerden`.`Beschwerde_ID` =' . $beschwerdeid . ' LIMIT 1';
			if (mysql_query($abfrage3, $sql)  == true)
			{
				if (mysql_query($abfrage4, $sql)  == true)
				{
					$nachricht = '<html>
						<p>Hallo '.$schueler.',</p>
						<p>deine abgegebene Beschwerde zum Eintrag </br></br><b>'.$poebel.'</b></br>wurde genehmigt!</br></br>Der Eintrag wurde vorruebergehend unsichtbar gemacht. In deinem Poebelbuch kannst du nun entscheiden, die Aktion rueckgaengig zu machen, oder den Eintrag endgueltig zu loeschen.</br>Bei Fragen kannst du gerne auf diese EMail anworten.</p>
					<p>Gruss,</br>Stufenforum-Team</p></html>';
						
					$header  = "MIME-Version: 1.0\r\n"; 
					$header .= "Content-type: text/html; charset=utf-8\r\n"; 
					$header .= "From: $admin_mail\r\n";
					$header .= "X-Mailer: PHP ". phpversion();  
					$subject = "Stufenforum Beschwerde";
					@mail($email, $subject, $nachricht, $header); 
					header('Location: ./poebel.php?msg=erfolg');				
				}	
			}
		}
		else
		{
			header('Location: ./poebel.php?msg=fehler');
		}
	echo '</div></div>';
	include('footer.inc.php');		
}
else
{
	header('Location: admin.php?berechtigung=0');
}

?>