<!DOCTYPE html>
<?php
/*  Détail d'un objet par défaut (template génériques pour les modules)  Ce template à besoin des variables suivantes :  - L'objet à afficher : $objet (objet chargé) */
?>
<html>
    <head>
      <meta charset="UTF-8">
      <title><?= htmlentities($objet->getNomObjet()) ?> : <?= htmlentities($objet->getNomComplet())?></title>
      <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
      <?php
        // Header
        include "templates/fragments/header.php";
      ?>
      <h1><?= htmlentities($objet->getNomComplet()) ?></h1>
      <?php
        // Affichage des différents champs
        // Parcours de la liste des champs
        foreach ($objet->getChamps() as $nomChamp => $detailChamps) {
          include "templates/champs/affiche_" . $detailChamps["type"] . ".php";
          }
      ?>
      <a href="index.php?module=<?= $objet->getModule() ?>&action=modif_form&id=<?= $objet->getId() ?>"><button>Modifier</button></a>
      <a onclick="return window.confirm('Voulez-vous vraiment supprimer cet article ?')" href="index.php?module=<?= $objet->getModule() ?>&action=delete&id=<?= $objet->getId() ?>"><button>Supprimer</button></a>
      <?php
        // Footer
        include "templates/fragments/footer.php";
      ?>
    </body>
  </html>
