<?php

/*

Templates de fragment

Rôle : générer le contenu de la section contribution
Paramètre : 
    $contributions: un tableau avec toutes les contributions de la recette

*/

use library\GestionSessionUtilisateur;
use modeles\Contribution;

$utilisateur = GestionSessionUtilisateur::utilisateurConnecte();
$contribution = new Contribution();
//Je récupère la contribution de l'utilisateur connecté à la recette en cours
$contributionUtilisateur = $contribution->getContributionByUtilisateurAndRecette($utilisateur->id(), $recette->id());

?>
<div class="contenair">
    <div class="row">
        <h2>Liste des contributions</h2>
        <div class="contenair-contribution">
            <?php
                foreach($contributions as $contribution){
                    include "templates/fragments/card_contribution.php";
                }
            ?>
        </div>
        <form action="enregistrer_contribution.php?id=<?= $contributionUtilisateur->id() ?>" method="POST">
            <label>Note sur 5: 
                <input type="number" name="note" value="<?= htmlentities($contributionUtilisateur->get("note")) ?>">
            </label>
            <label>Commentaire: 
                <input type="text" name="commentaire" value="<?= htmlentities($contributionUtilisateur->get("commentaire")) ?>">
            </label>
            <input type="hidden" name="recette" value="<?= htmlentities($recette->id()) ?>">
            <input type="submit" class="primary-btn" value="Enregistrer">
        </form>
    </div>
</div>