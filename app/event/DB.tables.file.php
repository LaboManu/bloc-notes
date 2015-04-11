<?php
function connect()
{
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
    $link = mysql_connect($hostname, $username, $password);
    mysql_select_db($name);
    $q = "insert into blocnotes_items (user, filename, moment, type) values('" . mysql_real_escape_string($monutilisateur, $link) . "', '" .
            mysql_real_escape_string($filename, $link) . "', '" . mysql_real_escape_string($date, $link) . "', 'file.creation');";
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
    $link = mysql_connect($hostname, $username, $password);
    mysql_select_db($name);
    $q = "insert into blocnotes_items (user, filename, contenu, moment, type) values('" . mysql_real_escape_string($monutilisateur, $link) . "', '" .
            mysql_real_escape_string($filename, $link) . "', '" . mysql_real_escape_string($contenu, $link) . "',     '" . mysql_real_escape_string($date, $link) . "', 'file.update');";
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
    $q = "insert into blocnotes_items (user, filename, moment, type) values('" . mysql_real_escape_string($monutilisateur, $link) . "', '" .
            mysql_real_escape_string($filename, $link) . "', '" . mysql_real_escape_string($date, $link) . "', 'file.delete');";
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
    $q = "insert into blocnotes_items (user, filename, moment, type, contenu) values('" . mysql_real_escape_string($monutilisateur) . "', '" .
            mysql_real_escape_string($newname) . "', '" . mysql_real_escape_string($date) . "', 'file.rename', '".mysql_real_escape_string($oldname)."');";
    //echo $q;

    mysql_query($q);

    mysql_close();
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
    mysql_select_db($name);
    $results = mysql_query($q);
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
    if (($row = mysql_fetch_assoc($res))!= NULL) {
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
               " ORDER BY MOMENT DESC ".

                "LIMIT 1 )";
        //echo $q;
        $result = simpleQ($q);
        return $result;
    }
    

    function getDocuments($classeur = "*") {
$q = "SELECT * FROM blocnotes_items WHERE MOMENT = (SELECT moment" .
                " FROM blocnotes_items " .
                "WHERE " .
               " ORDER BY MOMENT DESC ".

                "LIMIT 1 )";
        $result = simpleQ($q);
        return $result;
    }
    function getField($row, $field)
    {
        return $row[$field];
    }
    
    
    function creationDate($filename = "") {
        global $link;
        $q = "SELECT * FROM blocnotes_items WHERE filename =  '" . mysql_real_escape_string($filename, $link) . " ORDER BY MOMENT ASC" ;
        //echo $q;
        $result = simpleQ($q);
        $row = mysql_fetch_assoc($result);
        return getField($row, "moment");
    }