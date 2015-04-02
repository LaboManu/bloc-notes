<?php

require_once("../../config.php");

$document1 = filter_input(INPUT_GET, 'document');

$document = rawurldecode($document1);

echo "(($dataDir.$pathSep))<strong>$document</strong>";
?>
<form action="?composant=rename.txt&document=" method="GET">
    <input type="hidden" name="composant" value="rename.txt"/>
    <input type="hidden" name="document"  value="<?php echo rawurlencode($document); ?>"/>
    <input type="text" name="nom" value="<?php echo $document ?>">
    <input type="submit" name="renommer" value="Renommer"/>
</form>
<form action="?composant=save.txt&document=<?php echo rawurlencode($document); ?>" method="GET">
    <input type="hidden" name="composant" value="save.txt"/>
    <input type="hidden" name="document"  value="<?php echo rawurlencode($document); ?>"/>
    <textarea rows="24" cols="80" name="contenu">  
        <?php echo file_get_contents($dataDir.$pathSep.$document);
        ?>
    </textarea> <input type="submit" name="sauvegarder" value="Sauvergarder"/>
</form>
<form action="?composant=del.txt&document=<?php echo rawurlencode($document); ?>" method="GET">
    <input type="hidden" name="composant" value="del.txt"/>
    <input type="hidden" name="document"  value="<?php echo rawurlencode($document); ?>"/>
<input type="submit" name="supprimer" value="Supprimer document: <?php echo $document; ?>"><br/>
</form>
