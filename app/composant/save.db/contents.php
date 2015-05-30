<?php

require_once("../../config.php");
require_once("../browser/listesItem.php");

$type = rawurldecode(filter_input(INPUT_GET, "submit"));
if(isset($_GET['dbdoc']))
{
    $id = (int)(rawurldecode(filter_input(INPUT_GET, 'dbdoc')));
    $filename = rawurldecode(filter_input(INPUT_GET, 'filename'));
$folder = (int)(rawurldecode(filter_input(INPUT_GET, 'folder')));
}
else {
    $id = (int)(rawurldecode(filter_input(INPUT_POST, 'dbdoc')));
$folder = (int)(rawurldecode(filter_input(INPUT_POST, 'folder')));
}
$content = rawurldecode(filter_input(INPUT_GET, 'contenu'));


if($id==-2)
{
    echo "Nouveau dossier";
    connect();
    echo $sql = "insert into blocnotes_data (filename, username, isDirectory, mime, quandNouveau, folder_id) values('".mysqli_real_escape_string($mysqli, 
            
            $filename)."', '".
    mysqli_real_escape_string($mysqli, $monutilisateur)."', 1, 'directory', now(), ".mysqli_real_escape_string($mysqli, $folder).")";
    if(simpleQ($sql, $mysqli))
    {
        echo "Répertoire crée";
        // $doc = getLastDBDoc();
        // echo "<a href=?composant=reader.db&dbdoc=".($doc['id']);
    }
    else
    {
        echo "Erreur technique";
    }
}
else if($id==-1)
{
    connect();
    $folder_id = (int)rawurldecode(filter_input(INPUT_GET, 'folder'));
    echo "Ajouter données";
    echo $sql = "insert into blocnotes_data (filename, content_file, username, mime, quandNouveau, folder_id) values('".mysqli_real_escape_string($mysqli, $filename)."', '".mysqli_real_escape_string($mysqli, $content)."', '".
    mysqli_real_escape_string($mysqli, $monutilisateur)."', 'text/plain', now(), ".  mysqli_real_escape_string($mysqli, $folder_id).")";
    simpleQ($sql, $mysqli);
}
else if($id==0)
{
    print_r($_POST);
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
            echo $sql = "insert into blocnotes_data (filename, content_file, username, mime, quandNonveau, folder_id) values('".mysqli_real_escape_string($mysqli, $myFile['tmp_name'][$i]).
            "', '".mysqli_real_escape_string($mysqli, file_get_contents($myFile['tmp_name'][$i]))."', '".
            mysqli_real_escape_string($mysqli, $monutilisateur)."', '$mime', now(), " . mysqli_real_escape_string($mysqli, $folder). ")";
            simpleQ($sql, $mysqli);
            echo error_get_last();
        }
    }
}
else
{
    echo "Mettre à jour la note";
    connect();
    $doc = mysqli_fetch_assoc(getDBDocument($id));
    
    if(isTexte($doc["filename"], $doc["mime"]))
    {
        $mime = "text/plain";
    } else if(isImage($doc["filename"], $doc["mime"]))
    {
        $mime = "image/".getExtension($filename);
        
    }
        echo htmlspecialchars($sql = "update blocnotes_data set folder_id=".  mysqli_real_escape_string($mysqli, $folder).", content_file='".mysqli_real_escape_string($mysqli, $content)."', filename='".mysqli_real_escape_string($mysqli, $filename)."', mime='".$mime."',  quand=now() where id=".$id." and username='".$monutilisateur."'");
        simpleQ($sql, $mysqli);
}
