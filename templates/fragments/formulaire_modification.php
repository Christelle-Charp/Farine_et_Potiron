<?php

/*

Templates de fragment

Rôle : Mettre en forme l'affichage de la div formulaire_modification pour la modification du profil utilisateur
Paramètre : 
    Neant

*/

use library\GestionSessionUtilisateur;
use modeles\Utilisateur;
use modeles\Recette;

$utilisateur = new Utilisateur();
$utilisateur = GestionSessionUtilisateur::utilisateurConnecte();
?>
<div class="cta-closed">
    <button class="btn-closed" onclick="fermerPopUp()">X</button>
</div>
<div class="pop-profil">
    <div class="header-popup">
        <h3><?=htmlentities($utilisateur->get("email")) ?></h3>
    </div>
    <div class="body-popup">
        <form action="modifier_profil.php" method="POST">
            <label for="">Pseudo
                <input type="text" name="pseudo" value="<?=htmlentities($utilisateur->get("pseudo")) ?>">
            </label>
            <input type="submit" value="Modifier mon pseudo">
        </form>
    </div>
</div>