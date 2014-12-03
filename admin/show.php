<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
require_once('mysql.inc.php');
if (check_login("show") == true)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Benutzerverwaltung</title>
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
include('menu.inc.php');
if (isset($_GET['section']))//Section ausgeben
  {
  switch ($_GET['section'])
    {
	case "mann":
      $section="mann";
      break;
	case "frau":
      $section="frau";
      break;
	case "admin":
      $section="admin";
      break;	  
    case "alle":
      $section="alle";
      break;
    case "poebel":
      $section="poebel";
      break;	  
	}
  }	
else
  {
  $section="alle";
  }  
echo '
	<div id="inhalt">
	<div id="layout_canvas">
	<div class="profilkopf"><img src="./img/benutzerverwaltung.png">Benutzerverwaltung</></div>
	<div id="loading"><img src="img/wait.gif" alt="Loading..." /></div>';
if($section=="alle")
{  
		if ($_GET["msg"] == "erfolg")
		{
		echo '<div class="success">Aktion war erfolgreich!</div>';
		}elseif ($_GET["msg"] == "fehler")
		{
		echo '<div class="error">'.$_GET["errordesc"].'</div>';
		}
		echo '
		<ul id="submenu">
			<li class="selectedmenuitem"><a href="show.php?section=alle">Alle</a></li>
			<li><a href="show.php?section=mann">Mann</a></li>
			<li><a href="show.php?section=frau">Frau</a></li>
			<li><a href="show.php?section=admin">Admins</a></li>
			<li><a href="show.php?section=poebel">Pöbel</a></li>
		</ul>
		<div class="clearfix">
		<section>
			<div id="userStats" class="clearfix">';
		$abfrage = "SELECT `freigeschaltet`,`Deleted`,`SCHUELER_ID`,`Name_ganz`,`EMail`,`ICQ`,`Geschlecht` FROM `user` ORDER BY `SCHUELER_ID` DESC";
		$ergebnis = mysql_query($abfrage, $sql);
		while ($row = mysql_fetch_object($ergebnis))
		{
				$userid = $row->SCHUELER_ID;
				if (file_exists("../images/profil/".$userid.".jpg"))//wenn Profilbild existiert, dieses übernehemn, andernfalls standard anzeigen
				{
					$profilbild="../../images/profil/".$userid.".jpg";
				}
				else
				{
					$profilbild="../../images/profil/default.jpg";
				}
				
				if ($row->freigeschaltet == 1)
				{
						$check = "Ja";
				}
				else
				{
						$check = "Nein";
				}
				if ($row->Deleted == 1) {
				echo'	
				<div class="pic">
					<a href="'.$profilbild.'" rel="lightbox" ><img src="'.$profilbild.'" alt="Profilbild" width="150" height="159" /></a>
				</div>				
				<div class="data">
					<h1>' . $row->Name_ganz . '</h1>
					<h3>' . $row->EMail . ' ' . $row->ICQ . '</h3>
					<h4><a href="../profil.php?schuelerid=' . $row->SCHUELER_ID . '">Zum Profil</a></h4>
					<div class="socialMediaLinks">						
						<a class="btn btn-small" title="Schüler editieren" href="update-show.php?edit=' . $row->SCHUELER_ID . '"><i class="icon-pencil"></i></a>
						<a class="btn btn-small btn-danger disabled" title="Schüler löschen"><i class="icon-remove icon-white"></i></a>
					</div>
					<div class="sep"></div>
					<ul class="numbers clearfix">
						<li>Freigeschaltet<strong><a href="update-show.php?toogle=' . $row->SCHUELER_ID . '">' . $check . '</a></strong></li>
						<li>Geschlecht<strong>' . $row->Geschlecht . '</strong></li>
						<li class="nobrdr">User ID<strong>' . $row->SCHUELER_ID . '</strong></li>
					</ul>
				</div>				
				';
				}else
				{		
				echo'			
				<div class="pic">
					<a href="'.$profilbild.'" rel="lightbox"><img src="'.$profilbild.'" alt="Profilbild" width="150" height="159" /></a>
				</div>				
				<div class="data">
					<h1>' . $row->Name_ganz . '</h1>
					<h3>' . $row->EMail . ' ' . $row->ICQ . '</h3>
					<h4><a href="../profil.php?schuelerid=' . $row->SCHUELER_ID . '">Zum Profil</a></h4>
					<div class="socialMediaLinks">
						<a class="btn btn-small" title="Schüler editieren" href="update-show.php?edit=' . $row->SCHUELER_ID . '"><i class="icon-pencil"></i></a>
						<a class="btn btn-small btn-danger" title="Schüler löschen" href="update-show.php?del=' . $row->SCHUELER_ID . '"><i class="icon-remove icon-white"></i></a>
					</div>
					<div class="sep"></div>
					<ul class="numbers clearfix">
						<li>Freigeschaltet<strong><a href="update-show.php?toogle=' . $row->SCHUELER_ID . '">' . $check . '</a></strong></li>
						<li>Geschlecht<strong>' . $row->Geschlecht . '</strong></li>
						<li class="nobrdr">User ID<strong>' . $row->SCHUELER_ID . '</strong></li>
					</ul>
				</div>				
				';			
				}
		}
}

