<?php

require_once("../../config.php");

$document1 = filter_input(INPUT_GET, 'document');

$newname = strtolower("note.txt");
        // replace spaces with hyphens and remove funny characters
        $newname = str_replace(' ', '-', $newname);
        //$newname = preg_replace('/[^\d\w\._-]/', '', $newname);
        // make sure there's something left
        $newname = $newname ? $newname : 'file';
        // prevent renaming over an existing file
        $i = 0;
        while ($newname !== $nom && file_exists($dataDir . '/' . $newname)) {
            $newname ="_".$i."_".$newname;
            $i++;
        }


if(touch($dataDir.$pathSep.$newname))
{
    echo "<h1>Note créée avec succès</h1>";
    echo "<p>$newname</p>";
}

?>
