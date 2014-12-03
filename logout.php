<?php
session_start();
session_unset();
$_SESSION=array();
$_SESSION["logged_in"]=FALSE;
header('Location: ./login.php');
?>
