<?php
require_once(__DIR__ . "/../all-configured-and-secured-included.php");


connect();

function randomSerId() {
    return rand(1, 9999999);
}

function id_exists($id) {
    global $tablePrefix;
    $q = "select serid from " . $tablePrefix . "_items where serid=" . mysqli_real_escape_string($mysqli, (int)$id);
    if (simpleQ($q, $mysqli) == NULL){
        return false;
    }
    else{
        return true;
    }
}

function getSeridFromFilename($filename, $utilisateur) {
    global $tablePrefix;
    $q = "select serid from " . $tablePrefix . "_items where filename='" . mysqli_real_escape_string($mysqli, $filename) . "' and username='" . mysqli_real_escape_string($mysqli, $utilisateur) . "'";
    if (($serid = simpleQ($q, $mysqli)) == NULL)
    {
        return FALSE;
    }
    else
    {
        return $serid;
    }
}

function connect() {
    global $mysqli;
    global $config;
    global $date;
    if ($date == "") {
        $date = date("Y-m-d-H-i-s");
    }
    $hostname = trim($config->hostname);
    $username = trim($config->username);
    $password = trim($config->password);
    $dbname = trim($config->name);


    //conection: 
    $mysqli = mysqli_connect($hostname, $username, $password, $dbname) or die("Error " . mysqli_error($mysqli));

    if ($mysqli->connect_error) {
        die('Erreur de connexion (' . $mysqli->connect_errno . ') '
                . $mysqli->connect_error);
    }


    //echo 'Succès... ' . $mysqli->host_info . "\n";
}

$link = null;

function createFile($filename, $mime, $data = "", $isDirectory = FALSE, $folder_id = -1) {
    global $monutilisateur;
    global $mysqli;
    connect();
    if ($folder_id == -1) {
        $folder_id = getRootForUser();
    }
    $q = "insert into blocnotes_data (username, filename, mime, content_file, isDirectory, folder_id) values('" .
            mysqli_real_escape_string($mysqli, $monutilisateur) . "', '" .
            mysqli_real_escape_string($mysqli, $filename) . "', '" . mysqli_real_escape_string($mysqli, $mime) .
            "', '" . mysqli_real_escape_string($mysqli, $data) . "', " .
            (($isDirectory == 1) ? 1 : 0) . ", " . ((int) ($folder_id)) . ")";
    if (mysqli_query($mysqli, $q)) {
        $id = mysqli_insert_id($mysqli);

        return $id;
    } else {
        return -1;
    }
}

function updateFile($filename, $date = "", $contenu = "") {
    global $mysqli;
    global $monutilisateur;
    connect();
    if ($date == "") {
        $date = date("Y-m-d-H-i-s");
    }
    $serid = getSeridFromFilename($filename, $monutilisateur);
    $q = "insert into blocnotes_items (user, filename, contenu, moment, type, serid) values('" . mysqli_real_escape_string($mysqli, $monutilisateur) . "', '" .
            mysqli_real_escape_string($mysqli, $filename) . "', '" . mysqli_real_escape_string($mysqli, $contenu) . "','" . mysqli_real_escape_string($mysqli, $date) . "', 'file.update'," . mysqli_real_escape_string($mysqli, $serid) . ");";
    //echo $q;

    mysql_query($q);
}

function deleteFile($filename, $date = "") {
    if ($date == "") {
        $date = date("Y-m-d-H-i-s");
    }
    global $mysqli;
    global $monutilisateur;
    $serid = getSeridFromFilename($filename, $monutilisateur);
    $q = "insert into blocnotes_items (user, filename, moment, type, serid) values('" . mysqli_real_escape_string($mysqli, $monutilisateur) . "', '" .
            mysqli_real_escape_string($mysqli, $filename) . "', '" . mysqli_real_escape_string($mysqli, $date) . "', 'file.delete'," . mysqli_real_escape_string($mysqli, $serid) . ")";
    mysql_query($q);
}

