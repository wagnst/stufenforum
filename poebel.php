<?php
$dateien = array(); //Erstellt einen neuen Array $dateien
$dateien['auswahlliste'] = "./poebel/schueler_auswahl.php"; //für jede Section ein neue Variable
$dateien['anschauen'] = "./poebel/schueler_anschauen.php";
$dateien['senden'] = "./poebel/poebel_senden.php";
$dateien['untereintrag'] = "./poebel/poebel_untereintrag_erstellen.php";
$dateien['untereintrag_senden'] = "./poebel/poebel_untereintrag_senden.php";
$dateien['bewerten'] = "./poebel/bewerten.php";
$dateien['schutz'] = "./poebel/schutz.php";
$dateien['freischalten'] = "./poebel/freischalten.php";
$dateien['melden'] = "./poebel/melden.php";
$dateien['melden_senden'] = "./poebel/melden_senden.php";
$dateien['beschwerde_erfolg'] = "./poebel/beschwerde_erfolg.php";
$dateien['beschwerde_fehler'] = "./poebel/beschwerde_fehler.php";

if(isset($_GET['aktion']) AND isset($dateien[$_GET['aktion']]))
{
 //Ist eine $_GET Variable vorhanden wird PHP angewiesen
 //zu prüfen ob die Datei existiert und diese dann zu laden

 if(!file_exists($dateien[$_GET['aktion']])) echo "Die Datei ist nicht vorhanden.";

 include $dateien[$_GET['aktion']];
}
else
{
 //Wenn keine Variable oder Definition vorhanden ist
 //lade die Fehlerseite bzw. die Indexseite
 include $dateien['auswahlliste'];
}
?>