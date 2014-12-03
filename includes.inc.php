<?php
$admin_mail = "admin@ohg2013.de";
$verbindung = mysql_connect('***','***','***');
mysql_select_db('***');//Datenbank auswählen
mysql_query("SET NAMES utf8");
header('content-type: text/html; charset=utf-8');//auf UTF-8 umstellen
$main_site_title="ABITALIA - ";//wird im Seitentitel immer angehängt
?>