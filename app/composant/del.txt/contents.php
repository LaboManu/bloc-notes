<?php

require_once("../../config.php");

$document1 = filter_input(INPUT_GET, 'document');

$document = rawurldecode($document1);


if(unlink($dataDir.$pathSep.$document))
{
    echo "<h1>Fichier <strong>SUPPRIME</strong> avec succès.</h1>";
}


?>
