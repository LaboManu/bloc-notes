<?PHP

require_once("config.php");

require_once("access-controlled.php");


$filename = $_GET['filename'];

$source = $dataDir."/".$filename;
$dest = $publicDir."/".$filename;


$data = file_get_contents($source);
file_put_contents($dest, $data);

?>
