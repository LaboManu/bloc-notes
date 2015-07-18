<?php

require_once("../browser/listesItem.php");


connect();
$result = getDBDocument((int)filter_input(INPUT_GET, "id"));
if ($result != NULL) {
    if (($doc = mysqli_fetch_assoc($result)) != NULL) {
        $filename = $doc['filename'];
        $content = $doc['content_file'];
        $ext = getExtension($filename);
        
        
        
        if (isImage($ext, $doc['mime'])) {
            echoImgSelf($content, $filename);
        } else if (isTexte($ext, $doc["mime"])) {
            //preg_match ( string $pattern , string $subject [, array &$matches [, int $flags = 0 [, int $offset = 0 ]]] )
            //$content =  htmlspecialchars($content);
            //$content = "<p>".$content."</p>";
            //$content = str_replace("\n", "</p>\n<p>", $content);
            $content = str_replace("[[", "<a target='NEW' href='", $content);
            $content = str_replace("]]", "'>Lien</a>", $content);
            $content = str_replace("{{", "<img src='composant/display/contents.php?id=", $content);
            $content = str_replace("}}", "'/>", $content);
            // Following lines... Mmmh seems search another method?
            $content = str_replace("((", "<span class'included_doc'>include doc n0", $content);
            $content = str_replace("))", "</span>", $content);
            
            echo "<p><em>".$filename."</em></p>";
            echo $content;
            
        } else {
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
