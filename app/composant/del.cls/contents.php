<?php

require_once("../../config.php");

$document1 = filter_input(INPUT_GET, 'document');

$document = rawurldecode($document1);


if(unlink($dataDir.$pathSep."CLASS".$document))
{
    echo "<h1>Claseur <strong>SUPPRIME</strong> avec succès.</h1>";
    deleteFile($document);
}


?>
