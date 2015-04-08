<?php

require_once("../../config.php");

$document1 = filter_input(INPUT_GET, 'document');

$document = rawurldecode($document1);
if(substr($document, 0, 2)=="./")
{
        $document = substr($document, 2);
}
echo "(Remote path:$dataDir.$pathSep)<strong>$document</strong>";
?>
<hr/>
<form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="rename.cls"/>
    <input type="hidden" name="document"  value="<?php echo rawurlencode($document); ?>"/>
    <input type="text" name="nom" value="<?php echo $document; ?>">
    <input type="submit" name="renommer" value="Renommer"/>
</form>
<hr/>
<hr/>
<form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="del.txt"/>
    <input type="hidden" name="document"  value="<?php echo rawurlencode($document); ?>"/>
<input type="submit" name="supprimer" value="Supprimer document: <?php echo $document; ?>"><br/>
</form>
