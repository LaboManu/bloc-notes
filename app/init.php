<?php

require_once 'all-configured-and-secured-included.php';

connect();

$rootIf = getRootForUser();

if($rootIf==NULL or $_GET["extra_root"]=="TRUE")
{
    createRootForUser();
}
