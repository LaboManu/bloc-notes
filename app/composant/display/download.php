<?php
require_once("../browser/listesItem.php");
require_once("../../all-configured-and-secured-included.php");
require_once("../../lib/fpdf17/fpdf.php");
require_once("../core/functional.php");

$id = (int) filter_input(INPUT_GET, "id");
$result = getDBDocument($id);
if(($doc=mysqli_fetch_assoc($result))!=NULL)
{
    header("Content-Type: ".($doc['mime']));
    echo $doc['content_file'];
}
else {
    Error("404");
}