<?php

/*

Templates de fragment

Rôle : générer le "header" quand l'utilisateur est connecté
Paramètre : 
    neant

*/
?>
<header>
    <div class="contenair">
        <div class="row">
            <div class="logo">
                <a href="index.php" title="Venez découvrir nos farines">
                    <h3>Farine & Potiron</h3>
                </a>
            </div>
            <nav>
                <ul>
                    <li>
                        <a href="index.php" title="Venez découvrir nos farines">Nos Farines</a>
                    </li>
                    <li>
                        <a href="afficher_formulaire_recherche.php" title="Partez à la découverte de nos farines à travers de délicieuses recettes">Les recettes</a>
                    </li>
                </ul>
            </nav>
            <div class="user-menu">
                <ul>
                    <li>
                        <a href="afficher_mon_espace.php" title="Accedez à votre espace">Mon espace</a>
                        <a href="deconnecter.php" title="Déconnectez-vous!">Se déconnecter</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>