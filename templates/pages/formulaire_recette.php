<?php
/*
Template de page complète : Mettre en forme l'affichage du formulaire de création/modification d'une recette
Paramètres:    
    $recette si modification
    $catalogue
    $farinesChoisies(liste des farines choisies pour la recette) si modification
    $ingredientsChoisis(liste des ingredients choisis pour la recette) si modification
*/
use library\GestionSessionUtilisateur;

$connexion = GestionSessionUtilisateur::etatConnexion();
$difficultes = [
    1 => "Très facile",
    2 => "Facile",
    3 => "Difficile"
];
$difficulteRecette = $recette ? $recette->get("difficulte") : null;

?>
<!DOCTYPE html>
<html lang="fr">
<?php // Inclure le "head"
    $titre = "Créer une recette";       // Valoriser la variable $titre atendue par le fragment
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
    <section class="formulaire-recette" data-recette-id="<?= htmlentities($recette->id()) ?>">
        <div class="contenair">
            <div class="row">
                <h2>Votre recette:</h2>
                <form action="enregistrer_recette.php?id=<?= htmlentities($recette->id()) ?>" method="POST" id="form-recette">
                    <div class="label-align">
                        <label for="" class="label-titre">Titre
                            <input type="text" name="titre" value="<?= htmlentities($recette->get("titre")) ?>" class="titre">
                        </label>
                        <div id="titreError" class="error-box"></div>
                    </div>
                    <div id="form-farine">
                        <p>Le choix d'une de nos farine est la 1ère étape obligatoire pour créer une recette!</p>
                        <label for="">Farine:
                            <select name="farine">
                                <option selected value="0">Choisissez votre farine</option>
                                <?php
                                    foreach($catalogue as $farine){
                                        include "templates/fragments/select_farine.php";
                                    }
                                ?>
                            </select>

                        </label>
                        <label for="">Quantité en gr:
                            <input type="number" name="quantite" value="">
                        </label>
                        <button type="button" class="tertiary-btn" onclick="<?= $recette->id() > 0 ? 'enregistrerFarine()' : 'enregistrerFarineCreerRecette()'?>">Ajouter</button>
                    </div>
                    <div id="list_farines">

                    </div>
                    <div id="form-ingredient">
                        <label for="">Ingredient:
                            <input type="text" name="ingredient" value="" >
                        </label>
                        <label for="">Quantité:
                            <input type="number" step="0.01" value="" name="quantite">
                        </label>
                        <label for="">Unité:
                            <input type="text" name="unite" value="">
                        </label>
                        <button type="button" class="tertiary-btn" onclick="enregistrerIngredient()">Ajouter</button>
                    </div>
                    <div id="list_ingredients"></div>
                    <div class="label-align">
                        <label for="">Temps de réalisation
                            <input type="text" name="realisation" value="<?= htmlentities($recette->get("realisation")) ?>">
                        </label>
                        <div id="realisationError" class="error-box"></div>
                    </div>
                    <div class="label-align">
                        <label for="">Difficulté:
                            <select name="difficulte" id="">
                                <option value="">Selectionnez votre difficulté</option>
                                <?php foreach ($difficultes as $valeur => $libelle): ?>
                                    <option value="<?= $valeur ?>" <?= ($valeur == $difficulteRecette) ? "selected" : "" ?>>
                                        <?= htmlentities($libelle) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <div id="difficulteError" class="error-box"></div>
                    </div>
                    <div class="label-align"> 
                        <label for="">Descrisption détaillée:
                            <input type="text" name="description" value="<?= htmlentities($recette->get("description")) ?>" class="description">
                        </label>
                        <div id="descriptionError" class="error-box"></div>
                    </div>
                    <input type="submit" value="Enregistrer la recette" class="primary-btn">
                </form>
            </div>
        </div>
    </section>
    <?php   //Inclure le footer
    include "templates/fragments/footer.php";
    ?>
    <script src="js/fonctions.js"></script>
</body>
</html>