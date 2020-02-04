<?php

include "lib/init.php";

$objet = new article();
$objet->listAll();


include "templates/pages/liste_default.php";
?>