<?php
require_once("../browser/listesItem.php");

if(!isset($_GET['search']))
{
    $keywords = explode(",", $_GET['keywords']);
    $needle = filter_input(INPUT_GET, $_GET['folder']);
}
?>
<div class="miniImgContainer">
    <input type="text" name="keywords"/>
    <select name="folder" >
        <?php 
        connect();
        $folderRes =selectDBFolders(false);
        if($folderRes!=NULL)
        {
            while(($doc=  mysql_fetch_assoc($folderRes))!=NULL)
            {
                echo "<option name='".$doc['folder_name']."' >".$doc['folder_name']."</option>";
            }
        }
        ?>
    </select>
</div>
<?php
if(!isset($_POST['search']))
{
}