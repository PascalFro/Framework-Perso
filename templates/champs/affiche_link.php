<?php
/* Template pour afficher un champ de type link
 *      En entrée, on a besoin :
 *          $objet : objet instancié auqul le champ appartient
 *          $nomChamp : nom du champ dans ce objet
 *
 *
 */
?>
<p><?= htmlentities($objet->getLibelle($nomChamp)) ?> : <b><a href="index.php?module=<?= $objet->getLinkNom($nomChamp) ?>&action=aff&id=<?= $objet->get($nomChamp) ?>"><?= htmlentities($objet->getLinkNom($nomChamp)) ?></a></b></p>
