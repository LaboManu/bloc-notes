<?php

require_once("../../config.php");


$newname = "Classeur";
        // replace spaces with hyphens and remove funny characters
        $newname = str_replace(' ', '-', $newname);
        $newname = preg_replace('/[^\d\w\._-]/', '', $newname);
        // make sure there's something left
        $newname = $newname ? $newname : 'file';
        // prevent renaming over an existing file
        $i = 1;
        $testnewname = $newname."_".$i.".txt";
        while ($testnewname !== $nom && file_exists($dataDir . '/' . $testnewname)) {
            $i++;
            $testnewname = $newname."_".$i.".txt";
        }
        $newname = $testnewname;

if(touch($dataDir.$pathSep.$newname))
{
    echo "<h1>Classeur créé avec succès</h1>";
    echo "<p>$newname</p>";
    
    require_once("../../event/DB.tables.file.php");

    createFile($newname);
}

?>

