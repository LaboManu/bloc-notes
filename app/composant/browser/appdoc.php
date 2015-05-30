<?php
require_once("../../all-configured-and-secured-included.php");
require_once("listesItem.php");

$dbdoc=(int) filter_input(INPUT_GET, "dbdoc");
?>
<ul>
<li class="button_appdoc"><a href="?composant=create.db&folder=<?php echo $dbdoc  ; ?>">Ecrire</a></li>
<li class="button_appdoc"><a href="?composant=create.folder.db&folder=<?php echo $dbdoc  ; ?>">Nouveau dossier</a></li>
</ul>