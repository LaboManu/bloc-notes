<?php
require_once("../../config.php");

$document1 = filter_input(INPUT_GET, 'document');

$document = rawurldecode($document1);

connect();

echo "<p>Création" . dbfile_getCreationTime($document) . "</p>";
echo "<p>Modifications" . dbfile_getModificationsAsList($document) . "</p>";
echo "<p>Suppressions" . dbfile_getDeleteTime($document) . "</p>";
?>



<ul>

    <li class="button_appdoc" ><a class="button_appdoc" href="#">Ajouter une note</a></li>
    <li class="button_appdoc"><a  href="?composant=del.txt&document=<?php echo rawurlencode($document) ?>">Supprimer une note</a></li>
    <li class="button_appdoc"><a href="?composant=edit.txt&document=<?php echo rawurlencode($document) ?>">Modifier, renommer, supprimer une note</a></li>

</ul>
<a href="?composant=browser">Retour à la navigation</a>
