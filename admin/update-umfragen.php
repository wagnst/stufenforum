<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
if ((check_login("umfragen") == true) OR (check_login("umfrageauswertung") == true))
{
	include('mysql.inc.php');
	if (!empty($_GET["del"]))
	{
		if (check_login("umfragen") == true)
		{
			$umfrage_id = (int)$_GET["del"];
			$abfrage = 'DELETE FROM `umfragen` WHERE `Umfrage_ID` = ' . $umfrage_id . ' LIMIT 1;';
			if (mysql_query($abfrage, $sql) == true)
			{
				header('Location: ./umfragen.php?manage=1&msg=erfolg');
			}else
			{
				header('Location: ./umfragen.php?manage=1&msg=fehler&errordesc=Die Aktion war nicht erfolgreich');
			}
		}else
		{
			header('Location: admin.php?berechtigung=0');
		}
    }elseif (!empty($_GET["auswertung"]))
	{  	
		if ((check_login("umfragen") == true) OR (check_login("umfrageauswertung") == true))
		{	
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
<script type="text/javascript" src="js/show_hide.js"></script>
<script language="javascript">
function testCustom(selObj) {
	if(selObj.options[selObj.selectedIndex].value == '8' || selObj.options[selObj.selectedIndex].value == '7' || selObj.options[selObj.selectedIndex].value == '10')
	{
	for (var i = 0; i < document.getElementsByName("antworten").length; i++) {
		//Show the textbox
		document.getElementsByName("antworten")[i].style.visibility = 'visible';
		document.getElementsByName("antworten")[i].style.display = '';
		document.getElementsByName("label_antworten")[i].style.visibility = 'visible';
		document.getElementsByName("label_antworten")[i].style.display = '';
	}
	}
	else
	{
	for (var i = 0; i < document.getElementsByName("antworten").length; i++) {
		//Hide the textbox
		document.getElementsByName("antworten")[i].style.visibility =  'hidden';
		document.getElementsByName("antworten")[i].style.display = 'none';
		document.getElementsByName("label_antworten")[i].style.visibility =  'hidden';
		document.getElementsByName("label_antworten")[i].style.display = 'none';		
	}
	}
 }
</script>
</head>	
<body>
<?php include('menu.inc.php'); ?>
<div id="inhalt">
<div id="layout_canvas">
		<?php		  		
			$umfrage_id = (int)$_GET["auswertung"];
			$Stimmen="Select * From umfrageergebnisse WHERE Umfrage_ID='$umfrage_id'";
			$ergebnis = mysql_query($Stimmen, $sql);
			
			$query="Select `Text` From umfragen WHERE Umfrage_ID='$umfrage_id'";
			$result = mysql_query($query, $sql);
			while (	$row1 = mysql_fetch_object ($result))
			{  
				$umfrage_text = $row1->Text;
			}	
			echo '<div class="profilkopf"><img src="img/umfrageverwaltung.png"> Umfrageergebnisse für Umfrage "'.$umfrage_text.'"</></div>
			<div id="userStats" class="clearfix">';
			if ($_GET["msg"] == "erfolg")
			{
				echo '<div class="success">Aktion war erfolgreich!</div>';
			}elseif ($_GET["msg"] == "fehler")
			{
				echo '<div class="error">'.$_GET["errordesc"].'</div>';
			}	
			echo '
				<h3>Platzierungen</h3>';
			echo '<table class="table table-bordered table-striped table-hover">';
			echo '<thead>
					<tr>
						<th>Platzierung</th>
						<th>Schüler(in)</th>
						<th>Anzahl Stimmen</th>
					</tr>
				 </thead>
				 <tbody>';					
			$i=1;
			$abfrage1="SELECT `Stimme`, COUNT(Stimme) AS `Anzahl` FROM `umfrageergebnisse` WHERE `Umfrage_ID` = '$umfrage_id' GROUP BY `Stimme` ORDER BY `Anzahl` DESC LIMIT 10";
			$ergebnis1 = mysql_query($abfrage1);
			while($row1=mysql_fetch_object($ergebnis1))
			{
				switch ($i) 
				{
				case 1: 
					echo '<tr><td><h4>Platz '.$i.': </h4><img src="./img/gold.png"></td>';
					echo "<td>$row1->Stimme <b>($row1->Anzahl)</b></td>";
					echo "<td><b>$row1->Anzahl</b></td></tr>";
					break;
				case 2:
					echo '<tr><td><h4>Platz '.$i.': </h4><img src="./img/silber.png"></td>';
					echo "<td>$row1->Stimme <b>($row1->Anzahl)</b></td>";
					echo "<td><b>$row1->Anzahl</b></td></tr>";
					break;
				case 3: 
					echo '<tr><td><h4>Platz '.$i.': </h4><img src="./img/bronze.png"></td>';	
					echo "<td>$row1->Stimme <b>($row1->Anzahl)</b></td>";
					echo "<td><b>$row1->Anzahl</b></td></tr>";
					break;				
				default: 
					echo '<tr><td><h4>Platz '.$i.': </h4></td>';	
					echo "<td>$row1->Stimme <b>($row1->Anzahl)</b></td>";
					echo "<td><b>$row1->Anzahl</b></td></tr>";
					break;
				}
			$i++;
			}	
			echo '</tbody></table>';	
			// draw pie
			include "./libchart/classes/libchart.php";
			$chart = new VerticalBarChart(600, 300);	
			
			$abfrage2="SELECT `Stimme`, COUNT(Stimme) AS `Anzahl` FROM `umfrageergebnisse` WHERE `Umfrage_ID` = '$umfrage_id' GROUP BY `Stimme` ORDER BY `Anzahl` DESC LIMIT 5";
			$ergebnis2 = mysql_query($abfrage2);
			$size = 0;
			while($row2 = mysql_fetch_array($ergebnis2))
			{
					$pie_stimme[$size] = $row2['Stimme'];
					$pie_anzahl[$size] = $row2['Anzahl'];
					$size = $size + 1;
			}		
			$chart = new PieChart(600, 300);

			$dataSet = new XYDataSet();
			for($i=0; $i < $size; $i++) {
				$dataSet->addPoint(new Point($pie_stimme[$i], $pie_anzahl[$i]));
			}			
			$chart->setDataSet($dataSet);

			$chart->setTitle($umfrage_text);
			$chart->render('./img/generated/'.$umfrage_id.'umfrage'.$umfrage_id.'.png');		
			echo '<img align="middle" src="./img/generated/'.$umfrage_id.'umfrage'.$umfrage_id.'.png">';
		}else
		{
			header('Location: admin.php?berechtigung=0');
		}	
		if (check_login("umfragen") == true)
		{		
		?>
			<div class="show-hide">
				<a href="javascript:toggle('show-hide-content')"><h3>Abgegebene Stimmen</h3><br /></a>
			</div>		
			<div id="show-hide-content" class="show-hide-content" style="display:	none;">
		<?php
			echo '<table class="table table-bordered table-striped table-hover">';
			echo '<thead>
					<tr>
						<th>Voter</th>
						<th>Stimme</th>
						<th>Aktion</th>
					</tr>
				 </thead>
				 <tbody>';
			while (	$row = mysql_fetch_object ($ergebnis))
				{
				sort($row);
				$stimme = $row->stimme;
				$voter = $row->Voter_ID;
				$abfrage1 = "Select `Name_ganz` From user WHERE SCHUELER_ID='$voter'";
				$query = mysql_query($abfrage1, $sql);
				$row1 = mysql_fetch_object($query);
				$name = $row1->Name_ganz;

				echo '<tr>
				<td>'.$name.'</td>
				<td>'.$stimme.'</td>
				<td><div align="center"><a class="btn btn-small btn-danger" title="Stimme löschen" href="update-umfragen.php?votedel=1&umfrageid='.$umfrage_id.'&voterid='.$voter.'"><i class="icon-remove icon-white"></i></a></div></td>	
				</tr>';
				}
				echo '</tbody></table>';
		}	
		echo '</div></div></div></div>';
	}elseif (!empty($_GET["toogle"]))
	{
		if (check_login("umfragen") == true)
		{	
		    $umfrage_id = (int)$_GET["toogle"];
			$abfrage3 = 'SELECT `beendet` FROM `umfragen` WHERE `Umfrage_ID` = ' . $umfrage_id;
			$ergebnis3 = mysql_query($abfrage3, $sql);
			$row = mysql_fetch_object($ergebnis3);				
			$status = $row->beendet;
			if ($status == 0)
			{
					$abfrage4 = 'UPDATE `'.$sql_db.'`.`umfragen` SET `beendet` =1 WHERE `umfragen`.`Umfrage_ID` =' . $umfrage_id . ' LIMIT 1';
					if (mysql_query($abfrage4, $sql) == true)
					{
						header('Location: ./umfragen.php?manage=1&msg=erfolg');
					}
					exit;
			}
			else
			{
					$abfrage5 = 'UPDATE `'.$sql_db.'`.`umfragen` SET `beendet` =0 WHERE `umfragen`.`Umfrage_ID` =' . $umfrage_id . ' LIMIT 1';
					if (mysql_query($abfrage5, $sql) == true)
					{ 
						header('Location: ./umfragen.php?manage=1&msg=erfolg');
					}
					exit;
			}
		}else
		{
			header('Location: admin.php?berechtigung=0');
		}
	}elseif (!empty($_GET["edit"]))
	{
		if (check_login("umfragen") == true)
		{	
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
			<script language="javascript">
			function testCustom(selObj) {
				if(selObj.options[selObj.selectedIndex].value == '8' || selObj.options[selObj.selectedIndex].value == '7' || selObj.options[selObj.selectedIndex].value == '10')
				{
				for (var i = 0; i < document.getElementsByName("antworten").length; i++) {
					//Show the textbox
					document.getElementsByName("antworten")[i].style.visibility = 'visible';
					document.getElementsByName("antworten")[i].style.display = '';
					document.getElementsByName("label_antworten")[i].style.visibility = 'visible';
					document.getElementsByName("label_antworten")[i].style.display = '';
				}
				}
				else
				{
				for (var i = 0; i < document.getElementsByName("antworten").length; i++) {
					//Hide the textbox
					document.getElementsByName("antworten")[i].style.visibility =  'hidden';
					document.getElementsByName("antworten")[i].style.display = 'none';
					document.getElementsByName("label_antworten")[i].style.visibility =  'hidden';
					document.getElementsByName("label_antworten")[i].style.display = 'none';		
				}
				}
			 }
			</script>
			</head>	
			<body>
			<?php include('menu.inc.php'); ?>
			<div id="inhalt">
			<div id="layout_canvas">
					<?php		
					$umfrage_id = (int)$_GET["edit"];
					$abfrage6 = 'SELECT * FROM `umfragen` WHERE `Umfrage_ID` = ' . $umfrage_id;
					$ergebnis6 = mysql_query($abfrage6, $sql);
					$row = mysql_fetch_object($ergebnis6);

					$typ = $row->Typ;
					$text = $row->Text;
					$max_stimmen = $row->max_stimmen;
					$antworten = $row->Antworten;
					$option = array("", "", "", "", "", "", "", "", "", ""); //Make x amount of blank fields, where x is the amount of options

					if($typ == "1"){
						$option[0] = "selected='selected'";
					}elseif($typ == "2"){
						$option[1] = "selected='selected'";
					}
					elseif($typ == "3"){
						$option[2] = "selected='selected'";
					}
					elseif($typ == "4"){
						$option[3] = "selected='selected'";
					}
					elseif($typ == "5"){
						$option[4] = "selected='selected'";
					}
					elseif($typ == "6"){
						$option[5] = "selected='selected'";
					}
					elseif($typ == "7"){
						$option[6] = "selected='selected'";
					}
					elseif($typ == "8"){
						$option[7] = "selected='selected'";
					}
					elseif($typ == "25"){
						$option[8] = "selected='selected'";
					}
					elseif($typ == "10"){
						$option[9] = "selected='selected'";
					}
					?>
						<div class="profilkopf"><img src="./img/umfrageverwaltung.png"> Umfrage <?php echo $text ?> editieren</></div>
						<div id="userStats" class="clearfix">
						<form action="p_edit-umfragen.php" method="post">
						<table class="tabelle_randlos">
						<tbody>
							<tr>
								<td></td>
								<td><input style="visibility: hidden; display: none;" type="text" size="6" maxlength="6" name="id" value="<?php echo $umfrage_id ?>" readonly"></td>
							</tr>	
							<tr>
							 <td>Auswahlmöglichkeiten:</td>
							 <td>
								<select name="typ" onChange="javascript:testCustom(this);"> 
									<option <?php echo $option[0]; ?> value="1">Alle Schüler</option> 
									<option <?php echo $option[1]; ?> value="2">Weibliche Schüler</option> 
									<option <?php echo $option[2]; ?> value="3">Männliche Schüler</option> 
									<option <?php echo $option[3]; ?> value="4">Weibliche Lehrer</option> 
									<option <?php echo $option[4]; ?> value="5">Männliche Lehrer</option> 
									<option <?php echo $option[5]; ?> value="6">Alle Lehrer</option> 
									<option <?php echo $option[6]; ?> value="7">Eigene Antwortmöglichkeiten</option> 
									<option <?php echo $option[7]; ?> value="8">Eigene Antwortmöglichkeiten mit Kommentar (Einteilung)</option> 
									<option <?php echo $option[8]; ?> value="25">Alle Schüler (testing)</option> 
									<option <?php echo $option[9]; ?> value="10">Abimotto</option> 	
								</select> 					 
							 </td>
							</tr>
							<tr>
							 <td>Frage:</th>
							 <td><input type="text" size="30" maxlength="30" name="text" value="<?php echo $text ?>"></td>
							</tr>
							<tr>
							 <td>Max. Stimmen:</td>
							 <td><input type="text" size="2" maxlength="2" name="max_stimmen" value="<?php echo $max_stimmen ?>"></td>
							</tr>
							<tr>
							 <td><label style="visibility:hidden; display:none;" name="label_antworten">Antworten(mit ; trennen!):</label></td>  
							 <td><textarea style="visibility:hidden; display:none;" name="antworten" cols="30" rows="10" wrap="soft"><?php echo $antworten ?></textarea></td>
							</tr>	
						</tbody> 
						</table><br><input class="button" type="submit" value="Abschicken">
						<a href="javascript:history.back()"><input class="button" type="button" name="cancel" value="Abbrechen" /></a>
						</form>
						</div></div></div>
						<?php
		}else
		{
			header('Location: admin.php?berechtigung=0');
		}		
	}elseif (!empty($_GET["votedel"]))
	{	
		if (check_login("umfragen") == true)
		{		
			$abfrage = 'DELETE FROM `'.$sql_db.'`.`umfrageergebnisse` WHERE `umfrageergebnisse`.`Umfrage_ID` = '.$_GET["umfrageid"].' AND `umfrageergebnisse`.`Voter_ID` = '.$_GET["voterid"].' LIMIT 1';
			if (mysql_query($abfrage, $sql) == true)
			{
				header('Location: update-umfragen.php?auswertung='.$_GET["umfrageid"].'&msg=erfolg');
			}else
			{
				header('Location: update-umfragen.php?auswertung='.$_GET["umfrageid"].'$msg=fehler&errordesc=Das Löschen war nicht erfolgreich');
			}
		}else
		{
			header('Location: admin.php?berechtigung=0');
		}
	}elseif (!empty($_GET["create"]))
	{
		if (check_login("umfragen") == true)
		{	
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
			<script language="javascript">
			function testCustom(selObj) {
				if(selObj.options[selObj.selectedIndex].value == '8' || selObj.options[selObj.selectedIndex].value == '7' || selObj.options[selObj.selectedIndex].value == '10')
				{
				for (var i = 0; i < document.getElementsByName("antworten").length; i++) {
					//Show the textbox
					document.getElementsByName("antworten")[i].style.visibility = 'visible';
					document.getElementsByName("antworten")[i].style.display = '';
					document.getElementsByName("label_antworten")[i].style.visibility = 'visible';
					document.getElementsByName("label_antworten")[i].style.display = '';
				}
				}
				else
				{
				for (var i = 0; i < document.getElementsByName("antworten").length; i++) {
					//Hide the textbox
					document.getElementsByName("antworten")[i].style.visibility =  'hidden';
					document.getElementsByName("antworten")[i].style.display = 'none';
					document.getElementsByName("label_antworten")[i].style.visibility =  'hidden';
					document.getElementsByName("label_antworten")[i].style.display = 'none';		
				}
				}
			 }
			</script>
			</head>	
			<body>
			<?php include('menu.inc.php'); ?>
			<div id="inhalt">
			<div id="layout_canvas">
					<?php		
					echo '
						<div class="profilkopf"><img src="./img/umfrageverwaltung.png"> Neue Umfrage erstellen</></div>
						<div id="userStats" class="clearfix">
						<form action="p_create-umfragen.php" method="post">
						<table class="tabelle_randlos">
						<tbody>
							<tr>	
							 <p>Nach Anlage ist die Umfrage sofort aktiv.</p>					
							</tr>
							<tr>
							 <td>Auswahlmöglichkeiten:</td>
							 <td>
								<select name="typ" onChange="javascript:testCustom(this);"> 
									<option value="1">Alle Schüler</option> 
									<option value="2">Weibliche Schüler</option> 
									<option value="3">Männliche Schüler</option> 
									<option value="4">Weibliche Lehrer</option> 
									<option value="5">Männliche Lehrer</option> 
									<option value="6">Alle Lehrer</option> 
									<option value="7">Eigene Antwortmöglichkeiten</option> 
									<option value="8">Eigene Antwortmöglichkeiten mit Kommentar (Einteilung)</option> 
									<option value="25">Alle Schüler (testing)</option> 
									<option value="10">Abimotto</option> 	
								</select> 					 
							 </td>
							</tr>
							<tr>
							 <td>Frage:</th>
							 <td><input type="text" size="30" maxlength="30" name="text" value=""></td>
							</tr>
							<tr>
							 <td>Max. Stimmen:</td>
							 <td><input type="text" size="2" maxlength="2" name="max_stimmen" value="1"></td>
							</tr>
							<tr>
							 <td><label style="visibility:hidden; display:none;" name="label_antworten">Antworten(mit ; trennen!):</label></td>  
							 <td><textarea style="visibility:hidden; display:none;" name="antworten" cols="30" rows="10" wrap="soft">Möglichkeit1;Möglichkeit2</textarea></td>
							</tr>	
						</tbody> 
						</table><br><input class="button" type="submit" value="Abschicken">
						<a href="javascript:history.back()"><input class="button" type="button" name="cancel" value="Abbrechen" /></a>
						</form>
						</div></div></div>';		
		}else
		{
			header('Location: admin.php?berechtigung=0');
		}				
	} 
	else
	{
		header('Location: ./umfragen.php?manage=1&msg=fehler');
	}
	include('footer.inc.php');	     
}
else
{
	header('Location: admin.php?berechtigung=0');
}

?>