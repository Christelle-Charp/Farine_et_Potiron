<?php
/*
Controleur:
    Préparer affichage de formulaire_connexion
Parametre: 
    neant

*/

/* Initialisations 
    Tout est regroupé dans le init:     
*/

use library\GestionSessionUtilisateur;

include "library/init.php";

// Vérification des droits:
//Page public - pas de vérification des droits


// Récupération des paramètrs :
//Néant

//Traitement:
//Néant

// Afficher la page: 
include "templates/pages/formulaire_connexion.php";