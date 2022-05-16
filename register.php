<?php 
    require_once('outils.php');
    require_once('bdd.php');

    // Information de connexion
    $email = ""; 
    $password = "";
    $conf = "";

    function verifierConfirmiteNouvelUtilisateur() {
        global $email, $password, $conf;
        $resultChamps = traiterChamps(["email", "password", "conf_password"], "register_form.php");
        $email = $resultChamps[0];
        $password = $resultChamps[1];
        $conf = $resultChamps[2];

        // 1.1 - Valider la conformité de l'email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            redirect_with_error("register_form.php", "email");
        }

        // 1.2 - vérifier le que la confirmation est correcte
        if($password !== $conf) {
            redirect_with_error("register_form.php", "password"); 
        }

        // Vérification du mot de passe
        if (check_mdp_format($password) === false) {
            redirect_with_error("register_form.php", "invalid_password");
        }
    }

    
    function ajouterUtilisateurEtConnecter() {
        global $email, $password;
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $bdd = new MyBDD();
        $result = $bdd->ajouterUtilisateur($email, $hash);
        if (gettype($result) === "string") {
            redirect_with_error("register_form.php",$result);
        }

        demarrerSession();
    }
    

    function demarrerSession() {
        global $email;
        session_start();
        $_SESSION["email"] = $email;
        header('Location: /');
    }


    verifierConfirmiteNouvelUtilisateur();
    ajouterUtilisateurEtConnecter();
    
?>