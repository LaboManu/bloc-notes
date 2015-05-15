<?php

function randomSerId() {
    $id = rand(1, 9999999);
}

function id_exists($id) {
    $q = "select serid from " . $tablePrefix . "_items where serid=" . mysql_real_escape_string($id);
    if (simpleQ($q) == NULL)
        return false;
    else
        return true;
}

function getSeridFromFilename($filename, $utilisateur) {

    $q = "select serid from " . $tablePrefix . "_items where filename='" . mysql_real_escape_string($filename) . "' and username='" . mysql_real_escape_string($utilisateur) . "'";
    if (($serid = simpleQ($q)) == NULL)
        return FALSE;
    else
        return $serid;
}

function connect() {
    if ($date == "") {
        $date = date("Y-m-d-H-i-s");
    }
    global $link;
    global $hostname;
    global $username;
    global $password;
    global $name;
    
    if($link==NULL)
    {
    $link = mysql_connect($hostname, $username, $password);
    }
    mysql_select_db($name);
}

$link = null;

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

    $link = mysql_connect($hostname, $username, $password);
    mysql_select_db($name);
    $q = "insert into blocnotes_items (user, filename, moment, type, serid) values('" . mysql_real_escape_string($monutilisateur, $link) . "', '" .
            mysql_real_escape_string($filename, $link) . "', '" . mysql_real_escape_string($date, $link) . "', 'file.creation', $serid);";
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
    function getDocumentsFiltered($filtre, $composedOnly=FALSE, $path="*") {
        global $monutilisateur;
        $q = "SELECT * FROM blocnotes_data " .
                "WHERE username='" . mysql_real_escape_string($monutilisateur) .
                "' and ((filename like '%" .mysql_real_escape_string($filtre).
                "%') or (content_file like'%" .mysql_real_escape_string($filtre).
                "%') and (content_file like '%".
                        ($composedOnly?"{{":"")."%' )) and "
                . "folder_name like ".($path=="*"?"''":"'%".$path."%'");// order by modification";
        $result = simpleQ($q);
        return $result;
    }
    function getDBDocument($id) {
        global $monutilisateur;
        connect();
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
        $q1 = "update blocnotes_link set nom_element_porteur=" . (int)mysql_real_escape_string($newname) . " where nom_element_porteur=" . (int)mysql_real_escape_string($oldname) . "";
        $q2 = "update blocnotes_link set nom_element_dependant=" . (int)mysql_real_escape_string($newname) . " where nom_element_dependant=" . (int)mysql_real_escape_string($oldname) . "";
        // Exécuter les requêtes

        mysql_query($q1);

        mysql_query($q2);
    }

    function createLink($nom_element_porteur, $nom_element_dependant) {
        global $link;
        $q = "insert into blocnotes_link (nom_element_porteur, nom_element_dependant) values (" .
                (int)mysql_real_escape_string($nom_element_porteur, $link) . " , " .
                (int)mysql_real_escape_string($nom_element_dependant, $link) . ")";

        mysql_query($q, $link);
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
    echo $sql = "select distint folder_name, username from blocnotes_data where username ='".  mysql_real_escape_string($monutilisateur)."' and folder_name like '%".$needle."%'";
    return mysql_query($sql);
}
function isDirectory($dbdoc)
{
    global $tablePrefix;
    $sql = "select isDirectory from ".$tablePrefix."_data where id=".((int)$dbdoc);
    $res = simpleQ($sql);
    if(($doc=mysql_fetch_assoc($res))!=NULL)
    {
        return $doc["isDirectory"];
    }
    return FALSE;
}
function getDirectoryPath($dbdoc)
{
    global $monutilisateur;
    global $tablePrefix;
    if(isDirectory($dbdoc))
    {
    $sql = "select isDirectory, folder_name, filename from ".$tablePrefix."_data where id=".((int)$dbdoc)." and username='".$monutilisateur."'";
    $res = simpleQ($sql);
    if(($doc=mysql_fetch_assoc($res))!=NULL)
    {
        return ($doc["folder_name"]==""?"":$doc["folder_name"]).$doc['filename'];
    }
    }
 else {
     echo "Erreur n'est pas un répertoire";
    }
    return "";
}
function getFolderList()
{
    global $monutilisateur;
    global $tablePrefix;
    $sql = "select * from ".$tablePrefix."_data where isDirectory=1 and username='".$monutilisateur."'";
    $res = simpleQ($sql);
    return $res;
}
function getMimeType($id)
{
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
    $myArray;
    
    $id = (int )$id;
    
    $row = getDBDocument($id);
    if(($doc = mysql_fetch_assoc($row))!=NULL)
    {
        $myArray["id"] = $doc;
        
        $sql = "select l.nom_element_porteur as masterId, d.* "
                . "from blocnotes_link as l"
        . " inner join blocnotes_data as d "
        . " on l.nom_element_porteur=d.nom_element_dependant "
                . "where l.nom_element_porteur=$id";
        $res = simpleQ($sql);
        
        $myArray["data"] = array();
                
         while(($doc2=mysql_fetch_assoc($res))!=NULL)
        {
             $myArray["data"][$doc2["id"]] = $doc2;
        }
        return $myArray;
    }
    
    else return NULL;
}
function insereImageOuNote($id, $idDependant=-1, $filename, $data, $mime, $ordre) {
    global $link;
    if($idDependant<=0)
    {
        
        $sql = "insert into blocnotes_data ( filename, content_file, mime )"
        . " values ( '".mysql_real_escape_string($filename).
        "' , '" . mysql_real_escape_string($data)."' , '".
                mysql_real_escape_string($mime)."')";
        simpleQ( $sql);
        $idDependant = mysql_insert_id($link);
    }
    createLink($id,  $idDependant, $ordre);
}


function deleteImageOuNoteDependant($id, $idDependant)
{
    
    $id = (int)$id;;
    $idDependant = (int)$idDependant ;
    $sql = "delete from blocnotes_link where ".
        "nom_element_porteur=$id and "
             ."   nom_element_dependant=$idDependant";
    simpleQ($sql);
}