<?php
include('sessiontest.inc.php');
require_once('functions.inc.php');
?>
<div id="dropdown-navi">
	<nav>
		<ul>
			<?php 
				// startseite
				if (check_login("start") == true){
					echo '<li><a href="admin.php">Start</a></li>';
				}else{
					echo '<li><a href="#"><span class="label label-important">Start</span></a></li>';
				}
				// benutzermenü
				if (check_login("show") == true){
				echo '
					<li class="drop">
						<a href="#">Benutzer</a>
						<div class="dropdownContain">
							<div class="dropOut">
								<div class="triangle"></div>
								<ul>
									<a href="show.php"><li>Anzeigen</li></a>
									<a href="update-show.php?create=1"><li>Erstellen</li></a>
								</ul>					
							</div>
						</div>
					</li>';
				}else{
					echo '<li><a href="admin.php?berechtigung=0"><span class="label label-important">Benutzer</span></a></li>';
				}
				// umfragen
				if ((check_login("umfragen") == true) OR (check_login("umfrageauswertung") == true)){
					echo '
						<li class="drop">
							<a href="#">Umfragen</a>
							<div class="dropdownContain">
								<div class="dropOut">
									<div class="triangle"></div>
									<ul>
										<a href="umfragen.php?manage=1"><li>Anzeigen</li></a>
										<a href="update-umfragen.php?create=1"><li>Erstellen</li></a>
										<a href="umfragen.php?motto=1"><li>Mottoauswertung</li></a>
									</ul>
								</div>
							</div>
						</li>';
				}else{
					echo '<li><a href="admin.php?berechtigung=0"><span class="label label-important">Umfragen</span></a></li>';
				}
				// mitteilungen
				if (check_login("news") == true){
					echo '<li><a href="news.php?manage=1">Mitteilungen</a></li>';
				}else{
					echo '<li><a href="admin.php?berechtigung=0"><span class="label label-important">Mitteilungen</span></a></li>';
				}
				
				// kalender
				if (check_login("kalender") == true){
					echo '	
						<li class="drop">
							<a href="#">Kalender</a>
							<div class="dropdownContain">
								<div class="dropOut">
									<div class="triangle"></div>
									<ul>
										<a href="kalender.php?aktion=anzeigen"><li>Anzeigen</li></a>
										<a href="kalender.php?aktion=schreiben"><li>Neuer Termin</li></a>
									</ul>
								</div>
							</div>
						</li>';
				}else{
					echo '<li><a href="admin.php?berechtigung=0"><span class="label label-important">Kalender</span></a></li>';
				}	
				// Lehrer
				if (check_login("lehrer") == true){
					echo '
						<li class="drop">
							<a href="#">Lehrer</a>
							<div class="dropdownContain">
								<div class="dropOut">
									<div class="triangle"></div>
									<ul>
										<a href="lehrer.php?show=1"><li>Lehrersprüche</li></a>
										<a href="lehrer.php?showteacher=1"><li>Lehrerliste</li></a>
										<a href="lehrer.php?createteacher=1"><li>Lehrer erstellen</li></a>					
									</ul>
								</div>
							</div>
						</li>';
				}else{
					echo '<li><a href="admin.php?berechtigung=0"><span class="label label-important">Lehrer</span></a></li>';		
				}
				// Gruppen
				if (check_login("teams") == true){
					echo '						
						<li class="drop">
							<a href="#">Gruppen</a>
							<div class="dropdownContain">
								<div class="dropOut">
									<div class="triangle"></div>
									<ul>
										<a href="teams.php?show=1"><li>Teams anzeigen</li></a>
										<a href="update-teams.php?create=1"><li>Team erstellen</li></a>
										<a href="teams.php?showcourse=1"><li>Kurse anzeigen</li></a>
										<a href="update-teams.php?createcourse=1"><li>Kurs erstellen</li></a>							
									</ul>
								</div>
							</div>
						</li>';
				}else{
					echo '<li><a href="admin.php?berechtigung=0"><span class="label label-important">Gruppen</span></a></li>';								
				}
				// Pöbel
				if ((check_login("poebel") == true) OR (check_login("poebeleintraege") == true)){
					echo '						
						<li class="drop">
							<a href="#">Pöbelbuch</a>
							<div class="dropdownContain">
								<div class="dropOut">
									<div class="triangle"></div>
									<ul>
										<a href="poebel.php"><li>Beschwerden</li></a>
										<a href="poebeleintraege.php"><li>Anzeigen</li></a>						
									</ul>
								</div>
							</div>
						</li>';
				}else{
					echo '<li><a href="admin.php?berechtigung=0"><span class="label label-important">Pöbelbuch</span></a></li>';								
				}				
				// Zungen
				if (check_login("zungen") == true){
					echo '<li><a href="zungen.php">Böse Zungen</a></li>';
				}else{
					echo '<li><a href="admin.php?berechtigung=0"><span class="label label-important">Böse Zungen</span></a></li>';							
				}
				// startseite
				if (check_login("start") == true){
					echo '<li><a href="login.php?logout=1&msg=erfolg">Stopp</a></li>';
				}else{
					echo '<li><a href="admin.php?berechtigung=0"><span class="label label-important">Stopp</span></a></li>';					
				}
				// startseite
				if (check_login("suchen") == true){
					?>
						<li>	
							<form method="get" action="livesuche.php">
								<input id="searchfield" type="text" name="suchwort" onblur="if (this.value=='') this.value=this.defaultValue;" onfocus="if (this.value=='Suchen...') this.value='';" value="Suchen...">
								<button id="search-send" type="submit"></button>
							</form>   
					   </li>
					<?php
				}else{
					echo '';	
				}
			?>			
		</ul>
	</nav>
</div>
	