<?php

$dbdoc=(int) filter_input(INPUT_GET, "dbdoc");
?>
<ul>
<li class="button_appdoc"><a href="?composant=create.db&folder=<?php echo $dbdoc  ; ?>">Ecrire</a></li>
<li class="button_appdoc"><a href="?composant=create.folder.db&folder=<?php echo $dbdoc  ; ?>">Nouveau dossier</a></li>
<!--<li class="button_appdoc"><a href="?help=composant=create.image.db">Créer une image en base de données</a></li>-->
<li class="button_help"><a href="?help=assemble">Aide : assembler dss données</a></li>
</ul>