function renameFile($oldname, $newname, $date = "") {
    if ($date == "") {
        $date = date("Y-m-d-H-i-s");
    }
    global $hostname;
    global $username;
    global $password;
    global $name;
    global $monutilisateur;
    $serid = getSeridFromFilename($filename, $monutilisateur);
    $q = "insert into blocnotes_items (user, filename, moment, type, contenu, serid) values('" . mysqli_real_escape_string($mysqli, $monutilisateur) . "', '" .
            mysqli_real_escape_string($mysqli, $newname) . "', '" . mysqli_real_escape_string($mysqli, $date) . "', 'file.rename', '" . mysqli_real_escape_string($mysqli, $oldname) . "', " . mysqli_real_escape_string($mysqli, $serid) . ");";
    mysql_query($q);

    mysql_close();

    updateLinks($oldname, $newname);
}

function listHistory($filename = null, $date = "") {
    if ($date == "") {
        $date = date("Y-m-d-H-i-s");
    }
    global $mysqli;
    global $monutilisateur;
    $q = "select user, filename, moment, type, contenu from blocnotes_items where user='" . mysqli_real_escape_string($mysqli, $monutilisateur, $link) . "' order by moment";
    mysqli_stmt_execute($q);
    $result = mysqli_stmt::get_result();
    return $result;
}

function simpleQ($q, $mysqli) {


    global $mysqli;
    global $date;
    $date = date("Y-m-d-H-i-s");

    if ($mysqli == NULL) {
        connect();
    }
    return mysqli_query($mysqli, $q);
}

function getSimpleRowElement($row, $field) {
    global $mysqli;
    return $row[$field];
}

function dbfile_getCreationTime($filename) {
    global $mysqli;
    connect();
    $q = "select moment from blocnotes_items where filename='" . mysqli_real_escape_string($mysqli, $filename) . "' and type='file.creation'";
    $res = simpleQ($q, $mysqli);
    if ($res == null) {
        return null;
    }
    if (($row = mysqli_fetch_assoc($res)) != NULL) {
        getSimpleRowElement($row, "date");
    }
    return getSimpleRowElement($row, "date");
}

function dbfile_getModifications($filename) {
    global $mysqli;
    $q = "select moment from blocnotes_items where filename='" . mysqli_real_escape_string($mysqli, $filename) . "' order by moment";
    $res = simpleQ($q, $mysqli);
    if ($res == null) {
        return null;
    }
    return $res;
}

function dbfile_getDeleteTime($filename) {
    global $mysqli;
    $q = "select moment from blocnotes_items where filename='" . mysqli_real_escape_string($mysqli, $filename) . "' and type='file.delete'";
    $res = simpleQ($q, $mysqli);
    if ($res == null) {
        return null;
    }
    if (($row = mysql_fetch_assoc($res)) != NULL) {
        getSimpleRowElement($row, "date");
    }
    return getSimpleRowElement($row, "date");
}

function dbfile_getModificationsAsList($filename) {
    global $mysqli;
    ?><table><?php
        $res = dbfile_getModifications($filename);
        if ($res != null) {
            while (($row = mysql_fetch_assoc($res)) != NULL) {
                echo "<tr><td>Modification</td><td>" . $row['moment'] . "</td></tr>";
            }
        }
        ?></table><?php
}

/* function getDocument($filename = "") {
  global $mysqli;
  $q = "SELECT * FROM blocnotes_items WHERE MOMENT = (SELECT moment" .
  " FROM blocnotes_items " .
  "WHERE filename =  '" . mysqli_real_escape_string($mysqli, $filename, $link) . "' " .
  " ORDER BY MOMENT DESC " .
  "LIMIT 1 )";
  //echo $q;
  $result = simpleQ($q, $mysqli);
  return $result;
  }

  function getDocuments() {
  global $monutilisateur;
  $q = "SELECT * FROM blocnotes_items " .
  "WHERE user='" . $monutilisateur . "'" .
  " ORDER BY MOMENT DESC " .
  "";
  $result = simpleQ($q, $mysqli);
  echo $q;
  return $result;
  }
 */

