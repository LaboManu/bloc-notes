<?php
require_once("../../lib/odtphp-1.0.1/library/odf.php");
define('TMP_PATH', str_replace(SELF, '', __FILE__) . 'tmp/');
$id = (int)filter_input(INPUT_GET, "id");
$result = getDBDocument($id);
if ($result != NULL) {
    if (($doc = mysql_fetch_assoc($result)) != NULL) {
        
    }
    
}
