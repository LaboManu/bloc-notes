<?php

function importFromFilesystem($dataDir, $basePath = "") {
    $extensionsReconnues = "PNG,JPG,GIF,TIFF,ICO,SVG,DOC,DOCX,ODT,TXT,RDP,AVI";

    $extensionsList = explode(",", $extensionsReconnues);

    global $monutilisateur;

    $dirRacine = opendir($dataDir . $basePath);

    while (($classeurOrNote = readdir($dirRacine)) != NULL) {
        if (is_dir($dataDir . "/" . $classeurOrNote)) {
            importFromFilesystem($basePath . "/" . $classeurOrNote);

            copieClasseurEnDB($basePath . "/" . $classeurOrNote);
            echo "Classeur importé";
        } else {
            $idx = array_search(substr($classeurOrNote, strpos($classeurOrNote, ".")), $extensions);
            if ($idx !== FALSE) {
                copieFichierEnDB($basePath . "/" . $classeurOrNote);
                echo "Fichier importé : " . $basePath . "/" . $classeurOrNote;
            } else {
                echo "Extension non reconnues" . $classeurOrNote;
            }
        }
    }
}

function copieClasseurEnDB($relPath) {
    global $tablePrefix;
    $q = "insert into " . mysql_real_escape_string($tablePrefix)
            . "_hach () values()";
}

function copieFichierEnDB($relPath) {
    global $tablePrefix;
    $q = "insert into " . mysql_real_escape_string($tablePrefix)
            . "_hach () values()";
}
