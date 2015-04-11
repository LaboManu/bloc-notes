<?php

require_once("../../config.php");

$classeur1 = filter_input(INPUT_GET, 'classeur');

$classeur = rawurldecode($classeur1);

$nom1 = filter_input(INPUT_GET, 'nom');

$nom = rawurldecode($nom1);


// replace spaces with hyphens and remove funny characters
$newname = str_replace(' ', '-', $nom);
$newname = preg_replace('/[^\d\w\._]/', '', $newname);
$classeur = preg_replace('/[^\d\w\._]/', '', $classeur);
// make sure there's something left
$newname = $newname ? $newname : 'file';
// prevent renaming over an existing file
$i = 0;
while ($newname !== $nom && file_exists($dataDir . '/' . $newname)) {
    $newname = "_" . $i . "_" . $newname;
    $i++;
}
$newnamedoc = $newname;

$oldname = $dataDir . $pathSep . "CLASS".$classeur;
$newname = $dataDir . $pathSep . "CLASS".$newname;

echo "<p>$oldname</p>";
echo "<p>$newname</p>";


if (rename($oldname, $newname)) {
    echo "<h1>Classeur renommé avec succès.</h1>";

    renameFile($document, $newnamedoc);
    createFile($newnamedoc); 
}
?>
