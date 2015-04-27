<?php


require_once("../../config.php");

$id = rawurldecode(filter_input(INPUT_GET, 'dbdoc'));
$content = rawurldecode(filter_input(INPUT_GET, 'contenu'));


connect();
$sql = "update blocnotes_data set content_file='".mysql_real_escape_string($content)."' where id=".$id;
simpleQ($sql);

echo $id." |  : | ".$content;