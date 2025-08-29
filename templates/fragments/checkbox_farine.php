<?php

/*

Templates de fragment

Rôle : générer une checkbox pour chaque farine
Paramètre : 
    $farine: un objet farine

*/
?>
<div>
    <input type="checkbox" id="farine-ref-<?= htmlentities($farine->id()) ?>" name="farines[]" value="<?= htmlentities($farine->id()) ?>">
    <label for="farine-ref-<?= htmlentities($farine->id()) ?>"><?= htmlentities($farine->get("libelle")) ?></label>
</div>