<?php
    // Importation des modules nécessaires
    require_once('outils.php');
    require_once('bdd.php');

    // Information de connexion
    $email = ""; 
    $password = "";


    function recupererChamps() {
        global $email, $password;
        $resultChamp = traiterChamps(["email", "password"], "login_form.php");
        $email = $resultChamp[0];
        $password = $resultChamp[1];
    }
    

    /**
     * Undocumented function
     *
     * @return void
     */
    function connecterUtilisateur() {
        global $email, $password;
        $bdd = new MyBDD();
        $result = $bdd->recupererInfoUtilisateurAvecEmail($email);
        if(empty($result)) { // Aucun compte lié à ce mail
            redirect_with_error("login_form.php","invalid");
        } else {
            if (!password_verify($password, $result["password"])) { // Mot de passe incorrect
                redirect_with_error("login_form.php","invalid");
            } else { // Compte vérifié, début de la session
                session_start();
                $_SESSION["email"] = $email;
                header('Location: articles_user_form.php');
            };
        };
    }

    recupererChamps();
    connecterUtilisateur();

?>