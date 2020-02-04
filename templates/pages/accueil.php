<!DOCTYPE html>
<?php
/*
  Détail d'un objet par défaut (template génériques pour les modules)

  Ce template à besoin des variables suivantes :
  - L'objet à afficher : $objet (objet chargé)

 */
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Accueil</title>
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        // Header
        include "templates/fragments/header.php";
        ?>
        <h1>Bienvenue</h1>


        <?php
// Footer
        include "templates/fragments/footer.php";
        ?>
    </body>
</html>