<?PHP

require_once("config.php");

require_once("access-controlled.php");


$result = $Tables->listItems($fgmembersite->UserFullName());
if($result!=NULL)
{
$i=0;
$value = $result[$i];
print_r($value);
while ($value)
//foreach($item as $no => $value)
{
	echo "<li>Item : ".$value['filename']." appartient à ".$value['user']."</li>";
$value = $result[$i];
$i++;
//print_r($value);
}
}
?>
