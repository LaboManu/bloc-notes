<a href="?composant=browser">Retour à la navigation</a>
<?php


require_once("../../config.php");

$document1 = filter_input(INPUT_GET, 'document');

$document = rawurldecode($document1);

?>

<ul>
    
<li class="button_appdoc"><a href="?composant=edit.txt&document=<?php echo rawurlencode($document); ?>">Modifier, renommer, supprimer une note</a></li>

</ul>
