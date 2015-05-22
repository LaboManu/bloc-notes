<?php
class DBConnection
{
private $link = null;
private $tablePrefix = "blocnotes";

function connect() {
    if ($date == "") {
        $date = date("Y-m-d-H-i-s");
    }
    global $link;
    global $hostname;
    global $username;
    global $password;
    global $name;
    $link = mysql_connect($hostname, $username, $password);
    mysql_select_db($name);
}

function randomSerId() {
    $id = rand(1, 9999999);
}

function id_exists($id) {
    global $mysqli;
    $q = "select serid from " . $tablePrefix . "_items where serid=" . mysql_real_escape_string($id);
    if (simpleQ($q, $mysqli) == NULL)
        return false;
    else
        return true;
}

function getSeridFromFilename($filename, $utilisateur) {

    $q = "select serid from " . $tablePrefix . "_items where filename='" . mysql_real_escape_string($filename) . "' and username='" . mysql_real_escape_string($utilisateur) . "'";
    if (($serid = simpleQ($q, $mysqli)) == NULL)
        return FALSE;
    else
        return $serid;
}


function createFile($filename, $date = "") {
    if ($date == "") {
        $date = date("Y-m-d-H-i-s");
    }
    global $link;
    global $hostname;
    global $username;
    global $password;
    global $name;
    global $monutilisateur;

    while (id_exists($serid = randomSerId())) {
        ;
    }

    simpleQ("insert into blocnotes_items (user, filename, moment, type, serid) values('" . mysql_real_escape_string($monutilisateur, $link) . "', '" .
            mysql_real_escape_string($filename, $link) . "', '" . mysql_real_escape_string($date, $link) . "', 'file.creation', $serid);",
            $mysqli);
    //echo $q;

    mysql_query($q);
}

function updateFile($filename, $date = "", $contenu = "") {
    global $link;
    if ($date == "") {
        $date = date("Y-m-d-H-i-s");
    }
    global $hostname;
    global $username;
    global $password;
    global $name;
    global $monutilisateur;
    $serid = getSeridFromFilename($filename, $monutilisateur);
    $link = mysql_connect($hostname, $username, $password);
    mysql_select_db($name);
    $q = "insert into blocnotes_items (user, filename, contenu, moment, type, serid) values('" . mysql_real_escape_string($monutilisateur, $link) . "', '" .
            mysql_real_escape_string($filename, $link) . "', '" . mysql_real_escape_string($contenu, $link) . "','" . mysql_real_escape_string($date, $link) . "', 'file.update'," . mysql_real_escape_string($serid, $link) . ");";
    //echo $q;

    mysql_query($q);
}

function deleteFile($filename, $date = "") {
    if ($date == "") {
        $date = date("Y-m-d-H-i-s");
    }
    global $link;
    global $hostname;
    global $username;
    global $password;
    global $name;
    global $monutilisateur;
    $link = mysql_connect($hostname, $username, $password);
    mysql_select_db($name);
    $serid = getSeridFromFilename($filename, $monutilisateur);
    $q = "insert into blocnotes_items (user, filename, moment, type, serid) values('" . mysql_real_escape_string($monutilisateur, $link) . "', '" .
            mysql_real_escape_string($filename, $link) . "', '" . mysql_real_escape_string($date, $link) . "', 'file.delete'," . mysql_real_escape_string($serid, $link) . ")";
    //echo $q;

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
    $q = "insert into blocnotes_items (user, filename, moment, type, contenu, serid) values('" . mysql_real_escape_string($monutilisateur) . "', '" .
            mysql_real_escape_string($newname) . "', '" . mysql_real_escape_string($date) . "', 'file.rename', '" . mysql_real_escape_string($oldname) . "', " . mysql_real_escape_string($serid) . ");";
    mysql_query($q);

    mysql_close();

    updateLinks($oldname, $newname);
}

function listHistory($filename = null, $date = "") {
    if ($date == "") {
        $date = date("Y-m-d-H-i-s");
    }
    global $link;
    global $hostname;
    global $username;
    global $password;
    global $name;
    global $monutilisateur;
    $link = mysql_connect($hostname, $username, $password);
    mysql_select_db($name);
    $q = "select user, filename, moment, type, contenu from blocnotes_items where user='" . mysql_real_escape_string($monutilisateur, $link) . "' order by moment";

    $results = mysql_query($q);
    return $results;
}

function simpleQ($q) {

    if ($date == "") {
        $date = date("Y-m-d-H-i-s");
    }
    global $link;
    global $hostname;
    global $username;
    global $password;
    global $name;
    global $monutilisateur;
    $link = mysql_connect($hostname, $username, $password);
    mysql_select_db($name, $link);
    $results = mysql_query($q, $link);
    return $results;
}

function getSimpleRowElement($row, $field) {
    global $link;
    return $row[$field];
}

function dbfile_getCreationTime($filename) {
    global $link;
    connect();
    $q = "select moment from blocnotes_items where filename='" . mysql_real_escape_string($filename, $link) . "' and type='file.creation'";
    $res = simpleQ($q);
    if ($res == null) {
        return null;
    }
    if (($row = mysql_fetch_assoc($res)) != NULL) {
        getSimpleRowElement($row, "date");
    }
    return getSimpleRowElement($row, "date");
}

function dbfile_getModifications($filename) {
    global $link;
    $q = "select moment from blocnotes_items where filename='" . mysql_real_escape_string($filename) . "' order by moment";
    $res = simpleQ($q);
    if ($res == null) {
        return null;
    }
    return $res;
}

function dbfile_getDeleteTime($filename) {
    global $link;
    $q = "select moment from blocnotes_items where filename='" . mysql_real_escape_string($filename) . "' and type='file.delete'";
    $res = simpleQ($q);
    if ($res == null) {
        return null;
    }
    if (($row = mysql_fetch_assoc($res)) != NULL) {
        getSimpleRowElement($row, "date");
    }
    return getSimpleRowElement($row, "date");
}

function dbfile_getModificationsAsList($filename) {
    global $link;
    ?><table><?php
    $res = dbfile_getModifications($filename);
    if ($res != null) {
        while (($row = mysql_fetch_assoc($res)) != NULL) {
            echo "<tr><td>Modification</td><td>" . $row['moment'] . "</td></tr>";
        }
    }
    ?></table><?php
    }

