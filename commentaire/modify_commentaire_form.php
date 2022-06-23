<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/add_modify_article.css">
</head>
<body>
    <?php 
        require_once('../bdd.php');
        require_once('../outils.php');
        require_once('../header_form.php');

        echo "<h1>Modifier votre commentaire</h1>";

        verifierSiUtilisateurConnecte();

        $email = $_SESSION["email"];
        $id_commentaire = "";


        if (!empty($_GET["id"])) {
            $id_commentaire = $_GET["id"];
            settype($id_commentaire, "int");
        }

        $bdd = new MyBDD;
        $result = $bdd->recupererCommentaireAvecIdEtMail($id_commentaire, $email)[0];
        if (empty($result)) {
            redirect_with_error("commentaires_user_form.php", "acces_denied");
        }

        afficherCommentaireAModifier($result)


    ?>

    <!-- <form action="modify_commentaire.php?id=1" method="post">
        <label for="texte">Texte du commentaire : </label>
        <p><input type="text" name="texte" required></p>

        <button type="submit">Envoyer</button>
    </form> -->
    
</body>
</html>