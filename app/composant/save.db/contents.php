<?php

require_once("../browser/listesItem.php");

$type = rawurldecode(filter_input(INPUT_GET, "submit"));
if(isset($_GET['dbdoc']))
{
    $dbdoc = (int)(rawurldecode(filter_input(INPUT_GET, 'dbdoc')));
    $filename = rawurldecode(filter_input(INPUT_GET, 'filename'));
$folder = (int)(rawurldecode(filter_input(INPUT_GET, 'folder')));
}
else {
    $dbdoc = (int)(rawurldecode(filter_input(INPUT_POST, 'dbdoc')));
$folder = (int)(rawurldecode(filter_input(INPUT_POST, 'folder')));
}
$content = rawurldecode(filter_input(INPUT_GET, 'contenu'));

if($_GET["option"]=="move.doc") {
        connect();
        echo "Déplacer document";
        
        $doc_orig = mysqli_fetch_assoc(getDBDocument($dbdoc));
        
        $folder_orig = $doc_orig['folder_id'];
        
        $sql = "update blocnotes_data set folder_id=".  mysqli_real_escape_string($mysqli, $folder)." where id=".$dbdoc." and username='".$monutilisateur."'";
        if(simpleQ($sql, $mysqli))
        {?>
        <h1>Note déplacée avec succès</h1>
    <ul>
        <li class='button_appdoc'><a class='button_appdoc' href='?composant=browser&dbdoc=<?php echo $folder_orig; ?>'>Retour au répertoire d'origine</a>
        </li>
        <li class='button_appdoc'><a class='button_appdoc' href='?composant=browser&dbdoc=<?php echo $folder; ?>'>Vers la destination</a>
        </li>
    </ul>

        <?php
        
        }
        die();
}
if($dbdoc==-2)
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
else if($dbdoc==-1)
{
    connect();
    $folder_id = (int)rawurldecode(filter_input(INPUT_GET, 'folder'));
    echo "Ajouter données";
    echo $sql = "insert into blocnotes_data (filename, content_file, username, mime, quandNouveau, folder_id) values('".mysqli_real_escape_string($mysqli, $filename)."', '".mysqli_real_escape_string($mysqli, $content)."', '".
    mysqli_real_escape_string($mysqli, $monutilisateur)."', 'text/plain', now(), ".  mysqli_real_escape_string($mysqli, $folder_id).")";
    simpleQ($sql, $mysqli);
}
else if($dbdoc==0)
{
    print_r($_POST);
    connect();

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
            $finfo = new finfo("", "");
            echo $mime = finfo_buffer($finfo, file_get_contents($filename, false, null, -1, 2048), "", null);
            
            
            
            echo $sql = "insert into blocnotes_data (filename, content_file, username, mime, quandNonveau, folder_id) values('".mysqli_real_escape_string($mysqli, $myFile['tmp_name'][$i]).
            "', '".mysqli_real_escape_string($mysqli, file_get_contents($myFile['tmp_name'][$i]))."', '".
            mysqli_real_escape_string($mysqli, $monutilisateur)."', '$mime', now(), " . mysqli_real_escape_string($mysqli, $folder). ")";
            simpleQ($sql, $mysqli);
            echo error_get_last();
            
            
            
            
            echo "<a href='?composant=browser.db&dbdoc='".$folder."'>Retour au dossier</a>";
            
        }
    }
}
else
{
    
    echo "Mettre à jour la note";
    connect();
    $doc = mysqli_fetch_assoc(getDBDocument($dbdoc));
    
    if(isTexte($doc["filename"], $doc["mime"]))
    {
        $mime = "text/plain";
    } else if(isImage($doc["filename"], $doc["mime"]))
    {
        $mime = "image/".getExtension($filename);
        
    }
        echo htmlspecialchars($sql = "update blocnotes_data set folder_id=".  mysqli_real_escape_string($mysqli, $folder).", content_file='".mysqli_real_escape_string($mysqli, $content)."', filename='".mysqli_real_escape_string($mysqli, $filename)."', mime='".$mime."',  quand=now() where id=".$dbdoc." and username='".$monutilisateur."'");
        simpleQ($sql, $mysqli);
        
        ?>
<ul>
<li class='button_appdoc'><a  class='button_appdoc' href="?composant=edit.db&dbdoc=<?php echo $dbdoc; ?>">Retour à l'éditeur</a></li>
<li class='button_appdoc'><a  class='button_appdoc' href="?composant=reader.db&dbdoc=<?php echo $dbdoc; ?>">Voir</a></li>
</ul>
    <?php
} 
