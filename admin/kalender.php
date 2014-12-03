<?php
function date_german2mysql($date) {
    $d    =    explode(".",$date);
    return    sprintf("%04d-%02d-%02d", $d[2], $d[1], $d[0]);
}//irgendwo im netz geklaut....

include('sessiontest.inc.php');
require_once('functions.inc.php');
if (check_login("kalender") == true)
{
	include('mysql.inc.php');

	$aktion=$_GET["aktion"];
	if(isset($_POST["thema"]))//Wenn Daten zum Eintragen über POST übergeben wurden--> Termin in DB schreiben
	  {
	  $thema=$_POST["thema"];
	  $text=$_POST["text"];
	  $datum=date_german2mysql($_POST["datum"]);
	  $betrifft=$_POST["betrifft"];
	  if ($bearbeiten=='j')
		{
		$news_id=$_POST['news_id'];
		$abfrage="SELECT * FROM news WHERE news_ID=".$news_id;
		$ergebnis=mysql_query($abfrage);
		$row=mysql_fetch_object($ergebnis);
		if ($row->poster_ID==$s_user_id)
		  $abfrage = "UPDATE news SET Thema='$thema', Text='$text', Bearbeitung=Bearbeitung+1, Bearbeitungszeit=CURRENT_TIMESTAMP";
		else
		  $abfrage='';	
		}
	  else  
		$abfrage = "INSERT INTO kalender (Poster_ID, Titel, Beschreibung,Betrifft,Datum) VALUES ('$s_user_id','$thema', '$text','$betrifft','$datum')";
	  mysql_query($abfrage);
	  header("Location: ./kalender.php?aktion=anzeigen&msg=erfolg");
	  }
	  
	elseif($aktion=="schreiben")//neuen Termin eintragen
	{
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
		<script language="Javascript">
		<!--
		   document.getElementById("loading").style.visibility='visible';
		//-->
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
		date=document.getElementById("datum").value;
		if(date != ""){
			if(DatumGueltig(date)==true){
				document.input.submit()
			}
		}else
		{
		 alert("Bitte geben Sie ein Datum an! Format: (tt.mm.jjjj)" );
		}
	}

	</script>

	</head>
	<body onLoad="javascript:document.getElementById('loading').style.visibility='hidden';">
	<?php include('menu.inc.php'); ?>
	<div id="inhalt">
	<div id="layout_canvas">
	<div class="profilkopf"><img src="./img/kalender.png">Neuer Kalendereintrag</></div>
	<div id="loading"><img src="img/wait.gif" alt="Loading..." /></div>
	<div id="userStats" class="clearfix">
	
	<form action="kalender.php" name="input" id="input" method="post">
	Titel:<br /><input name="thema" size="50" type="text"/><br /><br />
	Datum (TT.MM.JJJJ):<br />
	<input name="datum" type="text" id="datum"/><br /><br />
	Betrifft: <br />
	<select name="betrifft">
	<option value="0">Alle</option>
	<?php
	$abfrage = "SELECT * FROM teams ORDER BY team_name";
	$ergebnis = mysql_query($abfrage);
	while ($row=mysql_fetch_object($ergebnis))
	  {
	  echo '<option value="o'.$row->TEAM_ID.'">'.$row->team_name.'</option>';
	  }
	  
	$abfrage = "SELECT * FROM kurse ORDER BY fach_kurz";
	$ergebnis = mysql_query($abfrage);
	while ($row=mysql_fetch_object($ergebnis))
	  {
	  echo '<option value="k'.$row->FACH_ID.'">'.$row->fach_kurz.'</option>';
	  }
	?>
	</select>
	<br /><br />
	Beschreibung: <br />
	<textarea name="text" wrap="soft" cols="50" rows="20">
	</textarea>
	<br />

	<input onclick="ButtonClick()" type="button" value="Absenden" class="button"/></form>

	</div>
	</div>
	</div>
	<?php
	include ('footer.inc.php');
	?>
	<?php
	}

	
	elseif($aktion=='details')//Termindetails anzeigen
	{
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
		<script language="Javascript">
		<!--
		   document.getElementById("loading").style.visibility='visible';
		//-->
		</script>			
	</head>
	<body onLoad="javascript:document.getElementById('loading').style.visibility='hidden';">
	<?php
	$abfrage="SELECT * FROM kalender WHERE Termin_ID='".$_GET['id']."'";
	$ergebnis=mysql_query($abfrage);
	$row=mysql_fetch_object($ergebnis);
	include ('menu.inc.php');
	?>
	<div id="inhalt">
	<div id="layout_canvas">
	<div class="profilkopf"><img src="./img/kalender.png">Kalendereintrag "<?php echo $row->Titel ?>"</></div>
	<div id="loading"><img src="img/wait.gif" alt="Loading..." /></div>
	<div id="userStats" class="clearfix">
	<div class="profilkategorie">
		<?php echo $row->Datum . '  - ' . $row->Titel ?>
		<a class="btn btn-small" title="Eintrag editieren" href="update-kalender.php?edit=<?php echo $_GET['id']; ?>"><i class="icon-pencil"></i></a>
		<a class="btn btn-small btn-danger" title="Eintrag löschen" href="update-kalender.php?del=<?php echo $_GET['id']; ?>"><i class="icon-remove icon-white"></i></a>		
	
	</div>
	<td><div align="center"><a href="update-kalender.php?edit=' . $date_id . '"><img src="_edit.gif" border="0"></a></div></td>
	<div class="suchergebnis"><?php echo $row->Beschreibung ?></div>
	<?php
	$abfrage="SELECT Name_ganz FROM user WHERE SCHUELER_ID='".$row->poster_ID."'";
	$ergebnis=mysql_query($abfrage);
	$row=mysql_fetch_object($ergebnis);
	echo "eingetragen von ".$row->Name_ganz;
	?>
	</div>
	</div>
	</div>
	<?php
	include ('footer.inc.php');
	}
	
	
	elseif($aktion=='anzeigen')//Monatsübersicht anzeigen
	{
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
		<script type="text/javascript" src="js/show_hide.js"></script>
		<script language="Javascript">
		<!--
		   document.getElementById("loading").style.visibility='visible';
		//-->
		</script>			
	</head>
	<body onLoad="javascript:document.getElementById('loading').style.visibility='hidden';">
	<?php
	function schaltjahr($jahr)
	{
	  if($jahr % 400 == 0)
		{
		return true;
		}
	  elseif($jahr % 4 == 0 && $jahr % 100 != 0)
		{
		return true;
		}
	  else
		{
		return false;
		}
	}
	include ('menu.inc.php');
	?>
	<div id="inhalt">
	<div id="layout_canvas">
	<div class="profilkopf"><img src="./img/kalender.png">Kalender</></div>
	<div id="loading"><img src="img/wait.gif" alt="Loading..." /></div>
	<?php
	if ($_GET["msg"] == "erfolg")
	{
		echo '<div class="success">Aktion war erfolgreich!</div>';
	}elseif ($_GET["msg"] == "fehler")
	{
		echo '<div class="error">'.$_GET["errordesc"].'</div>';
	}	
	?>
	<div id="userStats" class="clearfix">
	<?php
	$m=$_GET['m'];
	if ($m=='')
	  $m=date("n");
	  
	$y=$_GET['y'];
	if ($y=='')
	  $y=date("Y");
	  
	$monate=array(1=>'Januar',2=>'Februar',3=>'März',4=>'April',5=>'Mai',6=>'Juni',7=>'Juli',8=>'August',9=>'September',10=>'Oktober', 11=>'November', 12=>'Dezember');
	$wochentag=date("w",strtotime("$y-$m-01"));
	if ($wochentag==0)
	  $wochentag=7;
	if(($m==1)or($m==3)or($m==5)or($m==7)or($m==8)or($m==10)or($m==12))
	  $maxtag=31;
	elseif (($m==4)or($m==6)or($m==9)or($m==11))
	  $maxtag=30;
	elseif (($m==2)and (schaltjahr($y)))
	  $maxtag=29;
	elseif (($m==2)and (!schaltjahr($y)))
	  $maxtag=28;
	  
	  
	$termine=array();
	$i=0;
	$abfrage="SELECT Name_ganz, `geb_d`, `geb_m`, Date(Concat(`geb_y`,'-',`geb_m`,'-',`geb_d`)) AS Gebutsdatum, ROUND((TO_DAYS(CONCAT($y,'-',$m,'-','1'))-To_Days(Concat(`geb_y`,'-',`geb_m`,'-', `geb_d`)))/365.25) AS age FROM `user` WHERE `geb_m`=$m";
	$ergebnis=mysql_query($abfrage);
	while($row=mysql_fetch_object($ergebnis))
	  {
	  $termine[$i]['betreff']='<img src="./img/icon_birthday.gif"/> '.$row->Name_ganz. ' ('.$row->age.')';
	  $termine[$i]['tag']=$row->geb_d;
	  $i++;
	  }
	  $abfrage = "SELECT teams.TEAM_ID FROM teams,user WHERE user.Teams LIKE CONCAT('%',teams.team_name,'%') AND user.SCHUELER_ID='$s_user_id'";
	  $ergebnis=mysql_query($abfrage);
	  while ($row = mysql_fetch_object($ergebnis))
		{
		$gruppen2[]='Betrifft="o'.$row->TEAM_ID.'"';
		}
		
	  $abfrage = "SELECT kurse.FACH_ID FROM kurse,user WHERE user.Kurse LIKE CONCAT('%',kurse.fach_kurz,'%') AND user.SCHUELER_ID='$s_user_id'";
	  $ergebnis=mysql_query($abfrage);
	  while ($row = mysql_fetch_object($ergebnis))
		{
		$gruppen2[]='Betrifft="k'.$row->FACH_ID.'"';
		}	
	 
	  
	$gruppen2[]='Betrifft="0"'; 
	$gruppenstring=implode (' OR ', $gruppen2);
	$abfrage="SELECT Day(Datum)as Tag, Datum,Titel,Termin_ID FROM kalender WHERE Month(Datum)=$m AND Year(Datum)=$y AND ($gruppenstring)";  
	$ergebnis=mysql_query($abfrage);
	while($row=mysql_fetch_object($ergebnis))
	  {
	  $termine[$i]['betreff']='<a href="kalender.php?aktion=details&amp;id='.$row->Termin_ID.'">'.$row->Titel. '</a>';
	  $termine[$i]['tag']=$row->Tag;;
	  $i++;
	  }
	echo '<table class="kalenderkopf"><tr><td>';
	if ($m==1)
	  echo '<a href="kalender.php?aktion=anzeigen&amp;m=12&amp;y='.($y-1).'">&lt;&lt; Dezember '.($y-1).'</a>';
	else
	  echo '<a href="kalender.php?aktion=anzeigen&amp;m='.($m-1).'&amp;y='.($y).'">&lt;&lt; '.$monate[$m-1].' '.($y).'</a>'; 

	echo '</td><td>';
	echo '<h1>'.$monate[$m].' '.($y).'</h1>';
	echo '</td><td>';
	if ($m==12)
	  echo '<a href="kalender.php?aktion=anzeigen&amp;m=1&amp;y='.($y+1).'">Januar '.($y+1).' &gt;&gt;</a>';
	else
	  echo '<a href="kalender.php?aktion=anzeigen&amp;m='.($m+1).'&amp;y='.($y).'">'.$monate[$m+1].' '.($y).' &gt;&gt;</a>'; 
	  
	echo '</td></tr></table>';  
	echo "<table class='kalender' width='100%'>";
	echo "<tr><th>Montag</th><th>Dienstag</th><th>Mittwoch</th><th>Donnerstag</th><th>Freitag</th><th>Samstag</th><th>Sonntag</th></tr>";
	echo "<tr valign='top' min-height='100px'>";
	for ($i=1; $i<$wochentag; $i++)
	  {
	  echo "<td class='kal_unsichtbar'></td>";
	  };
	$j=$wochentag;
	for ($i=1; $i<=$maxtag; $i++)
	  {
	  if (($j % 7)==0)
		{
		echo '<td><div class="profilkategorie kleiner">'.$i.'</div>';
		foreach($termine as $t)
		  {
		  if ($t['tag']==$i)
			echo '<div class="kleiner">'.$t['betreff'].'</div>';
		  }
		echo "</td></tr>\n<tr valign='top'>";
		}
	  else
		{
		echo '<td><div class="profilkategorie kleiner">'.$i.'</div>';
		foreach($termine as $t)
		  {
		  if ($t['tag']==$i)
			echo '<div class="kleiner">'.$t['betreff'].'</div>';
		  }
		echo "</td>";
		}
	  $j++;	
	  }
	while (($j % 7)!=1)
	  {
	  echo "<td class='kal_unsichtbar'></td>";
	  $j++;
	  }  
	  echo "</tr>";
	echo "</table>";
	?>
	</div>
	<!-- Anstehende Termine ausgeben -->
	<div class="show-hide">
		<a href="javascript:toggle('show-hide-content')"><h3>Anstehende Termine</h3></a>
	</div>
	<div id="show-hide-content" class="show-hide-content" style="display:	none;">
	<div id="userStats" class="clearfix">
		<?php
		$termine=array();
		$i=0;
		//Geburtstage in nächsten 2 Wochen abfragen
		$abfrage="SELECT Name_ganz, `geb_d`, `geb_m`, Date(Concat(`geb_y`,'-',`geb_m`,'-',`geb_d`)) AS Gebutsdatum, ROUND((TO_DAYS(CURDATE())-To_Days(Concat(`geb_y`,'-',`geb_m`,'-', `geb_d`)))/365.25) AS age FROM `user` WHERE ((TO_DAYS(Date(Concat(YEAR(now()),'-',`geb_m`,'-',`geb_d`)))-TO_DAYS(CURDATE()))>=0 AND (TO_DAYS(Date(Concat(YEAR(now()),'-',`geb_m`,'-',`geb_d`)))-TO_DAYS(CURDATE()))<=14) OR ((TO_DAYS(Date(Concat(YEAR(now())+1,'-',`geb_m`,'-',`geb_d`)))-TO_DAYS(CURDATE()))>=0 AND (TO_DAYS(Date(Concat(YEAR(now())+1,'-',`geb_m`,'-',`geb_d`)))-TO_DAYS(CURDATE()))<=14)";
		$ergebnis=mysql_query($abfrage);
		while($row=mysql_fetch_object($ergebnis))
		  {
			if (($row->geb_d != 0) or ($row->geb_m != 0) or ($row->geb_y != 0)) {
			  $termine[$i]['betreff']='<img src="./img/icon_birthday.gif"/> '.$row->Name_ganz. ' ('.$row->age.')';
			  $termine[$i]['tage']=ceil(((strtotime(date("Y",time()).'-'.$row->geb_m.'-'.$row->geb_d))-time())/86400);
			  if ($termine[$i]['tage']<0)
				$termine[$i]['tage']=ceil((strtotime(date("Y",time()+(86400*365)).'-'.$row->geb_m.'-'.$row->geb_d)-time())/86400);
			  $i++;
			}
		  }
		$gruppen2[]='Betrifft="0"';//Gruppenarray um betrifft=0 (Termine, die alle betreffen) ergänzen
		$gruppenstring=implode (' OR ', $gruppen2);//analog zu Foren-->Termine für Nutzer abfragen
		$abfrage="SELECT Datum,Titel,Termin_ID FROM kalender WHERE ((TO_DAYS(Datum)-TO_DAYS(CURDATE()))>=0 AND (TO_DAYS(Datum)-TO_DAYS(CURDATE()))<=14)";  
		$ergebnis=mysql_query($abfrage);
		while($row=mysql_fetch_object($ergebnis))
		  {
		  $termine[$i]['betreff']='<a href="kalender.php?aktion=details&amp;id='.$row->Termin_ID.'">'.$row->Titel. '</a>';
		  $termine[$i]['tage']=ceil(((strtotime($row->Datum)-time())/86400));
		  $i++;
		  }
		if(count($termine>0))//wenn Termine gefunden wurden
		  {
		  $zaehler=array();//Array zaehler[TAG]=Anzahl_Termine_an_diesem_Tag
		  foreach($termine as $t)
			{
			$zaehler[$t['tage']]++;
			}
		  }
		if($zaehler[0]>0)//wenn heute Termine-->Ausgeben e
		  {
		  echo "<h3>Heute</h3>";
		  foreach ($termine as $t)
			{
			if ($t['tage']==0)
			  echo $t['betreff'].'<br />';
			}
		  }  
		 if($zaehler[1]>0)
		  {
		  echo "<h3>Morgen</h3>";
		  foreach ($termine as $t)
			{
			if ($t['tage']==1)
			  echo $t['betreff'].'<br />';
			}
		  } 
		 if($zaehler[2]>0)
		  {
		  echo "<h3>Übermorgen</h3>";
		  foreach ($termine as $t)
			{
			if ($t['tage']==2)
			  echo $t['betreff'].'<br />';
			}
		  }  
		  
		for ($i=3; $i<=14;$i++)
		{
		 if($zaehler[$i]>0)
		  {
		  echo "<h3>".date("d.m.Y",time()+$i*86400)."</h3>";
		  foreach ($termine as $t)
			{
			if ($t['tage']==$i)
			  echo $t['betreff'].'<br />';
			}
		  }
		}	
		?>	
	</div>
	</div>	
	</div>
	</div>
	<?php
	include('footer.inc.php');
	}
}
else
{
	header('Location: admin.php?berechtigung=0');
}
?>
