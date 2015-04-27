<?php
require_once('../../config.php');


connect();
$document = getDBDocument(filter_input(INPUT_GET, "id"));

$filename = $document['filename'];
$content = $document['content_file'];

            if(in_array(getExtension($filename), array("jpg","png","gif","bmp")))
            {
                echoImg($content, $filename);
            }
 else if(in_array(getExtension($filename), array("txt")))
{
     echo $content;
 }
 else if(strpos($filename, "/CLASS")>0)
 {
     echo "Classeur";
 }

 
 function echoImg($content, $filename)
{
header('Content-type:image/'.  getExtension($filename));    // A few settings

echo $content;
}
function getExtension($filename)
{
 return $ext = strtolower(substr($filename, -3));
   
}


echo getExtension($filename);
echo $content;
