<?php
/*
Controleur:
    Créer la recette dans la bdd
    Enregistrer la farine dans la bdd
    Extraire les farines de la recette
Parametre: 
    $GET farine & quantite
    $GET titre

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

if(isset($_GET["titre"])){
    $titre = $_GET["titre"];
}else{
    $titre = "";
}


//Traitement:

//C'est une création de recette
$recette = new Recette();
//J'ajoute l'utilisateur connecté:
$recette->set("utilisateur", GestionSessionUtilisateur::utilisateurConnecte()->id());
//J'ajoute le titre si l'utilisateur l'a ajouté:
if($titre !== ""){
    $recette->set("titre", $titre);
}
$now = new DateTime();
$recette->set("maj", $now->format("Y-m-d H:i:s"));
//Je crée la recette dans la bdd et je récupère son id
$idRecette = $recette->insert();
//J'ajoute la farine à la table associée
$recette = new Recette($idRecette);
$recette->ajouterFarineChoisie($farine, $quantite);
//Je recharge la page complete pour avoir le bon id recette sur la page:
$recette = new Recette($idRecette);
$farinesChoisies = $recette->getFarinesChoisies($recette->id());
$catalogue = new Catalogue();
$catalogue = $catalogue->getCatalogue();
ob_start();
include "templates/fragments/list_farines.php";
$htmlFarinesChoisies = ob_get_clean();
//Construction d'un fichier json pour envoyer seulement les infos nécessaires à la mise à jour de la page
echo json_encode([
    'success'=>true,
    'idRecette'=>$idRecette,
    'htmlFarinesChoisies'=> $htmlFarinesChoisies
]);