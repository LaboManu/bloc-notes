<?php
require_once("../browser/listesItem.php");
require_once("../../all-configured-and-secured-included.php");
require_once("../../lib/fpdf17/fpdf.php");
require_once("../core/functional.php");

connect();

$id = (int) filter_input(INPUT_GET, "id");
$result = getDBDocument($id);
if ($result != NULL) {
    if (($doc = mysqli_fetch_assoc($result)) != NULL) {
        $contents = $doc['content_file'];

        $pdf = new FPDF();
        $filename = $doc['filename'];
        $mime = $doc['mime'];
        $slug = doc_slug($id, $filename);
        if ($mime == "text/plain") {
            $pdf->AddPage();
            $pdf->SetY(5);    // set the cursor at Y position 5
            $pdf->SetFont('Arial', 'B', 16);
            multiCellText($pdf, $contents);

            $pdf->AddPage();
            $pdf->SetY(5);    // set the cursor at Y position 5
            replaceContentDoc($pdf, $contents);
        } else if (isImage(getExtension($filename,$mime))) {
            $ext  = substr($doc["mime"], strlen("IMAGE/"));
            $pdf->AddPage();
            $pdf->SetY(5);    // set the cursor at Y position 5
            $docuurl = $urlApp . $pathSep . "composant" . $pathSep . "display" . $pathSep . "document.php?id=" . $matches[$i];
            $pdf->Image(doc_slug($id, $filename), $docuurl,0,0,210,297,$ext, '', $doc['content_file']);
        }
        $pdf->Output();
    }
}
     