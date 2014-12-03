<?php
include('sessiontest.inc.php');
$sql_server = "***"; /*SQL Server adress, often "localhost"*/
$sql_user = "***"; /*SQL Username*/
$sql_pw = "***"; /*Database password*/
$sql_db = "***"; /*Database*/

$admin_mail = "admin@ohg2013.de"; /*Mailversand "von"*/

$sql = mysql_connect ($sql_server, $sql_user, $sql_pw)
or die ("Es ist momentan keine Verbindung zur Datenbank moeglich. Bitte Kontaktieren sie einen Admin.");

mysql_select_db($sql_db)
or die ("Die ausgewaehlte Datenbank existiert nicht. Bitte Kontaktieren sie einen Admin.");

?>