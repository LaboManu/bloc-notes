<?php
require_once("../browser/listesItem.php");
$dbdoc = rawurldecode(filter_input(INPUT_GET, 'dbdoc'));

    connect();
    $result = getDBDocument($dbdoc);
    if(($doc=mysqli_fetch_assoc($result))!=NULL)
    {
        $filename = $doc['filename'];
        $ext = getExtension($filename);
        if(isTexte($ext, $doc["mime"]))
        {

            ?>
        <script src="js/tinymce/jquery.tinymce.min.js"></script>
        <script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
        <!-- place in header of your html document -->
<script>
tinymce.init({
    selector: "textarea#text_editor",
    theme: "modern",
    width: 600,
    height: 500,
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
   ],

  //content_css: "js/tinymce/css/content.css",
   toolbar: "addFile insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons", 
   style_formats: [
        {title: 'Bold text', inline: 'b'},
        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
        {title: 'Table styles'},
        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    ]
 }); 
</script>
<form action="page.xhtml.php" method="GET">
    <input type="hidden" name="option" value="edit.db"/>
    <input type="hidden" name="composant" value="save.db"/>
    <input type="hidden" name="dbdoc"  value="<?php echo $dbdoc; ?>"/>
    <?php                folder_field($doc["folder_id"]); ?>
    <input type="text" name="filename"  value="<?php echo $doc['filename']; ?>"/>
    <textarea rows="12" cols="40" name="contenu" id="text_editor"><?php echo $doc["content_file"]; ?></textarea>
    <input type="submit" name="sauvegarder" value="Sauvergarder"/>
</form>
<?php
        }
         else if(isImage($ext, $doc["mime"])) {?>
<form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="save.db"/>
    <input type="hidden" name="dbdoc"  value="<?php echo $dbdoc; ?>"/>
    <?php                folder_field($doc["folder_id"]); ?>
    <input type="text" name="filename"  value="<?php echo $doc['filename']; ?>"/>
    <input type="submit" name="sauvegarder" value="Sauvergarder"/>
</form><?php
        }
        else {?>
<form action="page.xhtml.php" method="GET">
    <input type="hidden" name="composant" value="save.db"/>
    <input type="hidden" name="dbdoc"  value="<?php echo $dbdoc; ?>"/>
    <?php                folder_field($doc["folder_id"]); ?>
    <input type="text" name="filename"  value="<?php echo $doc['filename']; ?>"/>
    <input type="submit" name="sauvegarder" value="Sauvergarder"/>
</form>
        <?php
            
        }
    }    ?>
    <a href="?composant=browser&file=all&type=selection&mode=multiple&dbdoc=<?php echo $dbdoc; ?>" target="NEW">Ajouter un fichier</a>
