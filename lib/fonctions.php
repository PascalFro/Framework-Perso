<?php

/*
 * Fonction diverses
 *
 */

function litGET($param, $def) {
    // Rôle : récupérer un paramètre dans $_GET si il existe, retourner une valeur par défaut sinon
    // Retour : la valeur du paramètre GET ou la valeur par défaut
    // Paramètres :
    //           $param : nom du paramètre GET recherché
    //           $def : valeur par défaut


    if (isset($_GET[$param])) {
        return $_GET[$param];
    } else {
        return $def;
    }

    // équivalent à : return (isset($_GET[$param])) ? $_GET[$param] : $def;
}

function litPOST($param, $def) {
    // Rôle : récupérer un paramètre dans $_POST si il existe, retourner une valeur par défaut sinon
    // Retour : la valeur du paramètre POST ou la valeur par défaut
    // Paramètres :
    //           $param : nom du paramètre POST recherché
    //           $def : valeur par défaut


    if (isset($_POST[$param])) {
        return $_POST[$param];
    } else {
        return $def;
    }
}

// Fonction pour gérer des traces, des messages, et des debug

function debug($texte) {
    // Rôle : enregistrer dans une variable globale des traces de debug
    // REtour : néant
    // Parmaètres : chaine de caractère (texte à afficher)

    global $debug;
    if (!isset($debug)) {
        $debug = "";
    }
    $debug .= "$texte\n";
    // echo "$texte<br>";
}

function message($texte) {
    // Rôle : enregistrer dans une variable globale un message pour l'utilisateur
    // REtour : néant
    // Paramètres : chaine de caractère (texte à afficher)

    global $message;
    if (!isset($message)) {
        $message = "";
    }
    $message .= "$texte\n";
}
