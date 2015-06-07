<?PHP




require_once(__DIR__."/pass.php");
/**

Defined in pass.php:
$appDir = <Local directory of app Example: '/var/www/htdocs/blocnotes/app'>

$hostname = 'localhost';
$username='';
$password='';
$name=''; /// database name


?>

**/
require_once(__DIR__."/lib/anchor.class.php");
require_once(__DIR__."/lib/dbconnection.class.php");
require_once(__DIR__."/lib/note.class.php");
require_once(__DIR__."/lib/image.class.php");
require_once(__DIR__."/lib/share.class.php");
require_once(__DIR__."/lib/text.class.php");
require_once(__DIR__."/lib/download.php");


$appName = "";

$version = "2.0";

$pathSep = "/";

global $appDir;

$tmpDir = $appDir."/tmp";

$allUserDataDir = $appDir."/data";
$allUserPublicDir = $appDir."/public";


require_once(__DIR__."/include/membersite_config.php");


if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

$monutilisateur = $fgmembersite->UserFullName();

$dataDir = $allUserDataDir . "/" . $fgmembersite->UserFullName();
$publicDir = $allUserPublicDir . "/" . $fgmembersite->UserFullName();
$appDirScript = $appDir = $appDir."/"."app";



$uploadDir = $dataDir;

$urlbase = "http://manudahmen.be/blocnotes";
$urlApp = $urlbase.$pathSep."app";
$urldir = "$urlApp/app/page.xhtml.php";

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


function getClasseurFromFullname($document)
{
    $pos=strpos($document, "/");
    if($pos==FALSE)
    {
        return NULL;
    }
    return substr(substr($document, 0, $pos), 5);
}
function getDocumentFromFullname($document)
{
    $pos=strpos($document, "/");
    if($pos==FALSE)
    {
        return $document;
    }
    return substr($document, $pos+1);
            
}
mb_internal_encoding('UTF-8');
setlocale(LC_CTYPE, 'fr_FR.UTF-8');