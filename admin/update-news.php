<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
if (check_login("news") == true)
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
<script language="javascript" type="text/javascript" src="../tinymce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">

tinyMCE.init({
	mode : "textareas",
	language: "de",
	theme : "advanced",
	plugins : "emotions,media",
	theme_advanced_buttons1 :"bold,italic,underline,strikethrough,|,sub,sup,|,blockquote",
	theme_advanced_buttons2 :"charmap,emotions,image,media,|,cleanup,help",
	theme_advanced_buttons3 :"",
	verify_html : true
});
</script>
</head>	
<body>
<?php include('menu.inc.php'); ?>
<div id="inhalt">
<div id="layout_canvas">
<?php        		
		if (!empty($_GET["del"]))
		{
			echo '<div class="profilkopf">Mitteilungen löschen</div>';
			$news_id = (int)$_GET["del"];
			$abfrage = 'DELETE FROM `news` WHERE `news_ID` =' . $news_id . ' LIMIT 1 ;';
			if (mysql_query($abfrage, $sql) == true)
		    {
				header('Location: ./news.php?manage=1&msg=erfolg');
		    }
		    else
		    {
				header('Location: ./news.php?manage=1&msg=fehler');
		    }
		}elseif (!empty($_GET["edit"]))
		echo '<div class="profilkopf"><img src="./img/nachricht.png">Mitteilungen editieren</></div>
		<div id="userStats" class="clearfix">';
		{
				$news_id = (int)$_GET["edit"];
				$abfrage1 = 'SELECT * FROM `news` WHERE `news_ID` = ' . $news_id;
				$ergebnis1 = mysql_query($abfrage1, $sql);
				$row = mysql_fetch_object($ergebnis1);

				$poster = $row->poster_ID;
				$topic = $row->Thema;
				$text = $row->Text;
				       				
				echo '<form action="p_edit-news.php" method="post">
		  <table class="tabelle_randlos">
  		    <tr>
    	     <td></td>
			 <td><p><input style="visibility:hidden; display:none;" size="6" maxlength="6" name="id" value="' . $news_id . '" readonly"></td>
			</tr> 
			<tr> 
    	     <td>Thema</td>
			 <td><input type="text" size="30" maxlength="30" name="topic" value="' . $topic . '"></td>
			</tr>
			<tr>
    	     <td>Text</td>  
			 <td><textarea name="text" cols="1" rows="10" wrap="soft">' . $text . '</textarea></td> 
  		 	</tr>
	    </table><br><input class="button" type="submit" value="Abschicken">';     
		}
	echo '</div></div></div>';
	include('footer.inc.php');	   
}
else
{
	header('Location: admin.php?berechtigung=0');
}

?>