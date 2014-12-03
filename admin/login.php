<?php
$msg = $_GET["msg"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Login</title>
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
	<script src="js/jquery-1.7.2.js"></script>
	<script src="js/lightbox.js"></script>
</head>
<body class="login">
<div id="loginbox">
	<form action="p_login.php" autocomplete="off" method="post">			  
	    <input class="loginfield" id="benutzer" name="name" autocomplete="off" type="text" onblur="if (this.value=='') this.value=this.defaultValue;" onfocus="if (this.value=='Benutzername') this.value='';" value="Benutzername"/>
	  	<br>
	    <input class="loginfield" id="passwort" name="password" type="password" onblur="if (this.value=='') this.value=this.defaultValue;" onfocus="if (this.value=='Geheimcode') this.value='';" value="Geheimcode" /> 
		<br><br>
		<button class="button" type="submit">Daten absenden</button>
		<br>
	  
	</form>
	<?php
	//check ob logout aufgerufen wurde
	if (!empty($_GET['logout']))
	{
			if ($_GET['logout'] == 1)
			{	
				/*setcookie("stufenadmin", " ", time() - 60 * 60 * 24 * 30); // 30 Tage
				setcookie("stufenuser", " ", time() - 60 * 60 * 24 * 30);*/
				session_start();
				session_unset();
				$_SESSION=array();
				$_SESSION["logged_in"]=FALSE;		

				if ($_GET["session"] == "timeout")
				{
					echo '<div class="error">Ihre Session ist abgelaufen. Bitte melden Sie sich erneut an!</div>';
				}elseif ($_GET["msg"] == "erfolg")
				{
					echo '<div class="success">Sie haben sich erfolgreich abgemeldet!</div>';
				}					
				
				//header('Location: login.php');
			}
	}

	
	if (!empty($msg))//Aufruf der Seite nach fehlerhaftem Login
	  {
	  	switch ($msg)
		{
				case "erfolgreich": 
						echo '<div class="error">Login war erfolgreich.</div>';
						break;
				case "fehlgeschlagen":
						echo '<div class="error">E-Mail / Name oder Passwort ist falsch.</div>';
						break;
				case "ausfuellen":
						echo '<div class="error">Bitte alle Felder ausfüllen.</div>';
						break;
		}
	  } 
?>	
  </div>	  		
<?php include('footer.inc.php'); ?>
