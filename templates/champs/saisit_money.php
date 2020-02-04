<?php
/* Template pour saisir un champ de type somme d'argent
 *      En entrée, on a besoin :
 *          $objet : objet instancié auqul le champ appartient
 *          $nomChamp : nom du champ dans ce objet
 *
 *
 */
?>
<label for="<?= $nomChamp ?>"><?= htmlentities($objet->getLibelle($nomChamp)) ?></label>
<input type="number" step="0.01" id="<?= $nomChamp ?>" name="<?= $nomChamp ?>" value="<?= htmlentities($objet->get($nomChamp)) ?>"/> €
