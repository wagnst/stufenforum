<?php
include('sessiontest.inc.php');
$aktion=addslashes($_GET["aktion"]);
if(isset($_POST["thema"]))
  {
  $thema=addslashes($_POST["thema"]);
  if($thema==""){
	$thema="Mitteilung";
  }
  $text=addslashes($_POST["text"]);
  $bearbeiten=addslashes($_POST["bearbeiten"]);
  if ($bearbeiten=='j')
    {
	$news_id=$_POST['news_id'];
	$abfrage="SELECT * FROM news WHERE news_ID=".$news_id;
    $ergebnis=mysql_query($abfrage);
    $row=mysql_fetch_object($ergebnis);
    if ($row->poster_ID==$s_user_id)
	  $abfrage = "UPDATE news SET Thema='$thema', Text='$text', Bearbeitung=Bearbeitung+1, Bearbeitungszeit=CURRENT_TIMESTAMP WHERE news_ID=" .$news_id;
	else
	  $abfrage='';
	}
  else  
    $abfrage = "INSERT INTO news (news_ID, Poster_ID, Thema, Text, Bearbeitung, Bearbeitungszeit) VALUES ('$news_id','$s_user_id','$thema', '$text',0, CURRENT_TIMESTAMP)";
  mysql_query($abfrage);
  header("Location: ./framework.php?id=index");
  }

elseif($aktion=="bearbeiten")
{

?>

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

<?php
$abfrage="SELECT * FROM news WHERE news_ID=".$_GET['newsid'];
$ergebnis=mysql_query($abfrage);
$row=mysql_fetch_object($ergebnis);

if ($row->poster_ID==$s_user_id)
{
?>
<div class="profilkopf">Mitteilung bearbeiten</div>

<form action="news.php" method="post">

Titel:<br /><input name="thema" size="50" type="text" value="<?php echo $row->Thema ?>"/><br /><br />
Text: <br />
<textarea name="text" wrap="soft" cols="50" rows="20">
<?php echo $row->Text ?>
</textarea>
<br />
<input type="hidden" name="bearbeiten" value="j"/>

<?php
  echo '<input type="hidden" name="news_id" value="'.$_GET['newsid'].'"/>';
?>
<input type="submit" value="Absenden" class="button"/></form>
<?php
}
else
  header("Location: ./framework.php?id=index");

}
elseif($aktion=="schreiben")
{
?>

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



<div class="profilkopf">Neue Mitteilung</div>

<form action="news.php" method="post">

Titel:<br /><input name="thema" size="50" type="text"/><br /><br />
Text: <br />
<textarea name="text" wrap="soft" cols="50" rows="20">
</textarea>
<br />
<input type="hidden" name="bearbeiten" value="n"/>

<input type="submit" value="Absenden" class="button"/></form>


<?php
}

?>