function getDocumentsParClasseur($folder_id = "") {
    if ($folder_id == "") {
        $classeur = getRootForUser();
    }

    global $monutilisateur;
    $q = "SELECT * FROM blocnotes_data " .
            "WHERE  isDeleted=0 and username='" . mysqli_real_escape_string($mysqli, $monutilisateur) . "' ";
    "'";
    $result = simpleQ($q, $mysqli);
    return $result;
}

function getDocumentsFiltered($filtre, $composedOnly, $pathId) {
    global $monutilisateur;
    global $mysqli;

    if ($pathId == 0) {
        $pathId = getRootForUser();
    }

    $q = "SELECT * FROM blocnotes_data " .
            "WHERE username='" . mysqli_real_escape_string($mysqli, $monutilisateur) .
            "' and ((filename like '%" . mysqli_real_escape_string($mysqli, $filtre) .
            "%') or (content_file like'%" . mysqli_real_escape_string($mysqli, $filtre) .
            "%') and (content_file like '%" .
            ($composedOnly ? "{{" : "") . "%' )) and isDeleted=0 and "
            . "folder_id=" . ( (int) $pathId);

    $result = simpleQ($q, $mysqli);

    return $result;
}

function getAllDocuments() {
    global $monutilisateur;
    global $mysqli;
    connect();

    $docs = array();

    $q = "SELECT * FROM blocnotes_data " .
            "WHERE isDeleted=0 and username='" . mysqli_real_escape_string($mysqli, $monutilisateur) . "'";

    $result = simpleQ($q, $mysqli);

    while (($doc = mysqli_fetch_assoc($result)) != NULL) {
        $id = $doc["id"];
        $docs[$id] = $doc;
    }


    return $result;
}

function document_field_follow($id, $name, $docs) {
    echo "<select name='$name'>";
    foreach ($docs as $oid => $doc) {
        if ($oid == $id) {
            $sel = " selected='selected'";
        } else {
            $sel = " ";
        }

        echo "<option value='" . $doc["id"] . "'>{{" . $doc["id"] . "}}" . $doc["filename"] . "</option>";
    }

    echo "</select>";
}

function getField($row, $field) {
    global $monutilisateur;
    global $mysqli;
    return $row[$field];
}

function getDBDocument($id) {
    global $monutilisateur;
    global $mysqli;
    connect();
    $q = "SELECT * FROM blocnotes_data " .
            "WHERE isDeleted=0 and username='" . mysqli_real_escape_string($mysqli, $monutilisateur) . "' and id =" . mysqli_real_escape_string($mysqli, (int) $id);

    $result = simpleQ($q, $mysqli);
    return $result;
}

function getDeletedDocuments($id) {
    global $monutilisateur;
    global $mysqli;
    connect();
    $q = "SELECT * FROM blocnotes_data " .
            "WHERE isDeleted=1 and username='" . mysqli_real_escape_string($mysqli, $monutilisateur) . "'";

    $result = simpleQ($q, $mysqli);
    return $result;
}

/*    function getField($row, $field) {
  global $monutilisateur;
  global $mysqli;
  return $row[$field];
  }
 */

function creationDate($filename = "") {
    global $monutilisateur;
    global $mysqli;
    $q = "SELECT * FROM blocnotes_items WHERE filename =  '" . mysqli_real_escape_string($mysqli, $filename, $link) . "' ORDER BY MOMENT DESC";
    //echo $q;
    $result = simpleQ($q, $mysqli);
    $row = mysql_fetch_assoc($result);
    return getField($row, "moment");
}
/**
 * 
 * @global type $monutilisateur
 * @global type $mysqli Globale : Type: mysqli
 * @param type $oldname id_element_porteur
 * @param type $newname or id_element_dependant
 */
