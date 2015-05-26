<?php
require_once("../../config.php");
require_once("../browser/listesItem.php");

$folder = (int)filter_input(INPUT_GET, "folder");

?><form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="save.db"/>
    <input type="hidden" name="dbdoc"  value="-1"/>
    <input type="text" name="filename"  value="Nouvelle note textuelle"/><br/>
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
    </select><br/>
    <textarea rows="12" cols="40" name="contenu"><?php echo $doc["content_file"]; ?></textarea><br/>
    <input type="submit" name="submit" value="addData"/><br/>
</form>
<form action="event/uploads/uploadfordb.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="composant" value="save.db" />
    <input type="hidden" name="dbdoc"  value="0"/><br/>
    <input type="file" name="files[]" multiple="multiple"/><br/>
    <input type="submit" name="submit" value="upload" /><br/>
</form>