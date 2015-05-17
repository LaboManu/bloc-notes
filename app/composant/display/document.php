<?php

require("../../config.php");
require_once("../../lib/fpdf17/fpdf.php");
require_once("../../lib/fpdf17/loadimages.php");


$id = (int) filter_input(INPUT_GET, "id");
$result = getDBDocument($id);
if ($result != NULL) {
    if (($doc = mysql_fetch_assoc($result)) != NULL) {
        $contents = $doc['content_file'];

        $pdf = new PDF_MemImage();

        $pdf->AddPage();
        if ($doc['mime'] == "text/plain") {
            $pdf->SetY(5);    // set the cursor at Y position 5
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(100, 200, $contents, 1);


            // Traiter le formattage manuel
            $matches = array();
            preg_match("/\\{\\{[0-9]+\\}\\}/", $contents, $matches);

            for ($i = 0; $i < count($matches); $i++) {

                $pdf->AddPage();
//Load an image into a variable
                $resultI = getDBDocument($matches[$i]);
                if ($resultI != NULL) {
                    if (($docI = mysql_fetch_assoc($resultI)) != NULL) {
                        $logo = $docI['content_file'];
//Output it
                        $pdf->MemImage($logo, 50, 30, 140, 0);
                    }
                }
            }
        } else if (strtolower(substr($doc["mime"], 0, 5)) == "image") {

//Load an image into a variable
                    $logo = $contents;
//Output it
                    $pdf->MemImage($logo, 50, 30, 140, 0);
        }
        $pdf->Output();
    }
}
     