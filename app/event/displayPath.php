<?php

require_once 'main.php';

function getPathArray($id) {
    $parray = array();
    
    $folder_id = -1;
    
        $i = 0;
    while(($id!=0) && ($folder_id!=$id)) {
        $res0 = getDBDocument($id);
	   $id = $folder_id;
	   if(($doc=  mysqli_fetch_assoc($res0))!=NULL)
        {
            $filename = $doc["filename"];
        	 $folder_id = $doc["folder_id"];
            $parray[$i++] = $filename;
        
        }
		else
		{
			$folder_id = NULL;
		}
    }
    return $parray;
}

function displayPath($id)
{
return;
    $parray_fn = getPathArray($id);
    
    echo "<div class='path_array'>";
    
    foreach($parray_fn as $i => $filename)
    {
        echo "<span class='path_array'>".$filename."</span>";
    }
    
    echo "</div>";
    
}
    