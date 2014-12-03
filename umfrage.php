

<title><?php echo $main_site_title; ?>Umfrage</title>
<?php
$umfrage_id=$_GET["qid"];
$abfrage="SELECT * FROM umfragen WHERE Umfrage_ID='$umfrage_id'";
$ergebnis = mysql_query($abfrage);
$row=mysql_fetch_object($ergebnis);
echo '<div class="profilkopf">'.$row->Text.'</div>';
$umfrage_typ=$row->Typ;

$abfrage_voted="SELECT Stimme FROM umfrageergebnisse WHERE Umfrage_ID='$umfrage_id' AND Voter_ID='$s_user_id'";
$ergebnis_voted = mysql_query($abfrage_voted);
$row_voted = mysql_fetch_object($ergebnis_voted);
$voted = $row_voted->Stimme;



?>
<div id="table" class="tr">
<div id="formular" class="td">
<form action="umfragesenden.php" method="post">
<input type="hidden" name="seite" value="<?php echo $_GET['seite']?>"/>
<?php
if ($voted != "") {
	echo '<p>Derzeitige Stimme: <b>' . $voted . '</b><br />'; 
};
?>
<p>Bitte hier abstimmen:</p>
<select name="stimme" size="1">
<?php
if ($umfrage_typ==1)
  {
  $abfrage="SELECT SCHUELER_ID,Name_ganz FROM user WHERE DELETED=0 ORDER BY Vorname, Nachname";
  //echo $abfrage;
  $ergebnis = mysql_query($abfrage);
  echo '<option value="">&mdash;</option>';
  while($row=mysql_fetch_object($ergebnis))
    {
	echo '<option value="'.$row->Name_ganz.'">'.$row->Name_ganz.'</option>';
	}
  }
elseif ($umfrage_typ==2)
  {
  $abfrage="SELECT SCHUELER_ID,Name_ganz FROM user WHERE Geschlecht='w' AND DELETED=0 ORDER BY Vorname, Nachname";
  //echo $abfrage;
  $ergebnis = mysql_query($abfrage);
  echo '<option value="">&mdash;</option>';
  while($row=mysql_fetch_object($ergebnis))
    {
	echo '<option value="'.$row->Name_ganz.'">'.$row->Name_ganz.'</option>';
	}
  }
elseif ($umfrage_typ==3)
  {
  $abfrage="SELECT SCHUELER_ID,Name_ganz FROM user WHERE Geschlecht='m' AND DELETED=0 ORDER BY Vorname, Nachname";
  //echo $abfrage;
  $ergebnis = mysql_query($abfrage);
  echo '<option value="">&mdash;</option>';
  while($row=mysql_fetch_object($ergebnis))
    {
	echo '<option value="'.$row->Name_ganz.'">'.$row->Name_ganz.'</option>';
	}
  }
  
elseif ($umfrage_typ==4)
  {
  $abfrage="SELECT LEHRER_ID,Nachname FROM lehrer_neu WHERE Geschlecht='w' ORDER BY Nachname";
  //echo $abfrage;
  $ergebnis = mysql_query($abfrage);
  echo '<option value="">&mdash;</option>';
  while($row=mysql_fetch_object($ergebnis))
    {
	echo '<option value="'.$row->Nachname.'">'.$row->Nachname.'</option>';
	}
  }  
  
  
elseif ($umfrage_typ==5)
  {
  $abfrage="SELECT LEHRER_ID,Nachname FROM lehrer_neu WHERE Geschlecht='m' ORDER BY Nachname";
  //echo $abfrage;
  $ergebnis = mysql_query($abfrage);
  echo '<option value="">&mdash;</option>';
  while($row=mysql_fetch_object($ergebnis))
    {
	echo '<option value="'.$row->Nachname.'">'.$row->Nachname.'</option>';
	}
  }

elseif ($umfrage_typ==6)
  {
  $abfrage="SELECT LEHRER_ID,Nachname FROM lehrer_neu ORDER BY Nachname";
  //echo $abfrage;
  $ergebnis = mysql_query($abfrage);
  echo '<option value="">&mdash;</option>';
  while($row=mysql_fetch_object($ergebnis))
    {
	echo '<option value="'.$row->Nachname.'">'.$row->Nachname.'</option>';
	}
  }
  
  
elseif ($umfrage_typ==7)
  {
  $ant=$row->Antworten;
  $ant=explode(";",$ant);
  $i=0;
  foreach($ant as $a)
    {
	echo '<option value="'.$i.'">'.$a.'</option>';
	$i++;
	}
  }	
elseif ($umfrage_typ==8)
  {
  $ant=$row->Antworten;
  $ant=explode(";",$ant);
  $i=0;
  foreach($ant as $a)
    {
	echo '<option>'.$a.'</option>';
	$i++;
	}	
	
  }
elseif ($umfrage_typ==25)
  {
  $abfrage="SELECT SCHUELER_ID,Name_ganz FROM user WHERE DELETED=0 ORDER BY Vorname, Nachname";
  //echo $abfrage;
  $ergebnis = mysql_query($abfrage);
  echo '<option value="">&mdash;</option>';
  while($row=mysql_fetch_object($ergebnis))
    {
	echo '<option value="'.$row->Name_ganz.'">'.$row->Name_ganz.'</option>';
	}
  }  
?>
</select>
<br><br>
<?php
if ($umfrage_typ==8)
  {
  echo 'Details: <input type="text" name="det"/>';
  }
elseif ($umfrage_typ==25)
  {
  echo '<select name="stimme2" size="1">';
  $abfrage="SELECT SCHUELER_ID,Name_ganz FROM user WHERE DELETED=0 ORDER BY Vorname, Nachname";
  //echo $abfrage;
  $ergebnis = mysql_query($abfrage);
  echo '<option value="">&mdash;</option>';
  while($row=mysql_fetch_object($ergebnis))
    {
	echo '<option value="'.$row->Name_ganz.'">'.$row->Name_ganz.'</option>';
	}
  } 
echo '<input name="umfrage_id" type="hidden" value="'.$umfrage_id.'" />';
?>
<br /><input type="submit" class="button" value="Abstimmen" />
</form>
</div>
<div id="ranking" class="td" style="padding-left:100px;">
<?php
  $i=1;
  $abfrage="SELECT Stimme, COUNT(Stimme) AS Anzahl FROM `umfrageergebnisse` WHERE Umfrage_ID = '$umfrage_id' GROUP BY `Stimme` ORDER BY `Anzahl` DESC LIMIT 3";
  $ergebnis = mysql_query($abfrage);
  while($row=mysql_fetch_object($ergebnis))
    {
	switch ($i) {
	case 1: 
		if ($row->Stimme == $s_user_name) {
		echo '<p><b>Deine Platzierung:</b></p>';
		echo '<h3>Platz 1: </h3><img src="images/gold.png">';
		echo "$row->Stimme <b>($row->Anzahl)</b>";
		break;
		}
	case 2:
		if ($row->Stimme == $s_user_name) {
		echo '<p><b>Deine Platzierung:</b></p>';
		echo '<h3>Platz 2: </h3><img src="images/silber.png">';
		echo "$row->Stimme <b>($row->Anzahl)</b>";
		break;
		}
	case 3: 
		if ($row->Stimme == $s_user_name) {
		echo '<p><b>Deine Platzierung:</b></p>';
		echo '<h3>Platz 3: </h3><img src="images/bronze.png">';	
		echo "$row->Stimme <b>($row->Anzahl)</b>";
		break;
		}
	}
	$i++;
	}
?>
</div>
</div>
<?php include ('resultate_umfrage.php'); ?>
</div>
