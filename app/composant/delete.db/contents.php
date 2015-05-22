<?php
require_once("../../config.php");
require_once("../browser/listesItem.php");

$dbdoc = (int)filter_input(INPUT_GET, "dbdoc");

connect();

deleteDoc($dbdoc);