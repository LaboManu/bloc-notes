<?php 
require_once("listesItem.php");

$classeur = filter_input(INPUT_GET, "classeur");
if($classeur=="")
    $classeur = null;
?>        <div>
            <a onclick="javascript:afficherNotes(true);">Afficher notes sur disque</a>
                    <a onclick="javascript:afficherNotes(false);">Masquer notes sur disque</a>
                    <a onclick="javascript:afficherNotesDB(true);">Afficher notes en DB</a>
                    <a onclick="javascript:afficherNotesDB(false);">Masquer notes en DB</a>
                <div id="listesDiv">
                        <hr/>
                        <h3>Classeurs sur disque</h3>
                        <form action="?composant=classerPlus" method="GET">
                    <div id="disclisting" class="clearBoth">
                            
                        <?php
                            listerTout($classeur);
                            ?></div><hr/>
                            <h3>Classeurs en base de données</h3>
                            <div id="dblisting" class="clearBoth">
                                <?php
                                connect();
                                listerNotesFromDB($classeur);    
                                ?>                        
                            </div>
                            </form>
                    </div>
                        
                    </div><script>
 
