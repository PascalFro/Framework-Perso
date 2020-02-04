<?php
/* Template pour saisir un champ de type lien (liste déroulante)
 *      En entrée, on a besoin :
 *          $objet : objet instancié auqul le champ appartient
 *          $nomChamp : nom du champ dans ce objet
 *
 *
 */
?>
<label for="<?= $nomChamp ?>"><?= htmlentities($objet->getLibelle($nomChamp)) ?></label>
<select id="<?= $nomChamp ?>" name="<?= $nomChamp ?>">
    <option value="">-------</option>
    <?php
// Construction de la liste des options

    foreach ($objet->getLinkList($nomChamp) as $key => $value) {
        ?>
        <option value="<?= $key ?>" <?= ( $key == $objet->get($nomChamp) ) ? 'selected' : '' ?> ><?= $value ?></option>
        <?php
    }
    ?>
</select>