<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
if (check_login("kalender") == true)
{
	include('mysql.inc.php');
	
function date_german2mysql($date) {
    $d    =    explode("-",$date);
    return    sprintf("%02d.%02d.%04d", $d[2], $d[1], $d[0]);
}//irgendwo im netz geklaut....
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Kalender</title>
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
	<script type="text/javascript">
	
	function TestDatum( nTag, nMaxTag ) {
	if( nTag >= 1 && nTag <= nMaxTag )
	  return true
	else
	  return false
	}

	function IstSchaltjahr( nJahr ) {
	if (( nJahr % 100 != 0 ) &&
	  ( nJahr % 4 == 0 )
	  ( nJahr % 400 == 0 )) {
	   return true;
	  }
	return false;
	}

	function DatumGueltigEx( nTag, nMonat, nJahr ) {
	var ok;
	ok=false;

	switch( nMonat ) {

	  case 1:
	   ok= TestDatum( nTag, 31 );
	   break;
	  case 2:
	   if( IstSchaltjahr( nJahr ) ) {
		ok= TestDatum( nTag, 29 )
	   } else {
		ok= TestDatum( nTag, 28 )
	   }
	   break;
	  
	  case 3:
	   ok= TestDatum( nTag, 31 );
	   break;
	  case 4:
	   ok= TestDatum( nTag, 30 );
	   break;
	  case 5:
	   ok= TestDatum( nTag, 31 );
	   break;
	  case 6:
	   ok= TestDatum( nTag, 30 );
	   break;
	  case 7:
	   ok= TestDatum( nTag, 31 );
	   break;
	  case 8:
	   ok= TestDatum( nTag, 31 );
	   break;
	  case 9:
	   ok= TestDatum( nTag, 30 );
	   break;
	  case 10:
	   ok= TestDatum( nTag, 31 );
	   break;
	  case 11:
	   ok= TestDatum( nTag, 30 );
	   break;
	  case 12:
	   ok= TestDatum( nTag, 31 );
	   break;
	}

	return ok;
	}

	function DatumGueltig( strDatum )
	{
	var nTag, nMonat, nJahr;
	var punkt1,punkt2;
	var gueltig;
	if (strDatum=="") return true;
	gueltig=false
	// auseinandernehmen
	punkt1=strDatum.indexOf(".");
	punkt2=punkt1+1+strDatum.indexOf(".",punkt1);
	punkt2=strDatum.lastIndexOf(".")
	nTag=strDatum.slice(0,punkt1);
	nMonat=strDatum.slice(punkt1+1,punkt2)
	nJahr=strDatum.slice(punkt2+1);
	if (nJahr.length != 4 ) {
	  alert("Ungültiges Datum! Bitte gib ein gültiges Datum ein (tt.mm.jjjj) ! " );
	  return false;
	}

	gueltig=DatumGueltigEx( Number(nTag), Number(nMonat), Number(nJahr) );
	if (gueltig==false){
	 alert("Ungültiges Datum! Bitte gib ein gültiges Datum ein (tt.mm.jjjj) ! " );
	 }

	return gueltig;

	}

	function ButtonClick() {
	date=document.getElementById("date").value;
	if(DatumGueltig(date)==true){
	document.input.submit()
	}
	}

	</script>
</head>	
<body>
		<?php
		if (!empty($_GET["del"]))
		{
				$termin_id = (int)$_GET["del"];
				$abfrage = 'DELETE FROM `kalender` WHERE `Termin_ID` =' . $termin_id . ' LIMIT 1 ;';
				if (mysql_query($abfrage, $sql) == true)
		    {
				header('Location: ./kalender.php?aktion=anzeigen&msg=erfolg');
		    }
		    else
		    {
				header('Location: ./kalender.php?aktion=anzeigen&msg=fehler&errordesc=Aktion war nicht erfolgreich!');
		    }
		}elseif (!empty($_GET["edit"]))
		{
				$date_id = (int)$_GET["edit"];
				$abfrage1 = 'SELECT * FROM `kalender` WHERE `Termin_ID` = ' . $date_id;
				$ergebnis1 = mysql_query($abfrage1, $sql);
				$row = mysql_fetch_object($ergebnis1);
				//$date = $row->Datum;
				$date=date_german2mysql($row->Datum);				
				$topic = $row->Titel;
				$betrifft = $row->Betrifft;
				$text = $row->Beschreibung;
						       				
				?>
				<?php include('menu.inc.php'); ?>
				<div id="inhalt">
				<div id="layout_canvas">
				<div class="profilkopf"><img src="./img/kalender.png">Kalendereintrag editieren</></div>
				<div id="userStats" class="clearfix">				
				<form action="p_edit-kalender.php" name="input" method="post">
				  <table style="tdstyle">
					<tr>
						<td><p><input type="hidden" size="6" maxlength="6" name="id" value="<?php echo $date_id; ?> readonly"></td>
					</tr> 
					<tr>
						<td>Titel:<br/><input type="text" size="50" maxlength="25" name="topic" value="<?php echo $topic; ?>"></td>
					</tr> 
					<tr>
						<td><br />Datum (TT.MM.JJJJ):<br/><input type="text" size="20" maxlength="20" name="date" id="date" value="<?php echo $date; ?>"></td>
					</tr> 
					<tr>
					 <td>
						<br />Betrifft:<br/>
						<select name="betrifft">
						<option value="0">Alle</option>
							<?php
							$abfrage = "SELECT * FROM teams ORDER BY team_name";
							$ergebnis = mysql_query($abfrage);
							while ($row=mysql_fetch_object($ergebnis))
							  {
								if (('o'.$row->TEAM_ID) == ($betrifft))
								{
									echo '<option selected="selected" value="o'.$row->TEAM_ID.'">'.$row->team_name.'</option>';
								}else
								{
									echo '<option value="o'.$row->TEAM_ID.'">'.$row->team_name.'</option>';
								}
							  }
							  
							$abfrage = "SELECT * FROM kurse ORDER BY fach_kurz";
							$ergebnis = mysql_query($abfrage);
							while ($row=mysql_fetch_object($ergebnis))
							  {
								if (('k'.$row->FACH_ID) == ($betrifft))
								{
									echo '<option selected="selected" value="k'.$row->FACH_ID.'">'.$row->fach_kurz.'</option>';
								}else
								{
									echo '<option value="k'.$row->FACH_ID.'">'.$row->fach_kurz.'</option>';
								}						  
							  }
							?>
						</select>	
					  </td>
					</tr> 
					<tr>
					 <td><br />Beschreibung:<br /><textarea name="text" style="width: 427px; height: 323px;" wrap="soft"><?php echo $text; ?></textarea></td>			  
					</tr>
				</table>
				<br/><input onclick="ButtonClick()" class="button" value="Abschicken"/>
				</div>
				</div>  
				</div>
				<?php	
		}elseif (!empty($_GET["groups"]))
		{
			/*Kurse holen*/
			$abfrage2 = 'SELECT * FROM `kurse`';
			$ergebnis2 = mysql_query($abfrage2, $sql);
			echo '<br><p><b>Kurse</b></p><br>';
			echo '<table style="tdstyle">';
			echo '<tr><td><b>ID</b></td><td><b>Betrifft</b></td><td><b>Fach</b></td><td><b>Lehrer</b></td></tr>'; 
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
			   </tr>';
			}
			echo '</table>';     
			/*Teams holen*/
					$abfrage3 = 'SELECT * FROM `teams`';
					$ergebnis3 = mysql_query($abfrage3, $sql);
					echo '<br><p><b>Teams</b></p><br>';
			echo '<table style="tdstyle">';
				echo '<tr><td><b>ID</b></td><td><b>Betrifft</b></td><td><b>Team Name</b></td></tr>'; 
			while ($row = mysql_fetch_object($ergebnis3)) 
			{     
				$team_id=$row->TEAM_ID;
				$team_name=$row->team_name;	
								   
				echo '<tr>
					<td>'.$team_id.'</td>
					<td>o'.$team_id.'</td>
					<td>'.$team_name.'</td>
					</tr>';
			}
			echo '</table></div></div></div>';         
		}
  include('footer.inc.php');	   
}
else
{
	header('Location: admin.php?berechtigung=0');
}

?>