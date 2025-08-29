<?php
/*
Controleur pour Ajax:
    Récupérer les infos de la farine
Parametre: 
    $GET ref: ref de la farine

*/

/* Initialisations 
    Tout est regroupé dans le init:     
*/

include "library/init.php";

use library\GestionSessionUtilisateur;
use modeles\Farine;



// Vérification des droits:
//Page public - pas de vérification des droits

// Récupération des parametres :
if(isset($_GET["ref"])){
    $ref = $_GET["ref"];
} else {
    $ref = "";
}

//Traitement:
//J'instancie un objet Farine:
$farine = new Farine();
$farine->loadFromRef($ref);

// Afficher le fragment:
include "templates/fragments/popup_farine.php"; 