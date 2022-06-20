<?php
    require_once('outils.php');
    require_once('bdd.php');

    verifierSiUtilisateurConnecte();

    $email = $_SESSION["email"];
    $id_commentaire = 0;
    $texte = "";


    if (!empty($_GET["id"])) {
        $id_commentaire = $_GET["id"];
        settype($id_commentaire, "int");
    } else {
        redirect_with_error("commentaires_user_form.php", "empty");
    }
    echo gettype($id_commentaire);

    function recupererChamps() {
        global $texte, $id_commentaire;
        $resultChamp = traiterChamps(["texte"], "modify_commentaire_form.php?id=$id_commentaire");
        $texte = $resultChamp[0];
    }

    recupererChamps();

    $bdd = new MyBDD;
    $bdd->modifierCommentaire($id_commentaire, $email, $texte);

    header('Location: commentaires_user_form.php');

    // echo json_encode($result);

?>