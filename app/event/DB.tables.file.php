<?php

function createFile($filename, $date="") {
    if($date=="")
    {
        $date = date("Y-m-d-H-i-s");
    }
    global $hostname;
    global $username;
    global $password;
    global $name;
    global $monutilisateur;
    mysql_connect($hostname, $username, $password);
    mysql_select_db($name);
    $q = "insert into blocnotes_items (user, filename, moment, type) values('" . $monutilisateur . "', '" .
            $filename . "', '".$date."', 'file.creation');";
    //echo $q;
    
    mysql_query($q);
    
    mysql_close();
}
function updateFile($filename, $date="") {
    if($date=="")
    {
        $date = date("Y-m-d-H-i-s");
    }
    global $hostname;
    global $username;
    global $password;
    global $name;
    global $monutilisateur;
    mysql_connect($hostname, $username, $password);
    mysql_select_db($name);
    $q = "insert into blocnotes_items (user, filename, moment, type) values('" . $monutilisateur . "', '" .
            $filename . "', '".$date."', 'file.update');";
    //echo $q;
    
    mysql_query($q);
    
    mysql_close();
}
function deleteFile($filename, $date="") {
    if($date=="")
    {
        $date = date("Y-m-d-H-i-s");
    }
    global $hostname;
    global $username;
    global $password;
    global $name;
    global $monutilisateur;
    mysql_connect($hostname, $username, $password);
    mysql_select_db($name);
    $q = "insert into blocnotes_items (user, filename, moment, type) values('" . $monutilisateur . "', '" .
            $filename . "', '".$date."', 'file.delete');";
    //echo $q;
    
    mysql_query($q);
    
    mysql_close();
}
function renameFile($filename, $date="") {
    if($date=="")
    {
        $date = date("Y-m-d-H-i-s");
    }
    global $hostname;
    global $username;
    global $password;
    global $name;
    global $monutilisateur;
    mysql_connect($hostname, $username, $password);
    mysql_select_db($name);
    $q = "insert into blocnotes_items (user, filename, moment, type) values('" . $monutilisateur . "', '" .
            $filename . "', '".$date."', 'file.rename');";
    //echo $q;
    
    mysql_query($q);
    
    mysql_close();
}
function listHistory($filename, $date="") {
    if($date=="")
    {
        $date = date("Y-m-d-H-i-s");
    }
    global $hostname;
    global $username;
    global $password;
    global $name;
    global $monutilisateur;
    mysql_connect($hostname, $username, $password);
    mysql_select_db($name);
    $q = "select user, filename, moment, type from blocnotes_items where user=".$monutilisateur ." order by moment desc;";
    
    $results = mysql_query($q);
    return $results;
}
