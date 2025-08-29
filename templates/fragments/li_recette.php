<?php

/*

Templates de fragment

Rôle : générer le li pour chaque recette
Paramètre : 
    $recette: un objet recette

*/
?>
<li>
    <a href="afficher_detail_recette.php?id=<?= htmlentities($recette->id()) ?>" title="Découvrez la recette de <?= htmlentities($recette->get("titre")) ?>">
        <?= htmlentities($recette->get("titre")) ?>
    </a>
</li>