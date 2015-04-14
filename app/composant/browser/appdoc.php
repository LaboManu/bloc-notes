<ul>
    

<li class="button_appdoc" ><a class="button_appdoc" href="?composant=create.txt&document=note">Ajouter une note</a></li>
<li class="button_appdoc"><a class="button_appdoc" href="javascript:alert('Clic sur fichier pour visualiser puis editer, modifier, supprimer, classer')">Modifier une note</a></li>
<li class="button_appdoc"><a class="button_app  doc" href="?composant=create.cls">Créer un classement</a></li>
<li class="button_appdoc"><a class="button_appdoc" href="#404">Trier les notes</a></li>
<li class="button_appdoc"><a class="button_appdoc" href="#404">Chercher une note</a></li>
<?php
$class1 = filter_input(INPUT_GET, "classeur");
$classeur = substr($class1, 5)  ;
if($classeur!="")
{
    ?>
<li class="button_appdoc"><a href="?composant=edit.cls&classeur=<?php echo $classeur; ?>">Modifier classeur</a></li>
    <?php

}
?>
</ul>