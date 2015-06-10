<?php

require_once("../browser/listesItem.php");

$id = (int) (rawurldecode(filter_input(INPUT_POST, 'dbdoc')));
$follow = (int) (rawurldecode(filter_input(INPUT_POST, 'follow')));

connect();
if (createLink($id, $follow)) {
    echo "Element lien créé.";
} else {
    echo "N'a pas pu créer le lien.";
}
