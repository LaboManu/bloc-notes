<?php
require_once("config.php");


function listerImage($action="list-view", $classeur=".")
{
	global $dataDir;
	global $userdataurl;
	global $userdataurl;
	global $document;
	$dirh = opendir($dataDir."/".$classeur);
	while(($f=readdir($dirh))!=NULL)
	{
	$actionurl="page.xhtml.php?composant=reader.img&document=$classeur/$f";
	if($action=="link")

{
		$actionurl .= "&documentlink=".$classeur."/".$document."";
}	
		if(strtolower(substr($f,-4)) == ".png" 
                        or strtolower(substr($f,-4) == ".jpg"))
		{?>
                    <a  class='miniImg'  href="<?= $actionurl ?>"><img src='<?= "$userdataurl/./$f" ?>' class="miniImg"><?php echo $classeur."/".$f; ?></a>
		<?php
                
                }
	}
}
function listerTexte($action="list", $classeur=".")
{
        global $urlApp;
	global $dataDir;
	global $userdataurl;
	global $document;
	global $documentlink;
	$dirh = opendir($dataDir."/".$classeur);
	while(($f=readdir($dirh))!=NULL)
	{
	$urlaction = "page.xhtml.php?composant=reader.txt&document=$classeur/$f";
	if($action=="link")

{
		$urlaction.= "&documentlink=$classeur/$f";
}	
		if(strtolower(substr($f,-4)) == ".txt")
		{?>
                    <a class='miniImg' href="<?= $urlaction ?>"><img src='<?= "$urlApp/composant/reader.txt/txt.jpg" ?>' class='miniImg' alt='Test Type File'/><?php echo $classeur."/".$f; ?></a>
		<?php
                
                }
	}
}
// Dépréciée par le développeur. Pourqoui? Inutilisée. Compliquée.
function listerBN()
{
	global $uploadDir;
	global $document;
	global $documentlink;
	global $Tables;
	global $fgmembersite;
	echo "<select id='listebn' name='listebn'>";
	
	$dirh = opendir($uploadDir);
	while(($f=readdir($dirh))!=NULL)
	{
		if($f!="." and $f!="..")
		{
			$aff  = substr($f,0,-4);
		if(true/*substr($f,-4) == ".txt" or substr($f,-4) == ".TXT" or substr($f,-4) == ".jpg" or substr($f,-4) == ".JPG"*/) 
		{
		
			 if($document==$f) 
			 {
				$selected="selected";
			 }
			 else
			 {
				$selected="";
			 }
			echo "<option name='$f' value='$f'  ".$selected." onclick=\"javascript:openblocnote('".$f."');\">Bloc-note no | $f</option>";
			
		}
		}
	}

$result = $Tables->listItems($fgmembersite->UserFullName());
if($result!=NULL)
{
$i=0;
$value = $result[$i];
print_r($value);
while ($value)
//foreach($item as $no => $value)
{
	echo "<option name=".$value['filename'].">Item : ".$value['filename'].
		" appartient à ".$value['user']."</option>";
$value = $result[$i];
$i++;
//print_r($value);
}
}
	echo "</select><button onclick=\"javascript:openblocnote(document.getElementById('listebn').value);\">Charger</button>";
}
function listerModeles3D($action="list", $classeur=".")
{
	global $dataDir;
	global $userdataurl;
	global $document;
	global $documentlink;
	$dirh = opendir($dataDir."/".$classeur);
	
	while(($f=readdir($dirh))!=NULL)
	{
	$urlaction = "page.xhtml.php?compsant=reader.stl&document=".$classeur."/".$document."";
	if($action=="link")
	{
		$urlaction .= "&documentlink=".$classeur."/".$document."";
	}

		if(strtolower(substr($f,-4)) == ".stl")
		{?>
                        <p><a href="<?= $urlaction ?>"><?= $f ?></a></p>
		<?php
                
                }
	}
    
}
?>
