<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
if (check_login("umfragen") == true)
{
	include('mysql.inc.php');
	//$abfrage='SELECT count(*) FROM umfrageergebnisse';
	$abfrage='SELECT DISTINCT(Umfrage_ID) as ID, count(stimme) AS counted 
	FROM umfrageergebnisse 
	GROUP BY ID 
	HAVING counted > 1
	ORDER BY `counted` DESC';
	$ergebnis = mysql_query($abfrage, $sql);
	echo '<table>';
		echo '
				<tr>
					<td>
					 ID
					</td>
					<td>
					 Fragetext
					</td>
					<td>
					 Stimmzahl
					</td>					
				</tr>
		';
	while ($row = mysql_fetch_object($ergebnis)) 
	{
		$temp_id = $row->ID;
		$votecount = $row->counted;
		$abfrage2 = "SELECT `Text` from `umfragen` WHERE `Umfrage_ID` ='$temp_id'";
		$ergebnis2 = mysql_query($abfrage2, $sql);
	
		$row1 = mysql_fetch_object($ergebnis2);
		$text = $row1->Text;	
		echo '
				<tr>
					<td>
					 '.$temp_id.'
					</td>
					<td>
					 '.$text.'
					</td>
					<td>
					 '.$votecount.'
					</td>					
				</tr>
		';
	}
	echo '</table>';	
}
else
{
	header('Location: admin.php?berechtigung=0');
}

?>
