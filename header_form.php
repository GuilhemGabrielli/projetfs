<head>
    <link rel="stylesheet" href="css/header.css">
</head>
<body>
    <?php
        require_once('outils.php');

        if (retournerSiUtilisateurConnecte()) {
            echo '<div id="header"><p><a href="/">Voir tout les articles</a> ou <a href="add_article_form.php">Ajouter un article</a> ou <a href="articles_user_form.php">Voir et modifier vos articles</a> ou <a href="commentaires_user_form.php">Voir et modifier vos commentaires</a></p>';
            echo '<p><a href="deconnexion.php">Déconnexion</a></p></div>';
        } else {
            echo '<p><a href="register_form.php">Inscription</a> ou <a href="login_form.php">Connexion</a></p>';
        }

        check_and_display_error();
    ?>
</body>
</html>


