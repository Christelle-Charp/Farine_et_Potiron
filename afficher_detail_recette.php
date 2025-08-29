<?php
/*
Controleur:
    Extraire la recette
    Préparer affichage de detail_recette
Parametre: 
    $GET id: id de la recette

*/

/* Initialisations 
    Tout est regroupé dans le init:     
*/

include "library/init.php";

use modeles\Recette;
use modeles\Catalogue;
use library\GestionSessionUtilisateur;
use modeles\Contribution;

// Vérification des droits:
//Page public - pas de vérification des droits

// Récupération des paramètrs :
if(isset($_GET["id"])){
    $id = $_GET["id"];
}else{
    $id = 0;
}

//Traitement:
//J'instancie et je charge mon objet Recette
$recette = new Recette($id);
//Je récupère le catalogue des farines:
$catalogue = new Catalogue();
$catalogue = $catalogue->getCatalogue();
//Je récupère les contributions de la recette
$contributions = $recette->getContributions();

// Afficher la page: 
include "templates/pages/detail_recette.php";