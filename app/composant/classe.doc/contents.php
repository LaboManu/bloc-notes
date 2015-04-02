<?php 
require_once("../../config.php");


$document1 = filter_input(INPUT_GET, 'document');

$document = rawurldecode($document1);

$CLASS = filter_input(INPUT_GET, 'CLASS');

$classeur = rawurldecode($CLASS);


$newname = strtolower($dataDir."/".$classeur."/".$document);
        // replace spaces with hyphens and remove funny characters
        $newname = str_replace(' ', '-', $newname);
        //$newname = preg_replace('/[^\d\w\._-]/', '', $newname);
        // make sure there's something left
        $newname = $newname ? $newname : 'file';
        // prevent renaming over an existing file
        $i = 0;
        while ($newname !== $nom && file_exists($dataDir."/".$classeur."/".$newname)) {
            $newname ="_".$i."_".$newname;
            $i++;
        }

        echo "<p>$oldname</p>";
echo "<p>$newname</p>";

$oldname = $dataDir.$pathSep.$document;
$newname = $dataDir.$pathSep.$classeur.$pathSep.$newname;

if(rename($oldname, $newname))
{
    echo "<h1>Fichier <strong>$oldname</strong> classé avec succès dans <strong>$newname</strong>.</h1>";
}


?>
