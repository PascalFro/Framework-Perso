<?php

/*
 * Classe : module
 * Classe mère héritée par les différents modules
 * 
 * Gère les actions de base sur un module :
 *      - Accès à la base de données pour la table du module
 *      - Les scénaries des actions de base
 * 
 */

/**
 * Description of module
 *
 * @author Pascal FROMENTIN
 */
class module {      // protected = private mais permet l'héritage car private ne permet d'avoir accès à la méthode qu'à l'intérieur de la classe

//******************************************************************************
    // ATTRIBUTS :
//******************************************************************************
    // Attributs à surcharger
    protected $table = "";        // Nom de la table dans la base de données
    protected $nomObjet = "Objet générique";    // Nom affichable des types d'objet
    protected $key = "";          // Nom de la clé primaire
    // Autres attributs
    protected $valeurs = [];      // Tableau contenant la valeur des champs, sous la forme [nomchamps1 => valeurchamps1, nomchmps2 => valeurchamps2, ...]
    protected $champs = [];       // Tableau des champs (liste des champs sous la forme : ["nomchamp1" => [ "libelle" => "libelle du champ", "type" => "type du champ], etc...]
    protected $req = null;      // Requête en cours éventuelle, en mode liste
    protected $links = [];      // Tableau stockant les objets pointés dans les champs de type link ["$nomChamp" => objPointé, ...]
    protected $libelle = [];      // (tableau contenant le) Libellé des champs pour les templates
    
    
    //**************************************************************************
    // Méthodes
    //**************************************************************************
    
    //**************************************************************************
    // Constructeur :
    //**************************************************************************

    public function __construct($id = null) {  // cette fonction est appelée automatiquement dès qu'on appelle un nouvel objet (new $objet)
        // Constructeur : charge l'objet si on lui passe un id
        // Retour : Néant
        // Paramètres :
                // $id : valeur de la clé primaire à charger (si null ou inexistante, on ne charge pas)
        
        $this->construitChamps();
        if (!is_null($id)) {
            $this->loadById($id);
        }
    }
    
    protected function construitChamps() {
        // Rôle : déclare les champs (à surcharger)
    }


    //**************************************************************************
    // Construction des champs
    //**************************************************************************
    
    protected function addNumber($nom, $libelle) {
        // Rôle : déclare un champ de type nombre
        // Retour : néant
        // Paramètres :
        //          $nom : nom du champ
        //          $libelle : libellé affichable pour le champ

        $this->champs[$nom] = ["libelle" => $libelle, "type" => "number"];
    }

    protected function addString($nom, $libelle) {
        // Rôle : déclare un champ de type texte mono-ligne
        // Retour : néant
        // Paramètres :
        //          $nom : nom du champ
        //          $libelle : libellé affichable pour le champ

        $this->champs[$nom] = ["libelle" => $libelle, "type" => "string"];
    }

    protected function addText($nom, $libelle) {
        // Rôle : déclare un champ de type texte multi-ligne
        // Retour : néant
        // Paramètres :
        //          $nom : nom du champ
        //          $libelle : libellé affichable pour le champ

        $this->champs[$nom] = ["libelle" => $libelle, "type" => "text"];
    }
    
    protected function addMoney($nom, $libelle) {
        // Rôle : déclare un champ de type monétaire
        // Retour : néant
        // Paramètres :
        //          $nom : nom du champ
        //          $libelle : libellé affichable pour le champ

        $this->champs[$nom] = ["libelle" => $libelle, "type" => "money"];
    }
    
    protected function addBool($nom, $libelle) {
        // Rôle : déclare un champ de type choix oui ou choix non (booleen)
        // Retour : néant
        // Paramètres :
        //          $nom : nom du champ
        //          $libelle : libellé affichable pour le champ

        $this->champs[$nom] = ["libelle" => $libelle, "type" => "bool"];
    }
    
    protected function addlink($nom, $libelle, $link) {
        // Rôle : déclare un champ de type lien vers un autre objet
        // Retour : néant
        // Paramètres :
        //          $nom : nom du champ
        //          $libelle : libellé affichable pour le champ
        //          $link : classe de l'objet qui est pointé par ce champ

        $this->champs[$nom] = ["libelle" => $libelle, "type" => "link", "link" => $link];
    }
    //**************************************************************************
    // Opérations sur la base de données
    //**************************************************************************
    
