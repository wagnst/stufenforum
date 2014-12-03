<?php
function get_adminsections() //returns the available adminitration sections
{
	include('mysql.inc.php');
	$query = "SELECT * FROM `admin` WHERE `SchuelerID`=1";
	$result = mysql_query($query, $sql);	
	$row = mysql_fetch_object($result);
	
	$adminsec[] = array('name' => "start", 
						'value' => $row->start,
						'descr'   => "Administratorrechte"); 
	 
	$adminsec[] = array('name' => "kalender", 
						'value' => $row->kalender,
						'descr'   => "Kalender");
	 
	$adminsec[] = array('name' => "lehrer", 
						'value' => $row->lehrer,
						'descr'   => "Lehrer");
	 
	$adminsec[] = array('name' => "show", 
						'value' => $row->show,
						'descr'   => "Benutzerverwaltung");	

	$adminsec[] = array('name' => "berechtigungen", 
						'value' => $row->berechtigungen, 
						'descr'   => "Berechtigungen verwalten");

	$adminsec[] = array('name' => "teams", 
						'value' => $row->teams,
						'descr'   => "Teamverwaltung");
					  
	$adminsec[] = array('name' => "umfragen", 
						'value' => $row->umfragen, 
						'descr'   => "Umfragenverwaltung");

	$adminsec[] = array('name' => "poebel", 
						'value' => $row->poebel, 
						'descr'   => "Pöbelbeschwerden");					  

	$adminsec[] = array('name' => "news", 
						'value' => $row->news,
						'descr'   => "Mitteilungen");					  
	
	$adminsec[] = array('name' => "zungen", 
						'value' => $row->zungen,
						'descr'   => "Böse Zungen");					  
		
	return $adminsec; //returns the array
}

function check_login($sitesection) //returns true/false 
{

	$sections = get_adminsections();
	
	foreach ($sections as $nr => $inhalt) {
		$name[$nr]  = $inhalt['name'];
		$value[$nr]   = $inhalt['value'];
		$descr[$nr] =  $inhalt['descr'];
		
		if ($name[$nr] == $sitesection) {
			if ($value[$nr] == 1) {
				return true;
			} else {
				return false;
			}
		}
	}
}

echo "started";
if (check_login("start") == true){
	echo "true";
}else{
	echo "false";
}



;

?>