if($section=="mann")
{  
		echo '
		<ul id="submenu">
			<li><a href="show.php?section=alle">Alle</a></li>
			<li class="selectedmenuitem"><a href="show.php?section=mann">Mann</a></li>
			<li><a href="show.php?section=frau">Frau</a></li>
			<li><a href="show.php?section=admin">Admins</a></li>
			<li><a href="show.php?section=poebel">Pöbel</a></li>
		</ul>
		<div class="clearfix">
		<section>
			<div id="userStats" class="clearfix">';
		$abfrage = "SELECT `freigeschaltet`,`Deleted`,`SCHUELER_ID`,`Name_ganz`,`EMail`,`ICQ`,`Geschlecht` FROM `user` WHERE `Geschlecht`='m' ORDER BY `SCHUELER_ID` DESC";
		$ergebnis = mysql_query($abfrage, $sql);
		while ($row = mysql_fetch_object($ergebnis))
		{
				$userid = $row->SCHUELER_ID;
				if (file_exists("../images/profil/".$userid.".jpg"))//wenn Profilbild existiert, dieses übernehemn, andernfalls standard anzeigen
				{
					$profilbild="../../images/profil/".$userid.".jpg";
				}
				else
				{
					$profilbild="../../images/profil/default.jpg";
				}
				
				if ($row->freigeschaltet == 1)
				{
						$check = "Ja";
				}
				else
				{
						$check = "Nein";
				}
				if ($row->Deleted == 1) {
				echo'	
				<div class="pic">
					<a href="'.$profilbild.'" rel="lightbox"><img src="'.$profilbild.'" alt="Profilbild" width="150" height="159" /></a>
				</div>				
				<div class="data">
					<h1>' . $row->Name_ganz . '</h1>
					<h3>' . $row->EMail . ' ' . $row->ICQ . '</h3>
					<h4><a href="../profil.php?schuelerid=' . $row->SCHUELER_ID . '">Zum Profil</a></h4>
					<div class="socialMediaLinks">
						<a class="btn btn-small" title="Schüler editieren" href="update-show.php?edit=' . $row->SCHUELER_ID . '"><i class="icon-pencil"></i></a>
						<a class="btn btn-small btn-danger disabled" title="Schüler löschen"><i class="icon-remove icon-white"></i></a>
					</div>
					<div class="sep"></div>
					<ul class="numbers clearfix">
						<li>Freigeschaltet<strong><a href="update-show.php?toogle=' . $row->SCHUELER_ID . '">' . $check . '</a></strong></li>
						<li>Geschlecht<strong>' . $row->Geschlecht . '</strong></li>
						<li class="nobrdr">User ID<strong>' . $row->SCHUELER_ID . '</strong></li>
					</ul>
				</div>				
				';
				}else
				{		
				echo'			
				<div class="pic">
					<a href="'.$profilbild.'" rel="lightbox"><img src="'.$profilbild.'" alt="Profilbild" width="150" height="159" /></a>
				</div>				
				<div class="data">
					<h1>' . $row->Name_ganz . '</h1>
					<h3>' . $row->EMail . ' ' . $row->ICQ . '</h3>
					<h4><a href="../profil.php?schuelerid=' . $row->SCHUELER_ID . '">Zum Profil</a></h4>
					<div class="socialMediaLinks">
						<a class="btn btn-small" title="Schüler editieren" href="update-show.php?edit=' . $row->SCHUELER_ID . '"><i class="icon-pencil"></i></a>
						<a class="btn btn-small btn-danger" title="Schüler löschen" href="update-show.php?del=' . $row->SCHUELER_ID . '"><i class="icon-remove icon-white"></i></a>
					</div>
					<div class="sep"></div>
					<ul class="numbers clearfix">
						<li>Freigeschaltet<strong><a href="update-show.php?toogle=' . $row->SCHUELER_ID . '">' . $check . '</a></strong></li>
						<li>Geschlecht<strong>' . $row->Geschlecht . '</strong></li>
						<li class="nobrdr">User ID<strong>' . $row->SCHUELER_ID . '</strong></li>
					</ul>
				</div>				
				';		
				}
		}
}

