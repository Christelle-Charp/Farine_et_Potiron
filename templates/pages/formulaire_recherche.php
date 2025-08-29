<?php
/*
Template de page complète : Mettre en forme l'affichage de la page de recherche des recettes avec les formulaires
Paramètres:    
    $catalogue (liste des farines)
    $recettes (liste de recettes)
*/
use library\GestionSessionUtilisateur;

$connexion = GestionSessionUtilisateur::etatConnexion();
?>
<!DOCTYPE html>
<html lang="fr">
<?php // Inclure le "head"
    $titre = "Ma Recherche";       // Valoriser la variable $titre atendue par le fragment
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
    <section class="recherche-recette">
        <div class="contenair">
            <div class="row">
                <form action="rechercher_recettes.php" method="POST">
                    <div class="select-farine">
                        <h3>Sélectionnez vos farines</h3>
                        <div class="contenair-check">
                            <?php
                                foreach($catalogue as $farine){
                                    include "templates/fragments/checkbox_farine.php";
                                }
                            ?>
                        </div>
                    </div>
                    <div class="autre-recherche">
                        <div class="select-difficulte">
                            <label for="">
                                <select name="difficulte" id="">
                                    <option selected value="">Selectionnez votre difficulté</option>
                                    <option value="1">Très facile</option>
                                    <option value="2">Facile</option>
                                    <option value="3">Difficile</option>
                                </select>
                                
                            </label>
                        </div>
                        <div class="recherche-texte">
                            <input type="text" name="recherche" value="" placeholder="Votre recherche">
                        </div>
                    </div>
                    <input type="submit" value="Rechercher" class="primary-btn">
                </form>
            </div>
        </div>
    </section>
    <section class="list-recettes">
        <div class="contenair">
            <div class="row">
                <h3>Votre sélection de recettes</h3>
                <ul>
                    <?php
                        if(empty($recettes)){
                            echo "<li><p>Aucune recette ne correspond à votre recherche</p></li>";
                        }else{
                            foreach($recettes as $recette){
                                include "templates/fragments/li_recette.php";
                            }
                        }
                    ?>
                </ul>                
            </div>
        </div>
    </section>
    <?php   //Inclure le footer
    include "templates/fragments/footer.php";
    ?>
</body>
</html>