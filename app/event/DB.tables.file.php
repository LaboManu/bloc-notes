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
function listHistory($filename = null, $date="") {
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
    $q = "select user, filename, moment, type from blocnotes_items where user='".$monutilisateur ."' order by moment";
    
    $results = mysql_query($q);
    return $results;
}
function simpleQ($q)
{
    
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
    $results = mysql_query($q);
    return $results;
}
function getSimpleRowElement($row, $field)
{
    return $row[$field];
}
function dbfile_getCreationTime($filename)
{
    $q = "select moment from blocnotes_items where filename='".$filename."' and type='file.creation'";
    $res = simpleQ($q);
    if($res==null) {return null;}
    if(($row= mysql_fetch_assoc($res))!=NULL)
            getSimpleRowElement($row, "date");
    return getSimpleRowElement($row, "date");
}
function dbfile_getModifications($filename)
{
    $q = "select moment from blocnotes_items where filename='".$filename."' and type='file.update' order by date";
    $res = simpleQ($q);
    if($res==null) {return null;}
    return $res;
    
}
function dbfile_getDeleteTime($filename)
{
    $q = "select moment from blocnotes_items where filename='".$filename."' and type='file.delete'";
    $res = simpleQ($q);
    if($res==null) {return null;}
    if(($row= mysql_fetch_assoc($res))!=NULL)
            getSimpleRowElement($row, "date");
    return getSimpleRowElement($row, "date");
    
}
function dbfile_getModificationsAsList($filename)
{
    ?><table><?php
    $res = dbfile_getModifications($filename);
    if($res!=null)
    {
        while(($row=  mysql_fetch_assoc($res))!=NULL)
        {
            echo "<tr><td>Modification</td><td>".$row['date']."</td></tr>";
            
        }
    }
    ?></table><?php
}