    public function loadById($id) {
        // Rôle : charger un objet (initialiser ses attributs) depuis la table, en donnant l'ID
        // Retour : true si on a trouvé, false sinon
        // Paramètres :
        //      $id : id de l'enregistrement à charger
        
        // Construction de la requête et du tableau des paramètres
        $sql = "SELECT * FROM `$this->table` WHERE `$this->key` = :id";
        $param = [":id" => $id];
        
        // Préparaer et exécuter la requête
        $req = $this->request($sql, $param);
        // Récupérer la première ligne
        if (!($ligne = $req->fetch(PDO::FETCH_ASSOC))) {
            debug("Pas d'enregistrement $id dans la table $this->table");
            return false;
        }
        
        // Mettre à jour les attributs avec la ligne
        return $this->loadFromTable($ligne);
    }
    
    public function update() {
        // Rôle : mettre à jour l'enregistrement courant dans la base de données
        // Retour : true si réussi, false si échec
        // Paramètres : néant
        
        // Construction de la requête et le tableau des paramètres
        
        // UPDATE table SET champ1 = valeurchamp1, champ2 = valeurchamp2, ... WHERE key = :key
        $sql = "UPDATE `$this->table` SET";
        $param = [];
        // Fabriquer la liste des champs
        $liste = [];
        // Pour chaque champ
        foreach ($this->champs as $nomchamp => $descritpionChamp) {
            // Construire le texte nomchamp = :nomchamp
            // Ajouter dans les paramètres, l'index :nomchamp, avec la valeur du champ
            if ($nomchamp !== $this->key) {
                $liste[] = "`$nomchamp` = :$nomchamp";
                $param[":$nomchamp"] = $this->valeurs[$nomchamp];
            }
        }
        // Ajouter la liste des champs à la requête
        // Traiter le problème de la virgule finale
        $sql .= implode(",", $liste);       // implode transforme la liste des éléments du tableau en une chaine, en séparant les éléments par le texte donné en 1er argument
        // Clause WHERE
        $sql .= "WHERE `$this->key` = :$this->key";
        $param[":$this->key"] = $this->valeurs[$this->key];
        
        // Préparer et exécuter la requête
        $req = $this->request($sql, $param);
        
        return true;
    }

    public function insert() {
        // Rôle : insérer l'enregistrement courant dans la base de données
        // Retour : true si réussi, false si échec
        // Paramètres : néant
        
        // Construction de la requête et le tableau des paramètres
        
        // INSERT INTO table champ1 = valeurchamp1, champ2 = valeurchamp2, ... WHERE key = :key
        $sql = "INSERT INTO `$this->table` SET";
        $param = [];
        // Fabriquer la liste des champs
        $liste = [];
        // Pour chaque champ
        foreach ($this->champs as $nomchamp => $descriptionChamp) {
            // Construire le texte nomchamp = :nomchamp
            // Ajouter dans les paramètres, l'index :nomchamp, avec la valeur du champ
            if ($nomchamp !== $this->key) {
                $liste[] = "`$nomchamp` = :$nomchamp";
                $param[":$nomchamp"] = $this->valeurs[$nomchamp];
            }
        }
        // Ajouter la liste des champs à la requête
        $sql .= implode(",", $liste);
        // Traiter le problème de la virgule finale
        // Ajouter un champ fixe :key = valeurkey
        $sql .= "`$this->key` = :$this->key";
       
        
        // Préparer et exécuter la requête
        $req = $this->request($sql, $param);
        
        // Récupérer l'id
        global $bdd;
        $this->valeurs[$this->key] = $bdd->lastInsertId();
        
        return true;
    }

    public function delete() {
        // Rôle : supprimer l'enregistrement courant dans la base de données
        // Retour : true si réussi, false si échec
        // Paramètres : néant
        
        // Construction de la requête
        
        // DELETE FROM table WHERE id = :id
        $sql = "DELETE FROM `$this->table`";
       
        // Clause WHERE
        $sql .= "WHERE `$this->key` = :$this->key";
        $param[":$this->key"] = $this->valeurs[$this->key];
        
        // Préparer et exécuter la requête
        $req = $this->request($sql, $param);
        
        if ($req === false) {
            return false;
        } else {
            return true;
        }
    }
    
    //**************************************************************************
    // Récupération des infos
    //**************************************************************************
    
