<?php
/*
Controleur:
    Ajouter/modifier la contribution à la bdd
    Extraire la recette 
    Préparer affichage de detail_recette
Parametre: 
    "$GET id: id de la contribution
    $POST note & commentaire & id de la recette"

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

// Récupération des paramètres :
if(isset($_GET["id"])){
    $id = $_GET["id"];
} else{
    $id = 0;
}

if(isset($_POST["note"]) && $_POST["note"] !== ""){
    $note = $_POST["note"];
} else {
    $note = null;
}

if(isset($_POST["commentaire"]) && $_POST["commentaire"] !== ""){
    $commentaire = $_POST["commentaire"];
} else {
    $commentaire = null;
}

if(isset($_POST["recette"])){
    $idRecette = $_POST["recette"];
} else {
    $idRecette = 0;
}

//Traitement:
//Je vérifie s'il y a une recette, si non, message d'erreur et sortie du programme
if($idRecette == 0){
    echo "<p>Impossible d'enregistrer votre contribution</p>";
    include "templates/pages/mon_espace.php";
    exit;
}

//Je vérifie que la contribution n'est pas vide:
if($note == null && $commentaire==null){
    echo "<p>Impossible d'enregistrer une contribution vide</p>";
    //Traitement pour afficher la page detail_recette
    $recette = new Recette($idRecette);
    $catalogue = new Catalogue();
    $catalogue = $catalogue->getCatalogue();
    $contributions = $recette->getContributions();
    include "templates/pages/detail_recette.php";
    exit;
}

//Je vérifie s'il y a un id pour la contribution: oui = mise à jour, non = création
if($id > 0){
    //Je modifie l'objet contribution
    $contribution = new Contribution($id);
    $contribution-> set("note", $note);
    $contribution-> set("commentaire", $commentaire);
    $now = new DateTime();
    $contribution-> set("maj", $now->format("Y-m-d H:i:s")); 
    //Je modifie la bdd
    $update = $contribution->update(); 
    if($update){
        //Traitement pour afficher la page detail_recette
        $recette = new Recette($idRecette);
        $catalogue = new Catalogue();
        $catalogue = $catalogue->getCatalogue();
        $contributions = $recette->getContributions();
        include "templates/pages/detail_recette.php";
    } else {
        echo "<p>Impossible de modifier votre contribution</p>";
        //Traitement pour afficher la page detail_recette
        $recette = new Recette($idRecette);
        $catalogue = new Catalogue();
        $catalogue = $catalogue->getCatalogue();
        $contributions = $recette->getContributions();
        include "templates/pages/detail_recette.php";
    }
} elseif($id == 0){
    //Je modifie l'objet contribution pour la création:
    $contribution = new Contribution();
    $contribution-> set("note", $note);
    $contribution-> set("commentaire", $commentaire);
    $now = new DateTime();
    $contribution-> set("maj", $now->format("Y-m-d H:i:s"));   
    $contribution-> set("creation", $now->format("Y-m-d H:i:s"));
    $contribution-> set("utilisateur", GestionSessionUtilisateur::utilisateurConnecte()->id()); 
    $contribution-> set("recette", $idRecette);  
    //Je crée la contribution dans la bdd
    $creer = $contribution->insert();
    if(!empty($creer)){
        //Traitement pour afficher la page detail_recette
        $recette = new Recette($idRecette);
        $catalogue = new Catalogue();
        $catalogue = $catalogue->getCatalogue();
        $contributions = $recette->getContributions();
        include "templates/pages/detail_recette.php";
    }else {
        echo "<p>Impossible d'enregistrer votre contribution</p>";
        //Traitement pour afficher la page detail_recette
        $recette = new Recette($idRecette);
        $catalogue = new Catalogue();
        $catalogue = $catalogue->getCatalogue();
        $contributions = $recette->getContributions();
        include "templates/pages/detail_recette.php";
    }
}
