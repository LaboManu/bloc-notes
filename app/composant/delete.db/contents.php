<?php
require_once("../../all-configured-and-secured-included.php");

$dbdoc = (int)filter_input(INPUT_GET, "dbdoc");

connect();

if(deleteDBDoc($dbdoc))
{?>
    <p>Element supprimé : <?php echo $dbdoc; ?></p>
    <ul><li class='button_appdoc'><a class='button_appdoc' href='?composant=browser&dbdoc=<?php echo getFolder( $dbdoc)["id"]; ?>'>Retour</a></li></ul>
<?php

}