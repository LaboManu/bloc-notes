<?php
$class1 = filter_input(INPUT_GET, "classeur");
$classeur = substr($class1, 5)  ;
?>
<ul>
    
<!--
<?php
if($classeur!="")
{
    ?>
<li class="button_appdoc" ><a class="button_appdoc" href="?composant=create.txt&document=note&classeur=<?php echo $classeur; ?>">Ajouter une note dans le classeur <?php echo $classeur; ?></a></li>
    <?php

}
?>
<li class="button_appdoc"><a class="button_appdoc" href="javascript:alert('Clic sur fichier pour visualiser puis editer, modifier, supprimer, classer')">Modifier une note</a></li>
<li class="button_appdoc"><a class="button_app  doc" href="?composant=create.cls">Créer un classement</a></li>
<li class="button_appdoc"><a class="button_appdoc" href="#404">Trier les notes</a></li>
<li class="button_appdoc"><a class="button_appdoc" href="#404">Chercher une note</a></li>
<?php
if($classeur!="")
{
    ?>
<li class="button_appdoc"><a href="?composant=edit.cls&classeur=<?php echo $classeur; ?>">Modifier classeur</a></li>
    <?php

}
?>
<li class="button_appdoc"><a onclick="classeSelection()">Classer sélection</a></li>
</ul>
-->
<ul>
<li class="button_appdoc"><a href="?composant=create.db">Créer un élément en base de données</a></li>
<li class="button_help"><a href="?help=assemble">Aide : assembler dss données</a></li>
</ul>