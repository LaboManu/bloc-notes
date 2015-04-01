<?PHP
header("Location: page.xhtml.php");

require_once("config.php");

require_once("access-controlled.php");
require_once("listesItem.php");
if($trad['CMD']['DOWNLOAD']==$cmd)
{
	echo "download";
require_once 'lib/download.php';
 
$local=$dataDir.$pathSep.$bnf;
$remote=$download;
 echo "<br>$local <br>$remote<br>";
$DownloadBinaryFile=new DownloadBinaryFile();
if ($DownloadBinaryFile->load($remote)==TRUE) {
    $DownloadBinaryFile->saveTo($local);
} else {
    echo 'download failed';
}

}	


if($action=="link")
{
$Tables->setPair($username, $bnf, $bnflink);

}

if($trad['CMD']['SAVE']==$cmd)
{
	$f = fopen($dataDir.$pathSep.$bnf, "w");
	
	fwrite($f, $content);
	
	fclose($f);
}
else if($trad['CMD']['RENAME_FORM']==$cmd)

{
	?>
	<form name="rename" method="POST">
		<input type="text" name="rename" value="<?php echo $bnf; ?>"/>
		<input type="text" name="rename_to" value="<?php echo "" ?>"/>
		<input type="submit" name="cmdexec" value="<?php echo $trad['CMD']['RENAME'] ?>"/>
	</form>
	<?php
}
else if($trad['CMD']['DELETE']==$cmd)

{
	echo "Supprime (corbeille)";

	if(!file_exists ($dataDir.$pathSep.$bnf,$dataDir.$pathSep.$bnf.".BAK") and
	 file_exists ($dataDir.$pathSep.$bnf))
	{
	
		echo rename($dataDir.$pathSep.$bnf, $dataDir.$pathSep.$bnf.".BAK")
			?
				"Supprimé"
			:
				"Non supprimé";
		
	}
	else
	{
		echo "Erreur: fichier non supprimé";
	}
	
	
}
if($trad==$trad['CMD']['DISPLAY'] or $cmd==$trad['CMD']['DOWNLOAD'] or $cmd=="" )
{
	if($isNew === false)
	{
		$content = file_get_contents($dataDir.$pathSep.$bnf);
	}
} else if($trad['CMD']['NEW']==$cmd)
{
	$bnf = "NEW FILE ".rand().".TXT";
}
if($trad['CMD']['RENAME']==$cmdexec and $cmdexec!="")
{
	echo "Renomme ...";
	if(file_exists ($dataDir.$pathSep.$rename) and
	 !file_exists ($dataDir.$pathSep.$rename_to))
	{
	
		echo rename($dataDir.$pathSep.$rename, $dataDir.$pathSep.$rename_to)
			?
				"Renommé"
			:
				"Non renommé";
		
	}
	else
	{
		echo "Erreur: fichier non renommée";
	}
}
?>
<!--</div>-->
<?php
listerBN();

?>

<form name="blocnoteForm" method="POST">
	<button><img class="icon-32" src="images/1416633544.png">DELETE</img></button>
<button>	<img class="icon-32" src="images/1416633603.png">COPY</img></button>
<button>	<img class="icon-32" src="images/1416633660.png">MOVE</img></button>
<button>	<img class="icon-32" src="images/1416634052.png">EDIT</img></button>

<button>	<img class="icon-32" src="images/1416634099.png">SAVE</img></button>
	<input type="submit" name="cmd" value="<?php echo $trad['CMD']['NEW']; ?>"/>
	<input type="submit" name="cmd" value="<?php echo $trad['CMD']['SAVE']; ?>" />
	<input type="submit" name="cmd" value="<?php echo $trad['CMD']['RENAME_FORM']; ?>" />
	<input type="submit" name="cmd" value="<?php echo $trad['CMD']['DELETE']; ?>" />
	<input type="text" name="id"    value="<?php echo $id; ?>" size="20" />
	<input type="text" name="bnf"   value="<?php echo "$bnf"; ?>" />
            <?php if($Tables->findType($bnf)=="text"){?>
 	<textarea id="EditView" name="content" rows="25" cols="80">
          <?php echo $content; ?>

        </textarea><br/><div id="HtmlView"></div><?php }    ?>
            <?php if($Tables->findType($bnf)=="image"){?>
               ---- <img src="<?php echo $userdataurl.$pathSep.$bnf ; ?>"/><a href="editimage.php?imagepng=<?= $bnf ?>">Editer image</a><a href="publish.php?filename=<?= $bnf ?>">Publier</a>
            <?php }?>
            <p>-</p>
            <p>T&eacute;l&eacute;charger: <a href="<?php echo $urlbase."/data/".$fgmembersite->UserFullName()."/".$bnf;  ?>"><?php echo $urlbase."/data/".$bnf;  ?></a></p>
	<p>T&eacute;l&eacute;charger URL: <input type"text" name="download" value="" size="20" /><input type="submit" name="cmd" value="<?php echo $trad['CMD']['DOWNLOAD']; ?>" /></p>
	<p><button name="" onclick="javascript:inserer();">Insérer</button></p></form >
	<p><button name="" onclick="javascript:htmlView();">As HTML</button></p>
	<p><a href="associerItemA.php?bnf=<?= $bnf ?>">Associer &agrave;</a></p>
