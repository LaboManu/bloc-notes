<?php

require_once 'all-configured-and-secured-included.php';



$rootIf = getRootForUser();

if($rootIf==NULL}
{
    createRootForUser();
}
