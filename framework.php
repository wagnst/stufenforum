<?php
include('sessiontest.inc.php');
include('usefulfunctions.inc.php');
if (isset($_GET['id'])){
	$site_url = $_GET['id'];
	}
else {
	$site_url = 'index';
	}
$url_filename="startseite.php";
switch($site_url){
	case "forum":
		$url_filename="forum.php";
		break;
	case "gkontakt":
		$url_filename="gkontakt.php";
		break;
	case "gruppe":
		$url_filename="gruppe.php";
		break;
	case "impressum":
		$url_filename="impressum.php";
		break;
	case "kalender":
		$url_filename="kalender.php";
		break;
	case "kursliste":
		$url_filename="kursliste.php";
		break;
	case "lehrer":
		$url_filename="lehrer.php";
		break;
	case "livesuche":
		$url_filename="livesuche.php";
		break;
	case "news":
		$url_filename="news.php";
		break;
	case "poebel":
		$url_filename="poebel.php";
		break;
	case "profil":
		$url_filename="profil.php";
		break;
	case "profiledit":
		$url_filename="profiledit.php";
		break;
	case "teamliste":
		$url_filename="teamliste.php";
		break;
	case "thema":
		$url_filename="thema.php";
		break;
	case "thema_beitrag_loeschen":
		$url_filename="thema_beitrag_delete.php";
		break;
	case "thema_neu":
		$url_filename="thema_neu.php";
		break;
	case "umfrage":
		$url_filename="umfrage.php";
		break;
	case "umfragen":
		$url_filename="umfragen.php";
		break;
	case "zungen":
		$url_filename="zungen.php";
		break;
	
}

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" 
      type="image/png" 
      href="images/favicon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=ANSI">
<script type="text/javascript" src="js/show_hide.js"></script>
<?php
	echo $style;
  ?>
</head>
<body>
<?php
include ('topmenu.inc.php');
//include ('bottommenu.inc.php');
?>
<div id="main">
	<?php
		include('header.inc.php');
	?>
	<div id="inhalt">
		<?php
			include($url_filename);
		?>
	</div>
</div>
<?php
include ('footer.inc.php');
?>

</body>
</html>