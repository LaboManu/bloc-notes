<h3>Choose file(s)</h3>
    <p>
      
    </p>
    <div id="mydrop" style="background-color: black; color: white; margin: 40px; height: 100px; width: 100px; background-color: #00ffff">
        
    </div>
    <form action="upload.php"
      class="dropzone"
      id="my-awesome-dropzone" method="POST" enctype="multipart/form-data">
          <input id="file" name="file[]" type="file" multiple="multiple">
                   <input type="submit" name="submitButton" value="Envoyer les fichiers"/>

    </form>
    <ul id="file-list">
    	<li class="no-items">(no files uploaded yet)</li>
    </ul>
        <script language="javascript" type="text/javascript" src="../../scripts/dropzone.js"></script>
        <script language="javascript" type="text/javascript">
            ("div#mydrop").dropzone({ url: "upload.php" });
        </script>
    
    