<?php
require_once("../../all-configured-and-secured-included.php");
require_once("../../composant/browser/listesItem.php");
//print_r($_POST);
connect();
global $mysqli;
global $link;

$type = rawurldecode(filter_input(INPUT_GET, "submit"));
if (isset($_GET['dbdoc'])) {
    $id = (int) (rawurldecode(filter_input(INPUT_GET, 'dbdoc')));
} else {
    $id = (int) (rawurldecode(filter_input(INPUT_POST, 'dbdoc')));
}
$content = rawurldecode(filter_input(INPUT_GET, 'contenu'));

if (isset($_GET['folder'])) {
    $folder = (int) (rawurldecode(filter_input(INPUT_GET, 'folder')));
} else {
    $folder = (int) (rawurldecode(filter_input(INPUT_POST, 'folder')));
}


if ($id == 0) {
    print_r($_POST);
    echo "Ajouter fichiers (images ou textes)";
    connect();
    echo "TODO: Insert uploaded files.";

    echo $_SERVER['REQUEST_METHOD'];
    echo "POST";
    if (isset($_FILES['files'])) {
        //echo "$ _ FILES[files] is set";
        $myFiles = $_FILES['files'];
        $fileCount = count($myFiles["name"]);

        for ($i = 0; $i < $fileCount; $i++) {
            echo "File n°$i | $filename<br/>";
            $filename = $myFiles['name'][$i];
            $ext = getExtension($filename);
            if (isImage($ext, "")) {
                $mime = "image/" . $ext;
            } else if (isTexte($ext, "")) {
                $mime = "text/plain";
            } else {
                $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
                $mime = finfo_file($finfo, $myFiles['tmp_name'][$i]) ;
                finfo_close($finfo);
            }
            

            
            $sql = "insert into blocnotes_data (filename, content_file, username, mime, quandNouveau, folder_id) values('" . mysqli_real_escape_string($mysqli, $filename) .
                    "', ?, '" .
                    mysqli_real_escape_string($mysqli, $monutilisateur) . "', '$mime', now(), " . ((int) $folder) . ")";
            
            
            $stmt = $mysqli->prepare($sql);
            $null = NULL;
            $stmt->bind_param("b", $null);
            $fp = fopen($myFiles['tmp_name'][$i], "r");
            while (!feof($fp)) {
                $stmt->send_long_data(0, fread($fp, 8192));
            }
            fclose($fp);
            $stmt->execute();

            
            /*
            
            if ($res = simpleQ($sql, $mysqli)) {
                echo "Fichier inséré : " . $filename;
            } else {
                echo mysqli_dump_debug_info($mysqli);
            }
            if ($res) {
                mysqli_free_result($res);
            };*/
        }
    }
}
?>
<ul>
    <li class="appdoc_button"><a href="../../page.xhtml.php?composant=browser">Naviguer</a></li>
    <li class="appdoc_button"><a href="../../page.xhtml.php?composant=create.db">Créer une autre note ou uploader des fichiers.</a></li>

</ul>
