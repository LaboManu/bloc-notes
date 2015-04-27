<?php
require_once("../browser/listesItem.php");

$id = (int) filter_input(INPUT_GET, "dbdoc");
connect();
$result = getDBDocument($id);


echo $id;




if ($result != NULL) {
    if (($doc = mysql_fetch_assoc($result)) != NULL) {

        $filename = $doc['filename'];
        $content = $doc['content_file'];
        ?>
        <div id="document">
            <?php 
            if (isImage(getExtension($filename))) {
                ?>
                <img src="<?php echo $urlApp . "/composant/display/contents.php?id=$id"; ?>"/>
                <?php
            }
            ?>
        </div>
        <ul>
            <li><a href="#">Modifier</a></li>
            <li><a href="#">Voir</a></li>
        </ul>

        <?php if (isTexte(getExtension($filename))) { ?>
            <script type="text/javascript">
                var urlAppJS = "<?php echo $urlApp; ?>";
                $("#document").load(url = urlAppJS + "/composant/display/contents.php?id=<?php echo $id; ?>", function (response, status, xhr) {
                    if (status == "error") {
                        var msg = "Sorry but there was an error: ";
                        $("#error").html(msg + xhr.status + " " + xhr.statusText + url);
                    }
                });

            </script>
            <?php
        }
    }
}
?>