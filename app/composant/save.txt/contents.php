<?php

require_once("../../config.php");

$document1 = filter_input(INPUT_GET, 'document');

$document = rawurldecode($document1);

$contenu = rawurldecode(filter_input(INPUT_GET, 'contenu'));
?>
<p>Document:<?php echo $document; ?></p>
<pre>Contenu:<?php echo $contenu; ?></pre>
<?php
$fp = fopen($dataDir.$pathSep.$document.".txt", "w");

fwrite($fp, $contenu);

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
