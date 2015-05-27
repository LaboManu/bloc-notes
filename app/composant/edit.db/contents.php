<?php
require_once("../browser/listesItem.php");
$id = rawurldecode(filter_input(INPUT_GET, 'dbdoc'));

function folder_field(){
    ?>
<select name="folder">
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
    </select><br/><?php
 }

    connect();
    $result = getDBDocument($id);
    if(($doc=mysqli_fetch_assoc($result))!=NULL)
    {
        $filename = $doc['filename'];
        $ext = getExtension($filename);
        if(isTexte($ext, $doc["mime"]))
        {

            ?>
<form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="save.db"/>
    <input type="hidden" name="dbdoc"  value="<?php echo $id; ?>"/>
    <?php                folder_field(); ?>
    <input type="text" name="filename"  value="<?php echo $doc['filename']; ?>"/>
    <textarea rows="12" cols="40" name="contenu"><?php echo $doc["content_file"]; ?></textarea>
    <input type="submit" name="sauvegarder" value="Sauvergarder"/>
</form>
<?php
        }
         else if(isImage($ext, $doc["mime"])) {?>
<form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="save.db"/>
    <input type="hidden" name="dbdoc"  value="<?php echo $id; ?>"/>
    <?php                folder_field(); ?>
    <input type="text" name="filename"  value="<?php echo $doc['filename']; ?>"/>
    <input type="submit" name="sauvegarder" value="Sauvergarder"/>
</form><?php
        }
        else {?>
<form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="save.db"/>
    <input type="hidden" name="dbdoc"  value="<?php echo $id; ?>"/>
    <?php                folder_field(); ?>
    <input type="text" name="filename"  value="<?php echo $doc['filename']; ?>"/>
    <input type="submit" name="sauvegarder" value="Sauvergarder"/>
</form>
        <?php
            
        }
    }    
