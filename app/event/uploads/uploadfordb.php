<?php

require_once("../../composant/browser/listesItem.php");

$type = rawurldecode(filter_input(INPUT_GET, "submit"));
if(isset($_GET['id']))
{
    $id = (int)(rawurldecode(filter_input(INPUT_GET, 'dbdoc')));
}
else {
    $id = (int)(rawurldecode(filter_input(INPUT_POST, 'dbdoc')));
}
$content = rawurldecode(filter_input(INPUT_GET, 'contenu'));


if($id==-1)
{
    echo "Ajouter données";
    connect();
    echo $sql = "insert into blocnotes_data (filename, content_file, username) values('Newly created.txt', '".mysql_real_escape_string($content)."', '".
    mysql_real_escape_string($monutilisateur)."')";
    simpleQ($sql, $mysqli);
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
            $sql = "insert into blocnotes_data (filename, content_file, username, mime) values('".mysql_real_escape_string($myFile['name'][$i]).
            "', '".mysql_real_escape_string(file_get_contents($myFile['tmp_name'][$i]))."', '".
            mysql_real_escape_string($monutilisateur)."', '$mime')";
            simpleQ($sql, $mysqli);
            echo error_get_last();
        }
    }
}
else
{
    echo "Mettre à jour la note";
    connect();
    $sql = "update blocnotes_data set content_file='".mysql_real_escape_string($content)."' where id=".$id;
    simpleQ($sql, $mysqli);
}
echo $id." |  : | ".$content;
?>
<ul>
<li class="appdoc_button"><a href="../../page.xhtml.php?composant=browser">Naviguer</a></li>
<li class="appdoc_button"><a href="../../page.xhtml.php?composant=create.db">Créer une autre note ou uploader des fichiers.</a></li>

</ul>
