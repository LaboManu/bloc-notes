<?php

require_once("../../config.php");

$classeur1 = filter_input(INPUT_GET, 'classeur');

$classeur = rawurldecode($classeur1);
?>
<hr/>
<form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="rename.cls"/>
    <input type="hidden" name="classeur"  value="<?php echo rawurlencode($classeur); ?>"/>
    <input type="text" name="nom" value="<?php echo $classeur; ?>">
    <input type="submit" name="renommer" value="Renommer"/>
</form>
<hr/>
<hr/>
<form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="del.txt"/>
    <input type="hidden" name="classeur"  value="<?php echo rawurlencode($classeur); ?>"/>
<input type="submit" name="supprimer" value="Supprimer document: <?php echo $classeur; ?>"><br/>
</form>
