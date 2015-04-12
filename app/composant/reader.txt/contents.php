<?php




require_once("../../config.php");


$document = filter_input(INPUT_GET, 'document');

$document = rawurldecode($document);

connect();
$date = dbfile_getModificationsAsList($document.".txt");

?>
<div id="document"><p id="document_name"><?php echo $document; ?></p><?php echo file_get_contents($dataDir.$pathSep.$document.".txt");?><tt>DATES<?php echo $date; ?></tt>
</div>
<div id="doc2">

    <pre><?php
connect();
 $row1 = getDocument($document.".txt");
 echo getField($row, "contenu");
?></pre>
    <p>DATE de dernière mise à jour <?php echo getField($row, "moment"); ?>

</div>
