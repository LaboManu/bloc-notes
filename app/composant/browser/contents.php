<?php 
require_once("listesItem.php");
/*
$classeur = filter_input(INPUT_GET, "classeur");
if($classeur=="")
    $classeur = null;
*/
$filtre = filter_input(INPUT_GET, "filter");


?><!--        <div>
            <a onclick="javascript:afficherNotes(true);">Afficher notes sur disque</a>
                    <a onclick="javascript:afficherNotes(false);">Masquer notes sur disque</a>
                    <a onclick="javascript:afficherNotesDB(true);">Afficher notes en DB</a>
                    <a onclick="javascript:afficherNotesDB(false);">Masquer notes en DB</a>
                <div id="listesDiv">
                        <hr/>
                        <h3>Classeurs sur disque</h3> -->
                        <form action="" method="GET">
                    <!--<div id="disclisting" class="clearBoth">
                        <?php
                            //listerTout($classeur);
                            ?></div><hr/>
                            <h3>Classeurs en base de données</h3>-->
                            <input type="text" name="filter" value="<?php echo $filtre; ?>"/>
                            <input type="hidden" name="composant" value="browser"/>
                            <div id="dblisting" class="clearBoth">
                                <?php
                                
                                connect();
                                listerNotesFromDB($filtre);    
                                ?>                        
                            </div>
                            </form>
                  