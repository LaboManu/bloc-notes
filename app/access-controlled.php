<?PHP
require_once("config.php");
require_once("include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}/*
      <script language="javascript" type="text/javascript" >
        url = "<?php echo $urldir; ?>";
        function erreurs()
        {
	var showErrors = ~showErrors;
        var elem = document.getElementById('code');
	if(showErrors)
	{
		elem.style.display='block';
	}
	else
	{
		elem.style.display='none';
	}
}

function afficherNotes(affImages)
{
        var elem = document.getElementById('disclisting');
	if(affImages)
	{
		elem.style.display='block';
	}
	else
	{
		elem.style.display='none';
	}
}
function afficherNotesDB(bdblistingDB)
{
        var elem = document.getElementById('dblisting');
	if(bdblistingDB)
	{
		elem.style.display='block';
	}
	else
	{
		elem.style.display='none';
	}
}
function afficherImages(affImages)
{
        var elem = document.getElementById('imagesDiv');
	if(affImages)
	{
		elem.style.display='block';
	}
	else
	{
		elem.style.display='none';
	}
}
function afficherTextes(affTextes)
{
	var elem = document.getElementById('textesDiv');
	if(affTextes)
	{
		elem.style.display='block';
	}
	else
	{
		elem.style.display='none';
	}
}
function afficherModeles3D(affTextes)
{
	var elem = document.getElementById('Modeles3DDiv');
	if(affTextes)
	{
		elem.style.display='block';
	}
	else
	{
		elem.style.display='none';
	}
}
function afficherListes(affListes)
{
	var elem = document.getElementById('listesDiv');
	if(affListes)
	{
		elem.style.display='block';
	}
	else
	{
		elem.style.display='none';
	}
}
</script>
<div class="mainmenu" style="float: left;">

<img src="images/logo-blocnotes-128.png"/><?php echo $appName ; ?>


<ul id='fg_membersite_content' class="mainmenu">
<li>
<a class="button_appdoc" href="page.xhtml.php?composant=browser" title="Explorer les notes et les images">Explorer</a>
</li>
<li>
<a class="button_appdoc" href="page.xhtml.php?composant=upload" title="Uploader des fichiers textes (*.txt) et images (jpg, png, gif) et autres fichiers">Téléverser</a>
</li>
</ul>
 */?>