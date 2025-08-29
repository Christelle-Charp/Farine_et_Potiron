<?php
/*
Controleur:
    Vérifier les codes de connexion
        - si ko:
            déconnecter l'utilisateur
            afficher formulaire_connexion
        si ok:
            connecter l'utilisateur
            afficher mon_espace
Parametre: 
    $POST identifiant & mdp

*/

/* Initialisations 
    Tout est regroupé dans le init:     
*/

include "library/init.php";

use modeles\Utilisateur;
use library\GestionSessionUtilisateur;

// Vérification des droits:
//Page public - pas de vérification des droits

// Récupération des paramètrs :
if(isset($_POST["identifiant"])){
    $identifiant = $_POST["identifiant"];
} else {
    $identifiant = "";
}

if(isset($_POST["mdp"])){
    $mdp = $_POST["mdp"];
} else {
    $mdp = "";
}

//Traitement:
//Vérifier si les codes de connexion correspond à un utilisateur
$utilisateur = GestionSessionUtilisateur::verifIdentifiant($identifiant, $mdp); //Cette fonction renvoie un objet ou false.
//Si l'utilsateur n'existe pas:
if($utilisateur === false){
    //On envoie sur la page pour se connecter:
    //On ne reroute pas vers la page de création ni de message pour ne pas donner d'info de sécurité
    include "templates/pages/formulaire_connexion.php";
    //on termine le programme
    exit;
}
//si l'utilisateur existe:
//1- on le connecte
GestionSessionUtilisateur::connecter($utilisateur->id());

// 2-Afficher la page: 
include "templates/pages/mon_espace.php";