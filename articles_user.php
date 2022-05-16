<?php
    require_once('bdd.php');
    require_once('outils.php');
    require_once('header.php');


    verifierSiUtilisateurConnecte();

    $email = $_SESSION["email"];

    echo "<h1>Vos articles $email</h1>";

    $bdd = new MyBDD;
    $result = $bdd->recupererArticlesUtilisateur($email);
    afficherArticles($result, true);
?>
