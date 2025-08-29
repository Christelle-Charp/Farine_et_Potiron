<?php

/*

Templates de fragment

Rôle : générer le une card pour chaque farine
Paramètre : 
    $farine: un objet farine

*/
?>
<div class="card-farine" data-ref-farine="<?= htmlentities($farine->get("reference")) ?>">
    <h4><?= htmlentities($farine->get("libelle")) ?></h4>
</div>