<?php
/**
 * Classe décrivant l'objet Recette du modèle conceptuel
 */

namespace modeles;

class Recette extends _model{
    protected $table = "recettes";
    protected $attributs = ["titre", "difficulte", "utilisateur", "description", "realisation", "creation", "maj", "publie"];     // liste simple des noms des attributs sans l'id
    protected $liens = ["utilisateur"=>"Utilisateur"];      // tableau  [ nomChamp => objetPointé, .... ]
    protected $liensMultiples = ["farines"=>"Farine", "contributions"=>"Contribution"]; // tableau [ nomChamp => objetPointé, .... ]
    protected $relation = ["ingredients_choisis"=>"recette", "contributions"=>"recette", "farines_choisies"=>"recette" ];       // tableau [ nomDeLaTable => champLiantTable]

    //Ajout des infos du modéle physique:
    protected $valeurs =[];     //stockage des valeurs des attributs (quand remplis) [ "champ1" = "valeur1", "champ2" => "valeur2" ]
    protected $idChamp = "id";  //Par défaut si pas de personnalisation dans la classe "fille"
    protected $id = 0;          //Modele appartenant au physique, l'id de l'objet

    //Methodes surchargées pour Recette:

    function recetteUne(){
        //Role: Récupérer la recette qui a la meilleure note moyenne dans les contributions
        //Parametre: 
        //  Neant
        //Retour: un objet Recette avec les infos de la recette avec la meilleure moyenne

        //Etapes pour la requete:
        //Attention, la requete ne doit prendre en compte que les recettes publiées soit publie=1
        //  1-Calculer la moyenne de chaque recette cad la somme de toutes les notes/le nombre de note
        // 2-Trier les recettes par la note
        // 3-Prendre la 1ere du tableau 
        
        $sql = "SELECT `r`.`id`, `r`.`titre`, `r`.`difficulte`, `r`.`utilisateur`, `r`.`description`, `r`.`realisation`, `r`.`creation`, `r`.`maj`, `r`.`publie`, AVG(`c`.`note`) AS `moyenne` 
        FROM `recettes` `r`
        LEFT JOIN `contributions` `c` ON `r`.`id` = `c`.`recette` 
        WHERE `r`.`publie` = 1 
        GROUP BY `r`.`id` 
        ORDER BY `moyenne` DESC 
        LIMIT 1 
        ";

        //Je récupére la seule ligne du tableau:
        $ligne = bddGetRecord($sql);

        //Je vérifie si le tableau $ligne est vide ou pas
        if (empty($ligne)) {
            return false;
        }

        $recette = $this->loadFromTab($ligne);
        $this->valeurs["moyenne"] = $ligne["moyenne"];
        $recette = $this->id = $ligne["id"];
        return $recette;
    }

    public function getMoyenne() {
        //Role: getter, récupérer la valeur du champ moyenne 
        //Parametre:
        //      Neant
        //Retour: la valeur du champ moyenne sinon null
        return isset($this->valeurs["moyenne"]) ? $this->valeurs["moyenne"] : null;
    }

    //Methodes pour la classe associée ingredients_choisis
    function getIngredientsChoisis($id){
        //Role: Récupérer les ingredients_choisis de la recette
        //Parametres:
        //  $id: id de la recette
        //Retour: un tableau associatif des ingredients

        //Construction de la requete:
        $sql = "SELECT `id`, `recette`, `ingredient`, `quantite`, `unite` FROM `ingredients_choisis` WHERE `recette`=:id";

        //Construction des parametres:
        $param = [":id"=>$id];

        //J'execute la requete et recupere les lignes du tableau
        $lignes = bddGetRecords($sql, $param);

        //Je retourne le tableau des ingredients:
        return $lignes;
    }

    function ajouterIngredientChoisi($ingredient, $quantite, $unite){
        //Role: Ajouter un ingredient à la table associée ingredients_choisis
        //Parametres:
        //  $ingredient: le nom de l'ingredient
        //  $quantite
        //  $unite
        // Retour: id de l'ingredient choisi sinon 0

        //Construction de la requete:
        $sql="INSERT INTO `ingredients_choisis` SET `recette`=:recette,`ingredient`=:ingredient,`quantite`=:quantite,`unite`=:unite";

        //Construction des parametres:
        $param = [":recette"=>$this->id(), ":ingredient"=>$ingredient, ":quantite"=>$quantite, ":unite"=>$unite];

        //On prepare et on execute la requete:
        $req = bddRequest($sql, $param);

        //On vérifie si la requete à marcher:
        if($req == false) {
            return 0;
        }

        //Retour
        global $bdd;
        return $bdd->lastInsertId();
    }

