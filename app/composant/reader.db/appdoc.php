<?php


$id = (int) filter_input(INPUT_GET, "dbdoc");


?>

<ul>
    <li class="button_appdoc"><a href="?composant=edit.db&type=txt&dbdoc=<?php echo $id; ?>">Editer</a></li>
</ul>