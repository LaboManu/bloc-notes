<?php
require_once '../../all-configured-and-secured-included.php';

connect();

$docs = getAllDocument();

showLinks($docs);

