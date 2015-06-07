<?php
require_once("../browser/listesItem.php");

$id = (int) filter_input(INPUT_GET, "dbdoc");
connect();
$result = getDBDocument($id);


echo $id;




if ($result != NULL) {
    if (($doc = mysqli_fetch_assoc($result)) != NULL) {

        $filename = $doc['filename'];
        $content = $doc['content_file'];
        $mime = $doc['mime'];
        ?>
<br/><a href="js/ViewerJS/#<?php echo $urlApp."/composant/display/document.php?id=".$id; ?>" target="NEW" >Voir dans une nouvelle page</a>
<br/><a href="<?php echo $urlApp."/composant/display/download.php?id=".$id; ?>" target="NEW" >Télécharger l'original</a>
<br/>
<br/><iframe src = "js/ViewerJS/#<?php echo $urlApp."/composant/display/document.php?id=".$id; ?>" width='490' height='490' allowfullscreen webkitallowfullscreen></iframe>
<br/><iframe src = "js/ViewerJS/#<?php echo $urlApp."/composant/display/download.php?id=".$id; ?>" width='490' height='490' allowfullscreen webkitallowfullscreen></iframe>

 <style type="text/css">

            body {
                overflow: hidden;
            }

            #main {
                position: absolute;
                width: 100%;
                height: 100%;
            }

            #area {
                width: 80%;
                height: 80%;
                margin: 5% auto;
                max-width: 1250px;
            }

            #area iframe {
                border: none;
            }

            #prev {
                left: 40px;
            }

            #next {  
                right: 40px;
            }

            .arrow {
                position: absolute;
                top: 50%;
                margin-top: -32px;
                font-size: 64px;
                color: #E2E2E2;
                font-family: arial, sans-serif;
                font-weight: bold;
                cursor: pointer;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }

            .arrow:hover {
                color: #777;
            }

            .arrow:active {
                color: #000;
            }
        </style>
  <script>
            "use strict";

            var Book = ePub("js/ePub/reader/reader/moby-dick/");

        </script>
    </head>
    <body>
        <div id="main">
            <div id="prev" onclick="Book.prevPage();" class="arrow">‹</div>
            <div id="area"></div>
            <div id="next" onclick="Book.nextPage();" class="arrow">›</div>
        </div>

        <script>

            Book.renderTo("area");

        </script>




  <video id='video' preload="none">
    <source src="<?php echo $urlApp."/composant/dpt>
  <script>isplay/download.php?id=".$id; ?>" type="<?php echo $mime?>">
  </video>
  <script src="/dist/player.js"></scri
    var video = document.getElementById('video');
    video.load();

    var adapter = playerjs.HTML5Adapter(video);

    adapter.ready();
  </script>




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
            if (isImage(getExtension($filename), $mime)) {
                ?>
                <img src="<?php echo $urlApp . "/composant/display/contents.php?id=$id"; ?>"/>
                <?php
            } else if (isTexte(getExtension($filename), $mime)) { ?>
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
            ?>
            
?>
        </div>
<?php
        }
    }

