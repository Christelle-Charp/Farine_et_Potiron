<?php
/*
Controleur pour Ajax:
    Enregistrer l'ingredient dans la bdd
    Extraire les ingredients de la recette
Parametre: 
    $POST ingredient & quantite & unite
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

if(isset($_POST["ingredient"])){
    $ingredient = $_POST["ingredient"];
}else{
    $ingredient = "";
}

if(isset($_POST["quantite"])){
    $quantite = $_POST["quantite"];
}else{
    $quantite = 0;
}

if(isset($_POST["unite"])){
    $unite = $_POST["unite"];
}else{
    $unite = "";
}


//Traitement:
//Je vérifie s'il y a une recette de créée
if ($id == 0 ){
    echo "<p>Merci de choisir une farine avant d'ajouter un ingrédient!</p>";
    $recette = new Recette();
    $ingredientsChoisis = $recette->getIngredientsChoisis($recette->id());
    include "templates/fragments/list_ingredients.php";   
    exit;
}
//J'instancie et je charge ma recette:
$recette = new Recette($id);
//je vérifie que l'utilisateur connecté est le créateur de la recette
if($recette->get("utilisateur")->id() !== GestionSessionUtilisateur::utilisateurConnecte()->id()){
    echo "<p>Vous n'etes pas autorisé à modifier cette recette!</p>";
    include "templates/pages/mon_espace.php";
    exit;
}
//J'ajoute mon ingredient:
$ajout = $recette->ajouterIngredientChoisi($ingredient, $quantite, $unite);

if($ajout == 0){
    echo "<p>Ajout de l'ingredient impossible!</p>";
}
$ingredientsChoisis = $recette->getIngredientsChoisis($recette->id());

// Afficher la page: 
include "templates/fragments/list_ingredients.php";