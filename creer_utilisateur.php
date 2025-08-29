<?php
/*
Controleur:
    Vérifier si l'email existe
        -si oui:
            afficher formulaire_connexion
        -si non:
            créer l'utilisateur
            connecter l'utilisateur
            afficher mon_espace
Parametre: 
    $POST email & mdp & pseudo & email2

*/

/* Initialisations 
    Tout est regroupé dans le init:     
*/
include "library/init.php";

use library\GestionSessionUtilisateur;
use modeles\Utilisateur;

// Vérification des droits:
//Pas besoin d'etre connecté pour se créer un compte

// Récupération des paramètres :
if(isset($_POST["email"])){
    $email = $_POST["email"];
}else{
    $email = "";
}

if(isset($_POST["mdp"])){
    $mdp = $_POST["mdp"];
}else{
    $mdp = "";
}

if(isset($_POST["pseudo"])){
    $pseudo = $_POST["pseudo"];
}else{
    $pseudo = "";
}
//honeypot:
if(isset($_POST["email2"])){
    $email2 = $_POST["email2"];
}else{
    $email2 = "";
}

//Traitement:
//Avant tout, on vérifie si c'est un robot avec le Honeypot:
if(!empty($email2)){
    //Si le champ n'est pas vide, on arrete le programme.
    //le code 204 indique que l'action a réussi mais qu'il n'y a pas de contenu sur la page.
    http_response_code(204);
    exit;
}
//1-Vérifier si l'email existe déja:
$utilisateur = new Utilisateur();
$utilisateur->loadByEmail($email);
//2- si l'email existe, on affiche la page de connexion
if($utilisateur->is()){
    //on affiche la page de connexion avec le message:
    echo "<p class='message-systeme'>Cet email a déjà un compte! Connectez-vous!</p>";
    include "templates/pages/formulaire_connexion.php";
    exit;
}

//3- si le pseudo existe, on averti
$utilisateurPseudo = new Utilisateur();
$utilisateurPseudo->loadByPseudo($pseudo);
//2- si le pseudo existe, on affiche un message
if($utilisateurPseudo->is()){
    echo "<p class='message-systeme'>Ce pseudo est déjà pris, merci d'en choisir un autre</p>";
    include "templates/pages/formulaire_creation_compte.php";
    exit;
}
//3-si l'email et le pseudo n'existent pas, on crée l'utilisateur:
if(!empty($mdp) && !empty($pseudo) && !empty($email)){
    $utilisateur->set("email", $email);
    $utilisateur->set("pseudo", $pseudo);
    //4- je hash le mot de passe:
    $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);
    $utilisateur->set("mdp", $mdp_hash);
    //J'enregistre l'utilisateur dans la bdd et je recupère l'id
    $id = $utilisateur->insert();
    //5-Je connecte l'utilisateur
    GestionSessionUtilisateur::connecter($id);
    //6-J'affiche la page mon_espace
    include "templates/pages/mon_espace.php";
}else{
    //Afficher la page de creation de compte
    echo "<p class='message-systeme'>Merci de remplir tous les champs!</p>";
    include "templates/pages/formulaire_creation_compte.php";
}
    

 