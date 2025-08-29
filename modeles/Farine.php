<?php
/**
 * Classe décrivant l'objet Farine du modèle conceptuel
 */

namespace modeles;

class Farine extends _api{
    protected static $urlAPI = "https://api.mywebecom.ovh/play/fep/catalogue.php";
    protected $attributs = ["reference", "libelle", "description"];
    protected $idChamp = "reference"; // ici on dit que l'identifiant est "reference"
}

