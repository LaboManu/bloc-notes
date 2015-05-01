<?php
require_once("../../config.php");
require_once("../browser/listesItem.php");
$id = rawurldecode(filter_input(INPUT_GET, 'dbdoc'));


    connect();
    $result = getDBDocument($id);
    if(($doc=mysql_fetch_assoc($result))!=NULL)
    {
        $filename = $doc['filename'];
        $ext = getExtension($filename);
        if($ext=="txt")
        {

            ?>
<form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="save.db"/>
    <input type="hidden" name="dbdoc"  value="<?php echo $id; ?>"/>
    <textarea rows="24" cols="80" name="contenu"><?php echo $doc["content_file"]; ?></textarea>
    <input type="submit" name="sauvegarder" value="Sauvergarder"/>
</form>
        <?php    
        }
         else if(isImage($filename)) {
            echo "Mise à jour non disponible acutellement : Type de fichier PICTURES ($ext) non pris en charge. $filename ";
        }
        else {
            echo "Erreur : Type de fichier ($ext) non pris en charge actuellement dans l'éditeur web blocnotes. $filename ";
        }
    }    
