
<title><?php echo $main_site_title; ?>Böse Zungen</title>
<script src="sorttable.js"></script>
<script language="javascript" type="text/javascript" src="./tinymce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	language: "de",
	theme : "advanced",
	plugins : "emotions",
	theme_advanced_buttons1 :"bold,italic,underline,strikethrough,|,sub,sup,|,charmap,emotions,|,cleanup,help",
	theme_advanced_buttons2 :"",
	theme_advanced_buttons3 :""
});
</script>
<?php

//kategorie abfragen, ansonsten auf schüler
if (!isset($_GET['kat']))
  $kat='s';
else
  $kat=$_GET['kat'];
 
//msg abfragen, wenn leer dann nichts 
if (!isset($_GET['msg']))
  $msg='';
else
  $msg=$_GET['msg'];


if (!($kat=='l') or (!$kat=='s'))
		$kat='s';

?>
<div class="profilkopf">Böse Zungen...</div>
	<br>
	<ul id="submenu">
	<?php
		if($kat=='s')
			echo '<li class="selectedmenuitem">Schüler</li>';
		else
			echo '<li><a href="framework.php?id=zungen&kat=s">Schüler</a></li>';
		if($kat=='l')
			echo '<li class="selectedmenuitem">Lehrer</li>';
		else
			echo '<li><a href="framework.php?id=zungen&kat=l">Lehrer</a></li>';	
	?>

	</ul><br>

		<?php
			
				if ($msg!='')
				{
					$inhalt .='<div class="suchergebnis" style="margin: 0px;">'.$msg.'</div><br>';
				}
				
				$inhalt .='<form action="zungensenden.php" method="post">';			
				$inhalt .='<table class="edittable" style="width:100%" bordercolorlight="#FFFFFF"><tr><th>Böse Zungen behaupten, dass		';
				$inhalt .='<select class="select" name="betroffener" size="1">';
				$inhalt .='<option value="">&mdash;</option>';
				if($kat=='s')
				{
					$abfrage="SELECT SCHUELER_ID,Name_ganz FROM user WHERE DELETED=0 ORDER BY Vorname, Nachname";
					$ergebnis = mysql_query($abfrage);
					while($row=mysql_fetch_object($ergebnis))
					{
						$inhalt .='<option value="'.$row->Name_ganz.'">'.$row->Name_ganz.'</option>';
					}
					$inhalt .='</p></select>';
					$inhalt .='<input name="seite" value="s" type="hidden" /></td></tr>';					
				}
				elseif($kat=='l')
				{	
					$abfrage="SELECT LEHRER_ID,Nachname FROM lehrer_neu ORDER BY Nachname";
					$ergebnis = mysql_query($abfrage);
					while($row=mysql_fetch_object($ergebnis))
					{
						$inhalt .='<option value="'.$row->Nachname.'">'.$row->Nachname.'</option>';
					}	
					$inhalt .='</select><input name="seite" value="l" type="hidden" /></th></tr>';
					
				}
				$inhalt .='<tr><td style="padding:0px !important"><textarea name="zungentext" wrap="soft" rows="15" style="width:100%; padding:0; margin:0;"></textarea></td></tr><tr style="background-color: #BBBBBB"><td><input class="button" style="margin-bottom:10px;  margin-top:10px;" type="submit" value="Absenden" /></form></td></tr>';
				echo $inhalt;
			
		?>
		</table>