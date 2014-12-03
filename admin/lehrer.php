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
	<title>Lehrer</title>
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
<div class="profilkopf"><img src="./img/lehrer.png">Lehrer</></div>
<div id="loading"><img src="img/wait.gif" alt="Loading..." /></div>
<div id="userStats" class="clearfix">
<?php     
    if (!empty($_GET["show"]))
	{    		
		$abfrage = "SELECT * FROM lehrer_neu";
		$ergebnis = mysql_query($abfrage, $sql);
		if ($_GET["msg"] == "erfolg")
		{
			echo '<div class="success">Aktion war erfolgreich!</div>';
		}elseif ($_GET["msg"] == "fehler")
		{
			echo '<div class="error">Fehler! Aktion war nicht erfolgreich!</div>';
		}		
		echo '<h3>Lehrersprüche</h3>';
		echo '<table class="table table-bordered table-striped table-hover">';
		echo '<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Anzahl</th>
					<th>letzter Eintrag</th>
					<th>Zeigen</th>
				</tr>
			 </thead>
			 <tbody>';
		while ($row = mysql_fetch_object($ergebnis)) 
		{     
			$teacher_id=$row->LEHRER_ID;
			$teacher=$row->Nachname;
			$count=$row->Eintraege;	
			$last=$row->letzter_Eintrag_Zeit;
         
		    echo '<tr>
         <td>'.$teacher_id.'</td>
         <td>'.$teacher.'</td>
         <td>'.$count.'</td>
         <td>'.$last.'</td>
		 <td>
			<a class="btn btn-small" title="Lehrer zeigen" href="lehrer.php?eintraege=' . $teacher_id . '">
				<i class="icon-folder-open"></i>
			</a>
		</td>
         </tr>';
		}
     	echo '</tbody></table></div></div>';              
    }elseif (!empty($_GET["eintraege"]))
	{    	
		$teacher_id = (int)$_GET["eintraege"];	
		$abfrage1 = 'SELECT * FROM lehrer_eintraege_neu WHERE `LEHRER_ID` = ' . $teacher_id;
		$ergebnis1 = mysql_query($abfrage1, $sql);	

		//get teacher name
		$abfrage2 = 'SELECT Nachname, Anrede FROM lehrer_neu WHERE `LEHRER_ID` = ' . $teacher_id;
		$ergebnis2 = mysql_query($abfrage2, $sql);	
		$row2 = mysql_fetch_object($ergebnis2);
		$gender=$row2->Anrede;
		$teacher=$row2->Nachname;
		
		echo "<p><b>Sprüche von $gender $teacher</b></p>";
		echo '<table class="table table-bordered table-striped table-hover">';
		echo '<thead>
				<tr>
					<th>ID</th>
					<th>Von</th>
					<th>Text</th>
					<th>Zeit</th>
					<th>Aktion</th>
				</tr>
			 </thead>
			 <tbody>';
		while ($row = mysql_fetch_object($ergebnis1)) 
		{     
			$entry_id=$row->Eintrags_ID;
			$poster=$row->Poster_ID;	
			$text=$row->eintragstext;
			$time=$row->Zeit;
         
			$abfrage2 = "Select `Name_ganz` From user WHERE SCHUELER_ID='$poster'";
			$ergebnis2 = mysql_query($abfrage2, $sql);
			$row1 = mysql_fetch_object($ergebnis2);
			$author = $row1->Name_ganz;
                  
		    echo '<tr>
         <td>'.$entry_id.'</td>
         <td>'.$author.'</td>
         <td>'.$text.'</td>
         <td>'.$time.'</td>
		 <td>
			<a class="btn btn-small" title="Spruch editieren" href="update-lehrer.php?edit=' . $entry_id . '">
				<i class="icon-pencil"></i>
			</a>
			<a class="btn btn-small btn-danger" title="Spruch löschen" href="update-lehrer.php?del=' . $entry_id . '">
				<i class="icon-remove icon-white"></i>
			</a>
		 </td>		 
         </tr>';
		}
     	echo '</tbody></table></div></div>';           
    }elseif (!empty($_GET["showteacher"]))
	{
		if ($_GET["msg"] == "erfolg")
		{
		echo '<div class="success">Aktion war erfolgreich!</div>';
		}elseif ($_GET["msg"] == "fehler")
		{
		echo '<div class="error">'.$_GET["errordesc"].'</div>';
		}		
		/*Kurse holen*/
		$abfrage2 = 'SELECT * FROM `lehrer_neu`';
		$ergebnis2 = mysql_query($abfrage2, $sql);
		echo '<h3>Lehrerliste</h3>';
		echo '<table class="table table-bordered table-striped table-hover">';
		echo '<thead>
				<tr>
					<th>ID</th>
					<th>Anrede</th>
					<th>Vorname</th>
					<th>Nachname</th>
					<th>Geschlecht</th>
					<th>Aktion</th>
				</tr>
			 </thead>
			 <tbody>';			
		while ($row = mysql_fetch_object($ergebnis2)) 
		{     
			$lehrer_id=$row->LEHRER_ID;
			$anrede=$row->Anrede;
			$vorname=$row->Vorname;	
			$nachname=$row->Nachname;
			$geschlecht=$row->Geschlecht;
							   
			echo '<tr>
					<td>'.$lehrer_id.'</td>
					<td>'.$anrede.'</td>
					<td>'.$vorname.'</td>
					<td>'.$nachname.'</td>
					<td>'.$geschlecht.'</td>
					 <td>
						<a class="btn btn-small" title="Lehrer editieren" href="update-lehrer.php?editteacher=' . $lehrer_id . '">
							<i class="icon-pencil"></i>
						</a>
						<a class="btn btn-small btn-danger" title="Lehrer löschen" href="update-lehrer.php?delteacher=' . $lehrer_id . '">
							<i class="icon-remove icon-white"></i>
						</a>
					 </td>					   
				</tr>';
		}
		echo '</tbody></table>';      
	}elseif (!empty($_GET["createteacher"]))
	{
		/*Kurse holen*/
		$abfrage2 = 'SELECT * FROM `kurse`';
		$ergebnis2 = mysql_query($abfrage2, $sql);
		echo '<h3>Neuen Lehrer erstellen</h3>';
		?>
				<form action="p_create-lehrer.php" method="post">
		        <table class="tabelle_randlos">
				<tbody>
					<tr>	
					 <p>Nachdem hier Lehrer erstellt wurden, können Kurse zugewiesen werden.</p>					
					</tr>
					<tr>
    	             <td>Anrede:</td>
					 <td>
						<select name="anrede"> 
							<option value="Herr">Herr</option> 
							<option value="Frau">Frau</option> 	
						</select> 					 
					 </td>
					</tr>					
					<tr>
    	             <td>Vorname:</th>
					 <td><input type="text" size="20" maxlength="20" name="vorname" value=""></td>
					</tr>
					<tr>
    	             <td>Nachname:</td>
					 <td><input type="text" size="20" maxlength="20" name="nachname" value=""></td>
					</tr>
					<tr>
    	             <td>Geschlecht:</td>
					 <td>
						<select name="geschlecht"> 
							<option value="m">Männlich</option> 
							<option value="w">Weiblich</option> 	
						</select> 					 
					 </td>
					</tr>
				</tbody> 
	            </table>
				<br><input class="button" type="submit" value="Abschicken">
				<a href="javascript:history.back()"><input class="button" type="button" name="cancel" value="Abbrechen" /></a>
				</form>	
		<?php
		while ($row = mysql_fetch_object($ergebnis2)) 
		{     

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
