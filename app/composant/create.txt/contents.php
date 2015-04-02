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
        $i = 1;
        $testnewname = $newname."_".$i;
        while ($testnewname !== $nom && file_exists($dataDir . '/' . $testnewname)) {
            $i++;
            $testnewname = $newname."_".$i;
        }
        $newname = $testnewname;

if(touch($dataDir.$pathSep.$newname))
{
    echo "<h1>Note créée avec succès</h1>";
    echo "<p>$newname</p>";
}

?>

<ul>
    
<li class="button_appdoc"><a href="?composant=edit.txt&document=<?php echo rawurlencode($newname); ?>">Modifier, renommer, supprimer une note</a></li>

</ul>

