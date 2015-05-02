<?php

require_once("../browser/listesItem.php");


connect();
$result = getDBDocument(filter_input(INPUT_GET, "id"));
if ($result != NULL) {
    if (($doc = mysql_fetch_assoc($result)) != NULL) {

        $filename = $doc['filename'];
        $content = $doc['content_file'];

        if (in_array(getExtension($filename), array("jpg", "png", "gif", "bmp"))) {
            echoImgSelf($content, $filename);
        } else if (in_array(getExtension($filename), array("txt"))) {
            $content = str_replace("[[", "<a target='NEW' href='", $content);
            $content = str_replace("]]", "'>Lien</a>", $content);
            $content = str_replace("{{", "<img src='composant/display/contents.php?id=", $content);
            $content = str_replace("}}", "'/>", $content);
            echo $content;
        } else if (strpos($filename, "/CLASS") > 0) {
            echo "Classeur";
        }
    }
} else {
    echo "404 NOT FOUND ...";
}

function echoImgSelf($content, $filename) {
    header('Content-type:image/' . getExtension($filename));

    echo $content;
}
