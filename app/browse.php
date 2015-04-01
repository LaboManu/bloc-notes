<?PHP

require_once("config.php");

require_once("access-controlled.php");



if(isset($_GET['inserer']))
{
	$tab = explode("!", $_GET['inserer']);
	$Tables->addItem($tab[1], $tab[0]);
	
}
?>
<form action="browse.php" method="GET">
<?php
$browseUploads = $dataDir;
if($dh = opendir($browseUploads))
{
while(($file=readdir($dh))!=NULL)
{
	$user = $fgmembersite->UserFullName();
	echo "<span color='#F00;'>".
$Tables->isUserFilePairPresent($user, $file).
"</span><span class='upload'><a href='$userdataurl/$file'>$userdataurl/$file<img width='100px' height='100px' src='$userdataurl/$file'/></a><input type='submit' name='inserer' value='$file!$user'/></span>";
}
}
?>
</form>
<html>
<head>
</head>
<body>
</body>
</html>
