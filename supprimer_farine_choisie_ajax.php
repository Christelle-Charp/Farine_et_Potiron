<?php
/*
Controleur pour Ajax:
    Supprimer la farine choisie
Parametre: 
    $GET id: id de la farineChoisie à supprimer
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
//Je supprime la farine choisies de la recette
//je vérifie le nombre de farines dans la recette,
//si seulement une, impossible de supprimer
if($recette->compterFarinesChoisies() == 1){
    echo "<p>Merci de sélectionner une nouvelle farine avant de supprimer celle-ci!</p>";
    $recette = new Recette($idRecette);
    $farinesChoisies = $recette->getFarinesChoisies($recette->id());
    $catalogue = new Catalogue();
    $catalogue = $catalogue->getCatalogue();
    include "templates/fragments/list_farines.php";
    exit;
}

$supression = $recette->supprimerFarineChoisie($id);

if(!$supression){
   echo "<p>Suppression impossible!</p>";
}

$recette = new Recette($idRecette);
$farinesChoisies = $recette->getFarinesChoisies($recette->id());
$catalogue = new Catalogue();
$catalogue = $catalogue->getCatalogue();

// Afficher la page: 
include "templates/fragments/list_farines.php";