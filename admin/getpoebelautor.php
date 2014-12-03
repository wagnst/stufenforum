<?php
if (isset($_POST['hash']))//wenn hash per POST gesendet
{
	$id = $_POST['id'];
	$hash = md5($id."***".$id);
	
	//wenn hash korrekt, zeige Autor
	if ($_POST["hash"] == $hash)
	{
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		<head>
			<title>Pöbelautor herausfinden</title>
			<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
			<link rel="stylesheet" type="text/css" href="css/style.css" />
			<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
			<script src="js/jquery-1.7.2.js"></script>

		</head>	
		<body>
		<div id="inhalt">
			<div id="layout_canvas">
				<div class="profilkopf"><img src="./img/poebel.png">Pöbelautor herausfinden</></div>
				<div id="userStats" class="clearfix">

		<?php

		$sql_server = "***"; /*SQL Server adress, often "localhost"*/
		$sql_user = "***"; /*SQL Username*/
		$sql_pw = "***"; /*Database password*/
		$sql_db = "***"; /*Database*/

		$sql = mysql_connect ($sql_server, $sql_user, $sql_pw)
		or die ("Es ist momentan keine Verbindung zur Datenbank moeglich. Bitte Kontaktieren sie einen Admin.");

		mysql_select_db($sql_db)
		or die ("Die ausgewaehlte Datenbank existiert nicht. Bitte Kontaktieren sie einen Admin.");
		
		$abfrage1 = "SELECT PosterID,eintragstext FROM poebel_eintraege_neu WHERE EintragsID='$id'";
		$ergebnis1 = mysql_query($abfrage1);
		$row1 = mysql_fetch_object($ergebnis1);
		$posterid=$row1->PosterID; 
		$eintragstext=$row1->eintragstext; 

		if ($posterid <> "1") {
			$abfrage2 = "SELECT Name_ganz FROM user WHERE SCHUELER_ID='$posterid'";
			$ergebnis2 = mysql_query($abfrage2);
			$row2 = mysql_fetch_object($ergebnis2);
			$poebler=$row2->Name_ganz; 
			echo "<b>$poebler</b> hat folgendes geschrieben:";
			echo "<p>$eintragstext</p>";
		} else 
			echo "Fehler";
		echo '</div></div></div>';	
		exit;
	}	
}
if (isset($_POST['id']) )//wenn id Ã¼ber POST dann Mail mit Hash senden
{
	$id = $_POST['id'];
	$hash = md5($id."***".$id);
	if ($id <> "") {
		function email($mail, $sub, $msg, $a)
		{
			$mailto = $mail;
			$msg = $msg;
			$von = $admin_mail;
			$sub = $sub;

			$msg = htmlentities($msg);
			$auto = "\r\n\r\nGruss,\r\nStufenforum Team.";
			$n_auto = "";
			if ($a = 1) {
				$foot = $auto;
			}
			if ($a = 0) {
				$foot = $n_auto;
			}
			$msg = $msg . $foot;
			$msg = str_replace("\n.", "<br />", $msg);
			$msg = stripslashes($msg);

			$header = "From: $von";

			$mail_senden = mail ($mailto, $sub, $msg, $header); //use php function mail()
		}
		
		$nachricht = '<html>
			<p>Code fuer ID '.$id.' lautet: </br></br>'.$hash.'</p>';
			
		$header  = "MIME-Version: 1.0\r\n"; 
		$header .= "Content-type: text/html; charset=utf-8\r\n"; 
		$header .= "From: admin@ohg2013.de\r\n";
		$header .= "X-Mailer: PHP ". phpversion();  
		$subject = "Hash fuer ID $id";
		@mail("mail@steffenwagner.com", $subject, $nachricht, $header); 
		echo '<div style="margin:0 auto; color:white;"><b>Email mit Hash versandt!</b></div>';
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Pöbelautor herausfinden</title>
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
	<script src="js/jquery-1.7.2.js"></script>
	<script src="js/lightbox.js"></script>
</head>	
<body>
<div id="inhalt">
	<div id="layout_canvas">
		<div class="profilkopf"><img src="./img/poebel.png">Pöbelautor herausfinden</></div>
		<div id="userStats" class="clearfix">
			<form action="getpoebelautor.php" method="post">
			ID*: <input type="text" name="id">
			Hash: <input type="text" name="hash">
			<input type="submit" value="Get it">
			</form>			
		</div>
	</div>
</div>