    public function get($nom) {
        // Rôle : Retourner la valeur d'un champs
        // Retour : la valeur du champs ou "" si pas de champ
        // Paramètres :
                // $nom : nom du champs
        
        // Si le champ n'existe pas, càd si le nom du champ n'est pas un index du tableau $this->champs
        if (! isset($this->champs[$nom])) {
            debug("Champ $nom inexistant dans le modèle $this->table");
            return "";
        }
        
        
        if(isset($this->valeurs[$nom])) {
            return $this->valeurs[$nom];
        } else {
            return "";
        }
    }
    
    public function getId() {
        // Rôle : récupère et retourne la valeur de l'id
        if (isset($this->valeurs[$this->key])) {
            return $this->valeurs[$this->key];
        } else {
            return "";
        }
    }
    
    public function getLibelle($nom) {
        // Rôle : retourner le libelle d'un champ
        // Retour : Le libelle du champ, ou le nom si on ne trouve pas de libelle
        // Paramètres :
                // $nom : nom du champs
        
        // Si le champ n'existe pas, càd si le nom du champ n'est pas un index du tableau $this->champs
        if (! isset($this->champs[$nom])) {
            debug("Champ $nom inexistant dans le modèle $this->table");
            return $nom;
        }
        
        
        if(isset($this->champs[$nom]["libelle"])) {
            return $this->champs[$nom]["libelle"];
        } else {
            return $nom;
        }
    }
    
    public function getNomObjet() {
        // Rôle : Retourner le nom de l'objet (nom du module)
        // Retour : le nom
        // Paramètres : Néant
        
        return $this->nomObjet;
    }
    
    public function getModule() {
        // Retourne le nom du module
        return get_class($this);
    }
    public function getNomComplet() {
        // Rôle : retourner le nom complet de l'objet courant
        // Retour : Le nom complet
        // PAramètres : Néant
        
        return "";
    }
    
    public function getChamps($forceId = false) {
        // Rôle : retourner la liste des champs (au format : [ "nomchamp1" => ["libelle" => "libelle du champ", "type" => "type du champ" ]
        // Retour : Le tableau
        // Paramètres : 
                // $forceId : par défaut false, retire la clé primaire ; si true, ne retire pas la clé primaire 
        $result = $this->champs;
        if (!$forceId) {
            unset($result[$this->key]);
        }
        return $result;
    }
    
    //**************************************************************************
    // Récupération des liens
    //**************************************************************************
    
    public function getLinkObj($nom){
        // Role : retourner l'objet pointé parle champs (instancié)
        // Retour : l'objet pointé et instancié s'il existe
        //          si l'objet n'existe pas : un objet du type pointé mais vide
        //          si le champs n'existe pas ou n'est pas un lien : NULL
        // Paramètres :
        //      $nom : nom du champs
        
        // Si le champs n'existe pas
        if (!isset($this->champs[$nom])) {
            debug("Champ $nom inexistant dans le modèle $this->table");
            return null;
        }
        
        // Si le champ n'est pas un lien
        if ($this->champs[$nom]["type"] !== "link") {
            debug("Champs $nom dasn le modèle $this->table n'est pas un lien");
            return null;
        }
        
        // Récupérerl'objet s'il ne l'est pas déjà
        // Vérifier si on a l'objet
        if (isset($this->links[$nom]) and $this->links[$nom]->getId() == $this->get($nom)) {
            return $this->links[$nom];
        }
        // Si on arrive ici, on n'a pas l'objet pointé ou pas le bon
        $nomClasse = $this->champs[$nom]["link"];   // On récupère le nom de la classe pointée
        $obj = new $nomClasse($this->valeurs[$nom]); // On l'instancie en passant la clé de la ligne pointée
        $this->links[$nom] = $obj;  // On le stock dans l'attribut
        return $obj;    // On le retourne
    }
    
    public function getLinkNom($nom) {
        // Rôle : Retourner le nom complet de l'enregistrement pointé par le champ link
        // Retour : la valeur du nom complet ou vide
        // Paramètres :
        //      $nom : le nom du champs
        
        $obj = $this->getLinkObj($nom);
        if (is_null($obj)) {
            return "";
        } else {
            return $obj->getNomComplet();
        }
    }
    