    function getDocument($filename = "") {
        global $link;
        $q = "SELECT * FROM blocnotes_items WHERE MOMENT = (SELECT moment" .
                " FROM blocnotes_items " .
                "WHERE filename =  '" . mysql_real_escape_string($filename, $link) . "' " .
                " ORDER BY MOMENT DESC " .
                "LIMIT 1 )";
        //echo $q;
        $result = simpleQ($q);
        return $result;
    }

    function getDocuments() {
        global $monutilisateur;
        $q = "SELECT * FROM blocnotes_items " .
                "WHERE user='" . $monutilisateur . "'" .
                " ORDER BY MOMENT DESC " .
                "";
        $result = simpleQ($q);
        echo $q;
        return $result;
    }
    function getDocumentsParClasseur($classeur="") {
        global $monutilisateur;
        $q = "SELECT * FROM blocnotes_data " .
                "WHERE username='" . mysql_real_escape_string($monutilisateur) . "' ";//and filename like '%" .mysql_real_escape_string($classeur==""?"":"CLASS".$classeur).
                "'";
        $result = simpleQ($q);
        return $result;
    }
    function getDBDocument($id) {
        global $monutilisateur;
        $q = "SELECT * FROM blocnotes_data " .
                "WHERE username='" . mysql_real_escape_string($monutilisateur) . "' and id =" .mysql_real_escape_string((int)$id);
        
        $result = simpleQ($q);
        return $result;
    }

    function getField($row, $field) {
        return $row[$field];
    }

    function creationDate($filename = "") {
        global $link;
        $q = "SELECT * FROM blocnotes_items WHERE filename =  '" . mysql_real_escape_string($filename, $link) . "' ORDER BY MOMENT DESC";
        //echo $q;
        $result = simpleQ($q);
        $row = mysql_fetch_assoc($result);
        return getField($row, "moment");
    }

    function updateLinks($oldname, $newname) {
        // Table : blocnotes_links
        $q1 = "update blocnotes_link set nom_element_porteur='" . mysql_real_escape_string($newname) . "' where nom_element_porteur='" . mysql_real_escape_string($oldname) . "'";
        $q2 = "update blocnotes_link set nom_element_dependant='" . mysql_real_escape_string($newname) . "' where nom_element_dependant='" . mysql_real_escape_string($oldname) . "'";
        // Exécuter les requêtes

        mysql_query($q1);

        mysql_query($q2);
    }

    function createLink($nom_element_porteur, $nom_element_dependant) {
        global $link;
        $q = "insert into blocnotes_link (nom_element_porteur, nom_element_dependant) values ('" .
                mysql_real_escape_string($nom_element_porteur, $link) . "','" .
                mysql_real_escape_string($nom_element_dependant, $link) . "')";

        $this->simpleQ($q, $link);
    }



    function delete_link($id)    
    {
        $sql = "delete from ".$tablePrefix."_link where id=".mysql_real_escape_string((int)$id);
        $this->simpleQ($sql, $mysqli);
    
    }

    function listLinkedNotes($id)
    {
        $sql = "select link.id as linkid, link.pid as parent, link.eid as enfant, d1.filename as fp, d1.content_file as cp, d2.filename as fe, d2.content_file as ce".
            "from ".$this->tablePrefix."_link as link where nom_element_porteur=".((int)$id)." inner join ".$tablePrefix."_data as d1 on link.nom_element_porteur.id=d1.id".
            " inner join ".$tablePrefix."_data as de on de.id=link.nom_element_dependant";
        return $this->simpleQ($sql, $mysqli);
    }

function insertDB($basePath, $classeurOrNote)
{
    while(id_exists($serid = randomSerId()))
    {
        ;
    }
    $q = "insert ". $tablePrefix."_items (filename, serid, classeur, contents) "
            .
            " values ('".mysql_real_escape_string($classeurOrNote)."', ".
            ((int)$serid)
            .
            ",'".$basePath."', ".mysql_real_escape_string(file_get_contents($basePath."/".$classeurOrNote))."')";
    
    
}

function selectDBFolders($needle)
{
    global $monutilisateur;
    echo $sql = "select distint folder_name, username from blocnotes_data where username ='".  mysql_real_escape_string($monutilisateur)."'";
    return mysql_query($sql);
}

function renameDBFile($id, $filename_newname)
{
    global $tablePrefix;
    $sql = "update ".mysql_real_escape_string($tablePrefix)."_data set filename=".mysql_real_escape_string($filename_newname)." where id=".mysql_real_escape_string((int)$id);
    simpleQ($sql, $mysqli);
    
}
}
