<?php
function humanTime ($olddate){
	$olddate=strtotime($olddate);
	$elapsedtime = time() - $olddate; // to get the time since that moment
		$datetokens = array (
			31536000 => 'Jahr',
			2592000 => 'Monat',
			604800 => 'Woche',
			86400 => 'Tag',
			3600 => 'Stunde',
			60 => 'Minute',
			1 => 'Sekunde'
		);

		foreach ($datetokens as $unit => $timetext) {
			if ($elapsedtime < $unit) continue;
			$numberOfUnits = floor($elapsedtime / $unit);
			$textTime = 'vor '.$numberOfUnits.' '.$timetext;
			if ($numberOfUnits>1){
				switch ($timetext) {
					case "Jahr": 	$textTime=$textTime."en";
									break;
					case "Monat": 	$textTime=$textTime."en";
									break;
					case "Woche": 	$textTime=$textTime."n";
									break;
					case "Tag": 	$textTime=$textTime."en";
									break;
					case "Stunde": 	$textTime=$textTime."n";
									break;
					case "Minute": 	$textTime=$textTime."n";
									break;
					case "Sekunde": 	$textTime=$textTime."n";
									break;
				}
			}
			break;
		};
		return $textTime;
}
?>