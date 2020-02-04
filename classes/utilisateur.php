<?php

/*
 * Classe : utilisateur : gestion des utilisateurs
 * Héritée de module
 */

class utilisateur extends module {

    // Attributs
    protected $table = "utilisateurs";
    protected $key = "id";
    protected $typeObjet = "utilisateur";

    protected function construitChamps() {

        $this->addNumber("id", "identifiant");
        $this->addString("nom", "nom de l'utilisateur");
        $this->addString("prenom", "prenom de l'utilisateur");
        $this->addString("email", "adresse e-mail / login de connexion");
        $this->addString("passwd", "mot de passe");
        $this->addString("habilitation", "habilitation");
        $this->addBool("admin", "administrateur ?");
    }

    public function getNomComplet() {
        // Rôle : retourner le nom complet de l'objet courant
        // Retour : le nom de complet
        // Paramètres : néant

        return $this->get("prenom") . " " . $this->get("nom");
    }

}
