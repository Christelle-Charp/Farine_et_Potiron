<?php
/*
Controleur:
    Déconnecter l'utilisateur
    Extraire liste des farines
    Préparer affichage de accueil
Parametre: 
    neant

*/

/* Initialisations 
    Tout est regroupé dans le init:     
*/
include "library/init.php";

use modeles\Recette;
use modeles\Catalogue;
use library\GestionSessionUtilisateur;

// Vérification des droits:
//Inutile car on déconnecte

// Récupération des paramètrs :

//Traitement:
//1-Je déconnecte
GestionSessionUtilisateur::deconnecter();
//2-Je récupère le catalogue des farines:
$catalogue = new Catalogue();
$catalogue = $catalogue->getCatalogue();
//J'appelle ma recette à la Une
$recette = new Recette();
$recette->recetteUne();

// Afficher la page: 
include "templates/pages/accueil.php";