if($section=="frau")
{  
		echo '
		<ul id="submenu">
			<li><a href="show.php?section=alle">Alle</a></li>
			<li><a href="show.php?section=mann">Mann</a></li>
			<li class="selectedmenuitem"><a href="show.php?section=frau">Frau</a></li>
			<li><a href="show.php?section=admin">Admins</a></li>
			<li><a href="show.php?section=poebel">Pöbel</a></li>
		</ul>
		<div class="clearfix">
		<section>
			<div id="userStats" class="clearfix">';
		$abfrage = "SELECT `freigeschaltet`,`Deleted`,`SCHUELER_ID`,`Name_ganz`,`EMail`,`ICQ`,`Geschlecht` FROM `user` WHERE `Geschlecht`='w' ORDER BY `SCHUELER_ID` DESC";
		$ergebnis = mysql_query($abfrage, $sql);
		while ($row = mysql_fetch_object($ergebnis))
		{
				$userid = $row->SCHUELER_ID;
				if (file_exists("../images/profil/".$userid.".jpg"))//wenn Profilbild existiert, dieses übernehemn, andernfalls standard anzeigen
				{
					$profilbild="../../images/profil/".$userid.".jpg";
				}
				else
				{
					$profilbild="../../images/profil/default.jpg";
				}
				
				if ($row->freigeschaltet == 1)
				{
						$check = "Ja";
				}
				else
				{
						$check = "Nein";
				}
				if ($row->Deleted == 1) {
				echo'	
				<div class="pic">
					<a href="'.$profilbild.'" rel="lightbox"><img src="'.$profilbild.'" alt="Profilbild" width="150" height="159" /></a>
				</div>				
				<div class="data">
					<h1>' . $row->Name_ganz . '</h1>
					<h3>' . $row->EMail . ' ' . $row->ICQ . '</h3>
					<h4><a href="../profil.php?schuelerid=' . $row->SCHUELER_ID . '">Zum Profil</a></h4>
					<div class="socialMediaLinks">
						<a class="btn btn-small" title="Schüler editieren" href="update-show.php?edit=' . $row->SCHUELER_ID . '"><i class="icon-pencil"></i></a>
						<a class="btn btn-small btn-danger disabled" title="Schüler löschen"><i class="icon-remove icon-white"></i></a>
					</div>
					<div class="sep"></div>
					<ul class="numbers clearfix">
						<li>Freigeschaltet<strong><a href="update-show.php?toogle=' . $row->SCHUELER_ID . '">' . $check . '</a></strong></li>
						<li>Geschlecht<strong>' . $row->Geschlecht . '</strong></li>
						<li class="nobrdr">User ID<strong>' . $row->SCHUELER_ID . '</strong></li>
					</ul>
				</div>				
				';
				}else
				{		
				echo'			
				<div class="pic">
					<a href="'.$profilbild.'" rel="lightbox"><img src="'.$profilbild.'" alt="Profilbild" width="150" height="159" /></a>
				</div>				
				<div class="data">
					<h1>' . $row->Name_ganz . '</h1>
					<h3>' . $row->EMail . ' ' . $row->ICQ . '</h3>
					<h4><a href="../profil.php?schuelerid=' . $row->SCHUELER_ID . '">Zum Profil</a></h4>
					<div class="socialMediaLinks">
						<a class="btn btn-small" title="Schüler editieren" href="update-show.php?edit=' . $row->SCHUELER_ID . '"><i class="icon-pencil"></i></a>
						<a class="btn btn-small btn-danger" title="Schüler löschen" href="update-show.php?del=' . $row->SCHUELER_ID . '"><i class="icon-remove icon-white"></i></a>
					</div>
					<div class="sep"></div>
					<ul class="numbers clearfix">
						<li>Freigeschaltet<strong><a href="update-show.php?toogle=' . $row->SCHUELER_ID . '">' . $check . '</a></strong></li>
						<li>Geschlecht<strong>' . $row->Geschlecht . '</strong></li>
						<li class="nobrdr">User ID<strong>' . $row->SCHUELER_ID . '</strong></li>
					</ul>
				</div>				
				';	
			}
		}
}

