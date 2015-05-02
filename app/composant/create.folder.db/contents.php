<?php
require_once("../../config.php");
require_once("../browser/listesItem.php");
?><form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="save.db"/>
    <input type="hidden" name="dbdoc"  value="-2"/>
    <input type="text" name="filename"  value="Nouveau dossier"/>
    <input type="submit" name="submit" value="Valider"/>
</form>

