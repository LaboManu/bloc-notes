<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ; ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>${"page_title"}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    </head>
    <body>
        <!-- Barre du dessus -->
        <div id="context_menu_bar" style="height: 200px; background-color: #ffff00; color: #0000ff;  border: 3px #009;">${"context_menu_bar"}</div>
        <!-- Barre de gauche -->
        <div id="appdoc_menu" style="height: 800px; float: left; width: 20%; background-color: #C0C0C0; color: #0C0C0C; border: 3px #009;">${"appdoc_menu"}</div>
        <!-- Barre de gauche -->
        <div id="contents" style="height: 800px; background-color: #990000; color: #009999;  border: 3px #009;">${"contents"}</div>
    <script>
$( "#contents" ).load( "/blocnotes/app/index.php" );
</script>
    </body>
</html>
