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

if($form=="address")
{
    if($mode=="submit")
    {
        $url = rawurldecode(filter_input(INPUT_GET, "url"));
        $data = file_get_contents($url);
        
        $mime = getUrlMimeType($url);
        if(isset($data) && isset($mime))
        {
            $idLinkedElement = createFile($filename, $mime, $data);
            createLink($dbdoc, $idLinkedElement);
        }     
    }   
    }
    ?><form action="page.xhtml.php" method="GET">
       
        <fieldset >
        <fieldset >
            <label for="url">URL de l'image</label>
            <input type="text" value="<?php echo $url?>"/>
        </fieldset>
        <input type="hidden" name="dbdoc" value="<?php echo $dbdoc;?>"/>
        <input type="hidden" name="composant" value="addAndLinkImage"/>
        <input type="hidden" name="mode" value="submit"/>
        <input type="hidden" name="form" value="address"/>
        <fieldset >
        <input type="submit" name="submit-new-link" value="Ajouter"/>
        </fieldset>
        </fieldset>
</form>
}