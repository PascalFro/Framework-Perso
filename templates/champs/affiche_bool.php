<?php
/* Template pour afficher un champ de type nombre monétaire
 *      En entrée, on a besoin :
 *          $objet : objet instancié auqul le champ appartient
 *          $nomChamp : nom du champ dans ce objet
 *
 *
 */
?>
<p><?= htmlentities($objet->getLibelle($nomChamp)) ?> : <b><?= ($objet->get($nomChamp)) ? "Oui" : "Non" ?></b></p>


