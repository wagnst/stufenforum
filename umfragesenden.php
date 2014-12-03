<?php
include('sessiontest.inc.php');
if($s_user_id!=0)
{
$umfrage_id=$_POST["umfrage_id"];
$stimme=$_POST['stimme'];
}
$abfrage="SELECT * FROM umfragen WHERE Umfrage_ID='$umfrage_id'";
$ergebnis = mysql_query($abfrage);
$row=mysql_fetch_object($ergebnis);
$umfrage_typ=$row->Typ;
$Thema=$row->Text;
$Vorschau=$row->Vorschau;
if ($umfrage_typ==7)
  {
  $ant=$row->Antworten;
  $ant=explode(";",$ant);
  }
 
if ($umfrage_typ==8)
  {
  $stimme.=';'.$_POST['det'];
  }  

if ($umfrage_typ==25)
  {
  $stimme.=';'.$_POST['stimme2'];
  }    

$abfrage = "SELECT * FROM umfrageergebnisse WHERE Voter_ID='$s_user_id' AND Umfrage_ID='$umfrage_id'";
$ergebnis = mysql_query($abfrage);
$anzahl = mysql_num_rows($ergebnis);
if ($stimme!='')
  {

 // 3 Auswahlmöglichkeiten vorhanden wegen Abimottoabstimmung!

if ($Vorschau==false)
{  
	if ($Thema=='Abimotto')
	{
	  if (($anzahl==0) OR ($anzahl==1) OR ($anzahl==2))
		{
		$abfrage="INSERT INTO umfrageergebnisse (Voter_ID, Umfrage_ID, stimme) VALUES ('$s_user_id','$umfrage_id','$stimme')";
		mysql_query($abfrage);
		$abfrage="UPDATE umfragen SET anzahl_stimmen=(anzahl_stimmen+1) WHERE Umfrage_ID='$umfrage_id'";
		mysql_query($abfrage);
		}
	}
	 else
	{
	   if ($anzahl==0)
		{
		echo $site[$stimme];
		$abfrage="INSERT INTO umfrageergebnisse (Voter_ID, Umfrage_ID, stimme) VALUES ('$s_user_id','$umfrage_id','$stimme')";
		mysql_query($abfrage);
		$abfrage="UPDATE umfragen SET anzahl_stimmen=(anzahl_stimmen+1) WHERE Umfrage_ID='$umfrage_id'";
		mysql_query($abfrage);
		}
	  else
		{
		$abfrage="UPDATE umfrageergebnisse SET stimme='$stimme' WHERE Voter_ID='$s_user_id' AND Umfrage_ID='$umfrage_id'";
		mysql_query($abfrage);
		}
	}	
}

 
header('Location: ./framework.php?id=umfragen&kat='.$_POST['seite']);
}
else
{
echo "Es ist ein Fehler aufgetreten. Bitte melde dich nochmal an. Damit die Seite richtig funktioniert müssen Cookies aktiviert sein.<br/>Getestet mit Firefox 2+; Internet Explorer 7+; Opera 10";
}
?>