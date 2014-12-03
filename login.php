<?php
include ('includes.inc.php');
session_start();

if ((isset ($_SESSION["logged_in"])) and ($_SESSION["logged_in"]==TRUE))//überprüft, ob Nutzer eingeloggt ist
  {
	header('Location: ./framework.php?id=index');
  }

$fehler=FALSE;	
if (isset($_POST['benutzer']))//wenn Logindaten über POST gesendet, dann überprüfen
  {
  $benutzer=mysql_real_escape_string($_POST['benutzer']);
  $passwort=mysql_real_escape_string($_POST['passwort']);
  $abfrage = "SELECT * FROM user WHERE (Name_ganz LIKE '$benutzer' OR Name_kurz LIKE '$benutzer' OR Email LIKE '$benutzer') AND freigeschaltet='1'";

  $ergebnis = mysql_query($abfrage);
  if (mysql_num_rows($ergebnis)>0)
    {
    $row= mysql_fetch_object($ergebnis);
	if (md5($passwort)==$row->Passwort)//Passwort-Prüfsumme vergleichen; wenn gültig zur indexseite
	  {
	  $_SESSION["user_id"]=$row->SCHUELER_ID;
	  $_SESSION["user_name"]=$row->Name_ganz;
	  $_SESSION["logged_in"]=TRUE;
	  header('Location: ./framework.php?id=index');
	  }
	else//ungültige login-kombi
	  {
	  $fehler=TRUE;
	  }
	}
  else//benutzername fehlerhaft
    {
	$fehler=TRUE;
	}
  }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Login <?php  echo $seitentitel;?></title>
<link rel="icon" 
      type="image/png" 
      href="images/favicon.ico">
<link rel="stylesheet" type="text/css" href="css.php" />
<link rel="stylesheet" type="text/css" href="styles/login.css" />
<script type="text/javascript" src="js/mootools.js"></script>
<script type="text/javascript" src="js/login.js"></script>
<script type="text/javascript">
	var time=0;
	var t=0;
	function shake(){
		var helpvar = Math.floor(Math.random()*21)+52;
		var helpvary = Math.floor(Math.random()*11)+1;
		
		document.getElementById('shakebox').style.paddingLeft = helpvar + 'px';
		document.getElementById('shakebox').style.paddingTop = helpvary + 'px';
		helpvary=136-helpvary;
		document.getElementById('shakebox').style.height = helpvary+'px';
		time++;
		if (time<50){
			t=setTimeout(shake,5);
		}
		else {
			document.getElementById('shakebox').style.paddingLeft = '62px';
			document.getElementById('shakebox').style.paddingTop =  '6px';
			document.getElementById('shakebox').style.height =  '130px';
		}
		
	}
</script>	
</head>
<?php
 echo '<body';
	if ($fehler)
		echo ' onload="shake()"';
 echo ' class="login">';
?>
<div id="main_login">
<div id="login_logo">
</div>
<div id="shakebox">
<div id="loginbox">
		<form action="login.php" method="post">	
			<ul id="loginlist">
			<li id="listitemuser">
			<input id="benutzer" name="benutzer" type="text"  value="Mafiosi" onFocus="if (this.value=='Mafiosi') this.value='';" onblur="if(this.value=='') this.value=this.defaultValue;" />
			</li>
			<li id="listitempw">
				<input id="passwort" name="passwort" type="password"  value="xxxxxx" onFocus="if (this.value=='xxxxxx') this.value='';" onblur="if(this.value=='') this.value=this.defaultValue;" /> 
				<button id="regButton" type="submit"></button>
			</li>
			</ul>
			<a id="extender" class="extender" onclick="document.getElementById('pwbox').style.display = 'inherit'; document.getElementById('extender').style.display = 'none'"><hr><hr></a>
		</form>
</div>
</div>
	<?php
	if (isset($_GET["fehler"]))//Aufruf der Seite nach fehlerhaftem Login
	  {
	  }
	 
	?>
	<div id="pwbox" class="sprechblase"><a onclick="document.getElementById('pwbox').style.display = 'none'; document.getElementById('extender').style.display = 'inline'"><img class="closeimage" src="styles/img/close.png"></a><b>Passwort vergessen?</b><br><p>Dieses Forum ist ausschließlich für Schüler der MSS13 (2013) am Otto-Hahn-Gymnasium Landau eingerichtet.</p><table style="width:100%; text-align:center"><tr><td style="width:50%;"><a href="forgot.php">Passwort vergessen</a></td><td style="width:50%;"><a href= "reg.php">Registrieren</a></td></tr></table></div>
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