if($section=="admin")
{  
		echo '
		<ul id="submenu">
			<li><a href="show.php?section=alle">Alle</a></li>
			<li><a href="show.php?section=mann">Mann</a></li>
			<li><a href="show.php?section=frau">Frau</a></li>
			<li class="selectedmenuitem"><a href="show.php?section=admin">Admins</a></li>
			<li><a href="show.php?section=poebel">Pöbel</a></li>
		</ul>
		<div class="clearfix">
		<section>
			<div id="userStats" class="clearfix">';
		$abfrage = "SELECT `freigeschaltet`,`Deleted`,`SCHUELER_ID`,`Name_ganz`,`EMail`,`ICQ`,`Geschlecht` FROM `user` WHERE `admin`='1' ORDER BY `SCHUELER_ID` DESC";
		$ergebnis = mysql_query($abfrage, $sql);
		while ($row = mysql_fetch_object($ergebnis))
		{
				$userid = $row->SCHUELER_ID;
				if (file_exists("../images/profil/".$userid.".jpg"))//wenn Profilbild existiert, dieses übernehemn, andernfalls standard anzeigen
				{
					$profilbild="../../images/profil/".$userid.".jpg";
				}
				else
				{
					$profilbild="../../images/profil/default.jpg";
				}
				
				if ($row->freigeschaltet == 1)
				{
						$check = "Ja";
				}
				else
				{
						$check = "Nein";
				}
				if ($row->Deleted == 1) {
				echo'	
				<div class="pic">
					<a href="'.$profilbild.'" rel="lightbox"><img src="'.$profilbild.'" alt="Profilbild" width="150" height="159" /></a>
				</div>				
				<div class="data">
					<h1>' . $row->Name_ganz . '</h1>
					<h3>' . $row->EMail . ' ' . $row->ICQ . '</h3>
					<h4><a href="../profil.php?schuelerid=' . $row->SCHUELER_ID . '">Zum Profil</a></h4>
					<div class="socialMediaLinks">
						<a class="btn btn-small" title="Schüler editieren" href="update-show.php?edit=' . $row->SCHUELER_ID . '"><i class="icon-pencil"></i></a>
						<a class="btn btn-small btn-danger disabled" title="Schüler löschen"><i class="icon-remove icon-white"></i></a>
					</div>
					<div class="sep"></div>
					<ul class="numbers clearfix">
						<li>Freigeschaltet<strong><a href="update-show.php?toogle=' . $row->SCHUELER_ID . '">' . $check . '</a></strong></li>
						<li>Geschlecht<strong>' . $row->Geschlecht . '</strong></li>
						<li class="nobrdr">User ID<strong>' . $row->SCHUELER_ID . '</strong></li>
					</ul>
				</div>				
				';
				}else
				{		
				echo'			
				<div class="pic">
					<a href="'.$profilbild.'" rel="lightbox"><img src="'.$profilbild.'" alt="Profilbild" width="150" height="159" /></a>
				</div>				
				<div class="data">
					<h1>' . $row->Name_ganz . '</h1>
					<h3>' . $row->EMail . ' ' . $row->ICQ . '</h3>
					<h4><a href="../profil.php?schuelerid=' . $row->SCHUELER_ID . '">Zum Profil</a></h4>
					<div class="socialMediaLinks">
						<a class="btn btn-small" title="Schüler editieren" href="update-show.php?edit=' . $row->SCHUELER_ID . '"><i class="icon-pencil"></i></a>
						<a class="btn btn-small btn-danger" title="Schüler löschen" href="update-show.php?del=' . $row->SCHUELER_ID . '"><i class="icon-remove icon-white"></i></a>
					</div>
					<div class="sep"></div>
					<ul class="numbers clearfix">
						<li>Freigeschaltet<strong><a href="update-show.php?toogle=' . $row->SCHUELER_ID . '">' . $check . '</a></strong></li>
						<li>Geschlecht<strong>' . $row->Geschlecht . '</strong></li>
						<li class="nobrdr">User ID<strong>' . $row->SCHUELER_ID . '</strong></li>
					</ul>
				</div>				
				';		
				}
		}
}
if($section=="poebel")
{  
		echo '
		<ul id="submenu">
			<li><a href="show.php?section=alle">Alle</a></li>
			<li><a href="show.php?section=mann">Mann</a></li>
			<li><a href="show.php?section=frau">Frau</a></li>
			<li><a href="show.php?section=admin">Admins</a></li>
			<li class="selectedmenuitem"><a href="show.php?section=poebel">Pöbel</a></li>
		</ul>
		<div class="clearfix">
		<section>
			<div id="userStats" class="clearfix">';
		$abfrage = "SELECT `SCHUELER_ID`,`Name_ganz` FROM `user` ORDER BY `SCHUELER_ID` DESC";
		$ergebnis = mysql_query($abfrage, $sql);
		while ($row = mysql_fetch_object($ergebnis))
		{
			$userid = $row->SCHUELER_ID;
			$name = $row->Name_ganz;
			echo '<table class="table table-bordered table-striped table-hover">';
			echo '<thead>
					<tr>
						<th>Schülername</th>
						<th>Pöbelbuch-Eintragungen</th>
					</tr>
				 </thead>
				 <tbody>';	
			echo '<tr>
			<td><div>'.$name.'</div></td>			
			<td><div>';			
			$abfrage1 = "SELECT `eintragstext`,`EintragsID`,`PosterID`,`postzeit` FROM `poebel_eintraege_neu` WHERE `freigeschaltet`=1 AND `DELETED`=0 AND `SchuelerID`='$userid' ORDER BY `postzeit` ASC";
			$ergebnis1 = mysql_query($abfrage1, $sql);
			while ($row1 = mysql_fetch_object($ergebnis1))
			{
				
				$eintragstext = $row1->eintragstext;
				$eintragstext_ohnehtml = strip_tags($eintragstext,'');
				echo $eintragstext_ohnehtml.' | ';
	
			}
			echo '</div></td>
			</tr>';
			echo '</tbody></table>'; 


		}
}

		echo '</div>
			</section>
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