function updateLinks($oldname, $newname) {
    global $monutilisateur;
    global $mysqli;
    // Table : blocnotes_links
    $q1 = "update blocnotes_link set id_element_porteur=" . (int) mysqli_real_escape_string($mysqli, $newname) . " where nom_element_porteur=" . (int) mysqli_real_escape_string($mysqli, $oldname) . "";
    $q2 = "update blocnotes_link set id_element_dependant=" . (int) mysqli_real_escape_string($mysqli, $newname) . " where nom_element_dependant=" . (int) mysqli_real_escape_string($mysqli, $oldname) . "";
    // Ex�cuter les requètes

    mysqli_query($mysqli, $q1);
    mysqli_query($mysqli, $q2);
}

function createLink($id_element_porteur, $id_element_dependant) {
    global $mysqli;
    $q = "insert into blocnotes_link (id_element_porteur, id_element_dependant) values (" .
            (int) mysqli_real_escape_string($mysqli, $id_element_porteur, $link) . " , " .
            (int) mysqli_real_escape_string($mysqli, $id_element_dependant, $link) . ")";

    mysqli_query($mysqli, $q);
}

function insertDB($basePath, $classeurOrNote) {
    global $mysqli;
    while (id_exists($serid = randomSerId())) {
        ;
    }
    $q = "insert " . $tablePrefix . "_items (filename, serid, classeur, contents) "
            .
            " values ('" . mysqli_real_escape_string($mysqli, $classeurOrNote) . "', " .
            ((int) $serid)
            .
            ",'" . $basePath . "', " . mysqli_real_escape_string($mysqli, file_get_contents($basePath . "/" . $classeurOrNote)) . "')";
}

/*
  function selectDBFolders($needle) {
  global $monutilisateur;
  global $mysqli;
  echo $sql = "select distint folder_name, username from blocnotes_data where username ='" . mysqli_real_escape_string($mysqli, $monutilisateur) . "' and folder_name like '%" . $needle . "%'";
  return mysql_query($sql);
  }
 */

function isDirectory($dbdoc) {
    global $tablePrefix;
    global $mysqli;
    $sql = "select isDirectory from " . $tablePrefix . "_data where id=" . ((int) $dbdoc);
    $res = simpleQ($sql, $mysqli);
    if (($doc = mysql_fetch_assoc($res)) != NULL) {
        return $doc["isDirectory"];
    }
    return FALSE;
}

function getDirectoryInfo($dbdoc) {
    global $monutilisateur;
    global $tablePrefix;
    global $mysqli;

    $pathId = getDocument($dbdoc);
    $pathId = $pathId["folder_id"];
    if (isDirectory($dbdoc)) {
        $sql = "select * from " . $tablePrefix . "_data where id=" . ((int) $pathId) . " and username='" . $monutilisateur . "'";
        $res = simpleQ($sql, $mysqli);
        if (($doc = mysql_fetch_assoc($res)) != NULL) {
            return $doc;
        }
    } else {
        echo "Erreur n'est pas un répertoire";
    }
    return "";
}

function getFolderList() {
    global $config;
    global $monutilisateur;
    global $mysqli;
    $tablePrefix = $config->tablePrefix;
    $sql = "select * from " . $tablePrefix . "_data where isDirectory=1 and username='" . $monutilisateur . "'";
    $res = simpleQ($sql, $mysqli);
    return $res;
}

function getMimeType($id) {
    global $mysqli;
    connect();
    $result = getDBDocument($id);
    if ($result != NULL) {
        if (($doc = mysqli_fetch_assoc($result)) != NULL) {
            return $doc["mime"];
        }
    }
}

/*
 * ** array ( 
 *      "id" => $doc, 
 *      "data" =>array(noOrdre => $row_data)
 *  Pas de récursivités;
 */

