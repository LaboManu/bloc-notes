<?php

require_once("../../config.php");

$document = filter_input(INPUT_GET, 'document');

$document = rawurldecode($document);

echo $dataDir.$pathSep.$document;
?>
<div id="document">
    <p id="document_name"><?php echo $document; ?></p>
    <pre>
        <?php echo file_get_contents($dataDir.$pathSep.$document);?>
    </pre>
</div>
<div id="doc2">

    <pre><?php
connect();
 $row1 = getDocument($document);
 echo getField($row, "contenu");
?></pre>
    <p>DATE de dernière mise à jour <?php echo getField($row, "moment"); ?>

</div>

</div>
