<?php
			$abfrage = "SELECT * FROM user WHERE SCHUELER_ID='$s_user_id'";
			$ergebnis = mysql_query($abfrage);
			$anzahl = mysql_num_rows($ergebnis);
			$row = mysql_fetch_object($ergebnis);
			$Name_ganz=$row->Name_ganz;
?>
<div id="bottommenu">
	<div class="menucontainer">
		<div class="textmenu">
			<b>
				<?php
					echo $Name_ganz;
				?>
			</b> | Kurse | Organisation
		</div>
	</div>
</div>