

<title><?php echo $main_site_title; ?>Organisation</title>

<div class="profilkopf">Kommitees</div>
<br/>
<table class="altertable"><th>Kommitees, in denen du mitarbeitest<a href="framework.php?id=profiledit&section=schule"><img src="./styles/img/bearbeiten_klein.png" class="editbutton_small"></a></th>
<?php
$abfrage = "SELECT Teams FROM user WHERE SCHUELER_ID='$s_user_id'";
$ergebnis = mysql_query($abfrage);
$row = mysql_fetch_object($ergebnis);
$teams=$row->Teams;
$teams=explode(";",$teams);

$abfrage = "SELECT * FROM teams ORDER BY team_name";
$ergebnis = mysql_query($abfrage);
$anzahl = mysql_num_rows($ergebnis);
$eigene=0;
for($i=0; $i<($anzahl);$i++)
  {
  $row = mysql_fetch_object($ergebnis);
  $team_name=$row->team_name;
  foreach($teams as $t)
    {
	$belegt=false;
	if($t==$team_name)
	  {
	  $belegt=true;
	  }
	if ($belegt==true)
	  {
	  echo '<tr';
	  if ($eigene % 2 ==1)
		echo ' style="background-color: #D6D6D6;"';
	  echo '><td><a href="framework.php?id=gruppe&typ=o&amp;gid='.$row->TEAM_ID.'">'.$t.'</a></td></tr>';
	  $eigene++;
	  }
	}
  }
if ($eigene==0)
  echo '<tr><td>Du bist in keinem Kommitee</td></tr>';

echo '<tr><th>Andere Kommitees</th></tr>';
 

$abfrage = "SELECT * FROM teams ORDER BY team_name";
$ergebnis = mysql_query($abfrage);
$anzahl = mysql_num_rows($ergebnis);
$linecounter=0; 
while($row = mysql_fetch_object($ergebnis))
  {
  $team_name=$row->team_name;
  $belegt=false;
  foreach($teams as $t)
    {
	if($t==$team_name)
	  {
	  $belegt=true;
	  }

	}	
	if ($belegt==false)
	  {
	  echo '<tr';
	  if ($linecounter % 2 ==1)
		echo ' style="background-color: #D6D6D6;"';
	  echo '><td><a href="framework.php?id=gkontakt&typ=o&amp;gid='.$row->TEAM_ID.'">Kontakt</a>&nbsp;<a href="framework.php?id=gruppe&typ=o&amp;gid='.$row->TEAM_ID.'" >'.$team_name.'</a></td></tr>';
	  $linecounter++;
	  }
  }
  
?>
</table>
