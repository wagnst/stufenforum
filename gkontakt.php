

<?php
$gid=$_GET['gid'];
$abfrage = "SELECT * FROM teams WHERE TEAM_ID='$gid'";
$ergebnis = mysql_query($abfrage);
$row = mysql_fetch_object($ergebnis);
$gruppenname=$row->team_name;
?>
<title>
<?php
echo $main_site_title.$gruppenname;
?>
</title>


<script language="javascript" type="text/javascript" src="./tinymce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">

tinyMCE.init({
	mode : "textareas",
	language: "de",
	theme : "advanced",
	plugins : "emotions,media",
	theme_advanced_buttons1 :"bold,italic,underline,strikethrough,|,sub,sup,|,blockquote",
	theme_advanced_buttons2 :"charmap,emotions,image,media,|,cleanup,help",
	theme_advanced_buttons3 :"",
	verify_html : true
});
</script>
<div class="profilkopf">Kontakt</div>

<table class="edittable"><tr><th>Neue Nachricht an <?php echo $gruppenname ?></th></tr><tr><td>

<form action="gkontakt_absenden.php" method="post">

<textarea name="beitrag" wrap="soft" style="width:100%; padding:0; margin:0;" rows="15">
</textarea>
</td></tr><tr style="background-color: #BBBBBB"><td>

<?php
  echo '<input type="hidden" name="gid" value="'.$gid.'"/>';
  echo '<input class="button" style="margin-bottom:10px;  margin-top:10px;" type="submit" value="Absenden"/></form>';
?>

</td></tr></table>
