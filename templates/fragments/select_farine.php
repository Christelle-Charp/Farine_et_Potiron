<?php

/*

Templates de fragment

Rôle : générer un select pour chaque farine
Paramètre : 
    $farine: un objet farine

*/
?>
<option value="<?= htmlentities($farine->id()) ?>" id="farine-ref-<?= htmlentities($farine->id()) ?>"><?= htmlentities($farine->get("libelle")) ?></option>