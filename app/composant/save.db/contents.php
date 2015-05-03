<?php

require_once("../../config.php");
require_once("../browser/listesItem.php");


$type = rawurldecode(filter_input(INPUT_GET, "submit"));
if(isset($_GET['dbdoc']))
{
    $id = (int)(rawurldecode(filter_input(INPUT_GET, 'dbdoc')));
    $filename = rawurldecode(filter_input(INPUT_GET, 'filename'));
}
else {
    $id = (int)(rawurldecode(filter_input(INPUT_POST, 'dbdoc')));
}
$content = rawurldecode(filter_input(INPUT_GET, 'contenu'));


if($id==-2)
{
    echo "Nouveau dossier";
    connect();
    echo $sql = "insert into blocnotes_data (filename, username, isDirectory, mime) values('".mysql_real_escape_string($filename)."', '".
    mysql_real_escape_string($monutilisateur)."', 1, 'directory')";
    simpleQ($sql);
}
else if($id==-1)
{
    echo "Ajouter données";
    connect();
    echo $sql = "insert into blocnotes_data (filename, content_file, username, mime) values('".mysql_real_escape_string($filename)."', '".mysql_real_escape_string($content)."', '".
    mysql_real_escape_string($monutilisateur)."', 'text/plain')";
    simpleQ($sql);
}
else if($id==0)
{
    echo "Ajouter fichiers (images ou textes)";
    connect();
    echo "TODO: Insert uploaded files.";

    echo $_SERVER['REQUEST_METHOD'];
    echo "POST";
    if (isset($_FILES['files'])) {
        echo "$ _ FILES[files] is set";
        $myFile = $_FILES['files'];
        $fileCount = count($myFile["name"]);

        for ($i = 0; $i < $fileCount; $i++) {
            echo "File n°$i | $filename";
            $filename = $myFile['name'][$i];
            echo $filename;
            $ext = getExtension($filename);
            if (($ext == "txt")|| ($ext == "rtf") || ($ext = "tml") || ($ext == "htm") ||($ext == "stl"))
            {
                $mime = "text/plain";
                
            } else if(($ext == "jpg") || ($ext == "png") || ($ext == "gif")) {
                $mime = "image/".$ext;
            }    
            echo $sql = "insert into blocnotes_data (filename, content_file, username, mime) values('".mysql_real_escape_string($myFile['tmp_name'][$i]).
            "', '".mysql_real_escape_string(file_get_contents($myFile['tmp_name'][$i]))."', '".
            mysql_real_escape_string($monutilisateur)."', '$mime')";
            simpleQ($sql);
            echo error_get_last();
        }
    }
}
else
{
    echo "Mettre à jour la note";
    connect();
    $doc = mysql_fetch_assoc(getDBDocument($id));
    
    if(isTexte($doc["filename"], $doc["mime"]))
    {
    
        $sql = "update blocnotes_data set content_file='".mysql_real_escape_string($content)."', filename='".mysql_real_escape_string($filename)."', mime='text/plain' where id=".$id;
        simpleQ($sql);
    } else if(isTexte($doc["filename"], $doc["mime"]))
    {
        $sql = "update blocnotes_data set filename='".mysql_real_escape_string($filename)."', mime='image/".  getExtension($filename)."' where id=".$id;
        simpleQ($sql);
        
    }
    else
    {
        $sql = "update blocnotes_data set filename='".mysql_real_escape_string($filename)."' where id=".$id;
        simpleQ($sql);
        
    }
}
echo $id." |  : | ".$content;