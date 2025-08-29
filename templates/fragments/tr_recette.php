<?php

/*

Templates de fragment

Rôle : générer le tr pour chaque recette
Paramètre : 
    $recette: un objet recette

*/
?>
<tr>
    <td><?= htmlentities($recette->get("titre")) ?></td>
    <td><a href="afficher_detail_recette.php?id=<?= htmlentities($recette->id()) ?>" class="tertiary-btn">Voir</a></td>
    <td><a href="afficher_formulaire_recette.php?id=<?= htmlentities($recette->id()) ?>" class="tertiary-btn">Modifier</a></td>
</tr>