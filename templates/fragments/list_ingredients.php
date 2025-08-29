<?php

/*

Templates de fragment

Rôle : Mettre en forme l'affichage de la div list_ingredients
Paramètre : 
    $ingredientsChoisis(liste des ingredients choisis pour la recette)

*/
?>
<table>
    <tbody>
        <?php
            foreach($ingredientsChoisis as $ingredientChoisi){
                include "templates/fragments/tr_ingredient_choisi.php";
            }
        ?>
    </tbody>
</table>