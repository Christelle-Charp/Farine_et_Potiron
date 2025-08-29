<?php
/*
Controleur pour Ajax:
    Extraire les ingredients de la recette
Parametre: 
    $GET id: id de la recette

*/

/* Initialisations 
    Tout est regroupé dans le init:     
*/

include "library/init.php";

use modeles\Recette;
use modeles\Catalogue;
use modeles\Contribution;
use library\GestionSessionUtilisateur;

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
if(isset($_GET["id"])){
    $id = $_GET["id"];
}else{
    $id = 0;
}

//Traitement:

$recette = new Recette($id);
//Je récupère les ingredients et farines choisis pour la recette
$ingredientsChoisis = $recette->getIngredientsChoisis($recette->id());

// Afficher la page: 
include "templates/fragments/list_ingredients.php";