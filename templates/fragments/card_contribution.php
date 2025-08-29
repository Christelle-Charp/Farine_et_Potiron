<?php

/*

Templates de fragment

Rôle : générer le une card pour chaque contribution
Paramètre : 
    $contribution: un objet contribution

*/
?>
<div class="card-contribution">
    <div class="card-header">
        <div class="note">
            <p><?= htmlentities($contribution->get("note")) ?>/5</p>
        </div>
        <div class="info">
            <p>par <?= htmlentities($contribution->get("utilisateur")->get("pseudo")) ?></p>
            <p>Mise à jour le <?= htmlentities($contribution->get("maj")) ?></p>
        </div>
    </div>
    <div class="card-body">
        <p><?= htmlentities($contribution->get("commentaire")) ?></p>
    </div>
</div>