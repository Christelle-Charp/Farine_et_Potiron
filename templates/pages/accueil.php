<?php
/*
Template de page complète : Mettre en forme l'affichage de la page d'accueil
Paramètres:    
    $catalogue (liste des farines)
    $recette(recette avec la meilleure note)
    
*/

use library\GestionSessionUtilisateur;

$connexion = GestionSessionUtilisateur::etatConnexion();
?>
<!DOCTYPE html>
<html lang="fr">
<?php // Inclure le "head"
    $titre = "Accueil";       // Valoriser la variable $titre atendue par le fragment
    include "templates/fragments/head.php";
?>
<body>
    <?php // Inclure le header
        //Si l'utilisateur est connecté, j'inclus le fragment header_connecte
        if($connexion){
            include "templates/fragments/header_connecte.php";
        }else{
            //Si l'utilisateur n'est pas connecté, j'inclus le fragment header_public
            include "templates/fragments/header_public.php";
        }
    ?>
    <?php   //Inclure le h1
    include "templates/fragments/titre.php";
    ?>
    <section class="farines">
        <div class=contenair-modal id="popup_farine"></div>
        <div class="contenair">
            <div class="row">
                <h2>Venez découvrir toutes nos farines</h2>
                <div class="contenair-farines">
                    <?php
                        foreach($catalogue as $farine){
                            include "templates/fragments/card_farine.php";
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <section class="recette-une">
        <div class="contenair">
            <div class="row">
                <h2>Recette à la Une!</h2>
                <a href="afficher_detail_recette.php?id=<?= htmlentities($recette->id()) ?>" title="Découvrez la recette à la Une de <?= htmlentities($recette->get("titre")) ?>">
                    <div class="card-une">
                        <h4><?= htmlentities($recette->get("titre")) ?></h4>
                        <div class="info">
                            <?php
                            foreach($recette->getFarinesChoisies($recette->id()) as $farine){
                                $libelle = isset($catalogue[$farine['farine']]) ? $catalogue[$farine['farine']]->get("libelle") : $farine['farine'];
                                echo "<p>avec {$farine['quantite']}{$farine['unite']} de " . htmlentities($libelle) ."</p>";
                            }
                            ?>
                            <p>Notée <?= htmlentities(number_format($recette->getMoyenne(), 2)) ?>/5 par les internautes</p>
                        </div>
                        
                    </div>
                </a>
            </div>
        </div>
    </section>
    <?php   //Inclure le footer
    include "templates/fragments/footer.php";
    ?>
    <script src="js/fonctions.js"></script>
</body>
</html>