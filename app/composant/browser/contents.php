<?php 
require_once("listesItem.php");

$classeur = filter_input(INPUT_GET, "classeur");
if($classeur=="")
    $classeur = null;
?>
<!--
        <div>
                    <a onclick="javascript:afficherListes(true);">Afficher listes</a>
                    <a onclick="javascript:afficherListes(false);">Masquer listes</a>
                <div id="listesDiv">
                    <a onclick="javascript:afficherImages(true);">Afficher images</a>
                    <a onclick="javascript:afficherImages(false);">Masquer images</a>
                    <div id="imagesDiv">
                        <?php
                            //listerImage();
                        ?>                        
                    </div>
                    <a onclick="javascript:afficherTextes(true);">Afficher Textes</a>
                    <a onclick="javascript:afficherTextes(false);">Masquer Textes</a>
                    <div id="textesDiv">
                        <?php
                            //listerTexte();
                        ?>                        
                    </div>
                    <a onclick="javascript:afficherModeles3D(true);">Afficher Mod&egrave;les 3D</a>
                    <a onclick="javascript:afficherModeles3D(false);">Masquer Mod&egrave;les 3D</a>
                    <div id="Modeles3DDiv">
                        <?php
                            //listerModeles3D();
                        ?>                        
                    </div>
                </div>
        </div>
<!---->
        <div>
                    <a onclick="javascript:afficherListes(true);">Afficher listes</a>
                    <a onclick="javascript:afficherListes(false);">Masquer listes</a>
                <div id="listesDiv">
                    <div id="imagesDiv">
                        <form action="?composant=classerPlus" method="GET">
                        <?php
                        
                            listerTout($classeur);
                            ?><div id="bdblisting">
                                <?php
                                connect();
                                listerNotesFromDB();    
                                ?>                        
                            </div>
                            </form>
                    </div>
                        
                    </div>
                </div>
        </div>

