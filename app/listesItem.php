<?php
require_once("config.php");


function listerImage($action="list-view")
{
	global $dataDir;
	global $userdataurl;
	global $userdataurl;
	global $document;

	$dirh = opendir($dataDir);
	while(($f=readdir($dirh))!=NULL)
	{
	$actionurl="page.xhtml.php?composant=reader.img&document=$f";
	if($action=="link")

{
		$actionurl .= "&documentlink=$document";
}	
		if(strtolower(substr($f,-4)) == ".png" 
                        or strtolower(substr($f,-4) == ".jpg"))
		{?>
                    <a href="<?= $actionurl ?>"><img src='<?= "$userdataurl/$f" ?>' height='100px' width='100px'><!--<?= $f ?>--></a>
		<?php
                
                }
	}
}
function listerTexte($action="list")
{
        global $urlApp;
	global $dataDir;
	global $userdataurl;
	global $document;
	global $documentlink;
	$dirh = opendir($dataDir);
	while(($f=readdir($dirh))!=NULL)
	{
	$urlaction = "page.xhtml.php?composant=reader.txt&document=$f";
	if($action=="link")

{
		$urlaction.= "&documentlink=$f";
}	
		if(strtolower(substr($f,-4)) == ".txt")
		{?>
                    <a href="<?= $urlaction ?>"><img src='<?= "$urlApp/composant/reader.txt/txt.jpg" ?>' height='100px' width='100px'><?php echo $f; ?></a>
		<?php
                
                }
	}
}
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
function listerModeles3D($action="list")
{
	global $dataDir;
	global $userdataurl;
	global $document;
	global $documentlink;
	$dirh = opendir($dataDir);
	
	while(($f=readdir($dirh))!=NULL)
	{
	$urlaction = "page.xhtml.php?compsant=reader.stl&document=$document";
	if($action=="link")
	{
		$urlaction .= "&documentlink=$document";
	}

		if(strtolower(substr($f,-4)) == ".stl")
		{?>
                        <p><a href="<?= $urlaction ?>"><?= $f ?></a></p>
		<?php
                
                }
	}
    
}
?>
