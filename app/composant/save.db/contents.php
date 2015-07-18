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
$option = (int)(rawurldecode(filter_input(INPUT_GET, 'option')));

if($_GET["option"]=="aucunemethodechosie.doc") {
    die();
}
else if($_GET["option"]=="samefolder_move.doc") {
        connect();
        echo "Déplacer document";
        //intervertirDossierSecurized($dbdoc, $folder);

        /**
         * What moves?
         */
        $doc_what = mysqli_fetch_assoc(getDBDocument($dbdoc));
        $what = $doc_what["id"];
        $folder_id_what = $doc_what["folder_id"];
        
        /** 
         * where to move in?
         */
        $doc_where = mysqli_fetch_assoc(getDBDocument($folder));
        $where = $doc_where["id"];
        $folder_id_where = $doc_where["folder_id"];
        
        /**
         * Check for same origin;
         */
        if(($folder_id_what==$folder_id_where) && ($folder_id_what!=NULL)
                && ($what!=NULL)&&($where!=NULL)){
            
        $sql = "update blocnotes_data set folder_id=".  mysqli_real_escape_string($mysqli,(int) $where)." where id=".$what." and username='".$monutilisateur."'";
        if(simpleQ($sql, $mysqli))
        {?>
        <h1>Note déplacée avec succès</h1>
    <ul>
        <li class='button_appdoc'><a class='button_appdoc' href='?composant=browser&dbdoc=<?php echo $folder_id_what; ?>'>Retour au répertoire d'origine</a>
        </li>
        <li class='button_appdoc'><a class='button_appdoc' href='?composant=browser&dbdoc=<?php echo $where; ?>'>Vers la destination</a>
        </li>
    </ul>

        <?php
        
        }
 else {
        echo "Erreur s'est produite base de onnées lors du déplacement , la requête n'a pas pu être effectuée.";
        die();
     
 }
        }
        else
            {
        echo "Erreur s'est produite fichiers non valides.";
        die();
        }
        
        die();
    }
else if($_GET["option"]=="parentfolder_move.doc") {
        connect();
        echo "Déplacer document";
        //intervertirDossierSecurized($dbdoc, $folder);

        /**
         * What moves?
         */
        $doc_what = mysqli_fetch_assoc(getDBDocument($dbdoc));
        $what = $doc_what["id"];
        $folder_id_what = $doc_what["folder_id"];
        
        /** 
         * where to move in?
         */
        $doc_where = mysqli_fetch_assoc(getDBDocument($folder_id_what));
        $where = $doc_where["folder_id"];
        $folder_id_where = $doc_where["folder_id"];
        
        /**
         * Check for same origin;
         */
        if(($folder_id_where!=NULL)){
            
        $sql = "update blocnotes_data set folder_id=".  mysqli_real_escape_string($mysqli,(int) $where)." where id=".$what." and username='".$monutilisateur."'";
        if(simpleQ($sql, $mysqli))
        {?>
        <h1>Note déplacée avec succès</h1>
    <ul>
        <li class='button_appdoc'><a class='button_appdoc' href='?composant=browser&dbdoc=<?php echo $what; ?>'>Retour au répertoire d'origine</a>
        </li>
        <li class='button_appdoc'><a class='button_appdoc' href='?composant=browser&dbdoc=<?php echo $where; ?>'>Vers la destination</a>
        </li>
    </ul>

        <?php
        
        }
 else {
        echo "Erreur s'est produite base de onnées lors du déplacement , la requête n'a pas pu être effectuée.";
        die();
     
 }
        }
        else
            {
        echo "Erreur s'est produite fichiers non valides.";
        die();
        }
        
        die();
    }
/*if($_GET["option"]=="move_new.doc") {
        connect();
        echo "Déplacer document";
        ;
        if(deplacerDocumentSecurized($dbdoc, $folder))
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
if($_GET["option"]=="move.doc") {
        connect();
        echo "Déplacer document";
        //intervertirDossierSecurized($dbdoc, $folder);

        $doc_orig = mysqli_fetch_assoc(getDBDocument($dbdoc));
        
        
        $mime_orig = getField($doc_orig, "mime");
        
        if($mime_orig=="directory")
        {
            echo "Erreur ne peut déplacer un répertoire. Attends la version"
            . " suivante!";
            die();
        }
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
 * */
 
else if($dbdoc==-2)
{
    echo "Nouveau dossier";
    connect();
    echo $sql = "insert into blocnotes_data (filename, username, isDirectory, mime, quandNouveau, folder_id) values('".mysqli_real_escape_string($mysqli, 
            
            $filename)."', '".
    mysqli_real_escape_string($mysqli, $monutilisateur)."', 1, 'directory', now(), ".mysqli_real_escape_string($mysqli, $folder).")";
    if(simpleQ($sql, $mysqli))
    {
        $id = mysqli_insert_id($mysqli);
        
        $dbdoc_ref = getDBDocument($id);
        
        $dbdoc = mysqli_fetch_assoc($dbdoc);
        
        $folder = $doc["folder_id"];
        
        ?>
        <h1>Répertoire crée</h1>
    <ul>
        <li class='button_appdoc'><a class='button_appdoc' href='?composant=browser&dbdoc=<?php echo $dbdoc; ?>'>Dossier</a>
        </li>
        <li class='button_appdoc'><a class='button_appdoc' href='?composant=browser&dbdoc=<?php echo $folder; ?>'>Dossier parent</a>
        </li>
    </ul>

        <?php
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
else if($option=="edit.db")
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
