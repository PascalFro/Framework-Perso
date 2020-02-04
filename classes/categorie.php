<?php

/*
 * Classe : categorie : gestion des catégories d'articles
 * Héritée de module
 */

class categorie extends module {

    // Attributs
    protected $table = "categories";
    protected $key = "code";
    protected $typeObjet = "categorie";

    protected function construitChamps() {

        $this->addString("code", "code");
        $this->addString("libelle", "libellé");
    }

    public function getNomComplet() {
        // Rôle : retourner le nom complet de l'objet courant
        // Retour : le nom de complet
        // Paramètres : néant

        return $this->get("libelle");
    }

    public function delete() {
        // Exemple de cas possible : On surcharge pour ne pas pouvoir supprimer
        debug("Suppression désactivée sur les catégories");
        message("Suppression désactivée sur les catégories");
        return false;
    }

}