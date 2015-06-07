<?php
require_once("../browser/listesItem.php");


connect();

$id = rawurldecode(filter_input(INPUT_GET, 'dbdoc'));

$docRes = getDBDocument($id);

if(($doc = mysqli_fetch_assoc($docRes))!=NULL)
{
    //$folder = $doc["folder_id"];
    if($doc["isDirectory"]==1)
    {
        $folder = $id;
    }
    else
    {
        $folder = $doc["folder_id"];
    }
}
 else {
    die();
}


    connect();
    $result = getDBDocument($id);
    if(($doc=mysqli_fetch_assoc($result))!=NULL)
    {
        $filename = $doc['filename'];
        $ext = getExtension($filename);
            ?>
<form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="save.db"/>
    <input type="hidden" name="dbdoc"  value="<?php echo $id; ?>"/>
    <input type="hidden" name="option"  value="move.doc"/>
    <?php folder_field($folder); ?>
    <input type="submit" name="sauvegarder" value="Sauvergarder"/>
</form>
    <?php
    }