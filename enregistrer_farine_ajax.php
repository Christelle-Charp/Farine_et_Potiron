<?php
/*
Controleur pour Ajax:
    Enregistrer la farine dans la bdd
    Extraire les farines de la recette
Parametre: 
    $POST farine & quantite
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

if(isset($_GET["farine"])){
    $farine = $_GET["farine"];
}else{
    $farine = 0;
}

if(isset($_GET["quantite"])){
    $quantite = $_GET["quantite"];
}else{
    $quantite = 0;
}


//Traitement:
//J'instancie et je charge ma recette:
$recette = new Recette($id);
//je vérifie que l'utilisateur connecté est le créateur de la recette
if($recette->get("utilisateur")->id() !== GestionSessionUtilisateur::utilisateurConnecte()->id()){
    echo "<p>Vous n'etes pas autorisé à modifier cette recette!</p>";
    include "templates/pages/mon_espace.php";
    exit;
}
//J'ajoute ma farine:
$ajout = $recette->ajouterFarineChoisie($farine, $quantite);

if($ajout == 0){
    echo "<p>Ajout de la farine impossible!</p>";
}
$catalogue = new Catalogue();
$catalogue = $catalogue->getCatalogue();
$farinesChoisies = $recette->getFarinesChoisies($recette->id());

// Afficher la page: 
include "templates/fragments/list_farines.php";