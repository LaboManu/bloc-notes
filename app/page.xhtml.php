<?php
require_once(__DIR__ . "/access-controlled.php");
require_once(__DIR__ . "/all-configured-and-secured-included.php");

$document1 = filter_input(INPUT_GET, 'document');
$document = rawurlencode($document1);
/* @var $_GET type */

$composant = filter_input(INPUT_GET, 'composant');
if ($composant == "") {
    $composant = filter_input(INPUT_POST, 'composant');
}
if ($composant == "") {
    $composant = "browser";
}

$id =(int) filter_input(INPUT_GET, 'id');
$dbdoc = (int) filter_input(INPUT_GET, 'dbdoc');

if ($dbdoc == "") {
    $dbdoc = getRootForUser();
    echo "\\";
}

/*
if (!file_exists($appDir . "/composant/" . $composant."/contents.php")) {
    $composant = "browser";
}
*/
    if ($composant == "rename.txt") {
        $paramsSuppl = "nom=" . rawurlencode(filter_input(INPUT_GET, "nom"))
                . "&classeur=" . rawurlencode(filter_input(INPUT_GET, "classeur"));
    } if ($composant == "save.txt") {
        $paramsSuppl = "contenu=" . rawurlencode(filter_input(INPUT_GET, "contenu"))
                . "&classeur=" . rawurlencode(filter_input(INPUT_GET, "classeur"));
    } if ($composant == "browser") {
        $paramsSuppl .= "&dbdoc=" . rawurlencode(filter_input(INPUT_GET, "dbdoc"));
        $paramsSuppl .= "&filter=" . rawurlencode(filter_input(INPUT_GET, "filter"));
        $paramsSuppl .= "&composed=" . rawurlencode(filter_input(INPUT_GET, "composed"));
    } if (($composant == "classe.doc") || ($composant == "edit.cls") || ($composant == "save.cls") || ($composant == "rename.cls") || ($composant == "del.cls") || ($composant == "classement") || ($composant == "classe")) {
        $paramsSuppl = "classeur=" . rawurlencode(filter_input(INPUT_GET, "classeur"));
        if ($composant == "rename.cls") {
            $paramsSuppl .= "&nom=" . rawurlencode(filter_input(INPUT_GET, "nom"))
                    . "&classeur=" . rawurlencode(filter_input(INPUT_GET, "classeur"));
        }
    }
    if (($composant == "create.txt")) {
    }

    
    
    if(($composant == "create.db")||($composant == "create.folder.db"))
    {
        $paramsSuppl = "dbdoc=" . rawurlencode(filter_input(INPUT_GET, "dbdoc"))
                . "&folder=" . rawurlencode(filter_input(INPUT_GET, "folder"));
    }
    if (($composant == "reader.db") || ($composant == "edit.db")) {
        $paramsSuppl = "dbdoc=" . rawurlencode((int) filter_input(INPUT_GET, "dbdoc"))
            . "&viewer=" . rawurlencode((int) filter_input(INPUT_GET, "viewer"));
    }
    if (($composant == "save.db") || ($composant == "edit.db")|| ($composant == "move.db")) {
        $paramsSuppl = "dbdoc=" .
                rawurlencode((int) filter_input(INPUT_GET, "dbdoc")) . "&contenu=" .
                rawurlencode(filter_input(INPUT_GET, "contenu")) . "&filename=" . rawurlencode(filter_input(INPUT_GET, "filename"))
                . "&folder=" . rawurlencode(filter_input(INPUT_GET, "folder")). "&option=". rawurlencode(filter_input(INPUT_GET, "option"));
}
    if ($composant == "delete.db") {
        $paramsSuppl = "dbdoc=" .
                rawurlencode((int) filter_input(INPUT_GET, "dbdoc"));
    }
    if($composant=="create.follow.db")
    {
            $paramsSuppl = (int)(rawurldecode(filter_input(INPUT_POST, 'dbdoc')))."&".
        (int)(rawurldecode(filter_input(INPUT_POST, 'follow')));
    }
    if($composant=="follow.db")
    {
            $paramsSuppl = (int)(rawurldecode(filter_input(INPUT_POST, 'dbdoc')))."&".
                (int)(rawurldecode(filter_input(INPUT_POST, 'follow')));
    }
if ($composant == "addAndLinkImage") {
        $paramsSuppl = "dbdoc=" .
                rawurlencode((int) filter_input(INPUT_GET, "dbdoc"));
    }

    $waiterString = ""; //Loading and not load that is definitively not the question.--MD";


echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr">
    <head>
        <title>Bloc-notes</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link rel="icon" href="/favicon.ico" />
        <link rel="shortcut icon" href="/favicon.ico" />
        <link rel="profile" href="http://microformats.org/profile/hcalendar"/>
        <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

        <script type="text/javascript" src="composant/browser/dnd.js"></script>
        <script type="text/javascript" src="js/blocnoteslib.js"></script>
        <script type="text/javascript" src="js/playerJS/dist/player-0.0.10.min.js"></script>
        <script src="js/ePub/build/epub.min.js"></script>
    </head>
    <body>
        <?php if ($composant != "") { ?>
            <!-- Barre du dessus -->
            <div id="context_menu_bar" style="background-color: blue;">
<p ><?php
                displayPath($dbdoc);
        ?>
                &nbsp;</p>
            </div>
            <?php
            }
        ?>
           <!-- Barre du dessus -->
            <div id="user_frame" ></div>
            +<!-- Barre de gauche -->
            <div id="appdoc_menu"></div>
            <!-- Barre de gauche -->
            <div id="contents"><?php echo $waiterString ?></div>
            <div id="error"><?php echo $waiterString ?></div>
            <script>
                var urlAppJS = "<?php echo $urlApp; ?>";
                $("#contents").load(url = urlAppJS + "/composant/<?php echo $composant."/contents.php?".$paramsSuppl;?>" , function (response, status, xhr) {
                    if (status == "error") {
                        var msg = "Sorry but there was an error: ";
                        $("#error").html(msg + xhr.status + " " + xhr.statusText + url);
                    }
                });
                $("#user_frame").load(url = urlAppJS + "/user.php", function (response, status, xhr) {
                    if (status == "error") {
                        var msg = "Sorry but there was an error: ";
                        $("#error").html(msg + xhr.status + " " + xhr.statusText + url);
                    }
                });
                $("#appdoc_menu").load(url = urlAppJS + "/composant/<?php echo $composant."/appdoc.php?".$paramsSuppl;?>", function (response, status, xhr) {
                    if (status == "error") {
                        var msg = "Sorry but there was an error: ";
                        $("#error").html(msg + xhr.status + " " + xhr.statusText + url);
                    }
                });
                /*$("#context_menu_bar").load(url = urlAppJS + "/composant/<?php echo $composant; ?>/menubar.php?", function (response, status, xhr) {
                    if (status == "error") {
                        var msg = "Sorry but there was an error: ";
                        $("#error").html(msg + xhr.status + " " + xhr.statusText + url + <?php echo "'Composant + " . $composant + "'"; ?>);
                    }
                });*/

            </script>
    </body>
</html>
