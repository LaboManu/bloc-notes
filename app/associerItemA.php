<?PHP
require_once("config.php");

require_once("access-controlled.php");
require_once("listesItem.php");

	$isNew = false;
	$cmd = $_POST['cmd'];
	$id = $_POST['id'];
	$bnf = $_POST['bnf'];
	$download = $_GET['download'];
	$bnf_new=$_POST['bnf_new'];
	$cmdexec = $_POST['cmdexec'];
	$download = $_POST['download'];
	$rename = $_POST['rename'];
	$rename_to = $_POST['rename_to'];
	if($bnf=="")
	{
		$bnf = $_GET['bnf'];
	}
	

?>
<input type="text" name="bnf"   value="<?php echo "$bnf"; ?>" />
            <?php if($Tables->findType($bnf)=="text"){?>
 	<textarea id="EditView" name="content" rows="25" cols="80">
          <?php echo $content; ?>

        </textarea><br/><div id="HtmlView"></div><?php }    ?>
            <?php if($Tables->findType($bnf)=="image"){?>
              <img src="<?php echo $userdataurl.$pathSep.$bnf ; ?>"/>
            <?php }?>
<?php
listerImage("link");
listerTexte("link");
?>