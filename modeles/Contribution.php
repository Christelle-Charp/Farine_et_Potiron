<?php
/**
 * Classe décrivant l'objet Contribution du modèle conceptuel
 */

namespace modeles;

class Contribution extends _model{
    protected $table = "contributions";
    protected $attributs = ["note", "commentaire", "utilisateur", "recette", "creation", "maj"];     // liste simple des noms des attributs sans l'id
    protected $liens = ["utilisateur"=>"Utilisateur", "recette"=>"Recette"];      // tableau  [ nomChamp => objetPointé, .... ]
    protected $liensMultiples = []; // tableau [ nomChamp => objetPointé, .... ]
    protected $relation = [];       // tableau [ nomDeLaTable => champLiantTable]

    //Ajout des infos du modéle physique:
    protected $valeurs =[];     //stockage des valeurs des attributs (quand remplis) [ "champ1" = "valeur1", "champ2" => "valeur2" ]
    protected $idChamp = "id";  //Par défaut si pas de personnalisation dans la classe "fille"
    protected $id = 0;          //Modele appartenant au physique, l'id de l'objet

    //Methode surchargée

    function recupererContributionsForRecette($recette){
        //Role: Récupérer toutes les contributions d'une recette
        //Parametre:
        //  la recette
        //Retour: tableau contenant toutes les contribution de la recette

        //construire la requete
        $sql = "SELECT `id`, `note`, `commentaire`, `creation`, `maj`, `utilisateur`, `recette` 
        FROM `contributions` 
        WHERE `recette`=:recette";

        //construire les parametres:
        $param = [":recette"=>$recette];

        //Je récupére les lignes du tableau
        $lignes = bddGetRecords($sql, $param);

        //Je le transforme en tableau d'objets
        $list = $this->tab2TabObjects($lignes);

        //Je fais le retour:
        return $list;
    }

    function getContributionByUtilisateurAndRecette($utilisateur, $recette){
        //Role: Récupérer la contribution d'un utilisateur dans un recette
        //Parametre:
        //  $utilisateur: l'utilisateur dont on veut la contribution
        //  $recette: la recette dans laquelle on cherche la contribution
        //Retour: l'objet contribution trouvé sinon un objet contribution vide

        //construire la requete:
        $sql="SELECT `id`, `note`, `commentaire`, `creation`, `maj`, `utilisateur`, `recette` 
        FROM `contributions` 
        WHERE `utilisateur`=:utilisateur AND `recette`=:recette
        ";

        //Construire les parametres
        $param = [":utilisateur"=>$utilisateur, ":recette"=>$recette];

        //Je récupère la ligne du tableau
        $ligne = bddGetRecord($sql, $param);

        //Je vérifie si le tableau $ligne est vide
        if(empty($ligne)){
            return new Contribution();
        }
        //J'instancie un objet Contribution vide et je le rempli
        $contribution = new Contribution();
        $contribution->loadFromTab($ligne);
        $contribution->id = $ligne["id"];
        return $contribution;
    }
}