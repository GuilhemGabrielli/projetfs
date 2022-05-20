<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Article</title>
    <link rel="stylesheet" href="css/add_modify_article.css">
</head>
<body>
    <?php
    require_once('header_form.php');
    require_once('outils.php');

    echo "<h1>Ajouter un article</h1>";

    check_and_display_error();

    verifierSiUtilisateurConnecte();
    ?>
    <div id="div-form">
        <form action="add_article.php" method="post">
            <label for="titre">titre de l'article</label>
            <p><input type="text" name="titre" required></p>

            <label for="corps">corps de l'article</label>
            <p><textarea type="text" name="corps" cols="30" rows="10" required></textarea></p>

            <button type="submit">Envoyer</button>
        </form>
    </div>
    
    
</body>
</html>