function getDBDocumentAvecImagesEtTextes($id) {
    global $mysqli;
    $myArray;
    $id = (int) $id;
    $row = getDBDocument($id);
    if (($doc = mysqli_fetch_assoc($row)) != NULL) {
        $myArray["id"] = $doc;

        $sql = "select l.nom_element_porteur as masterId, d.* ". "from blocnotes_link as l"
                . " inner join blocnotes_data as d ". " on l.nom_element_porteur=d.nom_element_dependant ". "where l.nom_element_porteur=$id";
        $res = simpleQ($sql, $mysqli);
        if ($res != NULL) {
            $myArray["data"] = array();
            while (($doc2 = mysqli_fetch_assoc($res)) != NULL) {
                $myArray["data"][$doc2["id"]] = $doc2;
            }
        }
        return $myArray;
    } else
    {
        return NULL;
    }
}

function getFollowings($id) {
    global $mysqli;
    $sql = "select d2.* from blocnotes_data as d1 inner join blocnotes_link as l1 on " .
            " blocnotes_data.id=blocnotes_link.id_element_porteur and "
            . "blocnotes_link.id_element_porteur=" . ((int) ($id))
            . " inner join "
            . "blocnotes_data as d2 on l1.id_element_dependant=d2.id";

    simpleQ($sql, $mysqli);
}

function insereImageOuNote($id, $idDependant, $filename, $data, $mime, $ordre) {
    global $mysqli;
    if ($idDependant <= 0) {

        $sql = "insert into blocnotes_data ( filename, content_file, mime )"
                . " values ( '" . mysqli_real_escape_string($mysqli, $filename) .
                "' , '" . mysqli_real_escape_string($mysqli, $data) . "' , '" .
                mysqli_real_escape_string($mysqli, $mime) . "')";
        simpleQ($sql, $mysqli);
        $idDependant = mysql_insert_id($link);
    }
    createLink($id, $idDependant, $ordre);
}

function deleteImageOuNoteDependant($id, $idDependant) {
    global $mysqli;

    $id = (int) $id;
    $idDependant = (int) $idDependant;
    $sql = "delete from blocnotes_link where " .
            "nom_element_porteur=$id and "
            . "   nom_element_dependant=$idDependant";
    $res = simpleQ($sql, $mysqli);
    return $res;
}

function getRootForUser() {
    global $mysqli;
    global $monutilisateur;
    $sql = "select id from blocnotes_data where username like '" .
            mysqli_real_escape_string($mysqli, $monutilisateur)
            . "' and isRoot=1";

    $result = simpleQ($sql, $mysqli);
    if ($result) {
        if ($arr = $result->fetch_assoc()) {
            $id = $arr['id'];
        } else {
            $id = 0;
        }
    } else {
        $id = -1;
        echo "No root for user";
    }//echo "ID;; $id";
    return $id;
}

function createRootForUser() {
    global $mysqli;
    connect();
    $sql = "insert into blocnotes_data (filename, folder_id, isDirectory) values ('Dossier racine', -1, TRUE)";
    if (mysqli_query($mysqli, $sql)) {
        echo "Fichier racine créé";
    }
}

function deleteDBDoc($dbdoc) {
    global $mysqli;
    global $monutilisateur;
    $sql = "update blocnotes_data set isDeleted=1 where id=" . mysqli_real_escape_string($mysqli, $dbdoc) . " and username='" . mysqli_real_escape_string($mysqli, $monutilisateur) . "'";
    return simpleQ($sql, $mysqli);
}

function getPathArray($id) {
    $parray = array();


    $norec = FALSE;
    $i = 0;
    while (($id_old != $id) && ($norec != TRUE)) {
        $res0 = getDBDocument($id);
        if (($res0 != NULL) && (($doc = mysqli_fetch_assoc($res0)) != NULL)) {
            $filename = $doc["filename"];
            $id = $doc["folder_id"];
            $id_old = $doc["id"];
            $parray[$i] = array("filename" => $filename, "id" => $id_old);
            $i++;
            $norec = FALSE;
        } else {
            $norec = TRUE;
        }
    }
    return $parray;
}

