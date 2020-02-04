<?php
/* Template pour saisir un champ de type nombre entier
 *      En entrée, on a besoin :
 *          $objet : objet instancié auqul le champ appartient
 *          $nomChamp : nom du champ dans ce objet
 *
 *
 */
?>
<label for="<?= $nomChamp ?>"><?= htmlentities($objet->getLibelle($nomChamp)) ?></label>
<input type="text" id="<?= $nomChamp ?>" name="<?= $nomChamp ?>" value="<?= htmlentities($objet->get($nomChamp)) ?>"/>
