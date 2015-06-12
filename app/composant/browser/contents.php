<?php
require_once("listesItem.php");



connect();
$dbdoc = (int) filter_input(INPUT_GET, "dbdoc");
if ($dbdoc == "") {
    $dbdoc = getRootForUser();
    echo "\\";
}

$docCourant = mysqli_fetch_assoc(getDBDocument($dbdoc));


$filtre = filter_input(INPUT_GET, "filter");


$composed = ($_GET['composed'] or false);
if ($c == "Notes composees") {
    $composed = true;
} else {
    $composed = false;
}


?><form action="" method="GET">
    <h2 class="userInfo">Catégorie: <?php echo $docCourant["filename"]; ?></h2>
    <h3>Images et notes, etc</h3>
    Recherche textuelle <input type="text" name="filter" value="<?php echo $filtre; ?>"/>
    <input type="checkbox" name="composed" value="Notes composees" <?php echo $composed ? "checked" : ""; ?> />
    <input type="hidden" name="composant" value="browser" /></p>
    <div id="dblisting" class="clearBoth">
        <?php
        listerNotesFromDB($filtre, $composed, $dbdoc);
        ?>                        
    </div>
</form>
