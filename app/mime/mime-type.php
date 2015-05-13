<?php
require_once("../config.php");

connect();
$id =(int)$type = rawurldecode(filter_input(INPUT_GET, "id"));

$r = getDBDocument($id);
if(($doc=mysql_fetch_assoc($r))!=NULL)
{
    echo get_mime($doc["filename"]);
}

function get_mime($file) {
  if (function_exists("finfo_file")) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
    $mime = finfo_file($finfo, $file);
    finfo_close($finfo);
    return $mime;
  } else if (function_exists("mime_content_type")) {
    return mime_content_type($file);
  } else if (!stristr(ini_get("disable_functions"), "shell_exec")) {
    // http://stackoverflow.com/a/134930/1593459
    $file = escapeshellarg($file);
    $mime = shell_exec("file -bi " . $file);
    return $mime;
  } else {
    return false;
  }
}

?>
<div id="mime_file"></div>
<script type="text/javascript">
                var urlAppJS = "<?php echo $urlApp; ?>";
                $("#mime_file").load(url = urlAppJS + "/composant/display/contents.php?id=<?php echo $id; ?>", function (response, status, xhr) {
                    if (status == "error") {
                        var msg = "Sorry but there was an error: ";
                        $("#error").html(msg + xhr.status + " " + xhr.statusText + url);
                    }
                });

            </script>