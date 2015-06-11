<?php


$id = (int) filter_input(INPUT_GET, "dbdoc");


?>

<ul>
    <li class="button_appdoc"><a href="?composant=edit.db&type=txt&dbdoc=<?php echo $id; ?>">Editer</a></li>
    <li class="button_appdoc"><a href="javascript:copyclipboard(document.getElementById('document').innerHTML);">Copier vers presse-papier</a></li>
</ul>