function displayPath($id) {
    $parray_fn = getPathArray($id);

    echo "<div class='path_array'>";

    foreach ($parray_fn as $i => $arra) {
        echo "<span class='path_array'><a href='?composant=browser&dbdoc=" . ($parray_fn[$i]["id"]) . "'>" . $parray_fn[$i]["filename"] . "</a></span>";
    }

    echo "</div>";
}

function folder_field($folder_id, $field_name = "folder") {
    ?>
<fieldset> <select name="<?php echo $field_name; ?>" class="user-control">
    <?php
    $res = getFolderList();
    while (($row = mysqli_fetch_assoc($res)) != NULL) {
        if ($row["id"] == $folder_id) {
            $optionSel = "selected='selected'";
        } else {
            $optionSel = "";
        }
        echo "<option value='" . $row['id'] . "' " . $optionSel . " >" . htmlspecialchars($row['filename']) . "</option>";
    }

    mysqli_free_result($res);
    ?>
    </select><fieldset><?php
    }

    $ids = array();

    // List od parents
    function getLastLinked($id) {
        global $mysqli;
        $sql = "select id_element_porteur as id from blocnotes_link where nom_element_dependant=$id";
        if ($res = simpleQ($sql, $mysqli)) {
            while (($id = mysqli_fetch_assoc($res)) != NULL) {
                $docs[$i++] = $id["id"];
            }
        }
        return $docs;
    }

    // List od parents
    function getNextLinked($id) {
        global $mysqli;
        $sql = "select id_element_dependant as id from blocnotes_link where nom_element_porteur=$id";
        if ($res = simpleQ($sql, $mysqli)) {
            while (($id = mysqli_fetch_assoc($res)) != NULL) {
                $docs[$i++] = $id["id"];
            }
        }
        return $docs;
    }

    function parcoursInsert($docs, $id, &$tab) {
        
    }

    $tab = array();

// [numero serie][NO ORDRE] = doc
    function showLinks($docs) {
        global $tab;
        foreach ($docs as $doc) {

            $id = $doc["id"];
            if ($id != NULL) {
                $nexts = getNextLinked($id);
                $prevs = getLastLinked($id);

                echo "<table>";

                tableTableau($nexts);
                tableTableau($prevs);

                echo "</table>";
            }
        }
    }

    function tableTableau($docs_id) {
        echo "<tr>";
        for ($i = 0; $i < count($docs_id); $i++) {
            echo "<td>" . $docs_id[$i]["id"] . "/td>";
        }
        echo "</tr>";
    }

    function getUrlMimeType($url) {
        $buffer = file_get_contents($url);
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        return $finfo->buffer($buffer);
    }

    function getFolder($dbdoc) {
        global $mysqli;
        return mysqli_fetch_assoc(simpleQ("select * from blocnotes_data where folder_id=" . ((int) $dbdoc), $mysqli));
    }

    function displayNote($dbdoc) {
        // Master COde goes here.
        global $urlApp;
        $id = $dbdoc;
        $doc = mysqli_fetch_assoc(getDBDocument($dbdoc));
        $filename = $doc['filename'];
        $mime = $doc['mime'];
        if ($doc) {
            ?><div id="document"><?php if (isImage(getExtension($filename), $mime)) { ?>
                <img src="<?php echo $urlApp . "/composant/display/contents.php?id=$id"; ?>"/><?php } else if (isTexte(getExtension($filename), $mime)) {
                ?>
                <script type="text/javascript">
                    var urlAppJS = "<?php echo $urlApp; ?>";
                    $("#document").load(url = urlAppJS + "/composant/display/contents.php?id=<?php echo $id; ?>", function (response, status, xhr) {
                        if (status == "error") {
                            var msg = "Sorry but there was an error: ";
                            $("#error").html(msg + xhr.status + " " + xhr.statusText + url);
                        }
                    });

                </script>
        <?php } ?></div><?php
    }
}

