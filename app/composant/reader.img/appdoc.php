<?php
require_once("../../config.php");

$document1 = filter_input(INPUT_GET, 'document');

$document = rawurldecode($document1);

connect();

?>

<a class="button_appdoc" href="?composant=browser">Retour à la navigation</a>
<a class="button_appdoc" href="?composant=classement&document=<?php echo rawurlencode($document); ?>">Changer l'emplacement du fichier</a>