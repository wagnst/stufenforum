<?php

/*session_cache_expire( 20 );
session_start(); // NEVER FORGET TO START THE SESSION!!!
$inactive = 600; //10 min
if(isset($_SESSION['start']) ) {
	$session_life = time() - $_SESSION['start'];
	if($session_life > $inactive){
		header("Location: login.php?logout=1");
	}
}
$_SESSION['start'] = time();

session_start(); // NEVER FORGET TO START THE SESSION!!!

//$_SESSION['timeout'] = time();
if ($_SESSION['timeout'] + 1 * 60 < time()) //10 min (10 * 60)
{
	// session timed out
	header("Location: login.php?logout=1");
}
else 
{
	// session ok
	if ((isset ($_SESSION["logged_in"])) and ($_SESSION["logged_in"]==TRUE))//überprüft, ob Nutzer eingeloggt ist
	{
		$s_user_id=$_SESSION["user_id"];
		$s_user_name=$_SESSION["user_name"];
	}
	else//weiterleitung zur login-seite
	{
		header('Location: ./login.php');
	}
} */

session_start(); // NEVER FORGET TO START THE SESSION!!!

$inactive = 600; // 600 = 10 min

if(isset($_SESSION['timeout']) ) {
  $session_life = time() - $_SESSION['timeout'];
  if($session_life > $inactive) { 
    header("Location: login.php?logout=1&session=timeout"); 
  }else
  {
 	// session ok
	if ((isset ($_SESSION["logged_in"])) and ($_SESSION["logged_in"]==TRUE))//überprüft, ob Nutzer eingeloggt ist
	{
		$s_user_id=$_SESSION["user_id"];
		$s_user_name=$_SESSION["user_name"];
	}
	else//weiterleitung zur login-seite
	{
		header('Location: ./login.php');
	} 
  }
}

$_SESSION['timeout'] = time();
?>