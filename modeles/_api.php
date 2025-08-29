<?php

// Classe mere qui va servir de base aux autres classes chargées par une API
// Cette classe se contruit de manière généraliste et abstraite pour pouvoir etre appliquée aux classes "enfants"

//Je déclare l'espace de nom de ma classe
namespace modeles;

class _api{
    //Décrire l'objet réel: attributs pour décrire l'objet mais sans les nommer->ce fait dans la classe qui utilisera la cette classe comme "mère"
    protected static $urlAPI = "";          //URL de l'API à définir dans chaque classe fille
    protected $attributs = [];              // liste simple des noms des attributs sans l'id

    //Ajout des infos du modéle physique:
    protected $valeurs =[];     //stockage des valeurs des attributs (quand remplis) [ "champ1" = "valeur1", "champ2" => "valeur2" ]
    protected $idChamp = "ref";  //Par défaut si pas de personnalisation dans la classe "fille"
    protected $id = "";          //Modele appartenant au physique, l'id de l'objet

    function __construct($id = null) {
        //Role: constructeur (appelé automatiquement au "new"): charge une ligne de la bdd si on précise un id
        //Parametre:
        //      $id: facultatif car dans la parenthèse il y a $id=null. id de la ligne de la bdd à charger dans l'objet qu'on crée
        if(! is_null($id)) {
            $this->loadFromRef($id);
        }
    }

    function is() {
        // Rôle : vérifier si l'objet est chargé
        //parametre: néant
        //Retour: true s'il est chargé sinon false

        return !empty($this->id);

    }

    function id() {
        // Rôle : récupérer l'id de l'objet
        //Paramètre: néant
        //Retour: valeur de l'id ou sinon 0

        if(isset($this->id)){
            return $this->id;
        } else {
            return 0;
        }
    }

    function get($nom) {
        //Role: getter, récupérer la valeur d'un champ donné
        //Parametre:
        //      $nom: nom du champ à récupérer
        //Retour: valeur du champ ou valeur par défaut (chaine vide "")

        //Je vérifie si $nom fait partie des attributs dans le tableau listant le nom des attributs: $this->attributs
        if(! in_array($nom, $this->attributs)){
            return "";
        }

        //est ce qu'il a une valeur: il y a une valeur dans le tableau $this->valeurs (le tableau se charge au moment du loadFromId)
        if (isset($this->valeurs[$nom])) {
            //on retourne la valeur
            return $this->valeurs[$nom];
        } else {
            return "";
        }
    }

    function set($nom, $valeur) {
        //Role: setter, donne ou modifie la valeur d'un champ
        //Parametres:
        //      $nom: nom de l'attribut concerné
        //      $valeur: nouvelle valeur
        //retour: true si ok sinon false

        //Je vérifie si $nom fait partie des attributs dans le tableau listant le nom des attributs: $this->attributs
        if(! in_array($nom, $this->attributs)){
            return "";
        }

        //Si l'attribut existe, je remplace sa valeur par $valeur
        $this->valeurs[$nom] = $valeur;
        return true;
    }

    function callAPI($url){
        //Role: Récupérer les informations d'une API
        //Parametre:
        //      $url: url de l'API à appeler
        //Retour: la réponse décodée de l'API

        //Initialisatin de l'api:
        $api = curl_init($url);

        //On demande les données envoyées par l'API
        curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($api, CURLOPT_TIMEOUT, 10); // Timeout de sécurité
        curl_setopt($api, CURLOPT_SSL_VERIFYPEER, false); // à éviter en prod si possible
        curl_setopt($api, CURLOPT_FOLLOWLOCATION, true);    //Si l'adresse est redirigée


        //On soumet la requete et on récupère le résultat (false en cas d'echec)
        $reponse = curl_exec($api);
        //On teste la réponse
        if ($reponse === false) {
            // erreur de la réponse
            $message = curl_error($api);
            curl_close($api);
            error_log("Erreur réseau lors de l’appel à $url : $message");
            return null;
        }

        curl_close($api);

        // Tentative de décodage JSON
        $data = json_decode($reponse, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("Erreur JSON à $url : " . json_last_error_msg());
            return null;
        }

        return $data;

    }

    function loadFromRef($ref){
        //Role: charger un objet depuis les données récupérées de l'API
        //Parametre:
        //      $ref: ref de l'objet
        //Retour: true si on a réussi sinon false

        //Je crée mon url pour appeler l'api
        $url = static::$urlAPI . "?ref=" . urlencode($ref);
        //J'appelle l'api avec la référence
        $data = $this->callAPI($url);

        if(!is_array($data) || !isset($data[$this->idChamp])){
            return false;
        }
        $this->loadFromTab($data);
        $this->id = $data[$this->idChamp];
        return true;

    }

    function loadFromTab($tab) {
        //Role: charger les valeurs des attributs à partir des données dans un tableau indexé par les noms de champ sauf l'id
        //Parametres:
        //      $tab: tableau indexé, dont les index sont des attributs (du modele physique)
        //Retour: true si ok sinon false

        //Pour chaque attribut de l'objet,
        // si il est dans le tableau, on charge sa valeur
        foreach($this->attributs as $nomChamp) {
            if (isset($tab[$nomChamp])) {       //Si on a une valeur dans la tableau $tab:
                //On affecte la valeur au champ: on se sert du setter  $this->set(nom du champ, valeur du champ)
                $this->set($nomChamp, $tab["$nomChamp"]);
            }
        }
        return true;
    }

    function tab2TabObjects($tab) {
        //Role: Transformer, à partir d'un tableau simple de tableaux indexés des valeurs des champs (type de tableau récupéré de l api)
        // en un tableau de la classe courante
        // Parametre:
        //      $tab: tableau à transformer
        //Retour: tableau d'objets de la classe courante, indexé par l'id

        //On part d'un tableau de résultat vide:
        $result = [];
        //Pour chaque ligne de $tab
        foreach ($tab as $index=>$valeur) {
            //on crée un objet de la classe courante
            $objet = new static();
            //On le charge
            //Si les données sont sous forme [ref=>libelle], on les adapte
            if(is_string($index) && is_string($valeur)){
                $objet->loadFromTab([
                    $this->idChamp => $index,
                    "libelle"=> $valeur
                ]);
                $objet->id = $index;
            }
            //Sinon, on suppose que c'est un tableau associatif complet:
            elseif(is_array($valeur)){
                $objet->loadFromTab($valeur);
                //loadFromTab() ne gere pas l'id donc on le rajoute apres
                if(isset($valeur[$this->idChamp])){
                    $objet->id = $valeur[$this->idChamp];
                }
            }
            //On l'ajoute à $result au bon index:
            $result[$objet->id] = $objet;
        }
        return $result;
    }
}