<?php

require_once("../../config.php");


$document1 = filter_input(INPUT_GET, 'document');

$document = rawurldecode($document1);
if (substr($document, 0, 2) == "./") {
    $document = substr($document, 2);
}
$pos = strpos($document, "/");
if($pos!==FALSE)
{
    $documentName = substr($document, $pos+1);
}

$classeur = rawurldecode(filter_input(INPUT_GET, 'classeur'));


echo $classeur ;

$newname = $dataDir . "/CLASS" . $classeur . "/" . $documentName ;

$i = 0;

$testnewname = $newname;
while ($testnewame !== $nom && file_exists($testnewame)) {
    $testnewname = $dataDir . "/CLASS" . $classeur . "/" . $documentName . "_" . $i . "_";
    $i++;
}


$oldname = $dataDir . $pathSep . $document;
$newname = $testnewname;

echo "<p>old:$oldname</p>";
echo "<p>new:$newname</p>";


if (rename($oldname, $newname)) {
    echo "<h1>Fichier <strong>$oldname</strong> classé avec succès dans <strong>$newname</strong>.</h1>";
}

renameFile($oldname, $newname);
?>
