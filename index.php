<?php
/*
Controleur:
    Extraire liste des farines
    Préparer affichage de accueil
Parametre: 
    neant

*/

/* Initialisations 
    Tout est regroupé dans le init:     
*/

include "library/init.php";

use library\GestionSessionUtilisateur;
use modeles\Catalogue;
use modeles\Farine;
use modeles\Recette;



// Vérification des droits:
//Page public - pas de vérification des droits

// Récupération des paramètres :
//Néant

//Traitement:
//Je récupère le catalogue des farines:
$catalogue = new Catalogue();
$catalogue = $catalogue->getCatalogue();
//J'appelle ma recette à la Une
$recette = new Recette();
$recette->recetteUne();

// Afficher la page: 
include "templates/pages/accueil.php";
