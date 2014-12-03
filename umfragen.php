
<title><?php echo $main_site_title; ?>Umfragen</title>
<script src="sorttable.js"></script>
<?php

//1: Schueler

$abfrage = "SELECT * FROM umfragen WHERE (Typ>=1 AND Typ<=3)OR Typ=25";
$ergebnis = mysql_query($abfrage);
$anzahl_s = mysql_num_rows($ergebnis);

$abfrage = "SELECT * FROM umfragen WHERE Typ>=4 AND Typ<=6";
$ergebnis = mysql_query($abfrage);
$anzahl_l = mysql_num_rows($ergebnis);

$abfrage = "SELECT * FROM umfragen WHERE Typ=7";
$ergebnis = mysql_query($abfrage);
$anzahl_o = mysql_num_rows($ergebnis);
$TextUmfrage = $Row->Text;
$Abimotto = boolean;

$abfrage = "SELECT * FROM umfragen WHERE Typ=8";
$ergebnis = mysql_query($abfrage);
$anzahl_e = mysql_num_rows($ergebnis);

$abfrage = "SELECT * FROM umfragen WHERE Typ=20";
$ergebnis = mysql_query($abfrage);
$anzahl_z = mysql_num_rows($ergebnis);
if (!isset($_GET['kat']))
  $kat='z1';
else
  $kat=$_GET['kat'];

$kat_n=substr($kat,1);
$kat_t=substr($kat,0,1);


