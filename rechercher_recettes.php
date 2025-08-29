<?php
/*
Controleur pour Ajax:
    Extraire liste des recettes en fonction des critères de recherche
Parametre: 
    $POST critères de recherche

*/

/* Initialisations 
    Tout est regroupé dans le init:     
*/

include "library/init.php";

use modeles\Recette;
use modeles\Catalogue;
use library\GestionSessionUtilisateur;



// Vérification des droits:
//Page public - pas de vérification des droits

// Récupération des paramètrs :
if (isset($_POST["farines"])){
    $rechercheFarines = $_POST["farines"];
} else{
    $rechercheFarines = [];
}

if(isset($_POST["difficulte"])){
    $rechercheDifficulte = $_POST["difficulte"];
}else{
    $rechercheDifficulte = "";
}

if(isset($_POST["recherche"])){
    $rechercheText = $_POST["recherche"];
}else{
    $rechercheText = "";
}

//Traitement:
//Je récupère le catalogue des farines:
$catalogue = new Catalogue();
$catalogue = $catalogue->getCatalogue();
//J'instancie un objet recette
$recette = new Recette();

//Si tous les champs recherches sont vides:
if(empty($rechercheFarines) && $rechercheDifficulte == "" && $rechercheText ==""){
    $recettes = $recette->AllRecettes();
    include "templates/pages/formulaire_recherche.php";
    exit;
}

//Je commence par la recherche difficulté
//Je reprends mon filtre sur publie qui est obligatoire pour avoir les recettes completes
$filtres=["publie"=>1];
if($rechercheDifficulte !== ""){
    $filtres["difficulte"] = $rechercheDifficulte;
}
//Je lance ma fonction listFiltre
$recettes = $recette->listFiltre($filtres);

//Je continue par la recherche texte sur les résultats obtenus
if($rechercheText !== ""){
    //On utilise la fonction array_filter pour parcourir le tableau de recettes qui a passé le 1er filtre
    //et on garde les recettes qui vont retourner true dans le nouveau tableaux $recettes
    $recettes = array_filter($recettes, function($r) use ($rechercheText) {
        //$r représente un objet Recette
        //use permet à la fonction anonyme function($r) de récupérer la variable $rechercheText qui est à l'extérieur d'elle
        //stripos est une fonction pour faire une recherche insensible à la casse(majuscule ou miniscule) qui retourne la position du mot clé dans le texte
        //Si le texte recherché est trouvé dans le titre ou la description, la recette est conservée. 
        return stripos($r->get("titre"), $rechercheText) !== false ||
               stripos($r->get("description"), $rechercheText) !== false;
    });

}
//Je finis par la recherche des farines des recettes
if (!empty($rechercheFarines)) {
    //On utilise la fonction array_filter pour parcourir le tableau de recettes qui a passé les filtres précédants
    //et on garde les recettes qui vont retourner true dans le nouveau tableaux $recettes
    $recettes = array_filter($recettes, function($r) use ($rechercheFarines) {
        //$r représente un objet Recette
        //use permet à la fonction anonyme function($r) de récupérer la variable $rechercheFarines qui est à l'extérieur d'elle
        //Pour chaque recette, je récupère les farines_choisies dans la variable $farines
        $farines = $r->getFarinesChoisies($r->id());
        //Pour chaque recette, je crée un tableau qui contient les références des farines
        $idsFarines = array_column($farines, "farine");
        //Ensuite je compare le tableau $idsFarines qui contient les références des farines des recettes au tableau $rechercheFarines
        //qui contient la iste des références des farines cherchées 
        //Si le nombre de farines en commun entre les 2 tableaux est supérieur à 0, la recette est ajouté au nouveau tableau $recettes crée
        return count(array_intersect($idsFarines, $rechercheFarines)) > 0;
    });
}


// Afficher la page: 
include "templates/pages/formulaire_recherche.php";