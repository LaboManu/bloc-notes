<?php
require_once("../../config.php");
require_once("../browser/listesItem.php");

$dbdoc = (int)filter_input(INPUT_GET, "folder");

connect();

$dbdocRes= getDBDocument($dbdoc);

$currentDoc = mysqli_fetch_assoc($dbdocRes);


$id = $currentDoc["id"];


$docs = getAllDocuments();

?>
<h1><?php echo $currentDoc["filename"]; ?></h2>


<form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="create.follow.db"/>
    <input type="hidden" name="dbdoc"  value="-1"/>
    <fieldset>
        <label for="filename">Nom de fichier</label>
 <?php document_field_follow($id, "follow", $docs);  ?>
    </fieldset>
    <input type="submit" name="submit" value="Faire suivre" class="user-control"/><br/>
</form>