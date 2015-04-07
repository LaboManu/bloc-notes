<h1>Pour Version 2.0 beta</h1>

<ul>
    

<li class="button_appdoc" ><a class="button_appdoc" href="?composant=create.txt&document=note">Ajouter une note</a></li>
<li class="button_appdoc"><a href="javascript:alert('Clic sur fichier pour visualiser puis editer, modifier, supprimer, classer')">Modifier une note</a></li>
<li class="button_appdoc"><a href="?composant=classeur.create">Créer un classement</a></li>
<li class="button_appdoc"><a href="#404">Trier les notes</a></li>
<li class="button_appdoc"><a href="#404">Chercher une note</a></li>
<?php
$class1 = filter_input(INPUT_GET, "classeur");
$classeur = substr($class1, 5)  ;
if($classeur!="")
{
    ?>
<li class="button_appdoc"><a href="?composant=classeur.edit&classeur=<?php echo $class1; ?>">Modifier classeur</a></li>
    <?php

}
?>
</ul>