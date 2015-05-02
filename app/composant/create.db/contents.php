<?php
require_once("../../config.php");
require_once("../browser/listesItem.php");
?><form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="save.db"/>
    <input type="hidden" name="dbdoc"  value="-1"/>
    <input type="text" name="filename"  value="Nouveau fichier texte.txt"/>
    <textarea rows="24" cols="80" name="contenu"><?php echo $doc["content_file"]; ?></textarea>
    <input type="submit" name="submit" value="addData"/>
</form>
<form action="event/uploads/uploadfordb.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="composant" value="save.db" />
    <input type="hidden" name="dbdoc"  value="0"/>
    <input type="file" name="files[]" multiple="multiple"/>
    <input type="submit" name="submit" value="upload" />
</form>