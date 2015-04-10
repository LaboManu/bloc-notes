<?php

require_once("../../config.php");

$classeur1 = filter_input(INPUT_GET, 'classeur');

$classeur = rawurldecode(substr($classeur1, 5));

echo "(Remote path:$dataDir.$pathSep)<strong>$classeur</strong>";
?>
<hr/>
<form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="classeur.save"/>
    <input type="hidden" name="classeur"  value="<?php echo rawurlencode($classeur); ?>"/>
    <input type="text" name="nom" value="<?php echo $classeur; ?>">
    <input type="submit" name="renommer" value="Renommer"/>
</form>
