<!DOCTYPE html>
<?php
/*  Liste des objets sélectionnés (page complète)  Ce template à besoin des variables suivantes :  - $objet : objet instancié en mode liste  - Titre : $titre  (facultatif) */
?>
<html>
<head>
  <meta charset="UTF-8">
  <title><?= (isset($titre)) ? $titre : "Liste : " . $objet->getNomObjet() ?></title>
  <link href="css/styles.css" rel="stylesheet" type="text/css"/>
</head>
<body>
  <?php
  // Header
    include "templates/fragments/header.php";
    ?>
    <h1><?= (isset($titre)) ? $titre : "Liste : " . $objet->getNomObjet() ?></h1>
    <a href="index.php?module=<?= $objet->getModule() ?>&action=ajout_form"><button>Créer <?= $objet->getNomObjet() ?></button></a>
    <table>
      <tr>
        <?php
          // Construire la ligne d'en-tete, en parcourant les champs
          foreach ($objet->getChamps() as $nomChamp => $detailChamp) {
            echo "<th>" . $detailChamp["libelle"] . "</th>";
          }
        ?>
      </tr>
      <?php
      // Construire les lignes de la table (<tr>) pour chaque objet de la liste
      while ($objet->next()) {
        // prépare l'objet suivant et retourne true si il existe, false sinon
        // Afficher la ligne
        include "templates/fragments/ligne_objet.php";
        }
      ?>
    </table>
    <?php
    // Footer        include "templates/fragments/footer.php";
    ?>
  </body>
  </html>
