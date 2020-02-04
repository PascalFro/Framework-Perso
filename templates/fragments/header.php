<header>
    <div>FRAMEWORK</div>
    <nav><a href="index.php?module=article&action=list">Articles</a> <a href="index.php?module=utilisateur&action=list">Utilisateurs</a></nav>
</header>
<?php
global $message;
if (!empty($message)) {
    echo '<div class="messages">';
    echo nl2br(htmlentities($message));
    echo '</div>';
}
?>


