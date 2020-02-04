<?php
/*
 * Script PHP d'initialisations diverses
 *
 */

// Affichage des erreurs
ini_set('display_errors', 1);
error_reporting(E_ALL);
//session_start();

// Inclusion des fichiers de fonctions
include "lib/fonctions.php";

// Inclure les classes
include "classes/module.php";
include "classes/utilisateur.php";
include "classes/article.php";
include "classes/categorie.php";

// Ouverture de la base de données
global $bdd;
//$bdd = new PDO("mysql:host=sqlprive-be24678-001.privatesql;dbname=p-fromentin; charset=UTF8","p-fromentin", "Delauney42");
$bdd = new PDO("mysql:host=xxx;dbname=xxx; charset=UTF8", "xxx", "xxx");