function showActionFichier($controlType="Dropdown", $mimeType=NULL, $dbdoc=NULL)
{
    if($mimeType==NULL)
    {
        $doc = getDBDocument($dbdoc);
        
        $mimeType = $doc["mime"];
    }
    
    $list = getJSFunctionsOnDocsList($mime);
    switch($controlType)
    {
        case "Dropdown":
            break;
    }
}

/***
 * Déplacer un dossier A dans un dossier B quels sont les pièges à éviter
 * à l'utilisateur? Comment lui faciliter la vie en supprimant dès maintenant
 * les bogues qu'on n'aura pas à corriger puisque prévus par le déveloopeur?
 * 
 * Fichier Racine (orphelin le pauvre il a mangé "pauvre" même son parent)
 *  Dossier A 
 *  Dossier B
 * 
 * Mettre A dans B.
 * 
 * Erreur 1: A et B ne sont pas des dossiers. Mais OK on va quand même déplacer
 * => FEATURE1
 * Erreur 2 est fichier racine ou contient B dans sa structure.
 *  Par contre A contient B. Ca ne semble pas possible
 * de déplacer 
 * => Erreur.
 */
function intervertirDossierSecurized($IDfolderA, $IDfolderB)
{
    echo "Fonction désactivée";
    die();
    // Mauvaise feuille.
    global $mysqli;
    $docA = mysqli_fetch_assoc(getDBDocument($IDfolderA));
    if($docA==NULL){error_log("Dossier A n'existe pas dans deplacerDossierSecurized");return FALSE;}
    $docB = mysqli_fetch_assoc(getDBDocument($IDfolderB));
    if($docB==NULL){error_log("Dossier B n'existe pas dans deplacerDossierSecurized");return FALSE;}
    $folderA = getFolder($docA);
    $folderB = getFolder($docB);
    $sql1 = "update blocnotes_data set folder_id=".$folderB." where id=".$docA["id"];
    $sql2 = "update blocnotes_data set folder_id=".$folderA." where id=".$docB["id"];
    if (simpleQ($sql1, $mysqli) && simpleQ($sql2, $mysqli)) {
    
        return TRUE;
    }
    error_log("Erreur DB dans deplacerDossierSecurized");return FALSE;
}
function inPath($docWhat, $inpathID)
{
    $inpath= getPathArray($docWhat);
    
    return (in_array($docWhat, $inpath));
}


function deplacerDocumentSecurized(/**WHAT*/$IDfolderA, /** DANS IN */ $IDfolderB)
{
    echo "Fonction désativée Erreur";
    die();
    // Mauvaise feuille.
    global $mysqli;
    $docA = mysqli_fetch_assoc(getDBDocument($IDfolderA));
    if($docA==NULL){error_log("Dossier A n'existe pas dans deplacerDossierSecurized");return FALSE;}
    $docB = mysqli_fetch_assoc(getDBDocument($IDfolderB));
    if($docB==NULL){error_log("Dossier B n'existe pas dans deplacerDossierSecurized");return FALSE;}
    $folderA = getFolder($docA);
    $folderB = getFolder($docB);
    
    /** Réaction en chaîne...*/
    if(inPath($docB, $IDfolderB))
    {
        error_log("L'appication ne peut déplacer un dossier dans lui-même");
        return FALSE;
    }
    
    $sql1 = "update blocnotes_data set folder_id=".$IDfolderB." where id=".$docA["id"];
    /*if($docB["folder_id"]==$docA)
    {
        $sql2 = "update blocnotes_data set folder_id=".$folderA." where id=".$docB["id"];
    }
/   */
    if (simpleQ($sql1, $mysqli) && simpleQ($sql1, $mysqli)) {
    
        return TRUE;
    }
    error_log("Erreur DB dans deplacerDossierSecurized");return FALSE;
}