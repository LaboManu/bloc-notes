
<?php

require_once("../../config.php");

$newname = "CLASS".strtolower("classeur");
        // replace spaces with hyphens and remove funny characters
        $newname = str_replace(' ', '-', $newname);
        //$newname = preg_replace('/[^\d\w\._-]/', '', $newname);
        // make sure there's something left
        $newname = $newname ? $newname : 'CLASScls1';
        // prevent renaming over an existing file
        $i = 1;
        $testnewname = $newname."_".$i;
        while ($testnewname !== $nom && file_exists($dataDir . '/' . $testnewname)) {
            $i++;
            $testnewname = $newname."_".$i;
        }
        $newname = $testnewname;
?>
<h1>Création d'un classement</h1>
<?php
if(mkdir($dataDir.$pathSep.$newname))
{
    
    echo "<h1>Classeur créée avec succès</h1>";
    echo "<p>$newname</p>";
}

?>

<ul>
    
<li class="button_appdoc"><a href="?composant=edit.cls&document=<?php echo rawurlencode($newname); ?>">Modifier, renommer le classement</a></li>

</ul>

