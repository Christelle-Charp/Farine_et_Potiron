<?php

/*

Templates de fragment

Rôle : générer le tr pour chaque ingredient choisi
Paramètre : 
    $ingredientChoisi: une ligne d'un tableau associatif

*/
?>
<tr>
    <td><?= htmlentities($ingredientChoisi['quantite']) ?></td>
    <td><?= htmlentities($ingredientChoisi['unite']) ?></td>
    <td><?= htmlentities($ingredientChoisi['ingredient']) ?></td>
    <td><button class="danger-btn" type="button" onclick="supprimerIngredientChoisi('<?= htmlentities($ingredientChoisi['id']) ?>')">Supprimer</button></td>
</tr>