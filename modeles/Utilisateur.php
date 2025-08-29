<?php
/**
 * Classe décrivant l'objet Utilisateur du modèle conceptuel
 */

namespace modeles;

class Utilisateur extends _model{
    // Décrire l'objet réel : attributs pour décrire l'objet réel
    // On décrit le modèle conceptuel

    protected $table = "utilisateurs";
    protected $attributs = ["pseudo", "mdp", "email"];
    protected $liens = [];      // tableau  [ nomChamp => objetPointé, .... ]

    protected $liensMultiples = ["recettes"=>"Recette", "contributions"=>"Contribution"];
    protected $relation = ["recettes"=>"utilisateur", "contributions"=>"utilisateur"];       // tableau [ nomDeLaTable => champLiantTable]

    //Ajout des infos du modéle physique:
    protected $valeurs =[];     //stockage des valeurs des attributs (quand remplis) [ "champ1" = "valeur1", "champ2" => "valeur2" ]
    protected $idChamp = "id";  //Par défaut si pas de personnalisation dans la classe "fille"
    protected $id = 0;          //Modele appartenant au physique, l'id de l'objet

    //Fonctions surchargées pour la classe Utilisateur:
    function loadByIdentifiant($identifiant) {
        // Rôle : charger un utilisateur en connaissant son identifiant qui correspond à l'adresse soit à mail ou à pseudo qui sont uniques
        // Paramètres :
        //      $identifiant : identifiant cherché
        // Retour : true, false sinon

        // Construction de la requête SQL :
        $sql = "SELECT " . $this->listeChampsPourSelect() . " FROM `$this->table` WHERE `email`= :identifiant OR `pseudo`= :identifiant";
        // Construction des parametres:
        $param = [ ":identifiant" => $identifiant];

        // Je recupere la seule ligne du tableau
        $ligne = bddGetRecord($sql, $param);

        //Je vérifie si le tableau $ligne est vide ou pas
        if (empty($ligne)) {
            return false;
        }

        $this->loadFromTab($ligne);
        //Je rajoute l'id car la fonction loadFromTab ne gère pas l'id
        $this->id = $ligne["id"];
        return true;
    }

    function loadByEmail($email) {
        // Rôle : charger un utilisateur en connaissant son email qui correspond à l'adresse mail qui est unique
        // Paramètres :
        //      $email : email cherché
        // Retour : true, false sinon

        // Construction de la requête SQL :
        $sql = "SELECT " . $this->listeChampsPourSelect() . " FROM `$this->table` WHERE `email`= :email";
        // Construction des parametres:
        $param = [ ":email" => $email];

        // Je recupere la seule ligne du tableau
        $ligne = bddGetRecord($sql, $param);

        //Je vérifie si le tableau $ligne est vide ou pas
        if (empty($ligne)) {
            return false;
        }

        $this->loadFromTab($ligne);
        //Je rajoute l'id car la fonction loadFromTab ne gère pas l'id
        $this->id = $ligne["id"];
        return true;
    }

    function loadByPseudo($pseudo) {
        // Rôle : charger un utilisateur en connaissant son pseudo qui correspond à un pseudo unique
        //      $pseudo : pseudo cherché
        // Retour : true, false sinon

        // Construction de la requête SQL :
        $sql = "SELECT " . $this->listeChampsPourSelect() . " FROM `$this->table` WHERE `pseudo`= :pseudo";
        // Construction des parametres:
        $param = [ ":pseudo" => $pseudo];

        // Je recupere la seule ligne du tableau
        $ligne = bddGetRecord($sql, $param);

        //Je vérifie si le tableau $ligne est vide ou pas
        if (empty($ligne)) {
            return false;
        }

        $this->loadFromTab($ligne);
        //Je rajoute l'id car la fonction loadFromTab ne gère pas l'id
        $this->id = $ligne["id"];
        return true;
    }

}