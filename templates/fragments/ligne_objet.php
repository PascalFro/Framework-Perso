<?php
/*
  Affichage d'une ligne de tableau pour un objet
  Ce template à besoin des variables suivantes :
  - objet à afficher : $objet


  Affiche les colonnes


 */
?>

<tr>
    <?php
    // Pour chaque champ, afficher la valeur
    foreach ($objet->getChamps() as $nomChamp => $detailChamp) {
        echo "<td><a href='index.php?module=" . $objet->getModule() . "&action=aff&id=" . $objet->getId() . "' target='_blank'>" . htmlentities($objet->get($nomChamp)) . "</a></td>";
    }
    ?>
</tr>


