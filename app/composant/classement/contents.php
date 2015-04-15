<?php

require_once("../../config.php");

$document1 = filter_input(INPUT_GET, 'document');

$document = rawurldecode($document1);
if(substr($document, 0, 2)=="./")
{
        $document = substr($document, 2);
}
echo "(Remote path:$dataDir.$pathSep)<strong>$document</strong>";
?>
<hr/>
<form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="classe"/>
    <input type="hidden" name="document"  value="<?php echo rawurlencode($document); ?>"/>
        <select name="classeur">
<?php
$dir = $dataDir."/".$classeur;
$fh = opendir($dir);
while(($f=readdir($fh))!=NULL)
{
   
            if(strlen($f)>5 && substr($f,0, 5)=="CLASS")
                {
            ?>
            <option name="<?php echo substr($f, 5); ?>" value="<?php echo substr($f, 5); ?>"><?php echo substr($f, 5); ?></option>
            <?php
                }
 }
 ?>
            </select>
    <input type="submit" name="classer" value="Classer"/>
</form>
