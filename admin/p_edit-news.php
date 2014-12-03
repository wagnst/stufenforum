<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
if (check_login("news") == true)
{
	include('mysql.inc.php');
	
	if(empty($_POST['id'])) {
		$fehler .= "<li>Die ID fehlt</li>";
	}
	if(empty($_POST['topic'])) {
		$fehler .= "<li>Die Überschrift fehlt</li>";
	}
	if(empty($_POST['text'])) {
		$fehler .= "<li>Der Text fehlt</li>";
	}
		
	if(empty($fehler)) 
	{ 
			$news_id = (int)$_POST["id"];
			$topic = mysql_real_escape_string($_POST["topic"]);
			$text = mysql_real_escape_string($_POST["text"]);
		
			$eintrag = "UPDATE `news` SET `Thema` =  '".$topic."',`Text` = '".$text."' WHERE `news`.`news_ID` =".$news_id." LIMIT 1 ;";
			$eintragen = mysql_query( $eintrag, $sql );
			if ( $eintragen == true )
			{
				header('Location: ./news.php?manage=1&msg=erfolg');
			}
			else
			{
				header('Location: ./news.php?manage=1&msg=fehler&errordesc=Aktion war nicht erfolgreich');
			} 
	}
	else header('Location: ./news.php?manage=1&msg=fehler&errordesc='.$fehler.'');			

}
else
{
	header('Location: admin.php?berechtigung=0');
}
		 
?>

