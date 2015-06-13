<?php
require_once("../browser/listesItem.php");

$dbdoc = (int) filter_input(INPUT_GET, "dbdoc");
$viewer = (int) filter_input(INPUT_GET, "viewer");
if($viewer==0)
{
    $viewer=2;
}

connect();
$result = getDBDocument($dbdoc);


echo $dbdoc;




if ($result != NULL) {
    if (($doc = mysqli_fetch_assoc($result)) != NULL) {

        $filename = $doc['filename'];
        $content = $doc['content_file'];
        $mime = $doc['mime'];
    }
    else {
        die("404 Fichier non trouvé");
    }
}
else {
    die("404 Fichier non trouvé");
    
}


$ReaderurlSchema = "?composant=reader.db&dbdoc=$dbdoc&viewer=";
        ?>
<ol>
    <li><a href="<?php echo $ReaderurlSchema."1" ; ?>">Multimedia (film)</a></li>
    <li><a href="<?php echo $ReaderurlSchema."2" ; ?>">PDF With inclusions</a></li>
    <li><a href="<?php echo $ReaderurlSchema."3" ; ?>">ePub document Moby Dick</a></li>
    <li><a href="<?php echo $ReaderurlSchema."4" ; ?>">IFrame 4</a></li>
    <li><a href="<?php echo $ReaderurlSchema."5" ; ?>">IFrame 5</a></li>
</ol>
<div class="doc_container">
<div id="document_time" style="float:left; width: 200px; border: 1px solid red;">
    <table>
    <?php 
    echo "<tr><td>Date de modification :</td><td>".$doc["quand"] ."</td></tr>";
    echo "<tr><td>Date de création</td><td>". (($doc["quand"]!="")?date("Y-m-d H:j:s", strtotime($doc["quand"])):" Date de modification inconnue".date("F j, Y-m-d H:i:s a", time()))."</td></tr>";
    ?>
    </table>
    <table>
    <?php 
    echo "<tr><td>Nom du fichier</td><td>".$doc["filename"]."</td></tr>";
    echo "<tr><td>Type de fichier</td><td>". ($doc["mime"])."</td></tr>";
    ?>
    </table>

</div>
    <script language="javascript" type="text/javascript">
function listReadersCount() {
    return 3;
}
var arr = new Array();


function chooseReader(idx) {
    var i;
    for(i = 1; i<=listReadersCount(); i++)
    {
        var currentReader = document.getElementById("reader"+i);
        if(i===idx)
        {
            if(!arr[i])
            {
                arr [i] = currentReader.innerHTML
            }
            currentReader.innierHTML=arr[i];
        }
        else
        {
            if(!arr[i])
            {
                arr [i] = currentReader.innerHTML
            }
            currentReader.innierHTML="";
        }
    }
}
chooseReader(0);
</script>
<ol id="listOfReaders">
     <li id='reader1'>
<?php if($viewer==1){ ?>
  <video id='video' preload="none">
    <source src="<?php echo $urlApp."/composant/display/download.php?id=".$dbdoc; ?>" type="<?php echo $mime?>">
  </video>
  <script src="<?php echo $urlApp."/"; ?>js/playerJS/dist/player-0.0.10.js"></scri
    var video = document.getElementById('video');
    video.load();

    var adapter = playerjs.HTML5Adapter(video);

    adapter.ready();
    
    video.play();
  </script>

    <?php } ?>
</li>

     <li id='reader2'>
<?php if($viewer==2){ 
    
     displayNote($dbdoc);
}
?>

</li>
     <li id='reader3'>
<?php if($viewer==3){ 
    if($doc["mime"]!="text/plain")
    {            
        echo "<p><em>".($doc["filename"])."</em></p>";
    
    }?>
         <script src="<?php echo $urlApp ; ?>/js/ePub/build/epub.min.js" language="JavaScript" type="text/javascript"></script>
         <script src="<?php echo $urlApp ; ?>/js/ePub/build/hooks.min.js" language="JavaScript" type="text/javascript"></script>
         <script src="<?php echo $urlApp ; ?>/js/ePub/build/reader.min.js" language="JavaScript" type="text/javascript"></script>
         <script src="j<?php echo $urlApp ; ?>/js/ePub/build/libs/zip.min.js" language="JavaScript" type="text/javascript"></script>
          <script>
            var Book = ePub(<?php echo $urlApp ; ?>"/js/ePub/reader/moby-dick.epub");
        </script>
         <div id="area"></div>
        <div id="main">
            <div id="prev" onclick="Book.prevPage();" class="arrow">‹</div>
            <div id="area"></div>
            <div id="next" onclick="Book.nextPage();" class="arrow">›</div>
        </div>

        <script>

            Book.renderTo("area");

        </script>
    <?php } ?>
        </li>
    <li id='reader4'>
<?php if($viewer==4){ ?>
<br/><iframe src = "js/ViewerJS/#<?php echo $urlApp."/composant/display/document.php?id=".$dbdoc; ?>" width='490' height='490' allowfullscreen webkitallowfullscreen></iframe>
    <?php } ?>
</li>
<li id='reader5'>
    <?php if($viewer==5){ ?>

<br/><iframe src = "js/ViewerJS/#<?php echo $urlApp."/composant/display/download.php?id=".$dbdoc; ?>" width='490' height='490' allowfullscreen webkitallowfullscreen></iframe>
    <?php } ?>
</li>
</ol>



</div>

<?php

$elemSuite = getFollowings($dbdoc);
if($elemSuite==NULL)
{
  echo "Pas d'éléments suivants ou erreur";  
}
else
{
while ($row = mysqli_fetch_assoc($elemSuite)) {
    displayNote($row["id"]);
    echo "displayNote ".$row["id"];
}
}

?>