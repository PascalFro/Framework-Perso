<?php

/* 
 * Template pour afficher un champs de type string
 *      En entrée, on a besoin :
 *          $objet : objet instancié auquel le champ appartient
 *          $nomChamp : nom du champ dans cet objet
 */
?>
<p><?= htmlentities($objet->getLibelle($nomChamp)) ?> : <b><?= htmlentities($objet->get($nomChamp)) ?></b></p>