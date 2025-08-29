<?php
/*
Controleur:
    Modifier l'utilisateur dans la bdd 
    Préparer affichage de mon_espace
Parametre: 
    $POST pseudo

*/

/* Initialisations 
    Tout est regroupé dans le init:     
*/

include "library/init.php";

use library\GestionSessionUtilisateur;
use modeles\Utilisateur;

// Vérification des droits:
//  Si on n'est pas connecté:
if (! GestionSessionUtilisateur::etatConnexion()) {
    //  Envoie l'utilisateur sur la page de connexion pour rentrer ces acces:
    //  Termine le programme (fin du controlleur)
    include "templates/pages/formulaire_connexion.php"; 
    //avec changement de l'url. 
    exit;
}

// Récupération des paramètrs :
if(isset($_POST["pseudo"])){
    $newPseudo = $_POST["pseudo"];
}else{
    $newPseudo = "";
}
//Traitement:
//Je récupère l'utilisateur connecté
$utilisateur = new Utilisateur();
$utilisateur = GestionSessionUtilisateur::utilisateurConnecte();

//Je véifie si le pseudo a été modifié
if($utilisateur->get("pseudo") === $newPseudo ){
    //si le pseudo n'a pas été changé, je fais rien
    include "templates/pages/mon_espace.php";
}

//Je vérifie si le pseudo existe deja:
$utilisateurPseudo = new Utilisateur();
$utilisateurPseudo->loadByPseudo($newPseudo);
if($utilisateurPseudo->is()){
    echo "<p class='message-systeme'>Ce pseudo est déjà pris, merci d'en choisir un autre</p>";
    include "templates/pages/mon_espace.php";
    exit;
}

if($newPseudo !== ""){
    $utilisateur->set("pseudo", $newPseudo);
    $maj = $utilisateur->update();
    if ($maj){
        include "templates/pages/mon_espace.php";
    }
}else{
    echo "<p>Modification impossible! le Pseudo est obligatoire!</p>";
    include "templates/pages/mon_espace.php";
}

// Afficher la page: 