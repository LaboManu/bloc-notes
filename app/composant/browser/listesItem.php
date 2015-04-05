<?php
require_once("../../config.php");

function listerTout($classeur) {
    global $dataDir;
    $dirh = opendir($dataDir . "/" . $classeur);
    while (($f = readdir($dirh)) != NULL) {
        if (strtolower(substr($f, 0, 5)) == "class") {
            typeCls(substr($f, 5), $f);
        }
        if (strtolower(substr($f, -4)) == ".png"
                or strtolower(substr($f, -4) == ".jpg")) {
            typeImg($classeur, $f);
        } else if (strtolower(substr($f, -4)) == ".txt" || strtolower(substr($f, 0, 5)) == "class") {
            $filePath = $dataDir . "/" . $classeur . "/" . $f;
            typeTxt($classeur."/". $f, $filePath);
        }
    }
}

function typeTxt($cf, $filePath) {
    global $FILE_THUMB_MAXLEN;
    global $userdataurl;
    global $dataDir;
    $urlaction = "page.xhtml.php?composant=reader.txt&document=".$cf;
        ?>
        <a  draggable="true"
ondragstart="drag(event)" class='miniImg' href="<?= $urlaction ?>">
            <div class="miniImg file_preview">
                <?php echo file_get_contents($filePath, null, null, 0, 500); ?>
            </div>
            <span class="filename">
        <?php echo $cf; ?>
            </span>
        </a>
        <?php
}

function typeImg($classeur, $f) {
    global $userdataurl;
    global $dataDir;
    $actionurl = "page.xhtml.php?composant=reader.img&document=$classeur/$f";
    ?>
    <a  draggable="true"
ondragstart="drag(event)" class='miniImg'  href="<?= $actionurl ?>"><img src='<?= "$userdataurl/$classseur/$f" ?>' class="miniImg"><span class="filename"><?php echo $classeur . "/" . $f; ?></span></a>
    <?php
}

function typeCls($classeur, $f) {
    global $userdataurl;
    global $dataDir;
    $actionurl = "page.xhtml.php?composant=browser&classeur=$f";
    ?>
    <a  ondrop="drop(event)" ondragover="allowDrop(event)" class='miniImg'  href="<?= $actionurl ?>"><img src='images/alphabet.png' class="miniImg"><span class="filename"><?php echo substr($f, 0, 5); ?></span></a>
    <?php
}
