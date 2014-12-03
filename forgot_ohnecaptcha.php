<?php
include ('includes.inc.php');
$fehler = "";
$done = false;
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
  <title>Passwort Reset <?php echo $seitentitel;?></title> 
  <link rel="stylesheet" type="text/css" href="css.php" />
  <link rel="stylesheet" type="text/css" href="styles/login.css" />
</head> 

<body class="login">
<?php
include ('header.inc.php');
?>
<div id="inhalt">
<b>Passwort Reset</b><br /><br />
<?php
if(isset($_POST['submit'])) {

      if(empty($_POST['mail'])) 
      {
         $fehler .= "<li>Die Mailadresse fehlt!</li>";
      }elseif (preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/",$_POST['mail'])==0) 
      {
			   $fehler .= "<li>Die Mailadresse ist nicht gueltig!</li>";
	    }
	    
      $mail = $_POST['mail'];
      $sql = "SELECT Name_ganz FROM user WHERE EMail = '$mail' LIMIT 1";		  
      $result = mysql_query($sql) OR die(mysql_error());
      if ( mysql_num_rows($result) == 0 ) 
      {
          $fehler .= "<li>Diese EMail ist nicht vorhanden!</li>";
      }else
      {
          $row=mysql_fetch_object($result);
          $name = $row->Name_ganz;
      }
           
      if(empty($fehler)) 
      {
        $passwort = rand(100000, 9999999999); 
        $query = "UPDATE user SET Passwort = md5('$passwort') WHERE Name_ganz = '$name' LIMIT 1";
        
        $sql = mysql_query($query) or die(mysql_error());
              echo '<br /><br />Dein neues Passwort wurde dir per EMail zugesandt. <p><a href="index.php">Zum Login</a></p>';
        $done = true;
			  $nachricht_admin = "$name mit der EMail ".$_POST['mail']." hat das Passwort resettet.";
			  $nachricht_user = "Hallo $name,\r\n\r\nFuer ihre Email: ".$_POST['mail']." wurde ein neues Passwort angefordert.\r\n\r\nIhr neues Passwort lautet: '$passwort'\r\n\r\nLiebe Grüße";
			  $header = 'From: admin@ohg2013.de' . "\r\n" .
			  'Reply-To: admin@ohg2013.de' . "\r\n" .
			  'X-Mailer: PHP/' . phpversion();

			  mail('admin@ohg2013.de', 'Passwort Aenderung', $nachricht_admin, $header);
			  mail('ashvin@gmx.net', 'Passwort Aenderung', $nachricht_admin, $header);
			  mail("$mail", 'Passwort Aenderung', $nachricht_user, $header);
			
      }else
      {
        echo '<div class="error"><span style="font-weight:bold;">FEHLER:</span><ul>'.$fehler.'</div>';
      }
}
if (!$done) {
?> 

<form class="login" method="post">
  <p>E-Mail:<br /> 
    <input type="text" maxlength="32" name="mail" id="mail" value="Email" onFocus="if (this.value=='Email') this.value='';" onblur="if(this.value=='') this.value=this.defaultValue;" size="15">
  </p>  
<br /> 
  <input id="regButton" type="submit" name="submit" value="Abschicken" />
  <p><a href="index.php">Zum Login</a></p>  
</form> 
<?php
}
?>
</div>

<?php
include ('footer.inc.php');
?>
</body> 
</html> 
 