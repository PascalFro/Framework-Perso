<!DOCTYPE html>
<?php
/*
  Formulaire de saisie d'un objet  (page complète)

  Ce template à besoin des variables suivantes :
  - L'objet : $objet (objet article chargé ou avec des valeurs par défaut
  - Mode : $mode ( CREE : création d'un nouvel article, MOD : modification d'un article)

 */
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?= ($mode === "CREER") ? "Nouvel " . htmlentities($objet->getNomObjet()) : htmlentities($objet->getNomObjet()) . " " . htmlentities($objet->getNomComplet()) ?></title>
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        // Header
        include "templates/fragments/header.php";
        ?>
        <h1><?= ($mode === "CREER") ? "Nouvel " . htmlentities($objet->getNomObjet()) : "Modification " . htmlentities($objet->getNomObjet()) ?></h1>
        <form method="post" action="index.php?module=<?= $objet->getModule() ?>&action=<?= ($mode === "CREER") ? "ajout_traite" : "modif_traite" ?>&id=<?= $objet->getId() ?>">
            <?php
            // Afficher le fragment pour chaque champ
            foreach ($objet->getChamps() as $nomChamp => $detailChamps) {
                include "templates/champs/saisit_" . $detailChamps["type"] . ".php";
            }
            ?>
            <input type="submit" value="<?= ($mode === "CREER") ? "Ajouter" : "Modifier" ?>" />

        </form>
        <?php
        // Footer
        include "templates/fragments/footer.php";
        ?>
    </body>
</html>