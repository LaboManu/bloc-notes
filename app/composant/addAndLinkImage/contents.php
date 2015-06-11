<?php
require_once '../../all-configured-and-secured-included.php';


if(isset($_POST["form"]))
{
    $dbdoc = rawurldecode(filter_input(INPUT_POST, "dbdoc"));
    $mode = rawurldecode(filter_input(INPUT_POST, "mode"));
    $form = rawurldecode(filter_input(INPUT_POST, "form"));
}
else
{
    $dbdoc = rawurldecode(filter_input(INPUT_GET, "dbdoc"));
    $mode = rawurldecode(filter_input(INPUT_GET, "mode"));
    $form = rawurldecode(filter_input(INPUT_GET, "form"));
}
?>
<a target="NEW" href="?composant=addAndLinkImage&mode=showform&form=address" accesskey="a"><img src="images/image.jpg"/>Introduire une image par adresse</a>

<a target="NEW" href="?composant=addAndLinkImage&mode=showform&form=remote" accesskey="a"><img src="images/image.jpg"/>Parcourir sur Bloc-notes</a>

<a target="NEW" href="?composant=addAndLinkImage&mode=showform&form=local" accesskey="a"><img src="images/image.jpg"/>Parcours local</a>

<a target="NEW" href="?composant=addAndLinkImage&mode=showform&form=webcam" accesskey="a"><img src="images/image.jpg"/>Prendre un cliché</a>

<?php 
function imageCreateFromAny($filepath) { 
    $type = exif_imagetype($filepath); // [] if you don't have exif you could use getImageSize() 
    $allowedTypes = array( 
        1,  // [] gif 
        2,  // [] jpg 
        3,  // [] png 
        6   // [] bmp 
    ); 
    if (!in_array($type, $allowedTypes)) { 
        return false; 
    } 
    switch ($type) { 
        case 1 : 
            $im = imageCreateFromGif($filepath); 
        break; 
        case 2 : 
            $im = imageCreateFromJpeg($filepath); 
        break; 
        case 3 : 
            $im = imageCreateFromPng($filepath); 
        break; 
        case 6 : 
            $im = imageCreateFromBmp($filepath); 
        break; 
    }    
    return $im;  
} 

if($form=="address")
{
    if($mode=="submit")
    {
        $url = rawurldecode(filter_input(INPUT_GET, "url"));
        imageCreateFromAny($url);
    }   
    }
    ?><form action="?composant=addAndLinkImage&mode=submit&form=address" method="GET">
       
        <fieldset >
            <label for="url">URL de l'image</label>
            <input type="text" value="<?php echo $url?>"/>
        </fieldset>
        <input type="hidden" value="<?php echo $dbdoc;?>"/>
        <input type="submit" name="submit-new-link" value="Ajouter"/>
</form>
}