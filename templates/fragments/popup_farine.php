<?php

/*

Templates de fragment

Rôle : Mettre en forme l'affichage de la popup farine
Paramètre : 
    $farine: objet contenant le détail d'une farine
*/
?>
<div class="cta-closed">
    <button class="btn-closed" onclick="fermerPopUp()">X</button>
</div>
<div class="pop-farine">
    <div class="header-popup">
        <h3><?=htmlentities($farine->get("libelle")) ?></h3>
    </div>
    <div class="body-popup">
        <p class="description"><?=htmlentities($farine->get("description")) ?></p>
    </div>
    <div class="footer-popup">
        <p><?=htmlentities($farine->get("reference")) ?></p>
    </div>
</div>
