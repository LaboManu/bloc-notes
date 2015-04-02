<?PHP
require_once("config.php");
require_once("include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>Bloc-notes</title>
      <link rel="STYLESHEET" type="text/css" href="css/style.css"/>
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
function openblocnote(f)
{
	document.location.replace(url+'?document='+f);
	
}
function htmlView()
{
h=document.getElementById("HtmlView");
h.style.display="Block";
ed = document.getElementById("EditView");
h.innerHTML = 
ed.value
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

</head>
<body>
<div class="mainmenu" style="float: left;">

<img src="images/logo-blocnotes-128.png"/><?php echo $appName . " " . $version ?>
<ul id='fg_membersite_content' class="mainmenu">
<li>
<a href="page.xhtml.php?composant=browser">Explorer</a>
</li>
<li>
<a href="page.xhtml.php?composant=upload">Upload files</a>
</li>
</ul>
</div>
</span>

</body>
</html>
