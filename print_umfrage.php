<?php
include('sessiontest.inc.php');
$arr = array (array ("Allmendinger","Aumüller","Bast","Becker","Bertro","Beutel","Blesinger","Boessdoerfer","Bourquin","Burdack","Burkhart","Kussmaul","Dauber","Dauer","Dobler","Doll","Doppler","Dreisigacker","Essig","Foerster","Freywald","Gerriets","Graw","Guenthert","Hafemann","Hampl","Haug","Henkel","Herrmann","Hilbert-Wellinger","Hinrichs","Hohenschurz","Hoock","Hoeck","Hufnagel","Kammer","Karrer","Kiefer","Kistner","Klein","Kluge","Kobald","Kohlhepp","Lamb","Lambert","Lehmann","Lentner-Wanzek","Liebendoerfer","Marwitz","Mergenthaler","Merz","Moeller","Mueller","Nedwal","Noppenberger","Paul","Peris","Pfirrmann","Pietrass","Pletsch","Pogodzik","Priemer","Quicker","Raade","Ranker","Roesch","Sachse","Sattler","Scherrer","Schindler","Schmidt","Schneiders","Schreiber","Schunk","Sellmeier","Siemer","Sprengel","Sprenger","Stockerl","Stolte","Storck","Strassner","Uetzels","Ulbrich","Wadle","Wahl","Weigel","Weimar","Werny","Wiedemann","Wittmann","Wolf","Yan-Dorka","Ziegler","Zink"), array (), array());

$umfrage_id = 0;
$s = "SELECT * FROM umfragen";
$res = mysql_query ($s);
$anz_umfragen = mysql_num_rows ($res);

for ($i = 0; $i <= 94; $i++)
{
	for ($j = 0; $j <= $anz_umfragen - 1; $j++)
	{
		$arr [$i][$j] = 0;

		for ($k = 0; $k <= $anz_umfragen - 1; $k++)
			$arr [$i][$j][$k] = 0;
	}
}

for ($umfrage_id = 0; $umfrage_id <= $anz_umfragen-1; $umfrage_id++)
{
	for ($p = 0; $p <= 94; $p++)
	{
     		$s = "SELECT * FROM umfrageergebnisse WHERE (Umfrage_ID = '$umfrage_id') AND (stimme = '$p')";
		$res = mysql_query ($s);
		$temp = mysql_num_rows ($res);
		$arr [$p][$umfrage_id][$p] += 1;
	}
}
?>
