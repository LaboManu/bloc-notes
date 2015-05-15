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
<a href="js/ViewerJS/#<?php echo $urlApp."/composant/display/document.php?id=".$id; ?>" target="NEW" >Voir dans une nouvelle page</a>
<iframe src = "js/ViewerJS/#<?php echo $urlApp."/composant/display/document.php?id=".$id; ?>" width='490' height='490' allowfullscreen webkitallowfullscreen></iframe>
<div id="document_time">
    <table>
    <?php 
    echo "<tr><td>Date de modification :</td><td>".$doc["quand"] ."</td></tr>";
    echo "<tr><td>Date de création</td><td>". (($doc["quand"]!="")?date("Y-m-d H:j:s", strtotime($doc["quand"])):" Date de modification inconnue".date("F j, Y-m-d H:i:s a", time()))."</td></tr>";
    ?>
    </table>

</div>
        <div id="document">
            <?php 
            if (isImage(getExtension($filename), $doc['mime'])) {
                ?>
                <img src="<?php echo $urlApp . "/composant/display/contents.php?id=$id"; ?>"/>
                <?php
            } else if (isTexte(getExtension($filename), $doc['mime'])) { ?>
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
        </div>