if($s_user_id!=0)
{
?>

<div class="profilkopf">Umfragen</div>


<ul id="submenu">
<?php
if($kat_t=='m')
  echo '<li class="selectedmenuitem">Motto</li>';
else
  echo '<li><a href="framework.php?id=umfragen&kat=m1">Motto</a></li>';
 if($kat_t=='z')
  echo '<li class="selectedmenuitem">Abizeitung</li>';
else
  echo '<li><a href="framework.php?id=umfragen&kat=z1">Abizeitung</a></li>';

  if(($kat_t=='s')AND($kat_n==$i+1))
    echo '<li class="selectedmenuitem">Schüler</li>';
  else
    echo '<li><a href="framework.php?id=umfragen&kat=s1">Schüler</a></li>';

  if(($kat_t=='l')AND($kat_n==$i+1))
    echo '<li class="selectedmenuitem">Lehrer</li>';
  else
    echo '<li><a href="framework.php?id=umfragen&kat=l1">Lehrer</a></li>';

  if(($kat_t=='o')AND($kat_n==$i+1))
    echo '<li class="selectedmenuitem">Organisation</li>';
  else
  echo '<li><a href="framework.php?id=umfragen&kat=o1">Organisation</a></li>';

  if(($kat_t=='e')AND($kat_n==$i+1))
    echo '<li class="selectedmenuitem">Einteilung</li>';
  else
  echo '<li><a href="framework.php?id=umfragen&kat=e1">Einteilung</a></li>';
  
  if(($kat_t=='k')AND($kat_n==$i+1))
    echo '<li class="selectedmenuitem">Kuchen</li>';
  else
  echo '<li><a href="framework.php?id=umfragen&kat=k1">Kuchen</a></li>';  
 
?>
</ul>


<?php
$fragenzahl=0;
switch ($kat_t){
	case 's': 	$fragenzahl=$anzahl_s;
				break;
	case 'l': 	$fragenzahl=$anzahl_l;
				break;
	case 'o': 	$fragenzahl=$anzahl_o;
				break;
	case 'e': 	$fragenzahl=$anzahl_e;
				break;
	default:	$fragenzahl=0;
				break;
}
if ($fragenzahl>25){
	echo '<div style="text-align: center; font-size: 14px; color: #404040;margin-bottom: 10px;">';
	for ($i=1;$i<=ceil($fragenzahl/25);$i++){
		if ($kat_n==$i)
			echo $i.' ';
		else
			echo '<a href="framework.php?id=umfragen&kat='.$kat_t.$i.'" >'.$i.' </a>';
	}
	echo '</div>';
}

echo '<table class="altertable">';

if($kat_t=='m')
  $abfrage = "SELECT * FROM umfragen WHERE Typ=10";
elseif($kat_t=='s')
  $abfrage = "SELECT * FROM umfragen WHERE (Typ>=1 AND Typ<=3)Or Typ=25 LIMIT ".($kat_n*25-25).",25";
elseif($kat_t=='l')
  $abfrage = "SELECT * FROM umfragen WHERE Typ>=4 AND Typ<=6 LIMIT ".($kat_n*25-25).",25";
elseif($kat_t=='e')
  $abfrage = "SELECT * FROM umfragen WHERE Typ=8 LIMIT ".($kat_n-1).",1";
else
  $abfrage ="SELECT * FROM umfragen WHERE Typ=7 LIMIT ".($kat_n*25-25).",25";
$ergebnis = mysql_query($abfrage);
$anzahl = mysql_num_rows($ergebnis);

if($kat_t=='z')
  $anzahl=1;
if($kat_t=='k')
  $anzahl=1;  

if ($anzahl==0)
  {
  echo '<tr><td><div class="suchergebnis" style="border: none !important; text-align:center;">keine Umfragen gefunden</div></td></tr>';
  }
else
  {
 if($kat_t=='m')
    {
	echo "<tr><td>Du hast insgesamt <b>2 Stimmen.</b></td></tr>";
	$abfrage2="SELECT * FROM mottoergebnisse2 WHERE Voter_ID='$s_user_id'";
	$ergebnis2 = mysql_query($abfrage2);
    $anzahl2 = mysql_num_rows($ergebnis2);
	$row2=mysql_fetch_object($ergebnis2);
	if ($anzahl2>0)
	  {
	  echo "<tr><td><br>Du hast für folgende Mottos abgestimmt:<br><br />".$row2->Motto1."<br />".$row2->Motto2."<br /><hr /></td></tr>";
	  }
	else
	  {
	  echo "<tr><td>Du hast noch nicht abgestimmt<hr/></td></tr>";
	  }
	echo '<form action="mottosenden.php" method="POST">';
	$row = mysql_fetch_object($ergebnis);
	$umf_id=$row->Umfrage_ID;	
	$auswahl=$row->Antworten;
	$antworten=explode(";", $auswahl);

	$i=0;
	foreach ($antworten as $a)
	  {
	  echo '<tr><td><input type="checkbox" name="motto[]" value="'.$a.'" />'.$a.'</td></tr>';
	  $i++;
	  }
	echo '<tr><td><input class="button" type="submit" value="Abstimmen" /></td></tr>';
	echo "</form>";
			 
    }
  elseif($kat_t=='z')
    {	
	$abfrage2="SELECT SCHUELER_ID,Name_ganz,zeitung_komplett FROM user WHERE DELETED=0 ORDER BY Nachname,Vorname";
	$ergebnis2 = mysql_query($abfrage2);
	$schueler=array();
	$schueler_zeitung=array();
	while ($row2=mysql_fetch_object($ergebnis2))
	  {
	  $schueler[$row2->SCHUELER_ID]=$row2->Name_ganz;
	  $schueler_zeitung[$row2->SCHUELER_ID]=$row2->zeitung_komplett;
	  }
	
    $abfrage2="SELECT FACH_ID,fach_lang, lehrer,zeitung_komplett FROM kurse ORDER BY fach_lang";
	$ergebnis2 = mysql_query($abfrage2);
	$kurse=array();
	$kurse_zeitung=array();
	while ($row2=mysql_fetch_object($ergebnis2))
	  {
	  $kurse[$row2->FACH_ID]['name']=$row2->fach_lang;
	  $kurse[$row2->FACH_ID]['lehrer']=$row2->lehrer;
	   $kurse_zeitung[$row2->FACH_ID]=$row2->zeitung_komplett;
	  }	
	  
	$abfrage2="SELECT DISTINCT * FROM zeitung";
	$ergebnis2 = mysql_query($abfrage2);
	$artikel=array();
	while ($row2=mysql_fetch_object($ergebnis2))
	  {
	  $artikel[$row2->Artikel][]=$schueler[$row2->Schreiber_ID];
	  } 
	echo '<tr>';
	
	echo "<br>Es sollte jeder bei mehreren Artikeln mitschreiben. Bitte schaut, dass alle sich für alle Artikel jemand findet (vor allem für Personen und LKs).";
	echo "<div>Bitte schickt die fertigen Artikel als PDF an abizeitung@ohg2013.de</div><br/>";
		echo "Der Artikel sollte in Schriftgröße 12 geschrieben und nicht viel größer als eine halbe Din A4 Seite sein.<br><br>";
		echo '<div class="profilkopf">Schüler</div>';
	echo '<table class="altertable"><tr><th  style="width: 50px">Status</th><th  style="width: 200px">Schüler</th><th  style="width: 100px">Mitmachen</th><th>Autoren</th></tr>';
	$linecounter=0;
	foreach ($schueler as $key => $s)
	  {	
	  $id="s".$key;
	  $autoren="";
	  if(count($artikel[$id])>0)
	    $autoren=implode("; ",$artikel[$id]);		
	  echo '<tr';
	  if ($linecounter % 2 ==1)
		echo ' style="background-color: #D6D6D6"';

	  $abfrage2 = "SELECT admin FROM user WHERE SCHUELER_ID='$s_user_id'";
	  $ergebnis2 = mysql_query($abfrage2);
	  $row2 = mysql_fetch_object($ergebnis2);
	  $bool_admin=$row2->admin; 

	  if ($bool_admin == 1) 
	  {
		//logged in user is admin
		  if (($schueler_zeitung[substr($id, 1)]) == 1 )
			{ echo '><td><a href="abizeitung.php?aktion=bad&section=schueler&id='.substr($id, 1).'"><img class="neubutton_small" style="margin-top: 1.5px !important;float: left !important;" src="./styles/img/check.gif"></img></a></td>'; }
		  else
			{ echo '><td><a href="abizeitung.php?aktion=ok&section=schueler&id='.substr($id, 1).'"><img class="neubutton_small" style="margin-top: 1.5px !important;float: left !important;" src="./styles/img/not.gif"></img></a></td>'; }
	  }else{
		//logged in user is not admin
		  if (($schueler_zeitung[substr($id, 1)]) == 1 )
			{ echo '><td><img class="neubutton_small" style="margin-top: 1.5px !important;float: left !important;" src="./styles/img/check.gif"></img></td>'; }
		  else
			{ echo '><td><img class="neubutton_small" style="margin-top: 1.5px !important;float: left !important;" src="./styles/img/not.gif"></img></td>'; }		  
	  }
  
	  echo '<td>'.$s.'</td><td class="mitschreiben">';
	  if ($key != $s_user_id) {
		if (in_array($s_user_name, $artikel[$id]))
			echo'<a href="zeitung_del.php?id='.$id.'" class="abizeitung-mitschreiben">Entfernen!</a>';
		else
	   		echo'<a href="zeitung.php?id='.$id.'" class="abizeitung-mitschreiben">Ich schreib mit!</a>';
	  }		
	  else
		echo "Das bist du!";
	  echo'</td><td>'.$autoren.'</td></tr>';
	  $linecounter++;
	  }
	echo '</table><br/>';
	
	echo '<div class="profilkopf">Kurse</div><table class="altertable"><tr><th  style="width: 50px">Status</th><th  style="width: 200px">Kurs</th><th  style="width: 100px">Mitmachen</th><th>Autoren</th></tr>';	
	$linecounter=0;
	foreach ($kurse as $key => $value)
	  {
	  $id="k".$key;
	  $autoren="";
	  if(count($artikel[$id])>0)
	    $autoren=implode("; ",$artikel[$id]);
	  echo '<tr';
	  if ($linecounter % 2 ==1)
		echo ' style="background-color: #D6D6D6"';

	  $abfrage2 = "SELECT admin FROM user WHERE SCHUELER_ID='$s_user_id'";
	  $ergebnis2 = mysql_query($abfrage2);
	  $row2 = mysql_fetch_object($ergebnis2);
	  $bool_admin=$row2->admin; 

	  if ($bool_admin == 1) 
	  {
		//logged in user is admin
		  if (($kurse_zeitung[substr($id, 1)]) == 1 )
			{ echo '><td><a href="abizeitung.php?aktion=bad&section=kurse&id='.substr($id, 1).'"><img class="neubutton_small" style="margin-top: 1.5px !important;float: left !important;" src="./styles/img/check.gif"></img></a></td>'; }
		  else
			{ echo '><td><a href="abizeitung.php?aktion=ok&section=kurse&id='.substr($id, 1).'"><img class="neubutton_small" style="margin-top: 1.5px !important;float: left !important;" src="./styles/img/not.gif"></img></a></td>'; }
	  }else{
		//logged in user is not admin
		  if (($kurse_zeitung[substr($id, 1)]) == 1 )
			{ echo '><td><img class="neubutton_small" style="margin-top: 1.5px !important;float: left !important;" src="./styles/img/check.gif"></img></td>'; }
		  else
			{ echo '><td><img class="neubutton_small" style="margin-top: 1.5px !important;float: left !important;" src="./styles/img/not.gif"></img></td>'; }		  
	  }		
		
		
	  echo '<td>'.$value['name'].'('.$value['lehrer'].')</td><td class="mitschreiben">';
	  if (in_array($s_user_name, $artikel[$id]))
		echo'<a href="zeitung_del.php?id='.$id.'" class="abizeitung-mitschreiben">Entfernen!</a></td>';
	  else
	   	echo'<a href="zeitung.php?id='.$id.'" class="abizeitung-mitschreiben">Ich schreib mit!</a></td>';		
	echo '<td>'.$autoren.'</td></tr>';
	$linecounter++;
	  }
	echo '</table>';
	echo '</tr>';
			 
    }
	elseif($kat_t=='k')
    {	
	echo "<tr><td>Wähle hier, welchen Kuchen du backen möchtest. <br/>Klicke auf [+], um einen neuen Kuchen hinzuzufügen.</td></tr>";
	echo '<div class="profilkopf">Kuchenbäckerei</div><table class="altertable"><tr><th  style="width: 200px">Kuchenart</th><th  style="width: 100px">Backen</th><th>Bäcker</th></tr>';	

	$abfrage2="SELECT SCHUELER_ID,Name_ganz FROM user WHERE DELETED=0 ORDER BY Nachname,Vorname";
	$ergebnis2 = mysql_query($abfrage2);
	$schueler=array();
	while ($row2=mysql_fetch_object($ergebnis2))
	  {
	  $schueler[$row2->SCHUELER_ID]=$row2->Name_ganz;
	  }
	  
    $abfrage2="SELECT * FROM kuchen ORDER BY kuchen_name";
	$ergebnis2 = mysql_query($abfrage2);
	$kuchen=array();
	while ($row2=mysql_fetch_object($ergebnis2))
	  {
	  $kuchen[$row2->Kuchen_ID]['name']=$row2->kuchen_name;
	  }		
	
	$abfrage2="SELECT  * FROM kuchen_baecker";
	$ergebnis2 = mysql_query($abfrage2);
	$kuchen_baecker=array();
	while ($row2=mysql_fetch_object($ergebnis2))
	  {
	  $kuchen_baecker[$row2->KuchenID][]=$schueler[$row2->Schueler_ID];
	  }
	  
	$linecounter=0;
	foreach ($kuchen as $key => $value)
	  {
	  $id=$key;
	  $baecker="";
	  if(count($kuchen_baecker[$id])>0)
	    $baecker=implode("; ",$kuchen_baecker[$id]);
	  echo '<tr';
	  if ($linecounter % 2 ==1)
		echo ' style="background-color: #D6D6D6"';
	  echo '><td>'.$value['name'].'</td><td class="mitschreiben">';
	  if (in_array($s_user_name, $kuchen_baecker[$id]))
		echo'<a href="kuchen_del.php?id='.$id.'" class="abizeitung-mitschreiben">Verbrannt...</a></td>';
	  else
	   	echo'<a href="kuchen.php?id='.$id.'" class="abizeitung-mitschreiben">Ofen heizen!</a></td>';		
	echo '<td>'.$baecker.'</td></tr>';
	$linecounter++;
	  }
	echo '</table>';
	?>
	<div class="show-hide">
		<a href="javascript:toggle('show-hide-content')"><h3><img src="./styles/img/neu_klein.png"/> Neuen Kuchen hinzufügen</h3></a>
	</div>
	<div id="show-hide-content" class="show-hide-content" style="display:	none;">	
	 <?php
		echo '<table class="altertable">
		<tr><th  style="width: 200px">Kuchenname</th>
		<form action="kuchen_create.php" method="POST">
		<tr><td><div></br><input type="text" size="20" maxlength="30" name="kuchenname" /><input class="button" type="submit" value="Einfügen und Ofen heizen" /></div></td></tr>
		</form></tr></table>';	 
	 ?>
	</div>
	<?php
    }	
	
  elseif($kat_t=='e')
  {
  $row = mysql_fetch_object($ergebnis);
  $umf_id=$row->Umfrage_ID;
					   
  $abfrage="SELECT Name_ganz,SCHUELER_ID FROM user WHERE DELETED=0 ORDER BY Nachname";
  
  echo	'<div class="tabelle_kopf">'.$row->Text.'</div>';			 
  echo	'<p>'.$row->Hinweis.'</p>';			 
  echo '<a href="framework.php?id=umfrage&qid='.$umf_id.'&amp;seite='.$kat.'">Eintragen</a>';  
  echo '<tr><td><table class="altertable sortable"><tr><th style="width: 50%">Name</th><th>Antwort</th><th>Details</th></tr>';  
  $ergebnis = mysql_query($abfrage);
  $schueler=array();
  $i=0;
  while($row=mysql_fetch_object($ergebnis))
    {
	$schueler[$row->SCHUELER_ID]['name']=$row->Name_ganz;
    $i++; 	
	}
  $abfrage="SELECT stimme,Voter_ID FROM umfrageergebnisse WHERE Umfrage_ID='".$umf_id."'";
  $ergebnis = mysql_query($abfrage); 
  while($row=mysql_fetch_object($ergebnis))
    {
	if($row->stimme!=NULL)
	  {
	  $s=$row->stimme;
	  $schueler[$row->Voter_ID]['ant']=substr($s,0,strpos($s,';'));
	  $schueler[$row->Voter_ID]['kom']=substr($s,strpos($s,';')+1);
	  }
	}
	
	foreach($schueler as $s)
	  {
	  if ($s['ant']==NULL)
	    $s['ant']="&mdash;";
	  echo "<tr><td>".$s['name']."</td><td>".$s['ant']."</td><td>".$s['kom']."</td></tr>";
	  }
  echo "</table></td></tr>";
  }
  else
  {
  echo '<table class="altertable"><tr><th style="width: 50%">Umfrage</th><th>Abstimmen</th><th>Status</th></tr>';
  $linecounter=0;
  while($row = mysql_fetch_object($ergebnis))
    {
	
	$umfrage_id=$row->Umfrage_ID;
	$abfrage2 = "SELECT * FROM umfrageergebnisse WHERE Voter_ID='$s_user_id' AND Umfrage_ID='$umfrage_id'";
    $ergebnis2 = mysql_query($abfrage2);
    $anzahl2 = mysql_num_rows($ergebnis2);
	
	$inhalt='<td style="color: #404040">'.$row->Text.'</td><td width="150">';
	if ($row->beendet==1)
	 $inhalt.= '>Umfrage beendet.</td>';
	else
      {	
	  $inhalt.= '<a href="framework.php?id=umfrage&qid='.$umfrage_id.'&amp;seite='.$kat.'"><b>Zur Umfrage</b></a></td><td>';
	  if ($anzahl2>0)
	    {
	    $inhalt.='<p style="color:green;">bereits abgestimmt</p></td>';
	    }
	  else
	    {
	    $inhalt.='<p style="color:red;">nicht abgestimmt</p></td>';
	    }
	  }
	if ($linecounter % 2 ==1)  
		echo '<tr style="background-color: #D6D6D6">'.$inhalt.'</tr>';
	else
		echo '<tr>'.$inhalt.'</tr>';
	$linecounter++;
    } 
  	
  }
  echo "</table>";
  }
?>
</table>


<?php
if ($fragenzahl>25){
	echo '<br><div style="text-align: center; font-size: 14px; color: #404040;margin-bottom: 10px;">';
	for ($i=1;$i<=ceil($fragenzahl/25);$i++){
		if ($kat_n==$i)
			echo $i.' ';
		else
			echo '<a href="framework.php?id=umfragen&kat='.$kat_t.$i.'" >'.$i.' </a>';
	}
	echo '</div>';
}
}
?>
