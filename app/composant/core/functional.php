<?php
require_once("../browser/listesItem.php");
require_once("../../all-configured-and-secured-included.php");
require_once("../../lib/fpdf17/fpdf.php");
require_once("../core/functional.php");
function gen_slug($str){
    # special accents
    $a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','Ð','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','?','?','J','j','K','k','L','l','L','l','L','l','?','?','L','l','N','n','N','n','N','n','?','O','o','O','o','O','o','Œ','œ','R','r','R','r','R','r','S','s','S','s','S','s','Š','š','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Ÿ','Z','z','Z','z','Ž','ž','?','ƒ','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','?','?','?','?','?','?');
    $b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
    return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','-',''),str_replace($a,$b,$str)));
}
function doc_slug($id, $filename)
{
    $ext = getExtension($filename);
    return gen_slug($id."__".$filename."__".$ext."__".date("D, d M Y H:i:s", time())).".".$ext;
}

function htmlizeDoc($content) {
    $content = htmlspecialchars($content);
    $content = str_replace("[[", "<a target='NEW' href='", $content);
    $content = str_replace("]]", "'>Lien</a>", $content);
    $content = str_replace("{{", "<img src='composant/display/contents.php?id=", $content);
    $content = str_replace("}}", "'/>", $content);

    $doc = getDBDocument($id);
    $content = str_replace("((", "<span class'included_doc'>include doc n0", $content);
    $content = str_replace("))", "</span>", $content);

    return $contents;
}
function multiCellText(FPDF $fpdf, $content)
{
    $fpdf->MultiCell(210, 36/*297*/, $content);
}
function replaceContentDoc(FPDF $fpdf, $contents) {
    $matches = ""; global $urlApp; global $pathSep;
    preg_match_all("/\{\{(([0-9])+)\}\}/", $contents, $matches);
    $matches = $matches[1];
    for ($i = 0; $i < count($matches); $i++) {
        $fpdf->AddPage();
        $resultI = getDBDocument($matches[$i]);$docI = mysqli_fetch_assoc($resultI);
        ($docI['id'] > 0) or die();$filename = $docI['filename'];$mime = $docI['mime'];$content = $docI['content_file'];$id=$docI["id"];
        $docuurl = $urlApp . $pathSep . "composant" . $pathSep . "display" . $pathSep . "document.php?id=" . $matches[$i];
        $slug = doc_slug($id, $filename);
        if (isTexte(getExtension($filename,$mime))) {
            multiCellText($fpdf, $contents);
        } else if (isImage(getExtension($filename,$mime))) {
            $fpdf->Image($slug, $docuurl, 0,0,210,297, getExtension($mime), '', $content);
            
        } else
        {
            $fpdf->MultiCell(210,297, "Contenu non pris en charge ou er");
        }
    }
    return $content;
}
