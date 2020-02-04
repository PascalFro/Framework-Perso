<?php
/* Template pour saisir un champ de type texte multiligne
 *      En entrée, on a besoin :
 *          $objet : objet instancié auqul le champ appartient
 *          $nomChamp : nom du champ dans ce objet
 *
 *
 */
?>
<label for="<?= $nomChamp ?>"><?= htmlentities($objet->getLibelle($nomChamp)) ?></label>
<textarea id="<?= $nomChamp ?>" name="<?= $nomChamp ?>"><?= htmlentities($objet->get($nomChamp)) ?></textarea>