<?php
/*
Template de page complète : Mettre en forme l'affichage du formulaire de connexion
Paramètres:    
    Neant
*/
use library\GestionSessionUtilisateur;

$connexion = GestionSessionUtilisateur::etatConnexion();
?>
<!DOCTYPE html>
<html lang="fr">
<?php // Inclure le "head"
    $titre = "Se connecter";       // Valoriser la variable $titre atendue par le fragment
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
    <section class="connexion">
        <div class="contenair">
            <h2><?= $titre ?></h2>
            <form action="connecter.php" method="POST">
                <label>Identifiant: 
                    <input type="text" name="identifiant" value="" placeholder="votre email ou votre pseudo">
                </label>
                <label>Mot de passe: 
                    <input type="password" name="mdp" value="">
                </label>
                <input class="primary-btn" type="submit" value="Se connecter">
            </form>
        </div>
    </section>
    <?php   //Inclure le footer
    include "templates/fragments/footer.php";
    ?>
</body>
</html>