<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voir vos commentaires</title>
    <link rel="stylesheet" href="../css/liste_article.css">
</head>
<body>
    <?php 
        require_once('../bdd.php');
        require_once('../outils.php');
        require_once('../header_form.php');

        verifierSiUtilisateurConnecte();

        $email = $_SESSION["email"];
        echo "<h1>Vos commentaires $email</h1>";

        $bdd = new MyBDD;
        $result = $bdd->recupererCommentairesUtilisateur($email);
        afficherCommentairesUser($result);

    ?>
    
</body>
</html>