<?php

/*
 * Classe : article : gestion des articles
 * Héritée de module
 */

class article extends module {  // Permet l'héritage de la classe module

    //Attributs
    protected $table = "articles_simples";
    protected $key = "id";
    protected $nom_objet = "Article";
    
    protected function construitChamps() {
        // Rôle : construit les chamsp avec le bon type
        $this->addNumber("id","identifiant");
        $this->addString("libelle","nom");
        $this->addText("designation","description");
        $this->addMoney("prix","prix en euros");
        $this->addlink("categ", "catégorie", "categorie");
        debug(print_r($this->champs, true));    // On rajoute true car print_r est dans une fonction
    }
    
    public function getNomComplet() {
        // Rôle : retourner le nom complet de l'objet courant
        // Retour : Le nom complet
        // PAramètres : Néant
        
        return $this->get("libelle");
    }
    
    // Exemple de cas possible : On ne veut pas détruire les artciles de la catégorie CT2
    public function delete() {
        if($this->get("categ") === "CT2") {
            return false;
        } else {
            parent::delete();   // Rappelle la fonction du module pour qu'elle s'applique
        }
    }
}