    public function getLinkClasse($nom) {
        // Rôle : Retourne le nom de la classe du champ pointé
        // Retour : la valeur de la classe (son nom) ou vide
        // Paramètres :
        //      $nom : nom du champ
        
        $obj = $this->getLinkObj($nom);
        if (is_null($obj)) {
            return "";
        } else {
            return $obj->getNomObjet();
        }
    }
    
    public function getLinkList($nom){
        // Rôle : Retourner la liste de choix possibles sur le champ de type Link
        // Retour : un tableau indexé [ idChoix1 => TexteChoix1, ... ]
        // Paramètres :
        //      $nom : nom du champ
        
        // Si le champ n'existe pas
        if (!isset($this->champs[$nom])) {
            debug("Champ $nom inexistant dasn le modèle $this->table");
            return [];
        }
        
        // Si le champ n'est pas un lien
        if ($this->champs[$nom]["link"] !== "link") {
            debug("Champ $nom dans le modèle $this->table n'est pas un lien");
            return[];
        }
        
        // Si on arrive ici, on n'a pas l'objet pointé ou pas le bon
        $nomClasse = $this->champs[$nom]["link"];   // On récupère le nom de la classe pointée
        $obj = new $nomClasse();    // On l'instancie sans le charger
        
        $obj->listAll();
        // Parcourir la liste pour construire le tableau
        $result = [];
        while ($obj->next()) {
            $result[$obj->getId()] = $obj->getNomComplet();
        }
        return $result;
    }
    
    //**************************************************************************
    // Mode Liste
    //**************************************************************************
    
    public function listAll() {
        // Rôle : Construction d'une liste de tous les articles
        // Retour : true ou false (false si on n'a pas d'objet)
        // Paramètres : n&ant
        //
        // Commande SQL et préparation de la requête
        
        $sql = "SELECT * FROM $this->table";
        $this->req = $this->request($sql, []);
        return true;
    }
    
    // Récupérer l'élément suivant dans la liste
    
    public function next() {
        // Rôle : charger la ligne suivante dans la liste active (si la liste existe et a un suivant)
        // Retour : true ou false (false si on n'a pas d'objet)
        // Paramètres : néant
        
        // A-t'on une liste ?
        if (!isset($this->req)) {
            return false;
        }
        // On a une liste : on tente la ligne suivante
        $ligne = $this->req->fetch(PDO::FETCH_ASSOC);
        
        if ($ligne === false) {
            // plus d'élément dans la liste
            $this->valeurs = [];
            return false;
        }
        return $this->LoadFromTable($ligne);
    }
    
    //**************************************************************************
    // GESTION DES ACTIONS
    //**************************************************************************
    
    public function action_list($id = "") {
        // Rôle : dérouler le scénario de l'affichage de la liste
        // Retour : true si ok, fasle en cas d'échec
        // Paramètres :
        //      $id (sans objet pour cette fonction)
        
        // Liste de tous les objets
        $this->listAll();
        
        // Affichage de la page
        $objet = $this;
        include "templates/pages/liste_default.php";
        return true;
    }
    
    public function action_aff($id = "") {
        // Rôle : dérouler le scénario de l'affichage d'un objet
        // Retour : true si ok, false en cas d'échec
        // Paramètres : $id
        
        // Chargement de l'objet
        if (!$this->loadById($id)) {
            // Objet non récupérable : affiche la liste
            debug($this->getNomObjet() . " " . $id . " inexistant");
            message($this->getNomObjet() . " recherché inexistant");
            // Afficher la liste (après l'avoir chargée)
            $this->action_list();
            return false;
        } else {
            // Afficher l'objet
            $objet = $this;
            include "templates/pages/affiche_default.php";
            return true;
        }
    }
    
    function action_modif_form($id = "") {
        // Rôle : affichage du formulaire de modification d'un objet
        // Retour : true ou false (false en cas d'échec)
        // Paramètres :
        //      $id : id de l'élément à afficher
        //
        // Charger l'objet
        if (!$this->loadById($id)) {
            // Objet non récupérable : affiche la liste
            debug($this->getNomObjet() . " " . $id . " inexistant");
            message($this->getNomObjet() . " recherché inexistant");
            // Afficher la liste (après l'avoir chargée)
            $this->action_list();
            return false;
        } else {
            // Afficher le formulaire
            $mode = "MOD";
            $objet = $this;
            include "templates/pages/form_default.php";
            return true;
        }
    }
    
