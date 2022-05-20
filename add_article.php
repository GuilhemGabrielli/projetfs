<?php
    // Importation des modules nécessaires
    require_once('outils.php');
    require_once('bdd.php');

    verifierSiUtilisateurConnecte();

    $email = $_SESSION["email"];

    // Information du nouvel article
    $titre = ""; 
    $corps = "";
    $today = date("Y-m-d");

    function recupererChamps() {
        global $titre, $corps;
        $resultChamp = traiterChamps(["titre", "corps"], "add_article_form.php");
        $titre = $resultChamp[0];
        $corps = $resultChamp[1];
    }

    recupererChamps();

    $bdd = new MyBDD();
    $id_user = $bdd->recupererInfoUtilisateurAvecEmail($email)["id"];

    $bdd->ajouterArticle($titre, $corps, $today, $id_user);

    header("Location: articles_user_form.php")

?>