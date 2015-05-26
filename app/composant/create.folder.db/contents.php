<?php
require_once("../../config.php");
require_once("../browser/listesItem.php");
?><form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="save.db"/>
    <input type="hidden" name="dbdoc"  value="-2"/>
    <input type="text" name="filename"  value="Nouveau dossier"/>
       Dossier parent<select name="folder">
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
<input type="submit" name="submit" value="Valider"/>
</form>

