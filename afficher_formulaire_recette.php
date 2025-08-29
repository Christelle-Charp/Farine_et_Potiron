<?php
/*
Controleur:
    Récupérer la recette si modification
    Préparer affichage de formulaire_recette
Parametre: 
    $GET id: id de la recette si modification

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
if($id > 0){
    $recette = new Recette($id);
    //je vérifie que l'utilisateur connecté est le créateur de la recette
    if($recette->get("utilisateur")->id() !== GestionSessionUtilisateur::utilisateurConnecte()->id()){
        echo "<p>Vous n'etes pas autorisé à modifier cette recette!</p>";
        include "templates/pages/mon_espace.php";
        exit;
    }
    //Je récupère les ingredients et farines choisis pour la recette
    $farinesChoisies = $recette->getFarinesChoisies($recette->id());
    $ingredientsChoisis = $recette->getIngredientsChoisis($recette->id());
}else{
    $recette = new Recette();
} 
$catalogue = new Catalogue();
$catalogue = $catalogue->getCatalogue();

// Afficher la page: 
include "templates/pages/formulaire_recette.php";