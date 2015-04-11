<?PHP

require_once("./include/membersite_config.php");
require_once("config.php");

if (!$fgmembersite->CheckLogin()) {
    echo "null";

    exit;
}
$user = $fgmembersite->UserFullName();


$urlbase = $dataDir . "/CLASSTéléversés";
// !empty( $_FILES ) is an extra safety precaution
// in case the form's enctype="multipart/form-data" attribute is missing
// or in case your form doesn't have any file field elements
if (strtolower($_SERVER['REQUEST_METHOD']) == 'post' && !empty($_FILES)) {
    if (isset($_FILES['file'])) {
        $myFile = $_FILES['file'];
        $fileCount = count($myFile["name"]);

        for ($i = 0; $i < $fileCount; $i++) {
            $filename = $myFile['name'][$i];
            $urlfinale = $urlbase . "/" . $filename;
            echo "$ext<br/>";
            $ext = strtolower(substr($urlbase, -3));
            if ($ext == "txt" || $ext == "rtf" || $ext = "tml" || $ext == "htm" ||
                    $ext == "jpg" || $ext == "png" || $ext == "gif" ||
                    $ext == "stl") {
                
                if (move_uploaded_file($myFile['tmp_name'][$i], $urlfinale)) {
                    
                    echo "<p><a href='".$urlfinale."'> moved: ".$myFile['name'][$i]."</a></p>";
                    createFile($filename);
                    
                } else {
                    
                    echo error_get_last();
                }
            }
        }
    }
}
?><a class="button_appdoc" href="page.xhtml.php?composant=upload">Retour au télécersement de fichiers</a>