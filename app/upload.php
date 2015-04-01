<?PHP

require_once("./include/membersite_config.php");
require_once("config.php");

$o = new stdClass();

if (!$fgmembersite->CheckLogin()) {
    echo "null";

    exit;
}
$user = $fgmembersite->UserFullName();


$url = "$uploadDir/";
// !empty( $_FILES ) is an extra safety precaution
// in case the form's enctype="multipart/form-data" attribute is missing
// or in case your form doesn't have any file field elements
if( strtolower( $_SERVER[ 'REQUEST_METHOD' ] ) == 'post' && !empty( $_FILES ) )
{
    foreach( $_FILES as $index => $array )
    {
        //if( empty( $array[ 'error' ] ) )
       // {
            // some error occured with the file in index $index
            // yield an error here
       //     return false; // return false also immediately perhaps??
       // }

        /*
            edit: the following is not necessary actually as it is now 
            defined in the foreach statement ($index => $tmpName)

            // extract the temporary location
            $tmpName = $_FILES[ 'image' ][ 'tmp_name' ][ $index ];
        */

        // check whether it's not empty, and whether it indeed is an uploaded file
        //if( !empty( $array['tmpName'] ) && is_uploaded_file( $array['tmpName'] ) )
        //{
            // the path to the actual uploaded file is in $_FILES[ 'image' ][ 'tmp_name' ][ $index ]
            // do something with it:
           $url.= $array['name'];
            move_uploaded_file( $array['tmpName'], $url); // move to new location perhaps?
        //}
    }
}
print $url;
print_r($_FILES);

?>