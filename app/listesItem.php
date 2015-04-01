<?php
require_once("config.php");


function listerImage($action="list-view")
{
	global $dataDir;
	global $userdataurl;
	global $userdataurl;
	global $bnf;

	$dirh = opendir($dataDir);
	while(($f=readdir($dirh))!=NULL)
	{
	$actionurl="page.xhtml.php?composant=reader.img&bnf=$f";
	if($action=="link")

{
		$actionurl .= "&bnflink=$bnf";
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
	global $bnf;
	global $bnflink;
	$dirh = opendir($dataDir);
	while(($f=readdir($dirh))!=NULL)
	{
	$urlaction = "page.xhtml.php?composant=reader.txt&bnf=$bnf";
	if($action=="link")

{
		$urlaction.= "&bnflink=$bnf";
}	
		if(strtolower(substr($f,-4)) == ".txt")
		{?>
                    <a href="<?= $urlaction ?>"><img src='<?= "$urlApp/composant/reader.txt/txt.jpg" ?>' height='100px' width='100px'><?= $f ?></a>
		<?php
                
                }
	}
}
function listerBN()
{
	global $uploadDir;
	global $bnf;
	global $bnflink;
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
		
			 if($bnf==$f) 
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
	global $bnf;
	global $bnflink;
	$dirh = opendir($dataDir);
	
	while(($f=readdir($dirh))!=NULL)
	{
	$urlaction = "page.xhtml.php?compsant=reader.stl&bnf=$bnf";
	if($action=="link")
	{
		$urlaction .= "&bnflink=$bnf";
	}

		if(strtolower(substr($f,-4)) == ".stl")
		{?>
                        <p><a href="<?= $urlaction ?>"><?= $f ?></a></p>
		<?php
                
                }
	}
    
}
?>
