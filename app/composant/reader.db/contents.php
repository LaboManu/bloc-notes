<?php

require_once("../browser/listesItem.php");

$id = (int) filter_input(INPUT_GET, "id");
connect();
$result = getDBDocument($id);







if($result != NULL) {
    if(($doc=  mysql_fetch_assoc($result))!=NULL) {
        
$filename = $doc['filename'];
$content = $doc['content_file'];

require_once("../display/contents.php?id=".$id);
?>
<ul>
    <li><a href="#">Modifier</a></li>
    <li><a href="#">Voir</a></li>
</ul>
<?php
/*
connect();
$result = getDBDocument();







if($result != NULL) {
    if(($doc=  mysql_fetch_assoc($result))!=NULL) {
        
$filename = $doc['filename'];
$content = $doc['content_file'];

if (in_array(getExtension($filename), array("jpg", "png", "gif", "bmp"))) {
    echoImgSelf($content, $filename);
} else if (in_array(getExtension($filename), array("txt"))) {
    echo $content;
} else if (strpos($filename, "/CLASS") > 0) {
    echo "Classeur";
}


echo getExtension($filename);
echo $content;
    }
} else {
    echo "404 NOT FOUND ...";
}
function echoImgSelf($content, $filename) {
    header('Content-type:image/' . getExtension($filename));

    echo $content;
}

*/
    }
}
?>