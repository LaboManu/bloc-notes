<?php

echo "ENCODE EN DB";

require_once("../config.php");

$directoryPrefix = "ENCODED_FOLDER_";
$dataPrefix = "ENCODED_DATA_";

/* * ** /
 * **  /  UTILISER AVEC PRECAUTION
 *  */
if(filter_input(INPUT_GET, "CODE")!="MyVerySecretCode")
{
    die("Accès restreint refusé");
    
}
//1 Boucler sur les utilisateur
// // Pour chaque utilisateur
function encodeFiles($username, $dir = "/") {
    global $dataPrefix;
    global $pathSep;
    
    connect();
    
    echo ($dirHandler = opendir($dir));
    
    
    while (($fichierParcouru = readdir($dirHandler)) != NULL) {
        echo "BOUCLE";
        // Parcours récursif des dossiers (dossiers et fichiers ($userDataDir.$userFullname, "@username:"/")
        // 1.1 // Si dossier
        if ((is_dir($dir . $pathSep . $fichierParcouru)) && (strstr($fichierParcouru, ".")===FALSE) && (strpos($fichierParcouru, "ENCODED_FOLDER_") == FALSE)) {
            // Chercher le chemin relatif en DB.
            //$q = "select folder_name form ".$tablePrefix."_data where username='".mysql_real_escape_string($username)."' and filename='"
            //   -> Si Aucun résultat encoder à la racinne \
            // Boucler jusqu'à nom de dossier valide ENCODED_FOLDER_XXXXXXXX 
            // Renommer en ENCODED_FOLDER_XXXXXXXX à la racine, date
            $encoded_name = hash("sha256", $fichierParcouru);
            // Encoder le nom du dossier
            //  avec: utilisateur, nom réel, chemin relatif virtuel
            query1($username, $fichierParcouru, $dir, $encoded_name);
            // Codage : mcrypt ou hash
            //     // Parcourir le dossier  renommé
            // Parcourir le dossier( paramètres; chemin reél, adresse virtuelle)
            encodeFiles($username, $dir . $pathSep . $fichierParcouru);
        } else if (is_file($dir . $pathSep . $fichierParcouru) && strpos($fichierParcouru, $dataPrefix) == FALSE) {
            // Renommer les fichiers en ENCODED_DATA_XXXX.<Extension réelle>
            query2($username, $fichierParcouru, $dir);
        }
    }
}

function query1($username, $fichierParcouru, $dir, $encoded_name) {
    global $tablePrefix;
    echo ($q = "insert into " . $tablePrefix .
    "_data (username, filename, folder_name, hachset_Filename) " .
    "values ('" .
    mysql_real_escape_string($username) . "','" .
    mysql_real_escape_string($fichierParcouru) . "', '"
    . mysql_real_escape_string($dir) . "','ENCODED_FOLDER"
    . mysql_real_escape_string($encoded_name) . "')");
    mysql_query($q);
}

function query2($username, $fichierParcouru, $dir) {
    global $pathSep;
    global $tablePrefix;
    // Encoder le nom du fichier en DB
    // Encoder les fichiers
    //  avec: utilisateur, nom réel, chemin relatif virtuel, date, contenu
    $encoded_name = hash("sha256", $fichierParcouru);
    echo ($q = "insert into " . $tablePrefix .
    "_data (username, filename, folder_name, hachset_filename, content_file) " .
    "values ('" .
    mysql_real_escape_string($username) . "','" .
    mysql_real_escape_string($fichierParcouru) . "', '"
    . mysql_real_escape_string($dir) . "','ENCODED_FILE_"
    . mysql_real_escape_string($encoded_name) . "', '" .
    mysql_real_escape_string(file_get_contents($dir . $pathSep . $fichierParcouru))
    . "')");
    // Codage : mcrypt ou hash
    mysql_query($q);
}



