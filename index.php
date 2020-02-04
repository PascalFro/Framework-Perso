<?php

/*
 * URL unique de l'application
 *
 * Reçoit en paramètres (GET) :
 *   - module (par défaut : articles)
 *   - action (par défaut : list)
 *   - id  (optionnel)
 *
 */

include "lib/init.php";

/*
  // Vérifier si on est connecté
  if (empty($_SESSION["connect"]) or ! $_SESSION["connect"]) {
  header("Location: login.php");
  }
 *
 */

// Récupérer le module, l'action et l'id
$module = litGET("module", "articles");
$action = litGET("action", "list");
$id = litGET("id", "");

debug("Module demandé : $module, action : $action, id : $id");



if (class_exists($module)) {
    // On va sous-traiter à la classe
    $objet = new $module();
    $methode = "action_$action";
    if (!method_exists($objet, $methode)) {
        $methode = "action_liste";
    }
    $objet->$methode($id);
} else {
    // Afichage page d'accueil ou un module par défaut
    include "templates/pages/accueil.php";
}
?>