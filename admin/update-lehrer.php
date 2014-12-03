<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
if (check_login("lehrer") == true)
{
	include('mysql.inc.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Lehrersprüche</title>
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
			$entry_id = (int)$_GET["del"];
			$abfrage = 'DELETE FROM `lehrer_eintraege_neu` WHERE `Eintrags_ID` =' . $entry_id . ' LIMIT 1 ;';
			if (mysql_query($abfrage, $sql) == true)
		    {
				header('Location: ./lehrer.php?show=1&msg=erfolg');  
		    }
		    else
		    {
				header('Location: ./lehrer.php?show=1&msg=fehler');
		    }
		}elseif (!empty($_GET["edit"]))
		{
			$entry_id = (int)$_GET["edit"];
			$abfrage1 = 'SELECT * FROM `lehrer_eintraege_neu` WHERE `Eintrags_ID` = ' . $entry_id;
			$ergebnis1 = mysql_query($abfrage1, $sql);
			$row = mysql_fetch_object($ergebnis1);
			
			$text = $row->eintragstext;
			
			echo '<div class="profilkopf"><img src="./img/lehrer.png">Lehrerspruch editieren</></div>';
			echo '<div id="userStats" class="clearfix">';			
			echo '<form action="p_edit-lehrer.php" method="post">
			<table class="tabelle_randlos">
				<tr>
					<td></td>
					<td><p><input style="visibility:hidden; display:none;" type="hidden" size="6" maxlength="6" name="id" value="' . $entry_id . '" readonly"></td>
				</tr>
				<tr>		
					<td>Text</td>   
					<td><textarea name="text" cols="40" rows="10" wrap="soft">' . $text . '</textarea></td>			 
				</tr>
			</table>
			<br>
			<input class="button" type="submit" value="Abschicken">';     
		}
		elseif (!empty($_GET["del"]))
		{
			$entry_id = (int)$_GET["del"];
			$abfrage = 'DELETE FROM `lehrer_eintraege_neu` WHERE `Eintrags_ID` =' . $entry_id . ' LIMIT 1 ;';
			if (mysql_query($abfrage, $sql) == true)
		    {
				header('Location: ./lehrer.php?show=1&msg=erfolg');  
		    }
		    else
		    {
				header('Location: ./lehrer.php?show=1&msg=fehler');
		    }
		}
		elseif (!empty($_GET["delteacher"]))
		{
			$lehrer_id = (int)$_GET["delteacher"];
			$abfrage = 'DELETE FROM `lehrer_neu` WHERE `LEHRER_ID` =' . $lehrer_id . ' LIMIT 1 ;';
			if (mysql_query($abfrage, $sql) == true)
		    {
				header('Location: ./lehrer.php?showteacher=1&msg=erfolg');  
		    }
		    else
		    {
				header('Location: ./lehrer.php?showteacher=1&msg=fehler');
		    }
		}elseif (!empty($_GET["editteacher"]))
		{
			$lehrer_id = (int)$_GET["editteacher"];
			$abfrage1 = 'SELECT * FROM `lehrer_neu` WHERE `LEHRER_ID` = ' . $lehrer_id;
			$ergebnis1 = mysql_query($abfrage1, $sql);
			$row = mysql_fetch_object($ergebnis1);
			
			$anrede = $row->Anrede;
			$vorname = $row->Vorname;
			$nachname = $row->Nachname;
			$geschlecht = $row->Geschlecht;
			
			$salutation_active = array("", ""); //Make x amount of blank fields, where x is the amount of options
			if($anrede == "Herr"){
				$salutation_active[0] = "selected='selected'";
			}elseif($anrede == "Frau"){
				$salutation_active[1] = "selected='selected'";
			}		
			
			$gender_active = array("", ""); //Make x amount of blank fields, where x is the amount of options
			if($geschlecht == "m"){
				$gender_active[0] = "selected='selected'";
			}elseif($geschlecht == "w"){
				$gender_active[1] = "selected='selected'";
			}						
			?>
			<div class="profilkopf"><img src="./img/lehrer.png">Lehrer editieren</></div>
			<div id="userStats" class="clearfix">
			<form action="p_edit-lehrer_person.php" method="post">
			  <table class="tabelle_randlos">
				<tr>
				 <td></td>
				 <td><input style="visibility:hidden; display:none;" size="3" maxlength="3" name="id" value="<?php echo $lehrer_id ?>" readonly"></td>
				</tr> 
				<tr> 
				 <td>Anrede:</td>
				 <td>
					<select name="anrede"> 
						<option <?php echo $salutation_active[0]; ?> value="Herr">Herr</option> 
						<option <?php echo $salutation_active[1]; ?> value="Frau">Frau</option> 
					</select> 					 
				 </td>
				</tr>
				<tr>
				 <td>Vorname:</td>  
				 <td><input type="text" size="30" maxlength="30" name="vorname" value="<?php echo $vorname ?>"></td> 
				</tr>
				<tr>
				 <td>Nachname:</td>  
				 <td><input type="text" size="30" maxlength="30" name="nachname" value="<?php echo $nachname ?>"></td> 
				</tr>
				<tr>
				 <td>Geschlecht:</td>  
				 <td>
					<select name="geschlecht"> 
						<option <?php echo $gender_active[0]; ?> value="m">Männlich</option> 
						<option <?php echo $gender_active[1]; ?> value="w">Weiblich</option> 
					</select> 					 
				 </td>
				</tr>				
			</table><br><input class="button" type="submit" value="Abschicken">
			<?php
		}		
	echo '</div></div></div>';
	include('footer.inc.php');	  
}
else
{
	header('Location: admin.php?berechtigung=0');
}

?>