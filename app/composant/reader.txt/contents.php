<?php

require_once("../../config.php");

$document = filter_input(INPUT_GET, 'document');

$document = rawurldecode($document);

echo $dataDir.$pathSep.$document;
?>
<div id="document">
    <p id="document_name"><?php echo $document; ?></p>
    <pre>
<?php echo file_get_contents($dataDir.$pathSep.$document);
?>
    </pre>
</div>
