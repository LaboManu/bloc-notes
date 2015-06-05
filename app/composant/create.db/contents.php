<?php
require_once("../../config.php");
require_once("../browser/listesItem.php");

$folder = (int)filter_input(INPUT_GET, "folder");

connect();

$folderRes= getDBDocument($folder);

$folderDoc = mysqli_fetch_assoc($folderRes);
?>
<h1><?php echo htmlspecialchars($folderDoc["filename"]); ?></h2>


<form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="save.db"/>
    <input type="hidden" name="dbdoc"  value="-1"/>
    <fieldset>
        <label for="filename">Nom de fichier</label>
        <input type="text" name="filename"  value="Nouvelle note textuelle" class="user-control"/><br/>
    </fieldset>
    <fieldset>
        <label for="folder">Choisissez où mettre la note</label>
    <select name="folder" class="user-control">
        <?php
        connect();
        $res = getFolderList();
        while(($row=  mysqli_fetch_assoc($res))!=NULL)
        {
            if($row["id"]==$folder)
            {
                $optionSel = "selected";
            }
            else {
                $optionSel = "";
     
            }
            echo "<option value='".$row['id']."' ".$optionSel." >".$row['filename']."</option>";
            
        }
        ?>
    </select>
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
<hr/>
<form action="event/uploads/uploadfordb.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="composant" value="save.db" />
    <input type="hidden" name="dbdoc"  value="0"/><br/>
    <fieldset>
        <label for="folder">Choisissez où mettre la note-fichier</label>
    <?php                folder_field($doc["folder_id"]); ?>
     
    <fieldset>
        <label for="file[]">Choisissez des fichiers</label>
        <input type="file" name="files[]" multiple="multiple" class="user-control"/><br/>
    </fieldset>
    <fieldset>
        <label for="submit">Envoyer</label>
    <input type="submit" name="submit" value="upload" class="user-control"/><br/>
    </fieldset>
</form>