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
function listerNotesFromDB($filtre){
    global $link;
    $results = getDocumentsFiltered($filtre);
    if($results) {
    while (($row=  mysql_fetch_assoc($results))!=NULL) {
        $filename = $row['filename'];
        $content = $row['content_file'];
        $id = $row['id'];
        typeDB($filename, $content, $id, $row);
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
<div class="miniImgContainer" ondrop="drop(event)" ondragover="allowDrop(event)" draggable="true"
        ondragstart="drag(event)" >
<input class="filecheckbox" type="checkbox" name="files[]" value="<?php echo "IMG_".$cf; ?>" />
    <a   class='miniImg'  href="<?= $actionurl ?>">
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
<div class="miniImgContainer" ondrop="drop(event)" ondragover="allowDrop(event)" draggable="true"
        ondragstart="drag(event)" >
<input class="filecheckbox" type="checkbox" name="files[]" value="<?php echo "CLASS_".substr($f, 0, -4); ?>" />
    <a class='miniImg'  href="<?= $actionurl ?>">
        <img src='images/alphabet.png' class="miniImg">
        <span class="filename"><?php echo $classeur; ?></span>
    </a>
</div>
    <?php
}
function typeDB($filename, $content, $id, &$rowdoc = NULL) {
    $urlaction = "page.xhtml.php?composant=reader.db&dbdoc=" . $id;
    ?><div id="<?php echo "data-$id"; ?>" class="miniImgContainer" ondrop="drop(event, <?php echo $id ?>)" ondragover="allowDrop(event)" draggable="true" ondragstart="drag(event)" >
        <span onclick="copyId(<?= $id ?>)">"<?= "Copy:{{{$id}}}" ?></span><select name="file_menu" id="menu<?php echo $id; ?>"><option value="Rien">---</option><option value="Voir">Voir</option><option value="Modifier">Modifier</option><option value="Move">Déplacer</option><option value="Copier">Copier</option><option value="Coller">Coller</option><option value="Corbeille">Corbeille</option><option value="Assembler">Assembler</option></select>
 <input class="filecheckbox" type="checkbox" name="files[]" value="<?php echo "TXT_".substr($cf, 0, -4); ?>" /><a class='miniImg' href="<?= $urlaction ?>">
<div class="miniImg">
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
 else if($rowdoc['isDirectory']==1)
 {
?><img src='images/alphabet.png' class="miniImg"><?php
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

// Echo out a sample image($filename)
echo '<img src="'.$src.'">';

}
function getExtension($filename)
{
 return $ext = strtolower(substr($filename, -3));
   
}
function isImage($ext)
{
 return in_array($ext, array("jpg","png","gif","bmp"));
   
}
function isTexte($ext)
{
 return in_array($ext, array("txt"));
   
}