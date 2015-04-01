<?php
require_once("../../config.php");


$document = filter_input(INPUT_GET, 'document');
$url = $userdataurl."/".$document;
?>
<div id="document" >
    <img src="<?php echo $url;?>" />
</div>
