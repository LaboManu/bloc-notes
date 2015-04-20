<?php

require_once("../../config.php");

$document = rawurldecode(filter_input(INPUT_GET, 'document'));
$classeur = rawurldecode(filter_input(INPUT_GET, 'classeur'));

$nom = rawurldecode(filter_input(INPUT_GET, 'nom'));

if($classeur=="")
{
    $classeur="./";
}

$newname = $nom;
// replace spaces with hyphens and remove funny characters
$newname = str_replace(' ', '-', $newname);
// make sure there's something left
$newname = $newname ? $newname : 'file';
// prevent renaming over an existing file
$i = 0;
while (file_exists($dataDir . '/'. $classeur."/". $newname)) {
    $newname = "_" . $i . "_" . $newname;
    $i++;
}
$newnamedoc = $newname;

echo "<p>$oldname</p>";
echo "<p>$newname</p>";

$oldname = $dataDir . $pathSep .($classeur==NULL?"":"CLASS".$classeur.$pathSep) .$document . ".txt";
$newname = $dataDir . $pathSep .($classeur==NULL?"":"CLASS".$classeur.$pathSep) . $newnamedoc . ".txt";

if (rename($oldname, $newname)) {
    echo "<h1>Fichier renommé avec succès.</h1>";

    renameFile($document, $newnamedoc);
    createFile($newnamedoc);
}
?>
<ul>
    <li class="button_appdoc"><a href="?composant=reader.txt&document=<?php echo rawurlencode(substr($newnamedoc, 0, -4)); ?>">Visualiser la note</a></li>
</ul>