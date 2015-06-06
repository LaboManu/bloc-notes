<?php

require_once 'all-configured-and-secured-included.php';

connect();

$rootIf = getRootForUser();

<<<<<<< HEAD
if($rootIf==NULL or $_GET["extra_root"]=="TRUE")
=======
if($rootIf==NULL)
>>>>>>> 5c7a529be157edb1fbfe09bac2ace7b8e293d529
{
    createRootForUser();
}
