<?php
require_once("listesItem.php");



connect();
$dbdoc = (int) filter_input(INPUT_GET, "dbdoc");
if ($dbdoc == "") {
    $dbdoc = getRootForUser();
    echo "Répertoire racine (par défaut:$dbdoc)";
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
    <h2 class="userInfo">Dossier: <?php echo $docCourant["filename"]; ?></h2>
    <h3>Classeurs en base de données</h3>
    Recherche<input type="text" name="filter" value="<?php echo $filtre; ?>"/>
    <input type="checkbox" name="composed" value="Notes composees" <?php echo $composed ? "checked" : ""; ?> />
    <input type="hidden" name="composant" value="browser" />
    <div id="dblisting" class="clearBoth">
        <?php
        listerNotesFromDB($filtre, $composed, $dbdoc);
        ?>                        
    </div>
</form>
