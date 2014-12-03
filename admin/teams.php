<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
if (check_login("teams") == true)
{
	include('mysql.inc.php');   		
	if (!empty($_GET["show"]))
	{  
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Teamverwaltung</title>
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
	<?php include('menu.inc.php'); ?>
	<div id="inhalt">
	<div id="layout_canvas">
	<div class="profilkopf"><img src="./img/teams.png">Teams</></div>
	<div id="loading"><img src="img/wait.gif" alt="Loading..." /></div>
	<div id="userStats" class="clearfix">
		<?php  	
		$abfrage='SELECT * FROM teams';
		$ergebnis = mysql_query($abfrage, $sql);
		if ($_GET["msg"] == "erfolg")
		{
			echo '<div class="success">Aktion war erfolgreich!</div>';
		}elseif ($_GET["msg"] == "fehler")
		{
			echo '<div class="error">Fehler! Aktion war nicht erfolgreich!</div>';
		}				
		echo '<table class="table table-bordered table-striped table-hover">';
		echo '<thead>
				<tr>
					<th>ID</th>
					<th>Team Name</th>
					<th>Aktion</th>
				</tr>
			 </thead>
			 <tbody>';
		while ($row = mysql_fetch_object($ergebnis)) 
		{  
			$team_id = $row->TEAM_ID;
			$team_name = $row->team_name;
         
			echo '<tr>
			<td><div>'.$team_id.'</div></td>
			<td><div>'.$team_name.'</div></td>
			<td>
				<a class="btn btn-small" title="Umfrage editieren" href="update-teams.php?edit=' . $team_id . '"><i class="icon-pencil"></i></a>
				<a class="btn btn-small btn-danger" title="Umfrage löschen" href="update-teams.php?del=' . $team_id . '"><i class="icon-remove icon-white"></i></a>				
			</td>
		  </tr>';
		}
		echo '</tbody></table>';        
	}elseif (!empty($_GET["showcourse"]))
	{
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Kursverwaltung</title>
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
	<?php include('menu.inc.php'); ?>
	<div id="inhalt">
	<div id="layout_canvas">
	<div class="profilkopf"><img src="./img/teams.png">Kurse</></div>
	<div id="loading"><img src="img/wait.gif" alt="Loading..." /></div>
	<div id="userStats" class="clearfix">
		<?php  	
		if ($_GET["msg"] == "erfolg")
		{
		echo '<div class="success">Aktion war erfolgreich!</div>';
		}elseif ($_GET["msg"] == "fehler")
		{
		echo '<div class="error">'.$_GET["errordesc"].'</div>';
		}		
		/*Kurse holen*/
		$abfrage2 = 'SELECT * FROM `kurse`';
		$ergebnis2 = mysql_query($abfrage2, $sql);
		echo '<h3>Kurse</h3>';
		echo '<table class="table table-bordered table-striped table-hover">';
		echo '<thead>
				<tr>
					<th>ID</th>
					<th>Betrifft</th>
					<th>Fach</th>
					<th>Lehrer</th>
					<th>Aktion</th>
				</tr>
			 </thead>
			 <tbody>';		
		while ($row = mysql_fetch_object($ergebnis2)) 
		{     
			$kurs_id=$row->FACH_ID;
			$fach=$row->fach_lang;
			$teacher=$row->lehrer;	
							   
			echo '<tr>
			<td>'.$kurs_id.'</td>
			<td>k'.$kurs_id.'</td>
			<td>'.$fach.'</td>
			<td>'.$teacher.'</td>
			<td>
				<a class="btn btn-small" title="Kurs editieren" href="update-teams.php?editcourse=' . $kurs_id . '">
					<i class="icon-pencil"></i>
				</a>
				<a class="btn btn-small btn-danger" title="Kurs löschen" href="update-teams.php?delcourse=' . $kurs_id . '">
					<i class="icon-remove icon-white"></i>
				</a>
			</td>					
			</tr>';
		}
		echo '</tbody></table>';  	
	}
	echo '</div></div></div>';  
	include('footer.inc.php'); 
}
else
{
	header('Location: admin.php?berechtigung=0');
}
		 
?>