<?php
include ('includes.inc.php');
session_start();
if ((isset ($_SESSION["logged_in"])) and ($_SESSION["logged_in"]==TRUE))//�berpr�ft, ob Nutzer eingeloggt ist
  {
  $s_user_id=$_SESSION["user_id"];
  $s_user_name=$_SESSION["user_name"];
  if ($_SESSION["style"]=='')//es war mal geplant dass jeder eigenes stylesheet ausw�hlen kann --> jetzt vermutlich unn�tig
    $_SESSION["style"]='blau';
  $style='<link rel="stylesheet" type="text/css" href="css.php" />';
  }
else//weiterleitung zur login-seite
  {
   header('Location: ./login.php');
  }   

?>