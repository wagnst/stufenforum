<?php
$schuelerID = $_GET['schuelerid'];
$abfrage = "SELECT Name_ganz FROM user WHERE SCHUELER_ID=$schuelerID";
$ergebnis = mysql_query($abfrage);
$row = mysql_fetch_object($ergebnis);
$Name_ganz = $row->Name_ganz;
$abfrage = "SELECT anzahl_eintraege FROM poebel_eigenschaften WHERE SCHUELER_ID=$schuelerID";
$ergebnis = mysql_query($abfrage);
$row = mysql_fetch_object($ergebnis);
$eintraege = $row->anzahl_eintraege;
?>
<title><?php echo $main_site_title.$Name_ganz; ?></title>
<script language="javascript" type="text/javascript" src="./tinymce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">

tinyMCE.init({
	mode : "textareas",
	language: "de",
	theme : "advanced",
	plugins : "emotions",
	theme_advanced_buttons1 :"bold,italic,underline,strikethrough,|,sub,sup,|,charmap,emotions,|,cleanup,help",
	theme_advanced_buttons2 :"",
	theme_advanced_buttons3 :""
});
</script>
<?php
echo '<div class="profilkopf">'.$Name_ganz.'<a href="framework.php?id=profil&schuelerid='.$schuelerID.'"><img src="./styles/img/view_klein.png" class="neubutton_small"></a></div>';
if ($schuelerID==$s_user_id)
  echo '<p>Auf deiner eigenen Seite siehst du auch gelöschte Beiträge. Wenn du auf das Schloss klickst, dann werden sie geschützt und sind für alle dauerhaft sichtbar, unabhängig von der bisherigen Berwertung.</p>';
function subeintraege($eintragsID, &$ausgabe)
   {
    global $schuelerID;
	global $s_user_id;
    $abfrage = "SELECT * FROM poebel_eintraege_neu WHERE EintragsID=$eintragsID";
    $ergebnis = mysql_query($abfrage);
	$row = mysql_fetch_object($ergebnis);
	if ($row->anzahl_untereintraege!=0)
	  { 
	    $abfrage = "SELECT * FROM poebel_eintraege_neu WHERE SchuelerID=$schuelerID AND untereintrag_zu=$eintragsID AND DELETED='0' AND (votes>'-5' OR SCHUTZ='1')";
		if ($schuelerID==$s_user_id)
		  $abfrage = "SELECT * FROM poebel_eintraege_neu WHERE SchuelerID=$schuelerID AND untereintrag_zu=$eintragsID AND DELETED='0'";
		$ergebnis = mysql_query($abfrage);
		while($row = mysql_fetch_object($ergebnis))
		  {
		    $ausgabe .= '<div class="poebel_untereintrag"><div class="poebel_kopf">';
			
		    $query2="SELECT SUM(stimme) as summe FROM poebel_votes WHERE Eintrags_ID='$row->EintragsID'";
            $result2=mysql_query($query2);
		    $row2=mysql_fetch_object($result2);
		    $anzahl_stimmen=$row2->summe;
		    if ($anzahl_stimmen==NULL)
				$anzahl_stimmen='';
			else
				$anzahl_stimmen=abs($anzahl_stimmen).' ';
		    $ausgabe .= "   Eintragungszeit: $row->postzeit";
			
			if (($schuelerID==$s_user_id)AND($row->SCHUTZ=='0'))
	           $ausgabe.='<a class="nohlimg" href="framework.php?id=poebel&aktion=schutz&amp;schuelerid='.$row->SchuelerID.'&amp;e='.$row->EintragsID.'"><img class="neubutton_small" src="./styles/img/lock.png"  style="margin-top: 1.5px !important"/></a> &nbsp;';
		    if ($row->SCHUTZ=='1')
			  {
		  
				if ($schuelerID==$s_user_id){
					$ausgabe.='<a  href="framework.php?id=poebel&aktion=schutz&amp;aufheben=aufheben&amp;schuelerid='.$row->SchuelerID.'&amp;e='.$row->EintragsID.'"><img class="neubutton_small" src="./styles/img/unlock.png" style="margin-top: 1.5px !important" /></a> &nbsp;';
				}
				else {
					$ausgabe.='<img class="neubutton_small" style="margin-top: 1.5px !important" src="./styles/img/lock.png" />';
				}
			  }
			else
  			  {
		      $ausgabe.='<a class="dislike" href="framework.php?id=poebel&aktion=bewerten&amp;v=n&amp;schuelerid='.$row->SchuelerID.'&amp;e='.$row->EintragsID.'"><span class="poebel_vote"><img class="dislikebutton_small"  src="./styles/img/dislike_frameless.png"  />'.$anzahl_stimmen.'</span></a>';
		      
			  }
			$ausgabe .= '</div><div class="poebel_inhalt"';
			if (($anzahl_stimmen>=5) AND ($schuelerID==$s_user_id)){
				$ausgabe.=' style="color:#6A0000"><p>Gemeldet';
				if ($row->SCHUTZ=='0')	
					$ausgabe.='und für die Öffentlichkeit nicht mehr sichtbar:</p>';
				else if ($row->SCHUTZ='1')
					$ausgabe.=', von dir aber trotzdem sichtbar gemacht:</p>';
			}
			else
				$ausgabe.='">';
			$ausgabe.= $row->eintragstext.'</div></div>'."\n";
		    subeintraege($row->EintragsID, $ausgabe);
	      }
	   }
   }
   

