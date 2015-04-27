<?php
require_once("../../config.php");

function listerTout($classeur) {
    global $dataDir;
    $dirh = opendir($dataDir . "/" . $classeur);
    while (($f = readdir($dirh)) != NULL) {
        if ((strtolower(substr($f, 0, 5)) == "class") && is_dir($dataDir."/".$f)) {
            if(substr($classeur, -1)=="/")
            {
                $f = substr($f, -1);
            }
            typeCls(substr($f, 5), $f);
        }
        else if (strtolower(substr($f, -4)) == ".png"
                or strtolower(substr($f, -4) == ".jpg")) {
            typeImg((($classeur=="")?"":$classeur. "/" ) . $f);
        } else if (strtolower(substr($f, -4)) == ".txt") {
            $filePath = $dataDir . "/" . $classeur ."/" .$f;
            typeTxt((($classeur=="")?"":$classeur. "/" ) . $f, $filePath);
        }
    }
}
function listerNotesFromDB($classeur = ""){
    global $link;
    $results = getDocumentsParClasseur($classeur);
    if($results) {
    while (($row=  mysql_fetch_assoc($results))!=NULL) {
        $filename = $row['filename'];
        $content = $row['content_file'];
        $id = $row['id'];
        typeDB($filename, $content, $id);
    }
    }
}
function typeTxt($cf, $filePath) {
    global $FILE_THUMB_MAXLEN;
    global $userdataurl;
    global $dataDir;
    $urlaction = "page.xhtml.php?composant=reader.txt&document=" . substr($cf, 0, -4);
    ?>
<div class="miniImgContainer">
<input class="filecheckbox" type="checkbox" name="files[]" value="<?php echo "TXT_".substr($cf, 0, -4); ?>" />
    <a  draggable="true"
        ondragstart="drag(event)" class='miniImg' href="<?= $urlaction ?>">
        <div class="miniImg">
            <?php echo file_get_contents($filePath, null, null, 0, 500); ?>
        </div>
        <span class="filename">
            <?php echo substr(getDocumentFromFullname($cf), 0, -4); ?>
        </span>
    </a>
</div>
    <?php
}

function typeImg($cf) {
    global $userdataurl;
    global $dataDir;
    $actionurl = "page.xhtml.php?composant=reader.img&document=$cf";
    ?>
<div class="miniImgContainer">
<input class="filecheckbox" type="checkbox" name="files[]" value="<?php echo "IMG_".$cf; ?>" />
    <a  draggable="true"
        ondragstart="drag(event)" class='miniImg'  href="<?= $actionurl ?>">
        <img src='<?php echo  "$userdataurl/$cf"; ?>' class="miniImg">
        <span class="filename"><?php echo $cf; ?></span></a>
</div>

        <?php
    }

    function typeCls($classeur, $f) {
        global $userdataurl;
        global $dataDir;
        $actionurl = "page.xhtml.php?composant=browser&classeur=$f";
        ?>
<div class="miniImgContainer">
<input class="filecheckbox" type="checkbox" name="files[]" value="<?php echo "CLASS_".substr($f, 0, -4); ?>" />
    <a  ondrop="drop(event)" ondragover="allowDrop(event)" class='miniImg'  href="<?= $actionurl ?>">
        <img src='images/alphabet.png' class="miniImg">
        <span class="filename"><?php echo $classeur; ?></span>
    </a>
</div>
    <?php
}
function typeDB($filename, $content, $id) {
    $urlaction = "page.xhtml.php?composant=reader.db&dbdoc=" . $id;
    ?>
<div class="miniImgContainer"><input class="filecheckbox" type="checkbox" name="files[]" value="<?php echo "TXT_".substr($cf, 0, -4); ?>" /><a  draggable="true" ondragstart="drag(event)" class='miniImg' href="<?= $urlaction ?>"><div class="miniImg">
            <?php 
            if(in_array(getExtension($filename), array("jpg","png","gif","bmp")))
            {
                //echoImgBase64($content, $filename);
                ?>
            <img src ="composant/display/contents.php?id=<?= $id ?>" alt="<?= $filename ?>"/>
            <?php
                
            }
 else if(in_array(getExtension($filename), array("txt")))
{
     echo substr($content, 0, 500);
 }
 else if(substr("/CLASS")>0)
 {
     echo "Classeur";
 } ?>
        </div><span class="filename"><?php echo $filename; ?></span></a></div>
    <?php }
function echoImgBase64($content, $filename)
{
                    // A few settings

// Read image path, convert to base64 encoding
$imgData = base64_encode($content);

// Format the image SRC:  data:{mime};base64,{data};
$src = 'data: image/'.  getExtension($filename).';base64,'.$imgData;

// Echo out a sample image
echo '<img src="'.$src.'">';

}
function getExtension($filename)
{
 return $ext = strtolower(substr($filename, -3));
   
}