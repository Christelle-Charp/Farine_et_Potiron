<?php

/*

Templates de fragment

Rôle : Mettre en forme l'affichage de la div list_farines
Paramètre : 
    $farinesChoisies(liste des farines choisies pour la recette)

*/
?>
<table>
    <tbody>
        <?php
            foreach($farinesChoisies as $farineChoisie){
                include "templates/fragments/tr_farine_choisie.php";
            }
        ?>
    </tbody>
</table>