if ($eintraege == 0){
  $inhalt = 'Keine Eintr&auml;ge';
  $inhalt .= " \n <br />\n <hr />";

}
else {
  $abfrage = "SELECT * FROM poebel_eintraege_neu WHERE SchuelerID=$schuelerID AND untereintrag_zu='0' AND DELETED='0' AND (votes>'-5' OR SCHUTZ='1')";
  if ($schuelerID==$s_user_id)
    $abfrage = "SELECT * FROM poebel_eintraege_neu WHERE SchuelerID=$schuelerID AND untereintrag_zu='0' AND DELETED='0'";
 
  $ergebnis = mysql_query($abfrage);

  while($row = mysql_fetch_object($ergebnis))
    {
	  $query2="SELECT SUM(stimme) as summe FROM poebel_votes WHERE Eintrags_ID='$row->EintragsID'";
      $result2=mysql_query($query2);
	  $row2=mysql_fetch_object($result2);
	  $anzahl_stimmen=$row2->summe;
	  if ($anzahl_stimmen==NULL)
	    $anzahl_stimmen='';
	  else
		$anzahl_stimmen=abs($anzahl_stimmen).' ';
		
	  if (($schuelerID == $s_user_id) AND ($row->freigeschaltet == '1')) // freigeschaltet und man selsbt
	  {
		  
		  $inhalt .= '<div class="poebel_eintrag"><div class="poebel_kopf"><a href="framework.php?id=poebel&aktion=untereintrag&eintragsid='.$row->EintragsID.'&schuelerid='.$schuelerID.'">[Untereintrag erstellen]</a>';
		  $inhalt .= 'Eintragungszeit: '.$row->postzeit;
		  $inhalt .= '<a  href="framework.php?id=poebel&aktion=melden&amp;eintragsid='.$row->EintragsID.'"><img class="neubutton_small" src="./styles/img/melden.png" style="margin-top: 1.5px !important" /></a> &nbsp;';
			
		  if($row->SCHUTZ=='1')
			{
					$inhalt.='<a  href="framework.php?id=poebel&aktion=schutz&amp;aufheben=aufheben&amp;schuelerid='.$row->SchuelerID.'&amp;e='.$row->EintragsID.'"><img class="neubutton_small" src="./styles/img/unlock.png" style="margin-top: 1.5px !important" /></a> &nbsp;';  
			}
		  else
			{	  	
					if ($row->SCHUTZ=='0')
					{
						$inhalt.='<a class="nohlimg" href="framework.php?id=poebel&aktion=schutz&amp;schuelerid='.$row->SchuelerID.'&amp;e='.$row->EintragsID.'"><img class="neubutton_small" src="./styles/img/lock.png" style="margin-top: 1.5px !important" /></a> &nbsp;';
					}
					$inhalt.='<a class="dislike" href="framework.php?id=poebel&aktion=bewerten&amp;v=n&amp;schuelerid='.$row->SchuelerID.'&amp;e='.$row->EintragsID.'"><span class="poebel_vote"><img class="dislikebutton_small"  src="./styles/img/dislike_frameless.png"  />'.$anzahl_stimmen.'</span></a>';	
			}
			
			
			$inhalt .= '</div><div class="poebel_inhalt"';
			if (($anzahl_stimmen>=5) AND ($schuelerID==$s_user_id)){
				$inhalt.=' style="color:#6A0000"><p>Gemeldet';
				if ($row->SCHUTZ=='0')	
					$inhalt.='und für die Öffentlichkeit nicht mehr sichtbar:</p>';
				else if ($row->SCHUTZ='1')
					$inhalt.=', von dir aber trotzdem sichtbar gemacht:</p>';
			}
			else
				$inhalt.='">';
			$inhalt.= $row->eintragstext.'</div></div>'."\n";
		  subeintraege($row->EintragsID, $inhalt);

		  
		  $inhalt .= "<hr />";
	  }
	  else if (($schuelerID != $s_user_id) AND ($row->freigeschaltet == '1')) // freigeschaltet und jemand anderes
	  {
		  $inhalt .= '<div class="poebel_eintrag"><div class="poebel_kopf"><a href="framework.php?id=poebel&aktion=untereintrag&eintragsid='.$row->EintragsID.'&schuelerid='.$schuelerID.'">[Untereintrag erstellen]</a>';
		  $inhalt .= 'Eintragungszeit: '.$row->postzeit;
	
		  if ($row->SCHUTZ=='1')
			{
			$inhalt.='<img  class="neubutton_small" src="./styles/img/lock.png" style="margin-top: 1.5px !important"/>';
			}
		  else
			{	  
				$inhalt.='<a class="dislike" href="framework.php?id=poebel&aktion=bewerten&amp;v=n&amp;schuelerid='.$row->SchuelerID.'&amp;e='.$row->EintragsID.'"><span class="poebel_vote"><img  class="dislikebutton_small" src="./styles/img/dislike_frameless.png" />'.$anzahl_stimmen.'</span></a>';
			}
			$inhalt.= '</div><div class="poebel_inhalt">';
			$inhalt.= $row->eintragstext.'</div></div>'."\n";
		  subeintraege($row->EintragsID, $inhalt);
			
		  
		  $inhalt .= "<hr />";
	  }
	  else if (($schuelerID == $s_user_id) AND ($row->freigeschaltet == '0')) // man selbst und nicht freigeschaltet
	  {
		  $inhalt .= '<div class="poebel_eintrag"><div class="poebel_kopf rot">    Eintragungszeit:'.$row->postzeit;
		  $inhalt .= '<span class="poebel_vote"><a href = "framework.php?id=poebel&aktion=freischalten&amp;p_id='.$row->EintragsID.'&amp;ok=0">Nicht freischalten</a>';
		  $inhalt .= '&#160&#160&#160&#160&#160&#160';
		  $inhalt .= '<a href = "framework.php?id=poebel&aktion=freischalten&amp;p_id='.$row->EintragsID.'&amp;ok=1">Freischalten</a></span></div>';
		  $inhalt .= '<div class="poebel_inhalt">'.$row->eintragstext.'</div></div>';
	  }
    }
}


$inhalt .= " \n <br />\n";
echo $inhalt;
?>
<table class="edittable"><tr><th>Neuer Eintrag</th></tr><tr><td>

<form action="framework.php?id=poebel&aktion=senden" method="post">

<textarea name="eintrag" wrap="soft" style="width:100%; padding:0; margin:0;" rows="15">
</textarea>
</td></tr><tr style="background-color: #BBBBBB"><td>

<?php
  echo '<input type="hidden" name="schuelerid" value="'.$schuelerID.'"/>';
  echo '<input class="button" style="margin-bottom:10px;  margin-top:10px;" type="submit" value="Absenden"/></form>';
?>
</table>
</div>
