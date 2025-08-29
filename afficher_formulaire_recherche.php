<?php
/*
Controleur:
    Préparer affichage de formulaire_recherche
Parametre: 
    neant

*/

/* Initialisations 
    Tout est regroupé dans le init:     
*/

use modeles\Catalogue;
use library\GestionSessionUtilisateur;
use modeles\Recette;

include "library/init.php";

// Vérification des droits:
//Page public - pas de vérification des droits

// Récupération des paramètrs :

//Traitement:
//Je récupère le catalogue des farines:
$catalogue = new Catalogue();
$catalogue = $catalogue->getCatalogue();

//Je récupère la liste de toutes les recettes
$recette = new Recette();
$recettes = $recette->AllRecettes();

// Afficher la page: 
include "templates/pages/formulaire_recherche.php";