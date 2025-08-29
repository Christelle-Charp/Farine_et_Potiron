<?php

//Classe permettant de gérer la session utilisateur

//J'indique le namespace ou ce trouve ma classe GestionSessionUtilisateur
namespace library;

//J'appelle les classes que je vais utiliser dans la classe GestionSessionUtilisateur
use modeles\Utilisateur;
use modeles\Recette;

class GestionSessionUtilisateur {
    /*
    Toutes les fonctions de cette classe sont en mode static car je n'instancie pas d'objet GestionSessionUtilisateur 
    et je ne modifie donc pas d'attribut de cet objet mais seulement la variable global $_SESSION 
    */

    public static function connecter($id){
        //Role: Déclarer qu'un utilisateur est connecté - Fonction d'activation de la connexion
        //Parametre:
        //  $id: id de l'utilisateur que l'on va déclarer connecté
        //Retour: true si ok sinon false

        $_SESSION["utilisateur"] = $id;
        $_SESSION["active"] = true;
        $_SESSION["derniere_action"] = time();
        $_SESSION["recherche"] = "";
    }

    public static function deconnecter(){
        //Role: déconnecter l'utilisateur connecté
        //Parametre: Néant
        //Retour: true si ok sinon false
        $_SESSION["utilisateur"] = 0;
        $_SESSION["active"] = false;
        $_SESSION["derniere_action"] = null;
        $_SESSION["recherche"] = "";
        return true;
    }

    public static function etatConnexion(){
        //Role: indiquer si un utilisateur est connecté - Fonction de vérification de la connexion, si elle est active
        //  Prendre en compte le délai depuis la dernière action et si sup à 24h, déconnecter
        //Parametre: Neant
        //Retour: true si une connexion est en cours sinon false

        //1ere étape: je vérifie si l'utilisateur est connecté:
        if(!empty($_SESSION["utilisateur"]) && $_SESSION["active"]){
            //2eme étape, je vérifie si le délai entre maintenant et derniere_action est inférieur à 24h
            if((time()-$_SESSION["derniere_action"]) < 86400) {
                //3eme étape, je mets à jour $_SESSION["derniere_action"]
                $_SESSION["derniere_action"] = time();
                //4eme étape, je retourne true
                return true;
            } else {
                //Si le délai de 24h est dépassé, je déconnecte l'utilisateur
                self::deconnecter();    //self évite de réécrire le nom de la classe à appeller car je suis dedans. 
                //Et comme pas d'héritage dans cette classe,
                // pas besoin d'utiliser static:: - self:: suffit
                return false;
            }
        }
        return false;
    }

    public static function verifIdentifiant($identifiant, $mdp){
        //Role: vérifier si les codes de connexion sont valables est si oui, connecter l'utilisateur
        //Parametres:
        //      $identifiant: identifiant de connexion 
        //      $mdp: mot de passe à vérifier
        //Retour: un objet utilisateur correspondant aux codes s'il existe, sinon false

        //Chercher l'utilisateur correspondant à l'identifiant
        $utilisateur = new Utilisateur();
        $utilisateur->loadByIdentifiant($identifiant);
        //Si l'identifiant n'existe pas: on retourne false:
        if(! $utilisateur->is()){
            return false;
        }

        //Vérifier que le mot de passe correspond a l'identifiant:
            //Si oui on retourne l'objet utilisateur chargé
            //Sinon, on retourne false
        if(password_verify($mdp, $utilisateur->get("mdp"))){
            self::connecter($utilisateur->id());
            return $utilisateur;
        }else{
            return false;
        }
    }

    public static function utilisateurConnecte(){
        //Role: Récupérer l'objet utilisateur connecté
        //Parametre: néant
        //Retour: objet utilisateur chargé avec les infos de l'utilisateur connecté ou un objet vide
        if(self::etatConnexion()){
            return new Utilisateur($_SESSION["utilisateur"]);
        }else{
            return new Utilisateur();
        }
    }
}
