<?php

require_once("../../config.php");

$document1 = filter_input(INPUT_GET, 'document');

$document = rawurldecode($document1);

$contenu = rawurldecode(filter_input(INPUT_GET, 'contenu'));
?>
<p>Document:<?php echo $document; ?></p>
<pre>Contenu:<?php echo $contenu; ?></pre>
<?php
$fp = fopen($dataDir.$pathSep.$document, "w");

fwrite($fp, $contenu);

echo "<h1>Fichier sauvegardé avec succès.</h1>";


?>
