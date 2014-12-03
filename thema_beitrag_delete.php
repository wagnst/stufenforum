

<title><?php echo $main_site_title.$thema; ?></title>
<?php


$beitrag_id = $_GET['id'];

if ($is_admin && $beitrag_id) {
	$delete_query = mysql_query ('DELETE FROM foren_beitraege WHERE Beitrags_ID = ' . $beitrag_id . ' LIMIT 1');
}



// obligatorischer Tadel für wannabe-Admins
if (!$is_admin) {
	header('Location: ./framework.php?id=index');
}

else {
	// hats geklappt? :P
	if ($delete_query != false) {
		// obligatorisches Lob für die wahren Helden
		echo '<p>Der Kommentar wurde erfolgreich gelöscht!</p>';
	} else {
		echo '<p>Beim Löschen ist ein unerwarteter Fehler aufgetreten.</p>';
	}
	echo '<p><a href="javascript:history.back();">Zurück &raquo;</a></p>';

}	
?>


