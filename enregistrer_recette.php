<?php
/*
Controleur:
    Modifier la recette dans la bdd 
    Préparer affichage de mon_espace
Parametre: 
    $GET id: id de la recette
    $POST titre & realisation & difficulte & description

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

if(isset($_POST["titre"])){
    $titre = $_POST["titre"];
}else{
    $titre = "";
}

if(isset($_POST["realisation"])){
    $realisation = $_POST["realisation"];
}else{
    $realisation = "";
}

if(isset($_POST["difficulte"])){
    $difficulte = $_POST["difficulte"];
}else{
    $difficulte = "";
}

if(isset($_POST["description"])){
    $description = $_POST["description"];
}else{
    $description = "";
}

//Traitement:
//Je vérifie qu'un recette est crée
if($id == 0){
    echo "<p>Merci de choisir une farine avant d'enregistrer votre recette!</p>"; 
    $catalogue = new Catalogue();
    $catalogue = $catalogue->getCatalogue();
    $recette = new Recette();
    $farinesChoisies = $recette->getFarinesChoisies($recette->id());
    $ingredientsChoisis = $recette->getIngredientsChoisis($recette->id());
    include "templates/pages/formulaire_recette.php";
}
//J'instancie la recette
$recette = new Recette($id);
//je vérifie que l'utilisateur connecté est le créateur de la recette
if($recette->get("utilisateur")->id() !== GestionSessionUtilisateur::utilisateurConnecte()->id()){
    echo "<p>Vous n'etes pas autorisé à modifier cette recette!</p>";
    include "templates/pages/mon_espace.php";
    exit;
}

//Je modifie les attributs:
$recette->set("titre", $titre);
$recette->set("realisation", $realisation);
$recette->set("difficulte", $difficulte);
$recette->set("description", $description);
$now = new DateTime();
$recette->set("maj", $now->format("Y-m-d H:i:s"));
//Comme la recette est complete, je change le statut pour qu'elle apparaisse dans les recherches
$recette->set("publie", 1);
//Je mets à jour la bdd
$maj = $recette->update();
if (!$maj){
    echo "<p>Mise à jour de la recette impossible</p>"; 
    $catalogue = new Catalogue();
    $catalogue = $catalogue->getCatalogue();
    $farinesChoisies = $recette->getFarinesChoisies($recette->id());
    $ingredientsChoisis = $recette->getIngredientsChoisis($recette->id());
    include "templates/pages/formulaire_recette.php";
}

// Afficher la page: 
include "templates/pages/mon_espace.php";
