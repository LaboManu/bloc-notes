<?PHP


require_once("pass.php");
/**

Defined in pass.php:
$appDir = <Local directory of app Example: '/var/www/htdocs/blocnotes/app'>

$hostname = 'localhost';
$username='';
$password='';
$name=''; /// database name


?>

**/


require_once("event/DB.tables.file.php");

$appName = "Bloc-notes";

$version = "2.0 beta 2";

$pathSep = "/";

global $appDir;

$tmpDir = $appDir."/tmp";

$allUserDataDir = $appDir."/data";
$allUserPublicDir = $appDir."/public";
require_once("globals-parameters.php");


require_once("$appDir/app/include/membersite_config.php");


if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

$monutilisateur = $fgmembersite->UserFullName();

$dataDir = $allUserDataDir . "/" . $fgmembersite->UserFullName();
$publicDir = $allUserPublicDir . "/" . $fgmembersite->UserFullName();
$appDirScript = $appDir = $appDir."/"."app";

if(!file_exists($dataDir)) {mkdir($dataDir);}
if(!file_exists($publicDir)) {mkdir($publicDir);}

$urldir = "http://manudahmen.be/blocnotes/app/index.php";

$uploadDir = $dataDir;

$urlbase = "http://manudahmen.be/blocnotes";
$urlApp = $urlbase.$pathSep."app";

$userdataurl= $urlbase.'/data/'.$fgmembersite->UserFullName();
$userpublicurl= $urlbase.'/public/'.$fgmembersite->UserFullName();

$trad = array(
	"CMD" => array(
		"NEW" => "Nouveau fichier",
		"SAVE" => "Sauvegarder",
		"DELETE" => "Supprimer",
		"RENAME_FORM" => "Renommer",
		"RENAME" => "Renommer (confirmation)",
		"DOWNLOAD" => "Telecharger",
		"DISPLAY" => "Afficher"
	),
	"DOWNLOAD" => "download",
	"PAGES" => array(
		"SIGNUP_FORM" => "Sign up"
	)
);
$file_ext = array(
	"TEXT" => array (
		"Texte simple" => "TXT"
	)
);
$FILE_THUMB_MAXLEN = 256;