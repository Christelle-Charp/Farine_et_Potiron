<?php
/*
Controleur pour Ajax:
    Afficher formulaire_modification
Parametre: 
    Neant

*/

/* Initialisations 
    Tout est regroupé dans le init:     
*/

include "library/init.php";

use library\GestionSessionUtilisateur;
use modeles\Recette;



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
//Néant

//Traitement:
//Néant

// Afficher la page: 
include "templates/fragments/formulaire_modification.php";