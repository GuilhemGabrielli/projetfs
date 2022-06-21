<?php
    // Importation des modules nécessaires
    require_once('outils.php');
    require_once('bdd.php');

    verifierSiUtilisateurConnecte();

    $email = $_SESSION["email"];

    // Information du nouveau commentaire
    $texte = ""; 
    $today = date("Y-m-d");
    $id_article = 0;

    if (!empty($_GET["id"])) {
        $id_article = $_GET["id"];
        settype($id_article, "int");
    } else {
        redirect_with_error("all_articles.php", "empty");
    }

    function recupererChamps() {
        global $texte;
        $resultChamp = traiterChamps(["texte"], "index.php");
        $texte = $resultChamp[0];
    }

    recupererChamps();

    $bdd = new MyBDD();
    $id_user = $bdd->recupererInfoUtilisateurAvecEmail($email)["id"];

    $bdd->ajouterCommentaire($texte, $today, $id_user, $id_article);

    header("Location: index.php")

?>