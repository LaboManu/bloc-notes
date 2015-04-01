<?php
require_once("../../config.php");


$document = filter_input(INPUT_GET, $document);

?>
<div id="document">
<?php echo file_get_contents($userdataurl.$pathSep.$document);
?>
</div>
