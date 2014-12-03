<?php
include ('includes.inc.php');
session_start();
$fehler = "";
$done = false;
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
  <title>ABITALIA - Registrieren</title> 
  <link rel="icon" 
      type="image/png" 
      href="images/favicon.ico">
  <link rel="stylesheet" type="text/css" href="css.php" />
  <link rel="stylesheet" type="text/css" href="styles/login.css" />
 

</head> 

<body class="login">
<div id="main">
<?php
include ('header.inc.php');
?>

<div id="inhalt">
<div class="profilkopf">Registrierung zum ABITALIA - Stufenforum</div>
<?php
if(isset($_POST['submit'])) {

       if(empty($_POST['first'])) {
              $fehler .= "<li>Der Vorname fehlt!</li>";
       }
       if(empty($_POST['last'])) {
              $fehler .= "<li>Der Nachname fehlt!</li>";
       }
       if(empty($_POST['mail'])) {
              $fehler .= "<li>Die Mailadresse fehlt!</li>";
       } elseif (preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/",$_POST['mail'])==0) {
			  $fehler .= "<li>Die Mailadresse ist nicht gültig!</li>";
	   }
       if(empty($_POST['pwd'])) {
              $fehler .= "<li>Das Passwort fehlt!</li>";             
       }elseif(strlen($_POST['pwd'])<6) {
			  $fehler .= "<li>Das Passwort ist zu kurz!</li>";
       }elseif($_POST['pwd'] != $_POST['pwd2']){
              $fehler .= "<li>Passwörter stimmen nicht überein!</li>";
      
       }
    $name = mysql_real_escape_string($_POST['first'])." ".mysql_real_escape_string($_POST['last']);
    $sql = "SELECT *
          FROM user
          WHERE Name_ganz = '$name'
          LIMIT 1";
		  
    $result = mysql_query($sql) OR die(mysql_error());
    if ( mysql_num_rows($result) == 0 ) {
               echo "";
    } else {
       $fehler .= "<li>Der Benutzername ist schon vergeben!</li>";
    }
        
    if(empty($fehler)) { //bisher kein Fehler -> Captcha prüfen
	
		include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';
		
		$securimage = new Securimage();
		if ($securimage->check($_POST['captcha_code']) == false) {
			$fehler .= "<li>Sicherheitscode falsch!</li>";
		}
	}
	
    if(empty($fehler)) {
            

            $query = "INSERT INTO user SET
               Vorname = '".mysql_real_escape_string($_POST['first'])."',
               Nachname = '".mysql_real_escape_string($_POST['last'])."',
               Name_ganz = '".mysql_real_escape_string($_POST['first']." ".$_POST['last'])."', 
               Name_kurz = '".mysql_real_escape_string(strtolower(substr($_POST['first'], 0, 1).$_POST['last']))."',
               EMail = '".mysql_real_escape_string($_POST['mail'])."',
               Passwort = md5('".mysql_real_escape_string($_POST['pwd'])."')";
            $sql = mysql_query($query) or die(mysql_error());
			$lastId = mysql_insert_id();
			$query = "INSERT INTO poebel_eigenschaften SET SCHUELER_ID='$lastId'";
			mysql_query($query);
            echo '<br /><br />Danke für deine Registrierung! Diese wird nun geprüft und dann freigeschaltet. <p><a href="index.php">Zum Login</a></p>';
			$done = true;
			$nachricht = $_POST['first']." ".$_POST['last']." mit der EMail ".$_POST['mail']." hat sich registriert. Zur Freischaltung: http://ohg2013.de/admin/show.php";
			$header = 'From: admin@ohg2013.de' . "\r\n" .
			'Reply-To: admin@ohg2013.de' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

			mail('admin@ohg2013.de', 'Registrierung', $nachricht, $header);
			mail('ashvin@gmx.net', 'Registrierung', $nachricht, $header);


       }
    else echo '<div class="error"><span style="font-weight:bold;">FEHLER:</span><ul>'.$fehler.'</div>';
}
elseif(!isset($_POST['submit'])) {#Garnichts ist#
echo "";
}
if (!$done) {
?> 

<form class="login" method="post">
  <p>Vorname:<br /> 
    <input type="text" name="first" value="<? echo $_POST['first'];?>"></p>
  <p>Nachname:<br /> 
    <input type="text" name="last" value="<? echo $_POST['last'];?>"></p>  
  <p>E-Mail:<br /> 
    <input type="text" name="mail" value="<? echo $_POST['mail'];?>"></p>  
  <p>Passwort (mind. 6 Zeichen):<br /> 
    <input type="password" name="pwd"></p> 
  <p>Passwort wiederholen:<br /> 
    <input type="password" name="pwd2"></p>
  <p>Sicherheitsabfrage: <br />
  <img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" /> <br />
  <input type="text" name="captcha_code" size="10" maxlength="6" />
  <a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false">[Neuer Code]</a>

  </p>
	
<br /> 
  <h3><b>Mit der Registrierung aktzeptierst du die im Impressum aufgeführten Regelungen!</b></h3></br></br>
  <input class="button" type="submit" name="submit" value="Abschicken" />
  <p><a href="login.php">Zum Login</a></p>
  
</form> 
<?php
}
?>
</div>
</div>
<div id="footer" class="footer">
<p>Stufenseite Abiturjahrgang 2013 &copy; Steffen No. 1 &amp; 2 </p>
<table class="footertable">
<tr>
<td class="leftlink"><a href="impressum_neu.php">Impressum</a></td><td class="footerseperator">|</td><td class="rightlink"><a href="admin/login.php">Admin</a></td>
</tr>
</table>
</div>
</body> 
</html> 
 