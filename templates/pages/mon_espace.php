<?php
/*
Template de page complète : Mettre en forme l'affichage de la page mon espace de l'utilisateur
Paramètres:    
    Neant
*/
use library\GestionSessionUtilisateur;
use modeles\Recette;
use modeles\Utilisateur;

$connexion = GestionSessionUtilisateur::etatConnexion();
$utilisateur = GestionSessionUtilisateur::utilisateurConnecte();
$recettes = $utilisateur->get("recettes");
$contributions = $utilisateur->get("contributions");
?>
<!DOCTYPE html>
<html lang="fr">
<?php // Inclure le "head"
    $titre = "Mon espace";       // Valoriser la variable $titre atendue par le fragment
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
    <section class="gestion-profil">
        <div class=contenair-modal id="formulaire_modification"></div>
        <button class="secundary-btn" id="profil">Modifier mon profil</button>
    </section>
    <section class="recettes-utilisateur">
        <div class="contenair">
            <div class="row">
                <div class="align">
                    <h3>Mes recettes</h3>
                    <a href="afficher_formulaire_recette.php" title="Créer votre recette" class="primary-btn">Ajouter une recette</a>
                </div>
                <p>Seules vos recettes complètes sont visibles par les internautes</p>
                <table>
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($recettes as $recette){
                                include "templates/fragments/tr_recette.php";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <section class="contributions-utilisateur">
        <div class="contenair">
            <div class="row">
                <h3>Les recettes avec mon grain de sel</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Note</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($contributions as $contribution){
                                include "templates/fragments/tr_contribution.php";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <?php   //Inclure le footer
    include "templates/fragments/footer.php";
    ?>
    <script src="js/fonctions.js"></script>
</body>
</html>