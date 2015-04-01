<html>
<head>
    <title>View saved image</title>
</head>
<body bgcolor="#e0e0e0">
<?php
    if (isset($_POST['image_data'])) {
	$filename = time().'.png';
    	if ($fp = fopen($filename,"wb")) {

    	    // decode from base64 and write to the file
    	    $bin_image = base64_decode(chunk_split($_POST['image_data']));
    	    fwrite($fp,$bin_image);
    	    fclose($fp);

	    // display it on the page
   	    echo "<h3>The image has been saved on the server as $filename</h3>";
   	    echo "<img src=\"$filename\" border=1>";
    	}
    	else
    	    echo("Can't open $filename for writing\n");
    }
    else
        echo("image_data is not passed in the request\n");
?>
</body>
</html>
