<?php

/*

Templates de fragment

Rôle : générer le tr pour chaque contribution
Paramètre : 
    $contribution: un objet contribution

*/
?>
<tr>
    <td><?= htmlentities($contribution->get("recette")->get("titre")) ?></td>
    <td><?= htmlentities($contribution->get("note")) ?></td>
    <td><a href="afficher_detail_recette.php?id=<?= htmlentities($contribution->get("recette")->id()) ?>" class="tertiary-btn">Allez voir la recette</a></td>
</tr>