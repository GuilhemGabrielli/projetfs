<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un article</title>
    <link rel="stylesheet" href="css/add_modify_article.css">
</head>
<body>
    <?php
        require_once('header_form.php');
        require_once('outils.php');
        require_once('bdd.php');

        echo "<h1>Modifier votre article</h1>";

        verifierSiUtilisateurConnecte();

        $email = $_SESSION["email"];
        $id_article = "";


        if (!empty($_GET["id"])) {
            $id_article = $_GET["id"];
            settype($id_article, "int");
        }

        $bdd = new MyBDD;
        $result = $bdd->recupererArticleAvecIdEtEmail($id_article, $email);
        if (empty($result)) {
            redirect_with_error("index.php", "acces_denied");
        }
        afficherArticlesAModifier($result);

    ?>
    
</body>
</html>