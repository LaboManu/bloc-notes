<?php
/*
create table anchor(
id int,
url varchar(1024),
title varchar(1024),
description blob,
mime varchar(100)
)
*/
class Anchor {
    private $dbconnection;

    private $id;
    
    private $title;
    private $url;
    private $description;
    
    function getAnchor($id) {
        
    }
    function deleteAnchor($id) {
        
    }
    function replaceAnchor($id, $title, $url, $descritpion) {
        
    }
    function createAnchor($id, $title, $url, $descritpion) {
        
    }
    function searchAnchor($url, $title="", $desciption="") {
        
    }
}

?>