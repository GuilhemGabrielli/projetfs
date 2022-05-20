<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="css/liste_article.css">
</head>
<body>
    <?php
        require_once('header_form.php');
        require_once('outils.php');
        check_and_display_error();

        echo "<h1>Nos articles</h1>";       

        require_once('all_articles.php');
    ?>

</body>
</html>