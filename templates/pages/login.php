<!DOCTYPE html>
<?php
/*
 * Formulaire de connexion
 * 
 * Paramètres : néant
 */
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Connexion</title>
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        // Header
        include "templates/fragments/header.php"
        ?>
        <form method="post">
            <label for="login">Nom d'utilisateur</label>
            <input type="text" name="login" value="<?= (isset($_POST["login"])) ? $_POST["login"] : "" ?>" />
            <label for="passeword">Mot de passe</label>
            <input type="password" id="passeword" name="password"/>
            <input type="submit" value="Se connecter"/>
        </form>
        <?php
        // Footer
        include "templates/fragments/footer.php"
        ?>
    </body>
</html>