    function supprimerIngredientChoisi($id){
        //Role: Supprimer un ingredient choisi de la table associée ingredients_choisis
        //Parametre:
        //  $id: id de l'ingredient choisi à supprimer
        //Retour: true si ok sinon false

        //Construction de la requete:
        $sql ="DELETE FROM `ingredients_choisis` WHERE `id`=:id";

        //Construction des parametres:
        $param = [":id"=>$id];

        //On prepare et on execute la requete:
        $req = bddRequest($sql, $param);
        //On vérifie si la requete à marcher:
        if($req == false) {
            return false;
        } else {
            //Retour
            return true;
        }

    }

    //Methodes pour la classe associée farines_choisies
    function getFarinesChoisies($id){
        //Role: Récupérer les farines_choisis de la recette
        //Parametres:
        //  $id: id de la recette
        //Retour: un tableau associatif des farines

        //Construction de la requete:
        $sql = "SELECT `id`, `recette`, `farine`, `quantite`, `unite` FROM `farines_choisies` WHERE `recette`=:id";

        //Construction des parametres:
        $param = [":id"=>$id];

        //J'execute la requete et recupere les lignes du tableau
        $lignes = bddGetRecords($sql, $param);

        //Je retourne le tableau des ingredients:
        return $lignes;
    }

    function ajouterFarineChoisie($farine, $quantite){
        //Role: Ajouter une farine à la table associée farines_choisies
        //Parametres:
        //  $farine: la ref de la farine
        //  $quantite
        // Retour: id de la farine choisie sinon 0

        //Construction de la requete:
        $sql="INSERT INTO `farines_choisies` SET `recette`=:recette,`farine`=:farine,`quantite`=:quantite";

        //Construction des parametres:
        $param = [":recette"=>$this->id(), ":farine"=>$farine, ":quantite"=>$quantite];

        //On prepare et on execute la requete:
        $req = bddRequest($sql, $param);

        //On vérifie si la requete à marcher:
        if($req == false) {
            return 0;
        }

        //Retour
        global $bdd;
        return $bdd->lastInsertId();
    }

    function supprimerFarineChoisie($id){
        //Role: Supprimer une farine choisie de la table associée farines_choisies
        //Parametre:
        //  $id: id de la farine choisie à supprimer
        //Retour: true si ok sinon false

        //Construction de la requete:
        $sql ="DELETE FROM `farines_choisies` WHERE `id`=:id";

        //Construction des parametres:
        $param = [":id"=>$id];

        //On prepare et on execute la requete:
        $req = bddRequest($sql, $param);
        //On vérifie si la requete à marcher:
        if($req == false) {
            return false;
        } else {
            //Retour
            return true;
        }
    }

    function compterFarinesChoisies(){
        //Role: Compter le nombre de farines choisies de la recette
        //Parametre: Neant
        //Retour: le nombre de farines choisies

        //je récupère les farines_choisies
        $farinesChoisies = $this->getFarinesChoisies($this->id);
        $nbreFarinesChoisies = count($farinesChoisies) ?? 0;
        //je fais le retour:
        return $nbreFarinesChoisies;
    }

    function AllRecettes(){
        //Role: Récupérer toutes les recettes dont le champ publie=1 et trié par date de mise à jour
        //Parametre:
        //  Néant
        //Retour: un tableau d'objets des recettes

        //J'utilise la fonction listFiltre($filtres=[], $order="") de mon model
        $filtre = ["publie"=>1];
        $order = "maj";

        return $this->listFiltre($filtre, $order);
    }

    function getContributions(){
        //Role: Récupérer toutes les contributions de la recette en cours
        //Parametre:
        //  Neant
        //Retour: tableau contenant toutes les contributions de la recette
        $contribution = new Contribution();
        $contributions = $contribution->recupererContributionsForRecette($this->id);
        return $contributions;
    }
}