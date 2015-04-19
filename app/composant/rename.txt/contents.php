<?php

require_once("../../config.php");

$document1 = filter_input(INPUT_GET, 'document');

$document = rawurldecode($document1);

$nom1 = filter_input(INPUT_GET, 'nom');

$nom = rawurldecode($nom1);


$newname = strtolower($nom);
// replace spaces with hyphens and remove funny characters
$newname = str_replace(' ', '-', $newname);
$newname = preg_replace('/[^\d\w\._-]/', '', $newname);
// make sure there's something left
$newname = $newname ? $newname : 'file';
// prevent renaming over an existing file
$i = 0;
while ($newname !== $nom && file_exists($dataDir . '/' . $newname)) {
    $newname = "_" . $i . "_" . $newname;
    $i++;
}
$newnamedoc = $newname;

echo "<p>$oldname</p>";
echo "<p>$newname</p>";

$oldname = $dataDir . $pathSep . $document . ".txt";
$newname = $dataDir . $pathSep . $newnamedoc . ".txt";

if (rename($oldname, $newname)) {
    echo "<h1>Fichier renommé avec succès.</h1>";

    renameFile($document, $newnamedoc);
    createFile($newnamedoc);
}
?>
<ul>
    <li class="button_appdoc"><a href="?composant=reader.txt&document=<?php echo rawurlencode(substr($newnamedoc, 0, -4)); ?>">Visualiser la note</a></li>
</ul>