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
        $testnewname = $newname."_".$i;
        while ($testnewname !== $nom && file_exists($dataDir . '/CLASS' . $testnewname)) {
            $i++;
            $testnewname = $newname."_".$i;
        }
        $newname = $testnewname;

if(mkdir($dataDir.$pathSep."CLASS".$newname, 0777, true))
{
    echo "<h1>Classeur créé avec succès</h1>";
    echo "<p>$newname</p>";
    
    require_once("../../event/DB.tables.file.php");

    createFile($newname);
}

?>

