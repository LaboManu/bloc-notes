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
        $paramsSuppl = "&nom=".  rawurlencode(filter_input(INPUT_GET, "nom"));
    }
    else if($composant=="save.txt")
    {
        $paramsSuppl = "&contenu=".  rawurlencode(filter_input(INPUT_GET, "contenu"));
    }
    
    
}
?>

<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ; ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Bloc-notes 2.0 alpha</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    </head>
    <body>
        <!-- Barre du dessus -->
        <div id="user_frame" style="float: right; height: 50px; background-color: #00ffff; color: #ff0000;  border: 3px #009;">${"user_frame"}</div>
        <!-- Barre du dessus -->
        <div id="context_menu_bar" style="height: 200px; background-color: #ffff00; color: #0000ff;  border: 3px #009;">${"context_menu_bar"}</div>
        <!-- Barre de gauche -->
        <div id="appdoc_menu" style="height: 800px; float: left; width: 20%; background-color: #C0C0C0; color: #0C0C0C; border: 3px #009;">${"appdoc_menu"}</div>
        <!-- Barre de gauche -->
        <div id="contents" style="height: 800px; background-color: #990000; color: #009999;  border: 3px #009;">${"contents"}</div>
        <div id="error"></div>
    <script>
var urlAppJS = "<?php echo $urlApp; ?>";
$( "#contents" ).load( url=urlAppJS+"/composant/<?php echo $composant;?>/contents.php?document=<?php echo $document .$paramsSuppl; ?>" , function( response, status, xhr ) {
if ( status == "error" ) {
var msg = "Sorry but there was an error: ";
$( "#error" ).html( msg + xhr.status + " " + xhr.statusText +url);
}});
$( "#user_frame" ).load(url=urlAppJS+ "/user.php?document=<?php echo $document; ?>", function( response, status, xhr ) {
if ( status == "error" ) {
var msg = "Sorry but there was an error: ";
$( "#error" ).html( msg + xhr.status + " " + xhr.statusText +url );
}});
$( "#appdoc_menu" ).load( url=urlAppJS+"/composant/<?php echo $composant;?>/appdoc.php?document=<?php echo $document; ?>" , function( response, status, xhr ) {
if ( status == "error" ) {
var msg = "Sorry but there was an error: ";
$( "#error" ).html( msg + xhr.status + " " + xhr.statusText +url );
}});
$( "#context_menu_bar" ).load(url=urlAppJS+"/composant/<?php echo $composant ; ?>/menubar.php?document=<?php echo $document; ?>" , function( response, status, xhr ) {
if ( status == "error" ) {
var msg = "Sorry but there was an error: ";
$( "#error" ).html( msg + xhr.status + " " + xhr.statusText +url );
}});
</script>
    </body>
</html>
