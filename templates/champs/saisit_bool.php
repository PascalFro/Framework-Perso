<?php
/* Template pour saisir un champ de type somme d'argent
 *      En entrée, on a besoin :
 *          $objet : objet instancié auqul le champ appartient
 *          $nomChamp : nom du champ dans ce objet
 *
 *
 */
?>
<label><?= htmlentities($objet->getLibelle($nomChamp)) ?></label>
<input type="radio" id="<?= $nomChamp ?>-oui" name="<?= $nomChamp ?>" value="1" <?= ($objet->get($nomChamp)) ? 'checked' : '' ?> />
<label for="<?= $nomChamp ?>-oui">Oui</label>
<input type="radio" id="<?= $nomChamp ?>-non" name="<?= $nomChamp ?>" value="0" <?= ($objet->get($nomChamp)) ? '' : 'checked' ?> />
<label for="<?= $nomChamp ?>-non">Non</label>