<?php
require_once 'config.php';
$document1 = filter_input(INPUT_GET, 'document');
$document =  rawurlencode($document1);
/* @var $_GET type */
$composant = filter_input(INPUT_GET, 'composant');

if($composant=="")
{
    $composant = "home";
}
if(!file_exists($appDir."/composant/". $composant))
{
    $composant = "pardefaut";
}
else {
    if($composant=="rename.txt")
    {
        $paramsSuppl = "&nom=".  rawurlencode(filter_input(INPUT_GET, "nom"))
            ."&classeur=".  rawurlencode(filter_input(INPUT_GET, "classeur"));
    }
    else if($composant=="save.txt")
    {
        $paramsSuppl = "&contenu=".  rawurlencode(filter_input(INPUT_GET, "contenu"))
            ."&classeur=".  rawurlencode(filter_input(INPUT_GET, "classeur"));
    }
    else if($composant=="browser")
    {
        $paramsSuppl = "&classeur=".  rawurlencode(filter_input(INPUT_GET, "classeur"));
    }
    else if(($composant=="classe.doc")||($composant=="edit.cls")||($composant=="save.cls")||($composant=="rename.cls")||($composant=="del.cls")
            ||($composant=="classement")||($composant=="classe"))
    {
            $paramsSuppl = "&classeur=".  rawurlencode(filter_input(INPUT_GET, "classeur"));
        if($composant=="rename.cls")
        {
            $paramsSuppl .= "&nom=".  rawurlencode(filter_input(INPUT_GET, "nom"))
        ."&classeur=".  rawurlencode(filter_input(INPUT_GET, "classeur"));
            }
    }
    if(($composant=="create.txt"))
    {
            $paramsSuppl = "&classeur=".  rawurlencode(filter_input(INPUT_GET, "classeur"));
    }
    
    
}

$waiterString = "";//Loading and not load that is definitively not the question.--MD";
?>

<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ; ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Bloc-notes</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link rel="icon" href="/favicon.ico" />
        <link rel="shortcut icon" href="/favicon.ico" />            
        <script type="text/javascript" src="composant/browser/dnd.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.js"></script>
    </head>
    <body>
        <!-- Barre du dessus -->
        <div id="context_menu_bar"><?php echo $waiterString ?></div>
        <!-- Barre du dessus -->
        <div id="user_frame" ><?php echo $waiterString ?></div>
        <!-- Barre de gauche -->
        <div id="appdoc_menu"><?php echo $waiterString ?></div>
        <!-- Barre de gauche -->
        <div id="contents"><?php echo $waiterString ?></div>
        <div id="error"><?php echo $waiterString ?></div>
    <script>
var urlAppJS = "<?php echo $urlApp; ?>";
$( "#contents" ).load( url=urlAppJS+"/composant/<?php echo $composant;?>/contents.php?document=<?php echo $document .$paramsSuppl; ?>" , function( response, status, xhr ) {
if ( status == "error" ) {
var msg = "Sorry but there was an error: ";
$( "#error" ).html( msg + xhr.status + " " + xhr.statusText +url);
}});
$( "#user_frame" ).load(url=urlAppJS+ "/user.php?document=<?php echo $document .$paramsSuppl; ?>", function( response, status, xhr ) {
if ( status == "error" ) {
var msg = "Sorry but there was an error: ";
$( "#error" ).html( msg + xhr.status + " " + xhr.statusText +url );
}});
$( "#appdoc_menu" ).load( url=urlAppJS+"/composant/<?php echo $composant;?>/appdoc.php?document=<?php echo $document .$paramsSuppl; ?>" , function( response, status, xhr ) {
if ( status == "error" ) {
var msg = "Sorry but there was an error: ";
$( "#error" ).html( msg + xhr.status + " " + xhr.statusText +url );
}});
$( "#context_menu_bar" ).load(url=urlAppJS+"/composant/<?php echo $composant ; ?>/menubar.php?document=<?php echo $document .$paramsSuppl;?>" , function( response, status, xhr ) {
if ( status == "error" ) {
var msg = "Sorry but there was an error: ";
$( "#error" ).html( msg + xhr.status + " " + xhr.statusText +url + <?php echo "'Composant + ".$composant+"'"; ?>);
}});
</script>
    </body>
</html>
