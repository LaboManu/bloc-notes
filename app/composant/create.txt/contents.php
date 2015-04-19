<?php

require_once("../../config.php");
require_once("../../event/DB.tables.file.php");

$document = filter_input(INPUT_GET, 'document');

$classeur = filter_input(INPUT_GET, 'classeur');

$newname = "CLASS".$classeur."/".$document;
        // replace spaces with hyphens and remove funny characters
        $newname = str_replace(' ', '-', $newname);
        //$newname = preg_replace('/[^\d\w\._-]/', '', $newname);
        // make sure there's something left
        $newname = $newname ? $newname : 'CLASSClasseur';
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
    echo "<h1>Note créée avec succès</h1>";
    echo "<p>$newname</p>";
    

    createFile($newname);
    createFile($newname);
}

?>

<ul>
    
<li class="button_appdoc"><a href="?composant=edit.txt&document=<?php echo rawurlencode(substr($newname, 0, -4)); ?>">Modifier, renommer, supprimer une note</a></li>
<li class="button_appdoc"><a href="?composant=reader.txt&document=<?php echo rawurlencode(substr($newname, 0, -4)); ?>">Visualiser la note</a></li>

</ul>

