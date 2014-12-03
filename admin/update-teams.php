<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
if (check_login("teams") == true)
{
	include('mysql.inc.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Gruppen</title>
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
			$team_id = (int)$_GET["del"];
			$abfrage = 'DELETE FROM `teams` WHERE `TEAM_ID` =' . $team_id . ' LIMIT 1 ;';
			if (mysql_query($abfrage, $sql) == true)
			{
				header('Location: ./teams.php?show=1&msg=erfolg');
			}
			else
			{
				header('Location: ./teams.php?show=1&msg=fehler');
			}
	}elseif (!empty($_GET["delcourse"]))
	{
			$course_id = (int)$_GET["delcourse"];
			$abfrage = 'DELETE FROM `kurse` WHERE `FACH_ID` =' . $course_id . ' LIMIT 1 ;';
			if (mysql_query($abfrage, $sql) == true)
			{
				header('Location: ./teams.php?showcourse=1&msg=erfolg');
			}
			else
			{
				header('Location: ./teams.php?showcourse=1&msg=fehler&errordesc=Aktion ist fehlgeschlagen');
			}			
	}elseif (!empty($_GET["edit"]))
	{
		$team_id = (int)$_GET["edit"];
		$abfrage1 = 'SELECT * FROM `teams` WHERE `TEAM_ID` = ' . $team_id;
		$ergebnis1 = mysql_query($abfrage1, $sql);
		$row = mysql_fetch_object($ergebnis1);
		
		$name = $row->team_name;
		
		echo '<div class="profilkopf"><img src="./img/teams.png">Team editieren</></div>
			<div id="userStats" class="clearfix">';   				
		echo '<form action="p_edit-teams.php" method="post">
			<table class="tabelle_randlos">
			<tr>
				<td></td>
				<td><p><input style="visibility:hidden; display:none;" type="hidden" size="6" maxlength="6" name="id" value="' . $team_id . '" readonly"></td>
			</tr>	
			<tr>
				<td>Team Name</td>    
				<td><p><input type="text" size="20" maxlength="20" name="name" value="' . $name . '""></td>		
				<td>z.B.: <span class="label label-info">Abilogokomitee</span></td>	
			</tr>
			</table><br><input class="button" type="submit" value="Abschicken"></div>';     
	}elseif (!empty($_GET["editcourse"]))
	{
		$course_id = (int)$_GET["editcourse"];
		$abfrage1 = 'SELECT * FROM `kurse` WHERE `FACH_ID` = ' . $course_id;
		$ergebnis1 = mysql_query($abfrage1, $sql);
		$row = mysql_fetch_object($ergebnis1);
		
		$fach_kurz = $row->fach_kurz;
		$fach_lang = $row->fach_lang;
		$lehrer = $row->lehrer;
		
		$abfrage_lehrer="SELECT LEHRER_ID,Nachname FROM lehrer_neu ORDER BY Nachname";
		$ergebnis_lehrer = mysql_query($abfrage_lehrer);
		
		echo '<div class="profilkopf"><img src="./img/teams.png">Kurs editieren</></div>
			<div id="userStats" class="clearfix">';   				
		echo '<form action="p_edit-teams_kurs.php" method="post">
			<table class="tabelle_randlos">
			<tr>
				<td></td>
				<td><p><input style="visibility:hidden; display:none;" type="hidden" size="6" maxlength="6" name="id" value="' . $course_id . '" readonly"></td>
			</tr>	
			<tr>		
				<p>Bei den Fach-Feldern darauf achten, dass nach Grundkurs (GK) und Leistungskurs (LK) unterschieden wird!</p>
				<td>Fach kurz</td>  
				<td><input type="text" size="20" maxlength="8" name="fach_kurz" value="' . $fach_kurz . '"></td>		
				<td>z.B.: <span class="label label-info">PH LK1</span></td>
			</tr>
			<tr>		
				<td>Fach lang</td> 
				<td><input type="text" size="20" maxlength="20" name="fach_lang" value="' . $fach_lang . '"></td>	
				<td>z.B.: <span class="label label-info">Physik LK 1</span></td>
			</tr>
			<tr>
				<td>Lehrer</td>    
				<td>
					<select name="lehrer">';
					echo '<option value="">&mdash;</option>';
					while($row_lehrer=mysql_fetch_object($ergebnis_lehrer))
					{
						if (($row_lehrer->Nachname) == ($lehrer))
						{
							echo '<option selected="selected" value="'.$row_lehrer->Nachname.'">'.$row_lehrer->Nachname.'</option>';
						}else
						{
							echo '<option value="'.$row_lehrer->Nachname.'">'.$row_lehrer->Nachname.'</option>';						
						}
					}	
					echo '</select>
				</td>	 
			</tr>			
			</table><br><input class="button" type="submit" value="Abschicken">
			<a href="javascript:history.back()"><input class="button" type="button" name="cancel" value="Abbrechen" /></a></div>';     			
    }elseif (!empty($_GET["create"]))
	{
		echo '<div class="profilkopf"><img src="./img/teams.png">Team anlegen</></div>
			<div id="userStats" class="clearfix">';   
		echo '<form action="p_create-teams.php" method="post">
			<table tabelle_randlos>
				<tr>
					<td></td>
					<td><p><input style="visibility:hidden; display:none;" type="hidden" size="6" maxlength="6" name="id" value="id" readonly"></td>
				</tr>
				<tr>		
					<td>Team Name</td>  
					<td><input type="text" size="50" maxlength="80" name="name" value=""></td>	
					<td>z.B.: <span class="label label-info">Abilogokomitee</span></td>		
				</tr>
			</table><br><input class="button" type="submit" value="Abschicken">
			<a href="javascript:history.back()"><input class="button" type="button" name="cancel" value="Abbrechen" /></a></form></div>';
    }elseif (!empty($_GET["createcourse"]))
	{
		$abfrage="SELECT LEHRER_ID,Nachname FROM lehrer_neu ORDER BY Nachname";
		$ergebnis = mysql_query($abfrage);

		echo '<div class="profilkopf"><img src="./img/teams.png">Kurs anlegen</></div>
			<div id="userStats" class="clearfix">';   
		echo '<form action="p_create-teams_kurs.php" method="post">
			<table tabelle_randlos>
				<tr>		
					<p>Bei den Fach-Feldern darauf achten, dass nach Grundkurs (GK) und Leistungskurs (LK) unterschieden wird!<br>Bevor Sie einen Lehrer auswählen können, müssen Sie erst welche erstellen!</p>
					<td>Fach kurz</td>  
					<td><input type="text" size="20" maxlength="8" name="fach_kurz" value=""></td>		
					<td>z.B.: <span class="label label-info">PH LK1</span></td>
				</tr>
				<tr>		
					<td>Fach lang</td> 
					<td><input type="text" size="20" maxlength="20" name="fach_lang" value=""></td>	
					<td>z.B.: <span class="label label-info">Physik LK 1</span></td>
				</tr>
				<tr>		
					<td>Lehrer</td>  					
					<td>
						<select name="lehrer">';
						echo '<option value="">&mdash;</option>';
						while($row=mysql_fetch_object($ergebnis))
						{
							echo '<option value="'.$row->LEHRER_ID.'">'.$row->Nachname.'</option>';
						}	
						echo '</select>
					</td>				
				</tr>					
			</table>
			<br><input class="button" type="submit" value="Abschicken">
			<a href="javascript:history.back()"><input class="button" type="button" name="cancel" value="Abbrechen" /></a></form>
			</div>';
    }  
	echo '</div></div>';
	include('footer.inc.php');	  
}
else
{
	header('Location: admin.php?berechtigung=0');
}

?>