<?php
require_once("../../config.php");

function listerTout($classeur) {
    global $dataDir;
    $dirh = opendir($dataDir . "/" . $classeur);
    while (($f = readdir($dirh)) != NULL) {
        if (strtolower(substr($f, 0, 5)) == "class") {
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
function listerNotesFromDB($classeur = "")
{
    global $link;
    global $dataDir;
    $results = getDocuments();
    while(($row=  mysql_fetch_assoc($result, $link))!=NULL)
    {
        $cf = (($classeur=="")?"":$classeur. "/" ) . $f;
        $urlaction = "page.xhtml.php?composant=reader.txt&document=" . $cf;
        $filePath = $dataDir . "/" . $classeur ."/" .$f;
    ?>
    <a  draggable="true"
        ondragstart="drag(event)" class='miniImg' href="<?= $urlaction ?>">
        <div class="miniImg">
            <?php echo file_get_contents($filePath, null, null, 0, 500); ?>
        </div>
        <span class="filename">
            <?php echo $cf; ?>
        </span>
    </a>
    <?php
        
    }
    
}
function typeTxt($cf, $filePath) {
    global $FILE_THUMB_MAXLEN;
    global $userdataurl;
    global $dataDir;
    $urlaction = "page.xhtml.php?composant=reader.txt&document=" . substr($cf, 0, -4);
    ?>
    <a  draggable="true"
        ondragstart="drag(event)" class='miniImg' href="<?= $urlaction ?>">
        <div class="miniImg">
            <?php echo file_get_contents($filePath, null, null, 0, 500); ?>
        </div>
        <span class="filename">
            <?php echo substr($cf, 0, -4); ?>
        </span>
    </a>
    <?php
}

function typeImg($cf) {
    global $userdataurl;
    global $dataDir;
    $actionurl = "page.xhtml.php?composant=reader.img&document=$cf";
    ?>
    <a  draggable="true"
        ondragstart="drag(event)" class='miniImg'  href="<?= $actionurl ?>">
        <img src='<?php echo  "$userdataurl/$cf"; ?>' class="miniImg">
        <span class="filename"><?php echo $cf; ?></span></a>
        <?php
    }

    function typeCls($classeur, $f) {
        global $userdataurl;
        global $dataDir;
        $actionurl = "page.xhtml.php?composant=browser&classeur=$f";
        ?>
    <a  ondrop="drop(event)" ondragover="allowDrop(event)" class='miniImg'  href="<?= $actionurl ?>">
        <img src='images/alphabet.png' class="miniImg">
        <span class="filename"><?php echo $classeur; ?></span>
    </a>
    <?php
}
