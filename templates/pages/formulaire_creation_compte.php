<?php
/*
Template de page complète : Mettre en forme l'affichage du formulaire de création d'un compte utilisateur
Paramètres : 
    Neant
*/
use library\GestionSessionUtilisateur;

$connexion = GestionSessionUtilisateur::etatConnexion();
?>
<!DOCTYPE html>
<html lang="fr">
<?php // Inclure le "head"
    $titre = "Création de compte";       // Valoriser la variable $titre atendue par le fragment
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
    <section class="creation-compte">
        <div class="contenair">
            <h2><?= $titre ?></h2>
            <form action="creer_utilisateur.php" method="POST">
                <label>Email: 
                    <input type="mail" name="email" value="">
                </label>
                <label>Pseudo: 
                    <input type="text" name="pseudo" value="">
                </label>
                <div class="mail-verification">
                    <label for="">Ne pas remplir ce champ si vous etes un humain:
                        <input type="text" name="mail2" value="">
                    </label>
                </div>
                <label>Mot de passe: 
                    <input type="password" name="mdp" value="">
                </label>
                <input class="primary-btn" type="submit" value="Créer son compte">
            </form>
        </div>
    </section>   
    <?php   //Inclure le footer
    include "templates/fragments/footer.php";
    ?> 
</body>
</html>