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
require_once("pass.php");


$Tables = new DBTables(); 
$appName = "Bloc-notes";

$version = "1.1";

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
?>
<?php 

$username = $fgmembersite->FullUserName;

class DBTables
{
  public $hostname = 'manudahmen.be.mysql';
  public $username='manudahmen_be';
  public $password='Znduy32A';
  public $name='manudahmen_be';
  public $tableUsers='blocnotes_users';
  public $tableItem='blocnotes_items';

	public function addItem($tusername, $filename)
	{
		mysql_connect($this->hostname, $this->username, $this->password);
		mysql_select_db($this->name);
		 $q = "insert into blocnotes_items (user, filename) values('".$tusername."', '". 
			$filename."');";
	echo $q;
		if($this->isUserFilePairPresent($tusername, $filename)<1)


			mysql_query($q) or die("impossible de faire la requête".$q . mysql_error());

	}
	public function setPair($id1, $id2)
	{
		mysql_connect($this->hostname, $this->username, $this->password);
		mysql_select_db($this->name);
		 $q = "insert into blocnotes_relations (blocnotes_items_idblocnotes_items,blocnotes_items_idblocnotes_items1) values($id1, $id2);". 
		

			mysql_query($q) or die("impossible de faire la requête".$q . mysql_error());

	}
        public function findType($filename)
        {
            $extension = strtolower(substr($filename,-3));
            if($extension=="peg" or $extension=="jpg" or $extension=="png")
            {
                return "image";
                
            }
            else if($extension=="txt")
            {
                return "text";
            }
                
        }
	public function listItems($tusername)
	{
		mysql_connect($this->hostname, $this->username, $this->password);
		mysql_select_db($this->name);
		$result = mysql_query("select * from blocnotes_items where user='$tusername'") or die("impossible de faire la requête".mysql_error());;
		$r = array();
		

		if($result)
		{	
			 $row = mysql_fetch_assoc($result);
				$r[0] = $row;
			 $i = 0;
			while($row!=NULL)
			{
				$r[$i] = $row;
				$row = mysql_fetch_assoc($result);
				$i++;
			}

		}
		else
			return NULL;
		return $r;
	}
	public function findItemByFilename($user, $filename)
	{
		mysql_connect($this->hostname, $this->username, $this->password);
		mysql_select_db($this->name);
		$result = mysql_query("select * from blocnotes_items where user='$user' and filename='$filename'") or die("impossible de faire la requête");
		$r = array();

		if($result)
		{	
			 $row = mysql_fetch_assoc($result);
				$r[0] = $row;
			 $i = 0;
			while($row!=NULL)
			{
				$r[$i] = $row;
				$row = mysql_fetch_assoc($result);
				$i++;
			}

		}
		else
			return NULL;
		return $r;
	}

	public function isUserFilePairPresent($user, $filename)
	{
		mysql_connect($this->hostname, $this->username, $this->password);
		mysql_select_db($this->name);
		if(!($result = mysql_query("select count(*) as compte from blocnotes_items where user='$user' and filename='$filename'")))
		{
			echo mysql_error();
			die("impossible de faire la requete");
		}
		$count = mysql_fetch_array($result);
		return $count[0];

	}
        
        public function checkFileExts($filename)
        {
            $extension = substr($filename , strrpos(".",$filename)+1, -1);
            mysql_connect($this->hostname, $this->username, $this->password);
		mysql_select_db($this->name);
		if(!($result = mysql_query("select fileextensions from blocnotes_item_type")))
		{
			echo mysql_error();
			die("impossible de faire la requete");
		}
		if($result)
		{	
			while(($row = mysql_fetch_assoc($result))!=NULL)
                        {
                            $dbextension = $row['extension'];
                            if($extension==$dbextension)
                            {
                                return TRUE;
                            }
                        }
                }
                else
                {
			return NULL;
                }
        }
        public function insertNewFile($filename, $user)
        {
		mysql_connect($this->hostname, $this->username, $this->password);
		mysql_select_db($this->name);
		$q = "insert into blocnotes_version (original, revision_no, user) values('".basename($filename)."',1, '".$user."');";
                file_put_contents("/config.txt", $q);
                mysql_query($q) or die("impossible de faire la requête".$q . mysql_error());
            
        }
        public function listFiles($user)
        {
        }
        
        public function insertNewFileInFilesystem($filename, $user)
        {
            mysql_connect($this->hostname, $this->username, $this->password);
		mysql_select_db($this->name);
		$q = "insert into blocnotes_filesystem(filename, isFolder, user) values('".basename($filename)."', 0, '".$user."');";
                mysql_query($q) or die("impossible de faire la requête".$q . mysql_error());
        }
}
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
