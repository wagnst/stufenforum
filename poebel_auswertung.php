<?php
include('sessiontest.inc.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Umfragen<?php echo $seitentitel; ?></title>
<link rel="stylesheet" type="text/css" href="css.php" />
<script src="sorttable.js"></script>
</head>
<body onload="if (top!=self) { top.location=self.location; }">
<?php
include ('header.inc.php');
include ('menu.inc.php');

  $sID=$_GET['sID'];


		
		
  $abfrage="SELECT eintragstext FROM poebel_eintraege_neu WHERE SchuelerID=".$sID." AND (VOTES>-5 OR SCHUTZ=1) AND freigeschaltet=1 AND untereintrag_zu=0;";
  //echo $abfrage;
  $ergebnis = mysql_query($abfrage);
  $eintraege = array();
 while($row=mysql_fetch_object($ergebnis))
    {
		$temp=$row->eintragstext;
		$temp=strip_tags($temp);
		$temp = str_replace("\n", '', $temp);
				$temp = str_replace("\r", '', $temp);
				$temp = trim($temp);
		$eintraege[] = $temp;
	}
	
	echo '<textarea>' . implode($eintraege, ' &mdash; ') . '</textarea>';



?>
</table>

</div>
</div>
<?php


include ('footer.inc.php');
?>
</body>
</html>