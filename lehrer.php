<?php
include('sessiontest.inc.php');
$dateien = array();
$dateien['auswahlliste'] = "./lehrer/lehrer_auswahl.php"; 
$dateien['anschauen'] = "./lehrer/lehrer_anschauen.php";
$dateien['senden'] = "./lehrer/lehrer_senden.php";


if(isset($_GET['aktion']) AND isset($dateien[$_GET['aktion']]))
{

 if(!file_exists($dateien[$_GET['aktion']]));

 include $dateien[$_GET['aktion']];
}
else
{
 include $dateien['auswahlliste'];
}
?>