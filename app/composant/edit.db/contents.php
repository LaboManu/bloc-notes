<?php

require_once("../../config.php");

$id = rawurldecode(filter_input(INPUT_GET, 'dbdoc'));
?>
<form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="save.db"/>
    <input type="hidden" name="dbdoc"  value="<?php echo $id; ?>"/>
    <textarea rows="24" cols="80" name="contenu"><?php
    connect();
    $result = getDBDocument($id);
    if(($doc=mysql_fetch_assoc($result))!=NULL)
    {
        echo $doc["content_file"];
    }
    else echo "Erreur : ".$id;
    
        ?></textarea> <input type="submit" name="sauvegarder" value="Sauvergarder"/>
</form>
