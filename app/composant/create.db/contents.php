<?php
require_once("../../config.php");
require_once("../browser/listesItem.php");
?><form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="save.db"/>
    <input type="hidden" name="dbdoc"  value="-1"/>
    <textarea rows="24" cols="80" name="contenu"><?php echo $doc["content_file"]; ?></textarea>
    <input type="submit" name="sauvegarder" value="Sauvergarder"/>
</form>
<form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="save.db" />
    <input type="hidden" name="dbdoc"  value="-1"/>
    <input type="file" name="files[]" multiple="multiple"/>
    <input type="submit" name="ajouter" value="Ajouter" />
</form>