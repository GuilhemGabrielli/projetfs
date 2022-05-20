<?php
    require_once('outils.php');
    require_once('bdd.php');

    verifierSiUtilisateurConnecte();

    $email = $_SESSION["email"];
    $id_article = 0;
    $titre = "";
    $corps = "";


    if (!empty($_GET["id"])) {
        $id_article = $_GET["id"];
        settype($id_article, "int");
    } else {
        redirect_with_error("articles_user.php", "empty");
    }
    echo gettype($id_article);

    function recupererChamps() {
        global $titre, $corps, $id_article;
        $resultChamp = traiterChamps(["titre", "corps"], "modify_article_form.php?id=$id_article");
        $titre = $resultChamp[0];
        $corps = $resultChamp[1];
    }

    recupererChamps();

    $bdd = new MyBDD;
    $bdd->modifierArticle($id_article, $email, $titre, $corps);

    header('Location: articles_user_form.php');

    // echo json_encode($result);

?>
