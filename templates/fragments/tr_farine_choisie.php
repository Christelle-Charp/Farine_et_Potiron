<?php

/*

Templates de fragment

Rôle : générer le tr pour chaque farine choisie
Paramètre : 
    $farineChoisie: une ligne d'un tableau associatif

*/
$ref = $farineChoisie['farine'];
$libelle = $catalogue[$ref]->get("libelle");
?>
<tr>
    <td><?= htmlentities($farineChoisie['quantite']) ?></td>
    <td><?= htmlentities($farineChoisie['unite']) ?></td>
    <td><?= htmlentities($libelle) ?></td>
    <td><button type="button" onclick="supprimerFarineChoisie('<?= htmlentities($farineChoisie['id']) ?>')" class="danger-btn">Supprimer</button></td>
</tr>