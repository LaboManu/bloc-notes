<?php
require_once("../../all-configured-and-secured-included.php");

echo "DBDOC: " . ($dbdoc = (int)filter_input(INPUT_GET, "dbdoc"));

connect();

if(deleteDBDoc($dbdoc))
{
    echo "Element mis en suppression";
}