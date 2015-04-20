<?php

require_once("../../config.php");

$document = rawurldecode(filter_input(INPUT_GET, 'document'));

$classeur = rawurldecode(filter_input(INPUT_GET, 'classeur'));

$contenu = rawurldecode(filter_input(INPUT_GET, 'contenu'));
?>
<p>Document:<?php echo $document; ?></p>
<p>classeur:<?php echo $classeur; ?></p>
<pre>Contenu:<?php echo $contenu; ?></pre>
<?php
$fp = fopen($dataDir.$pathSep.($classeur==NULL?"":"CLASS".$classeur.$pathSep).$document.".txt", "w");

fwrite($fp, $contenu);
fclose($fp);
echo "<h1>Fichier sauvegardé avec succès.</h1>";

global $link;
connect();

updateFile($document, "", $contenu);
$res = getDocument($document);
if($re!==NULL)
{
    
$row1 = mysql_fetch_row($result);
echo "<h2>Contenu</h2><pre>".($row1["contenu"])."</pre>";
echo "<h2>Modifié le </h2><pre>".($row1["moment"])."</pre>";

}
?>
<ul>
    <li class="button_appdoc"><a href="?composant=reader.txt&document=<?php echo rawurlencode(substr($newname, 0, -4)); ?>">Visualiser la note</a></li>
</ul>