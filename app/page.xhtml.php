<?php
require_once 'config.php';
$document1 = filter_input(INPUT_GET, 'document');
$document = rawurlencode($document1);
/* @var $_GET type */
$composant = filter_input(INPUT_GET, 'composant');

if ($composant == "") {
    $composant = filter_input(INPUT_POST, 'composant');
    if ($composant == "") {
        $composant="nontrouvé";
    }
}
$id=filter_input(INPUT_GET, 'id');

if (!file_exists($appDir . "/composant/" . $composant)) {
    $composant = "pardefaut";
} else {
    if ($composant == "rename.txt") {
        $paramsSuppl = "&nom=" . rawurlencode(filter_input(INPUT_GET, "nom"))
                . "&classeur=" . rawurlencode(filter_input(INPUT_GET, "classeur"));
    } if ($composant == "save.txt") {
        $paramsSuppl = "&contenu=" . rawurlencode(filter_input(INPUT_GET, "contenu"))
                . "&classeur=" . rawurlencode(filter_input(INPUT_GET, "classeur"));
    } if ($composant == "browser") {
        $paramsSuppl = "&classeur=" . rawurlencode(filter_input(INPUT_GET, "classeur"));
        $paramsSuppl .= "&filter=" . rawurlencode(filter_input(INPUT_GET, "filter")) ;
    } if (($composant == "classe.doc") || ($composant == "edit.cls") || ($composant == "save.cls") || ($composant == "rename.cls") || ($composant == "del.cls") || ($composant == "classement") || ($composant == "classe")) {
        $paramsSuppl = "&classeur=" . rawurlencode(filter_input(INPUT_GET, "classeur"));
        if ($composant == "rename.cls") {
            $paramsSuppl .= "&nom=" . rawurlencode(filter_input(INPUT_GET, "nom"))
                    . "&classeur=" . rawurlencode(filter_input(INPUT_GET, "classeur"));
        }
    }
    if (($composant == "create.txt")) {
        $paramsSuppl = "&classeur=" . rawurlencode(filter_input(INPUT_GET, "classeur"));
    }
    if (($composant == "reader.db") ||($composant == "edit.db")) {
        $paramsSuppl = "&dbdoc=" . rawurlencode((int)filter_input(INPUT_GET, "dbdoc"));
    }
    if($composant == "save.db"){
        $paramsSuppl = "&dbdoc=" . 
                rawurlencode((int)filter_input(INPUT_GET, "dbdoc"))."&contenu=".
        rawurlencode(filter_input(INPUT_GET, "contenu"))."&filename=".rawurlencode(filter_input(INPUT_GET, "filename"));
    }

    }

$waiterString = ""; //Loading and not load that is definitively not the question.--MD";
?>

<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"; ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr">
    <head>
        <title>Bloc-notes</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link rel="icon" href="/favicon.ico" />
        <link rel="shortcut icon" href="/favicon.ico" />
          <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script type="text/javascript" src="composant/browser/dnd.js"></script>
        <script type="text/javascript" src="js/blocnoteslib.js"></script>
    </head>
    <body>
        <?php if($composant!="") {?>
        <!-- Barre du dessus -->
        <div id="context_menu_bar">
            <?php
            require_once("$appDir/access-controlled.php");
            ?>Good day!
        </div>
        <!-- Barre du dessus -->
        <div id="user_frame" ><?php echo $waiterString ?></div>
        <!-- Barre de gauche -->
        <div id="appdoc_menu"><?php echo $waiterString ?></div>
        <!-- Barre de gauche -->
        <div id="contents"><?php echo $waiterString ?></div>
        <div id="error"><?php echo $waiterString ?></div>
        <script>
            var urlAppJS = "<?php echo $urlApp; ?>";
            $("#contents").load(url = urlAppJS + "/composant/<?php echo $composant; ?>/contents.php?document=<?php echo $document . $paramsSuppl; ?>", function (response, status, xhr) {
                if (status == "error") {
                    var msg = "Sorry but there was an error: ";
                    $("#error").html(msg + xhr.status + " " + xhr.statusText + url);
                }
            });
            $("#user_frame").load(url = urlAppJS + "/user.php?document=<?php echo $document . $paramsSuppl; ?>", function (response, status, xhr) {
                if (status == "error") {
                    var msg = "Sorry but there was an error: ";
                    $("#error").html(msg + xhr.status + " " + xhr.statusText + url);
                }
            });
            $("#appdoc_menu").load(url = urlAppJS + "/composant/<?php echo $composant; ?>/appdoc.php?document=<?php echo $document . $paramsSuppl; ?>", function (response, status, xhr) {
                if (status == "error") {
                    var msg = "Sorry but there was an error: ";
                    $("#error").html(msg + xhr.status + " " + xhr.statusText + url);
                }
            });
            $("#context_menu_bar").load(url = urlAppJS + "/composant/<?php echo $composant; ?>/menubar.php?document=<?php echo $document . $paramsSuppl; ?>", function (response, status, xhr) {
             if (status == "error") {
             var msg = "Sorry but there was an error: ";
             $("#error").html(msg + xhr.status + " " + xhr.statusText + url + <?php echo "'Composant + " . $composant + "'"; ?>);
             }
             });
             
        </script>
        <?php } ?>
    </body>
</html>
