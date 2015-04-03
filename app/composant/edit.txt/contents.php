<?php

require_once("../../config.php");

$document1 = filter_input(INPUT_GET, 'document');

$document = rawurldecode($document1);
if(substr($document, 0, 2)=="./")
{
        $document = substr($document, 2);
}
echo "(($dataDir.$pathSep))<strong>$document</strong>";
?>
<hr/>
<form action="?composant=rename.txt&document=" method="GET">
    <input type="hidden" name="composant" value="rename.txt"/>
    <input type="hidden" name="document"  value="<?php echo rawurlencode($document); ?>"/>
    <input type="text" name="nom" value="<?php echo $document ?>">
    <input type="submit" name="renommer" value="Renommer"/>
</form>
<hr/>
<form action="?composant=save.txt&document=<?php echo rawurlencode($document); ?>" method="GET">
    <input type="hidden" name="composant" value="save.txt"/>
    <input type="hidden" name="document"  value="<?php echo rawurlencode($document); ?>"/>
    <textarea rows="24" cols="80" name="contenu"><?php echo file_get_contents($dataDir.$pathSep.$document);
        ?></textarea> <input type="submit" name="sauvegarder" value="Sauvergarder"/>
</form>
<hr/>
<form action="?composant=classe.doc&document=<?php echo rawurlencode($document); ?>" method="GET">
    <input type="hidden" name="composant" value="classe.doc"/>
    <input type="hidden" name="document"  value="<?php echo rawurlencode($document); ?>"/>
        <select name="CLASS">
<?php
$fh = opendir($dataDir);
while(($f=readdir($fh)!=NULL))
{
    ?>
            <?php 
            if(substr($f,0, 5)=="CLASS")
                {
            ?>
            <option name="<?php echo $f; ?>" value="<?php echo substr($f, 5); ?>"></option>
            <?php
                }
            ?>
<?php
}
        ?>
            </select>
    <input type="submit" name="classer" value="Classer"/>
</form>
<hr/>
<form action="?composant=changetype&document=<?php echo rawurlencode($document); ?>" method="GET">
    <input type="hidden" name="composant" value="changetype"/>
    <input type="hidden" name="document"  value="<?php echo rawurlencode($document); ?>"/>
    <label>Changer le type du document:</label>
    <select name="typesouhait">
        <option value="TXT">Texte (.TXT)</option>
       <option value="HTML">Texte (.HTML)</option>
        <option value="XML">Texte (.XML)</option>
        <option value="JPG">Image (.JPG)</option>
        <option value="PNG">Image (.PNG)</option>
        <option value="ICO">Image (.ICO)</option>
        <option value="GIF">Image (.GIF)</option>
        <option value="ICS">Evenement de calendrier (.ICS)</option>
    </select>
    <input type="submit" name="changetype" value="Changer le type du document: <?php echo $document; ?>"><br/>
</form>
<hr/>
<hr/>
<form action="?composant=del.txt&document=<?php echo rawurlencode($document); ?>" method="GET">
    <input type="hidden" name="composant" value="del.txt"/>
    <input type="hidden" name="document"  value="<?php echo rawurlencode($document); ?>"/>
<input type="submit" name="supprimer" value="Supprimer document: <?php echo $document; ?>"><br/>
</form>
