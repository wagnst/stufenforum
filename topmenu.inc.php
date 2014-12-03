<?php
			$abfrage = "SELECT * FROM user WHERE SCHUELER_ID='$s_user_id'";
			$ergebnis = mysql_query($abfrage);
			$anzahl = mysql_num_rows($ergebnis);
			$row = mysql_fetch_object($ergebnis);
			$Name_ganz=$row->Name_ganz;
			$userid=$row->SCHUELER_ID;
?>
<div id="topmenu">
	<div class="menucontainer">
		<a href="framework.php?id=profil">
			<?php
				if (file_exists("./images/profil/".$userid.".jpg"))//wenn Profilbild existiert, dieses übernehemn, andernfalls standard anzeigen
				{
					$profilbild="./images/profil/".$userid.".jpg";
				}
				else
				{
					$profilbild="./images/profil_small/default.jpg";
				}
				
				echo '<div title="'.$Name_ganz.'" style="background-image: url('.$profilbild.')" class="menubutton" ></div>';
			?>
		</a>
		
		<a href="framework.php?id=index"><div title="Startseite" style="background-image: url(styles/img/home.png)" class="menubutton" ></div></a>
		<a href="framework.php?id=kalender"><div title="Kalender" style="background-image: url(styles/img/kalender.png)" class="menubutton" ></div></a>
		<a href="framework.php?id=kursliste"><div title="Meine Kurse" style="background-image: url(styles/img/kurse.png)" class="menubutton" ></div></a>
		<a href="framework.php?id=teamliste"><div title="Organisation und Planung" style="background-image: url(styles/img/orga.png)" class="menubutton" ></div></a>
		<a href="framework.php?id=forum"><div title="Forum" style="background-image: url(styles/img/forum.png)" class="menubutton" ></div></a>
		<a href="framework.php?id=zungen"><div title="Böse Zungen behaupten..." style="background-image: url(styles/img/zunge.png)" class="menubutton" ></div></a>
		<a href="framework.php?id=poebel"><div title="Pöbelbuch" style="background-image: url(styles/img/poebel.png)" class="menubutton" ></div></a>
		<a href="framework.php?id=lehrer"><div title="Lehrersprüche" style="background-image: url(styles/img/lehrer.png)" class="menubutton" ></div></a>
		<a href="framework.php?id=umfragen"><div title="Umfragen" style="background-image: url(styles/img/umfragen.png)" class="menubutton" ></div></a>
		<a href="logout.php"><div title="Abmelden" style="background-image: url(styles/img/exit.png)" class="menubutton" id="exitbutton" ></div></a>
		<div id="suchbox">
			<form id="form_personensuche" action="framework.php?id=livesuche" method="get">
				<!--Suche-->
				<input type="hidden" name="id" value="livesuche" />
				<input type="text" name="suchwort" id="suchwort" />
				<input type="button" alt="Suche" id="suchbutton"/>
			</form>
		</div>
		
	</div>
</div>