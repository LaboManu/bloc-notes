<?php

require_once("../../all-configured-and-secured-included.php");
require_once("../browser/listesItem.php");

$folder = (int) rawurldecode(filter_input(INPUT_GET, "folder"));

?><form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="save.db"/>
    <input type="hidden" name="dbdoc"  value="-2"/>
    <input type="text" name="filename"  value="Nouveau dossier"/>
    <fieldset><label for="folder">Dossier parent</label>
    <?php
        folder_field($folder);
    ?>
       <br/>
<input type="submit" name="submit" value="Valider"/>
</form>

