<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Article</title>
</head>
<body>
    <?php
    require_once('header.php');
    require_once('outils.php');

    echo "<h1>Ajouter un article</h1>";

    check_and_display_error();

    verifierSiUtilisateurConnecte();
    ?>

    <form action="add_article.php" method="post">
        <p>
            <label for="titre">titre de l'article</label>
            <input type="text" name="titre" required>
        </p>

        <p>
            <label for="corps">corps de l'article</label>
            <textarea type="text" name="corps" cols="30" rows="10" required></textarea>
        </p>

        <button type="submit">Envoyer</button>
    </form>
    
</body>
</html>