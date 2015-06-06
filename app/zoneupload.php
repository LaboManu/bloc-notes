<?PHP
require_once("access-controlled.php");
require_once("config.php");


?>
<html>
  <head>
    <!-- Load jQuery from Google's CDN -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <!-- Source our javascript file with the jQUERY code -->
    <script src="scripts/scripts.js"></script>
    <script src="./path/to/dropzone.js"></script>
  </head>
  <body>
    <h3>Choose file(s)</h3>
    <p>
      
    </p>
    <div id="mydrop" style="background-color: black; color: white; margin: 40px; height: 100px; width: 100px; background-color: #00ffff">
        
    </div>
    <form action="upload.php"
      class="dropzone"
      id="my-awesome-dropzone">
          <input id="file" name="file" type="file" multiple="true">
          <input type="submit" name="submitButton" value="Envoyer les fichiers"/>
    </form>
    <ul id="file-list">
        <script language="javascript" type="text/javascript">
            ("div#mydrop").dropzone({ url: "upload.php" });
        </script>
    	<li class="no-items">(no files uploaded yet)</li>
    </ul>
  </body>
</html>
