<?PHP
require_once("config.php");

require_once("access-controlled.php");
require_once("listesItem.php");

	$isNew = false;
	$cmd = $_POST['cmd'];
	$id = $_POST['id'];
	$document = $_POST['document'];
	$download = $_GET['download'];
	$document_new=$_POST['document_new'];
	$cmdexec = $_POST['cmdexec'];
	$download = $_POST['download'];
	$rename = $_POST['rename'];
	$rename_to = $_POST['rename_to'];
	if($document=="")
	{
		$document = $_GET['document'];
	}
	

?>
<input type="text" name="document"   value="<?php echo "$document"; ?>" />
            <?php if($Tables->findType($document)=="text"){?>
 	<textarea id="EditView" name="content" rows="25" cols="80">
          <?php echo $content; ?>

        </textarea><br/><div id="HtmlView"></div><?php }    ?>
            <?php if($Tables->findType($document)=="image"){?>
              <img src="<?php echo $userdataurl.$pathSep.$document ; ?>"/>
            <?php }?>
<?php
listerImage("link");
listerTexte("link");
?>