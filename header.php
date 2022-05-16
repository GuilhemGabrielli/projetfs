<?php
    require_once('outils.php');

    if (retournerSiUtilisateurConnecte()) {
        echo '<p><a href="/">Voir tout les articles</a> ou <a href="add_article_form.php">Ajouter un article</a> ou <a href="articles_user.php">Voir et modifier vos articles</a></p>';
        echo '<p><a href="deconnexion.php">Déconnexion</a></p>';
    } else {
        echo '<p><a href="register_form.php">Inscription</a> ou <a href="login_form.php">Connexion</a></p>';
    }
?>
