<?php
/**
 * Classe décrivant l'objet Catalogue du modèle conceptuel
 */

namespace modeles;

class Catalogue extends _api{
    protected static $urlAPI = "https://api.mywebecom.ovh/play/fep/catalogue.php";
    protected $attributs = [];
    protected $idChamp = "reference"; // ici on dit que l'identifiant est "reference"

    //Methodes surchargés pour la classe Catalogue

    function getCatalogue(){
        //Role: Récupérer un tableau d'objets qui contient tous les objets Farine en provenance de l'api
        //Parametre: néant
        //Retour: un tableau d'objet Farine

        //Je récupère le catalogue de l'api:
        $data = $this->callAPI(static::$urlAPI);
        //J'instancie mon tableau d'objet vide:
        $result = [];

        foreach($data as $ref=>$libelle){
            //Pour chaque ligne du catalogue, j'instancie un objet Farine
            $obj = new Farine();
            //Je charge chaque objet:
            $obj->loadFromTab([
                "reference"=>$ref,
                "libelle"=>$libelle
            ]);
            $obj->id = $ref;
            $result[$ref] = $obj;
        }
        return $result;

    }
}