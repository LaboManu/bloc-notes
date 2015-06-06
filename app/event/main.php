<?php
require_once(__DIR__ . "/../all-configured-and-secured-included.php");

function randomSerId() {
    $id = rand(1, 9999999);
}

function id_exists($id) {
    global $tablePrefix;
    $q = "select serid from " . $tablePrefix . "_items where serid=" . mysqli_real_query($mysqli, $id);
    if (simpleQ($q, $mysqli) == NULL)
        return false;
    else
        return true;
}

function getSeridFromFilename($filename, $utilisateur) {

    $q = "select serid from " . $tablePrefix . "_items where filename='" . mysqli_real_query($mysqli, $filename) . "' and username='" . mysqli_real_query($mysqli, $utilisateur) . "'";
    if (($serid = simpleQ($q, $mysqli)) == NULL)
        return FALSE;
    else
        return $serid;
}

function connect() {
    global $mysqli;
    global $config;
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

function createFile($filename, $date = "") {
    if ($date == "") {
        $date = date("Y-m-d-H-i-s");
    }
    global $mysqli;
    global $monutilisateur;

    while (id_exists($serid = randomSerId())) {
        ;
    }

    connect();
    $q = "insert into blocnotes_items (user, filename, moment, type, serid) values('" . mysqli_real_query($mysqli, $monutilisateur, $link) . "', '" .
            mysqli_real_query($mysqli, $filename, $link) . "', '" . mysqli_real_query($mysqli, $date, $link) . "', 'file.creation', $serid);";
    //echo $q;

    mysql_query($q);
}

function updateFile($filename, $date = "", $contenu = "") {
    global $mysqli;
    global $monutilisateur;
    connect();
    if ($date == "") {
        $date = date("Y-m-d-H-i-s");
    }
    $serid = getSeridFromFilename($filename, $monutilisateur);
    $q = "insert into blocnotes_items (user, filename, contenu, moment, type, serid) values('" . mysqli_real_query($mysqli, $monutilisateur, $link) . "', '" .
            mysqli_real_query($mysqli, $filename, $link) . "', '" . mysqli_real_query($mysqli, $contenu, $link) . "','" . mysqli_real_query($mysqli, $date, $link) . "', 'file.update'," . mysqli_real_query($mysqli, $serid, $link) . ");";
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
    $q = "insert into blocnotes_items (user, filename, moment, type, serid) values('" . mysqli_real_query($mysqli, $monutilisateur, $link) . "', '" .
            mysqli_real_query($mysqli, $filename, $link) . "', '" . mysqli_real_query($mysqli, $date, $link) . "', 'file.delete'," . mysqli_real_query($mysqli, $serid, $link) . ")";
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
    $link = mysql_connect($hostname, $username, $password);
    mysql_select_db($name);
    $serid = getSeridFromFilename($filename, $monutilisateur);
    $q = "insert into blocnotes_items (user, filename, moment, type, contenu, serid) values('" . mysqli_real_query($mysqli, $monutilisateur) . "', '" .
            mysqli_real_query($mysqli, $newname) . "', '" . mysqli_real_query($mysqli, $date) . "', 'file.rename', '" . mysqli_real_query($mysqli, $oldname) . "', " . mysqli_real_query($mysqli, $serid) . ");";
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
    connect();
    $q = "select user, filename, moment, type, contenu from blocnotes_items where user='" . mysqli_real_query($mysqli, $monutilisateur, $link) . "' order by moment";
    mysqli_stmt_execute($q);
    $result = mysqli_stmt::get_result();
    return $result;
}

function simpleQ($q, $mysqli) {


    global $mysqli;

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
    $q = "select moment from blocnotes_items where filename='" . mysqli_real_query($mysqli, $filename, $link) . "' and type='file.creation'";
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
    $q = "select moment from blocnotes_items where filename='" . mysqli_real_query($mysqli, $filename) . "' order by moment";
    $res = simpleQ($q, $mysqli);
    if ($res == null) {
        return null;
    }
    return $res;
}

function dbfile_getDeleteTime($filename) {
    global $mysqli;
    $q = "select moment from blocnotes_items where filename='" . mysqli_real_query($mysqli, $filename) . "' and type='file.delete'";
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
  "WHERE filename =  '" . mysqli_real_query($mysqli, $filename, $link) . "' " .
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
            "WHERE  isDeleted=0 and username='" . mysqli_real_query($mysqli, $monutilisateur) . "' ";
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

function getDBDocument($id) {
    global $monutilisateur;
    global $mysqli;
    connect();
    $q = "SELECT * FROM blocnotes_data " .
            "WHERE isDeleted=0 and username='" . mysqli_real_escape_string($mysqli, $monutilisateur) . "' and id =" . mysqli_real_escape_string($mysqli, (int) $id);

    $result = simpleQ($q, $mysqli);
    return $result;
}

function getField($row, $field) {
    global $monutilisateur;
    global $mysqli;
    return $row[$field];
}

function creationDate($filename = "") {
    global $monutilisateur;
    global $mysqli;
    $q = "SELECT * FROM blocnotes_items WHERE filename =  '" . mysqli_real_query($mysqli, $filename, $link) . "' ORDER BY MOMENT DESC";
    //echo $q;
    $result = simpleQ($q, $mysqli);
    $row = mysql_fetch_assoc($result);
    return getField($row, "moment");
}

function updateLinks($oldname, $newname) {
    global $monutilisateur;
    global $mysqli;
    // Table : blocnotes_links
    $q1 = "update blocnotes_link set nom_element_porteur=" . (int) mysqli_real_query($mysqli, $newname) . " where nom_element_porteur=" . (int) mysqli_real_query($mysqli, $oldname) . "";
    $q2 = "update blocnotes_link set nom_element_dependant=" . (int) mysqli_real_query($mysqli, $newname) . " where nom_element_dependant=" . (int) mysqli_real_query($mysqli, $oldname) . "";
    // Exécuter les requêtes

    mysqli_query($mysqli, $q1);

    mysqli_query($mysqli, $q2);
}

function createLink($nom_element_porteur, $nom_element_dependant) {
    global $mysqli;
    $q = "insert into blocnotes_link (nom_element_porteur, nom_element_dependant) values (" .
            (int) mysqli_real_query($mysqli, $nom_element_porteur, $link) . " , " .
            (int) mysqli_real_query($mysqli, $nom_element_dependant, $link) . ")";

    mysqli_query($mysqli, $q);
}

function insertDB($basePath, $classeurOrNote) {
    global $mysqli;
    while (id_exists($serid = randomSerId())) {
        ;
    }
    $q = "insert " . $tablePrefix . "_items (filename, serid, classeur, contents) "
            .
            " values ('" . mysqli_real_query($mysqli, $classeurOrNote) . "', " .
            ((int) $serid)
            .
            ",'" . $basePath . "', " . mysqli_real_query($mysqli, file_get_contents($basePath . "/" . $classeurOrNote)) . "')";
}
/*
function selectDBFolders($needle) {
    global $monutilisateur;
    global $mysqli;
    echo $sql = "select distint folder_name, username from blocnotes_data where username ='" . mysqli_real_query($mysqli, $monutilisateur) . "' and folder_name like '%" . $needle . "%'";
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
    echo $sql = "select * from " . $tablePrefix . "_data where isDirectory=1 and username='" . $monutilisateur . "'";
    $res = simpleQ($sql, $mysqli);
    return $res;
}

function getMimeType($id) {
    global $mysqli;
    connect();
    $result = getDBDocument($id);
    if ($result != NULL) {
        if (($doc = mysql_fetch_assoc($result)) != NULL) {
            return $doc["filename"];
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
    if (($doc = mysql_fetch_assoc($row)) != NULL) {
        $myArray["id"] = $doc;

        $sql = "select l.nom_element_porteur as masterId, d.* "
                . "from blocnotes_link as l"
                . " inner join blocnotes_data as d "
                . " on l.nom_element_porteur=d.nom_element_dependant "
                . "where l.nom_element_porteur=$id";
        $res = simpleQ($sql, $mysqli);

        $myArray["data"] = array();

        while (($doc2 = mysql_fetch_assoc($res)) != NULL) {
            $myArray["data"][$doc2["id"]] = $doc2;
        }
        return $myArray;
    } else
        return NULL;
}

function insereImageOuNote($id, $idDependant = -1, $filename, $data, $mime, $ordre) {
    global $mysqli;
    if ($idDependant <= 0) {

        $sql = "insert into blocnotes_data ( filename, content_file, mime )"
                . " values ( '" . mysqli_real_query($mysqli, $filename) .
                "' , '" . mysqli_real_query($mysqli, $data) . "' , '" .
                mysqli_real_query($mysqli, $mime) . "')";
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
    return$res;
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
function createRootForUser()
{
    global $mysqli;
    connect();
    $sql = "insert into blocnotes_data (filename, folder_id, isDirectory) values ('Dossier racine', -1, TRUE)";
    if(mysqli_query($mysqli, $sql))
    {
        echo "Fichier racine créé";
    }
}

function deleteDBDoc($dbdoc) {
    global $mysqli;
    global $monutilisateur;
    echo $sql = "update blocnotes_data set isDeleted=1 where id=" . mysqli_real_escape_string($mysqli, $dbdoc) . " and username='" . mysqli_real_escape_string($mysqli, $monutilisateur) . "'";
    simpleQ($sql, $mysqli);
}

function getPathArray($id) {
    $parray = array();


    $norec = FALSE;
    $i = 0;
    while (($id_old != $id) && ($norec != TRUE)) {
        $res0 = getDBDocument($id);
        if (($res0!=NULL) && (($doc = mysqli_fetch_assoc($res0)) != NULL)) {
            $filename = $doc["filename"];
            $id = $doc["folder_id"];
            $id_old = $doc["id"];
            $parray[$i++] = $filename;
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

    foreach ($parray_fn as $i => $filename) {
        echo "<span class='path_array'>" . $filename . "</span>";
    }

    echo "</div>";
}

function folder_field($folder_id){
    ?>
<select name="folder" class="user-control">
        <?php
        connect();
        $res = getFolderList();
        while(($row=  mysqli_fetch_assoc($res))!=NULL)
        {
            if($row["id"]==$folder_id)
            {
                $optionSel = "selected";
            }
            else {
                $optionSel = "";
     
            }
           echo "<option value='".$row['id']."' ".$optionSel." >".htmlspecialchars($row['filename'])."</option>";
            
        }
        ?>
    </select><br/><?php
 }
