<?php
require_once("../../config.php");
require_once("../browser/listesItem.php");

$folder = (int)filter_input(INPUT_GET, "folder");

connect();

$folderRes= getDBDocument($folder);

$folderDoc = mysqli_fetch_assoc($folderRes);


$folder_id = $folderDoc["id"];
?>
<h1><?php echo $folderDoc["filename"]; ?></h2>
<?php

// OLD CODE
if(isset($_GET["CREATE_FROM"]))
{

?>

<form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="save.db"/>
    <input type="hidden" name="dbdoc"  value="-1"/>
    <fieldset>
        <label for="filename">Nom de fichier</label>
        <input type="text" name="filename"  value="Nouvelle note textuelle" class="user-control"/><br/>
    </fieldset>
    <fieldset>
        <label for="folder">Choisissez où mettre la note</label>
       <?php
 folder_field($folder_id);  ?>
   </fieldset>
        
    <fieldset>
        <label for="contenu"></label>
    <textarea rows="12" cols="40" name="contenu"><?php echo $doc["content_file"]; ?></textarea><br/>
    </fieldset>
    <fieldset>
        <label for="submit">Envoyer</label>
    <input type="submit" name="submit" value="addData" class="user-control"/><br/>
    </fieldset>
    
</form>

<?php
}

$date = date("Y-m-d-H-i-s");

if(($id = createFile("Ma note", "text/plain", "--\nWho?".$monutilisateur.", \nThe date:".$date, 0, $folder))>0)
{
?>
<a href="?composant=edit.db&dbdoc=<?php echo $id; ?>">Editer la nouvelle note</a>
<?php
}
?>
<hr/>
<form action="event/uploads/uploadfordb.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="composant" value="save.db" />
    <input type="hidden" name="dbdoc"  value="0"/><br/>
    <fieldset>
        <label for="folder2">Choisissez où mettre la note-fichier</label>
     <?php
 folder_field($folder_id);  ?>
    <fieldset>
        <label for="file[]">Choisissez des fichiers</label>
        <input type="file" name="files[]" multiple="multiple" class="user-control"/><br/>
    </fieldset>
    <fieldset>
        <label for="submit">Envoyer</label>
    <input type="submit" name="submit" value="upload" class="user-control"/><br/>
    </fieldset>
</form>