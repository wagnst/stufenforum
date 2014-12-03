<?php
function get_adminsections($user) //returns the available adminitration sections
{
	//ask for db entries
	include('mysql.inc.php');
	$query = "SELECT * FROM `admin` WHERE `SchuelerID`='".$user."'";
	$result = mysql_query($query, $sql);	
	$row = mysql_fetch_object($result);
		
	// define which admin sections are available	
	$adminsec[] = array('name' => "start", 
						'value' => $row->start,
						'descr'   => "Startseite anzeigen"); 
	 
	$adminsec[] = array('name' => "kalender", 
						'value' => $row->kalender,
						'descr'   => "Kalenderverwaltung");
	 
	$adminsec[] = array('name' => "lehrer", 
						'value' => $row->lehrer,
						'descr'   => "Lehrerverwaltung");
	 
	$adminsec[] = array('name' => "show", 
						'value' => $row->show,
						'descr'   => "Benutzerverwaltung");	

	$adminsec[] = array('name' => "berechtigungen", 
						'value' => $row->berechtigungen, 
						'descr'   => "Berechtigungen verwalten (Superadministrator!)");

	$adminsec[] = array('name' => "teams", 
						'value' => $row->teams,
						'descr'   => "Gruppenverwaltung");
					  
	$adminsec[] = array('name' => "umfragen", 
						'value' => $row->umfragen, 
						'descr'   => "Umfragenverwaltung");

	$adminsec[] = array('name' => "poebel", 
						'value' => $row->poebel, 
						'descr'   => "Pöbelbeschwerden verwalten");					  

	$adminsec[] = array('name' => "news", 
						'value' => $row->news,
						'descr'   => "Mitteilungen verwalten");					  
	
	$adminsec[] = array('name' => "zungen", 
						'value' => $row->zungen,
						'descr'   => "Böse Zungen verwalten");		
						
	$adminsec[] = array('name' => "suchen", 
						'value' => $row->suchen,
						'descr'   => "Suchfunktion");	
						
	$adminsec[] = array('name' => "umfrageauswertung", 
						'value' => $row->umfrageauswertung,
						'descr'   => "Auswertungen der Umfragen ansehen");		
						
	$adminsec[] = array('name' => "poebeleintraege", 
						'value' => $row->poebeleintraege,
						'descr'   => "Pöbelbucheinträge ansehen");								
						
	//more sections can be added here! be careful: p_update_show.php then needs to be updated....
	
	return $adminsec; //returns the array
}

function check_login($sitesection) //returns true/false 
{
	include('sessiontest.inc.php'); //IMPORTANT!!! or s_user_id is not available
	$sections = get_adminsections($s_user_id);
	foreach ($sections as $nr => $inhalt) {
		$name[$nr] = $inhalt['name'];
		$value[$nr] = $inhalt['value'];
		
		if ($name[$nr] == $sitesection) {
			if ($value[$nr] == 1) {
				return true;
			} else {
				return false;
			}
		}
	}
}

function get_rights()  //returns description of rights
{
	include('sessiontest.inc.php'); //IMPORTANT!!! or s_user_id is not available
	$sections = get_adminsections($s_user_id);
	$rights = array();
	foreach ($sections as $nr => $inhalt) {
		$name[$nr] = $inhalt['name'];
		$value[$nr] = $inhalt['value'];
		$descr[$nr] = $inhalt['descr'];
		
		if ($value[$nr] == 1) {
			$rights[] =	$descr[$nr];
		}
	}
	return $rights; //return only granted rights (only description!)
}


// email(empfänger,betreff,nachricht,automatisch generiert [1,0])
function email($mail, $sub, $msg, $a)
{
	include('mysql.inc.php');
	$mailto = $mail;
	$msg = $msg;
	$von = $admin_mail;
	$sub = $sub;

	$msg = htmlentities($msg);
	$auto = "\r\n\r\nGruss,\r\nStufenforum Team.";
	$n_auto = "";
	if ($a = 1) {
		$foot = $auto;
	}
	if ($a = 0) {
		$foot = $n_auto;
	}
	$msg = $msg . $foot;
	$msg = str_replace("\n.", "<br />", $msg);
	$msg = stripslashes($msg);

	$header = "From: $von";

	$mail_senden = mail ($mailto, $sub, $msg, $header); //use php function mail()
}

function check_superadmin($user)
{
	include('sessiontest.inc.php');
	include('mysql.inc.php');
		
	//check if adminuser is superadmin
	$query = "SELECT * FROM `admin` WHERE `SchuelerID`='".$user."'";
	$result = mysql_query($query, $sql);	
	$row = mysql_fetch_object($result);

	if (($row->berechtigungen) == 0) {
		return false;
	} else {
		return true;
	}
}
?>