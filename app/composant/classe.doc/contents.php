<?php

require_once("../../config.php");


$document1 = filter_input(INPUT_GET, 'document');

$document = rawurldecode($document1);
if (substr($document, 0, 2) == "./") {
    $document = substr($document, 2);
}
$CLASS = filter_input(INPUT_GET, 'classeur');

$classeur = rawurldecode($CLASS);

echo $classeur ;

$newname = $dataDir . "/CLASS" . $classeur . "/" . $document.".txt" ;

$i = 0;

$testnewname = $newname;
while ($testnewame !== $nom && file_exists($testnewame)) {
    $testnewname = $dataDir . "/CLASS" . $classeur . "/" . $document . "_" . $i . "_".".txt";
    $i++;
}


$oldname = $dataDir . $pathSep . $document.".txt";
$newname = $testnewname;

echo "<p>old:$oldname</p>";
echo "<p>new:$newname</p>";


if (rename($oldname, $newname)) {
    echo "<h1>Fichier <strong>$oldname</strong> classé avec succès dans <strong>$newname</strong>.</h1>";
}

renameFile($oldname, $newname);
?>
