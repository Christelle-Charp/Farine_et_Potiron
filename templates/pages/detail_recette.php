<?php
/*
Template de page complète : Mettre en forme l'affichage des détails d'une recettes et ses contributions + formulaire se saisie d'une contribution
Paramètres:    
    $recette
    $contributions(liste des contributions)
    $catalogue
*/
use library\GestionSessionUtilisateur;
use modeles\Recette;
use modeles\Utilisateur;

$connexion = GestionSessionUtilisateur::etatConnexion();
$difficultes = [
    1 => "Très facile",
    2 => "Facile",
    3 => "Difficile"
];
$libelleDifficulte = $difficultes[$recette->get("difficulte")] ?? "Non spécifiée";
$farinesChoisies= $recette->getFarinesChoisies($recette->id());
$ingredientsChoisis = $recette->getIngredientsChoisis($recette->id());
?>

<!DOCTYPE html>
<html lang="fr">
<?php // Inclure le "head"
    $titre = "Détail recette";       // Valoriser la variable $titre atendue par le fragment
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
    <section class="detail-recette">
        <div class="contenair">
            <div class="row">
                <div class="header-recette">
                    <h2><?= htmlentities($recette->get("titre")) ?></h3>
                    <div class="createur">
                        <p>Par <?= htmlentities($recette->get("utilisateur")->get("pseudo")) ?></p>
                        <p>Mise à jour le <?= htmlentities($recette->get("maj")) ?></p>
                    </div>
                </div>
                <div class="body-recette">
                    <div class="farines">
                        <h3>Nos farines</h3>
                        <ul>
                            <?php
                                foreach($farinesChoisies as $farineChoisie){
                                    $ref = $farineChoisie['farine'];
                                    $libelle = $catalogue[$ref]->get("libelle");
                                    echo "<li>" . htmlentities($farineChoisie['quantite']) . htmlentities($farineChoisie['unite']) . " " . htmlentities($libelle) . "</li>";
                                }
                            ?>
                        </ul>
                    </div>
                    <div class="ingredients">
                        <h3>Les ingredients</h3>
                        <ul>
                            <?php
                                foreach($ingredientsChoisis as $ingredientChoisi){
                                    echo "<li>" . htmlentities($ingredientChoisi['quantite']) . htmlentities($ingredientChoisi['unite']) . " " . htmlentities($ingredientChoisi['ingredient']) . "</li>";
                                }
                            ?>
                        </ul>
                    </div>
                    <div class="info">
                        <h3>Informations</h3>
                        <ul>
                            <li><h4>Difficulté: </h4><?= htmlentities($libelleDifficulte) ?></li>
                            <li><h4>Temps de préparation: </h4><?= htmlentities($recette->get("realisation")) ?></li>
                        </ul>
                    </div>
                </div>
                <div class="footer-recette">
                    <h3>Descriptif de la recette:</h3>
                    <p><?= htmlentities($recette->get("description")) ?></p>
                </div>
            </div>
        </div>
    </section>
    <section class="contributions">
        <?php
            if($connexion){
                include "templates/fragments/contenu_contribution.php";
            } else{
                echo "<p class='message-avis'>Connectez-vous pour accéder aux avis !</p>";
            }
        ?>
    </section>
    <?php   //Inclure le footer
    include "templates/fragments/footer.php";
    ?>
</body>
</html>

