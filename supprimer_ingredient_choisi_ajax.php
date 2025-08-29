<?php
/*
Controleur pour Ajax:
    Supprimer l'ingredient choisi
Parametre: 
    $GET id: id de l'ingredient choisi à supprimer
    $GET idRecette
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

if(isset($_GET["recette"])){
    $idRecette = $_GET["recette"];
}else{
    $idRecette = 0;
}

//Traitement:
$recette = new Recette($idRecette);
//je vérifie que l'utilisateur connecté est le créateur de la recette
if($recette->get("utilisateur")->id() !== GestionSessionUtilisateur::utilisateurConnecte()->id()){
    echo "<p>Vous n'etes pas autorisé à modifier cette recette!</p>";
    include "templates/pages/mon_espace.php";
    exit;
}
//Je supprime l'ingredient choisi de la recette
$supression = $recette->supprimerIngredientChoisi($id);

if(!$supression){
   echo "<p>Suppression impossible!</p>";
}

$recette = new Recette($idRecette);
$ingredientsChoisis = $recette->getIngredientsChoisis($recette->id());

// Afficher la page: 
include "templates/fragments/list_ingredients.php";