    function action_modif_traite($id = "") {
        // Rôle : traitement du formulaire de modification d'un article, et affichage soit à nouveau du formulaire, soit de l'élément
        // Retour : true ou false (false en cas d'échec)
        // Paramètres :
        //      $id : id de l'élément à modifier
                  
        // Charger l'objet
        if (!$this->loadById($id)) {
            // Objet non récupérable : affiche la liste
            debug($this->getNomObjet() . " " . $id . " inexistant");
            message($this->getNomObjet() . " recherché inexistant");
            // Afficher la liste (après l'avoir chargée)
            $this->action_list();
            return false;
        } else {
            // Récupérer les champs saisis
            $this->loadFromTable($_POST);
            // Mettre à jour dans la base
            if ($this->update()) {
                // afficher l'objet
                $objet = $this;
                include "templates/pages/affiche_default.php";
                return true;
            } else {
                // Sinon : réafficher le formulaire
                $mode = "MOD";
                include "templates/pages/form_default.php";
                return false;
            }
        }
    }
    
    function action_delete($id = "") {
        // Rôle : suppression d'un objet
        // Retour : true ou false
        // Paramètres :
        //      $id : id de l'article à supprimer
        
        // Charger l'objet
        if (!$this->loadById($id)) {
            // Objet non récupérable : affiche la liste
            debug($this->getNomObjet() . " " . $id . " inexistant");
            message($this->getNomObjet() . " recherché inexistant");
            // Afficher la liste (après l'avoir chargée)
            $this->action_list();
            return false;
        } else {
            $this->delete();
            $this->action_list();
            return true;
        }
    }
    
    function action_ajout_form($id = "") {
        // Rôle : affichage du formulaire d'ajout d'un élément
        // Retour : true ou false (false en cas d'échec)
        // Paramètres :
        //      $id (sans objet ici)

        // Afficher le formulaire
        $mode = "CREER";
        $objet = $this;
        include "templates/pages/form_default.php";
        return true;
    }
    
    function action_ajout_traite($id = "") {
        // Rôle : traitement du formulaire d'ajout d'un élément, et affichage soit à nouveau du formulaire, soit de l'élément
        // Retour : true ou false (false en cas d'échec)
        // Paramètres :
        //      $id (sans objet ici)
        
        // Récupérer les champs saisis
        $this->loadFromTable($_POST);
        // Créer dans la base
        if ($this->insert()) {
            // afficher l'élément : afficher la page affiche_element
            message($this->getNomObjet() . " créé");
            $objet = $this;
            include "templates/pages/affiche_default.php";
            return true;
        } else {
            // Sinon : réafficher le formulaire
            $mode = "CREER";
            $objet = $this;
            include "templates/pages/form_default.php";
            return false;
        }
    }
    //**************************************************************************
    // Méthodes internes
    //**************************************************************************
    
    protected function request($sql, $param) {
        // Rôle : préparer et exécuter une requête
        // Retour : La requête exécutée ou false en cas d'erreur
        // Paramètres :
                // $sql : la requête elle-même
                // $param : le tableau des paramètres à substituer
        
        // Récupérer la base de données
        global $bdd;
        
        // Préparer la requête
        $req = $bdd->prepare($sql);
        
        // En cas d'échec on retourne false
        if ($req === false) {
            debug("Echec de la préparation de la requête : $sql");
            return false;
        }
        
        // Exécution de la requête
        if (!$req->execute($param)) {
            debug("Echec d'exécution de la requête : $sql");
            return false;
        }
        
        // La requête a réussi
        debug("La requête a réussi ($sql), et a impacté " . $req->rowCount() . " ligne(s)");
        return $req;
    }
    
    protected function LoadFromTable($tab) {
        // Charge (initialise) les attributs de l'objet à partir d'un tableau PHP de la forme [nomchamps1 => valeurchamps1, nomchmps2 => valeurchamps2, ...]
        // Retour : true si réussi, false si échec
        // Paramètres :
                // $tab : le tableau contenant les valeurs de champs
        
        // Pour chaque champ
        foreach ($this->champs as $nomchamp=> $descriptionChamp) {
            // Mettre à jour l'index $nomchamps de l'attribut valeurs
            if (isset($tab[$nomchamp])) {
                $this->valeurs[$nomchamp] = $tab[$nomchamp];
        } else {
            debug("Le champ $nomchamp n'a pas été récupéré dans la requête sur $this->table");
        }
    }
    return true;
    }
    
}
