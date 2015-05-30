<?php
require_once("../../all-configured-and-secured-included.php");
require_once("../../composant/browser/listesItem.php");
print_r($_POST);
connect();

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
        echo "$ _ FILES[files] is set";
        $myFiles = $_FILES['files'];
        $fileCount = count($myFiles["name"]);

        for ($i = 0; $i < $fileCount; $i++) {
            echo "File n°$i | $filename";
            $filename = $myFiles['name'][$i];
            echo $filename;
            echo "ext" . ($ext = getExtension($filename));
            if (isTexte($ext, null)) {
                $mime = "text/plain";
            } else if (isImage($ext)) {
                $mime = "image/" . $ext;
            } else {
                $mime = "text/plain";
            }
            $content = file_get_contents($myFiles['tmp_name'][$i]);
            $sql = "insert into blocnotes_data (filename, content_file, username, mime, quandNonveau, folder_id) values('" . mysqli_real_escape_string($mysqli, $filename) .
                    "', '" . mysqli_real_escape_string($mysqli, $content) . "', '" .
                    mysqli_real_escape_string($mysqli, $monutilisateur) . "', '$mime', now(), " . ((int) $folder) . ")";
            if (simpleQ($sql, $mysqli)) {
                echo "Fichier inséré avec succès" . $filename;
            }
        }
    }
}
?>
<ul>
    <li class="appdoc_button"><a href="../../page.xhtml.php?composant=browser">Naviguer</a></li>
    <li class="appdoc_button"><a href="../../page.xhtml.php?composant=create.db">Créer une autre note ou uploader des fichiers.</a></li>

</ul>
