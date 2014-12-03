<?php
include('sessiontest.inc.php');
if($s_user_id!=0)
{
	$abfrage2 = "SELECT admin FROM user WHERE SCHUELER_ID='$s_user_id'";
	$ergebnis2 = mysql_query($abfrage2);
	$row2 = mysql_fetch_object($ergebnis2);
	$bool_admin=$row2->admin; 

	if ($bool_admin == 1) 
	{	
		//only if user is admin
		$aktion=$_GET['aktion'];
		$id=$_GET['id'];
		$section=$_GET['section'];
		
		
		if ($aktion=="ok") {
			if ($section=="schueler") {
				//article is OK, write 1
				$abfrage="UPDATE user SET zeitung_komplett=1 WHERE SCHUELER_ID='$id'";
			}else if ($section=="kurse") {
				//article is OK, write 1
				$abfrage="UPDATE kurse SET zeitung_komplett=1 WHERE FACH_ID='$id'";				
			}	
			mysql_query($abfrage);
			header('Location: ./framework.php?id=umfragen&kat=z1');			
			
		}else if ($aktion=="bad"){
			if ($section=="schueler") {
				//article is NOT OK, write 0
				$abfrage="UPDATE user SET zeitung_komplett=0 WHERE SCHUELER_ID='$id'";
			}else if ($section=="kurse") {
				//article is NOT OK, write 0
				$abfrage="UPDATE kurse SET zeitung_komplett=0 WHERE FACH_ID='$id'";				
			}				
			mysql_query($abfrage);
			header('Location: ./framework.php?id=umfragen&kat=z1');					
		}

	}
}
else
{
echo "Es ist ein Fehler aufgetreten. Bitte melde dich nochmal an. Damit die Seite richtig funktioniert müssen Cookies aktiviert sein.<br/>Getestet mit Firefox 2+; Internet Explorer 7+; Opera 10";
}
?>
