<?php

require_once("../../config.php");

// Manuel Dahmen C2015

$id = rawurldecode(filter_input(INPUT_GET, "linkId"));
$linker = rawurldecode(filter_input(INPUT_GET, "linker"));
$linkedOn = rawurldecode(filter_input(INPUT_GET, "linkedOn"));



if($id==-1)
{
    $sql = "insert into ".$tablePrefix." (id_element_porteur, id_element_dependant) "/* FOR UPDATE:=type=chained (default) ,*/ .
        " values (".((int)mysql_real_escape_string($linker)).
        " , ".((int)mysql_real_escape_string($linker)).")";
    echo $sql;
    simplQ($sql);
    
} else if($id>0){
    $sql = "update into ".$tablePrefix." set id_element_porteur"
        . "= ".((int)mysql_real_escape_string($linker))
        . ", id_element_dependant=".((int)mysql_real_escape_string($linkedOn)).") "
            . "where id=".((int)$id);
    echo $sql;
    simplQ($sql);
}
