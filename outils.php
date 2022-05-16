<?php 

    session_start();

    $errors =  [
        "empty" => "Tous les champs doivent être renseignés",
        "password" => "Les mots de passes doivent être identiques", 
        "email" => "L'email est mal formé", 
        "duplicate" => "Cette adresse email est déjà enregistrée", 
        "invalid" => "Adresse mail ou mot de passe invalide", 
        "invalid_password" => "Le mot de passe doit contenir au moins 8 caractères, une lettre min et maj, un chiffre, un caractère spécial",
        "acces_denied" => "Accès interdit"
    ];

    /**
     * Redirige vers la page indiquée en paramètre, en donnant en paramètre (GET) un status=error et le type d'erreur 
     * 
     * Les types d'erreurs sont : 
     *  - empty : un des champs est vide
     *  - email : l'email est mal formée
     *  - password : le mot de passe ne correspond pas à sa confirmation
     *  - ... 
     * Attention, l'appel à cette fonction quitte le script en cours 
     * 
     * @param string $location l'url de redirection 
     * @param string $error La clé de l'erreur que l'on renvoie
     * @return void
     */
    function redirect_with_error(string $location, string $error ) {
        header("Location: $location?status=error&error=$error");
        exit; 

    }

    /**
     * Vérifie s'il existe une erreur passée en paramètre (GET) du script et affiche un élément HTML (div) contenant l'erreur
     *
     * @return void
     */
    function check_and_display_error() {
        // Pas très beau, mais fonctionnel ! Challenge : trouvez comment faire mieux !!!
        global $errors; // On rappelle la variable globale $errors définie plus haut
        if(!empty($_GET["error"])) {
            $err = $_GET["error"]; 
            echo "<div class='error'>";
            echo $errors[$err];
            echo "</div>";
        }
    }

    /**
     * Indique si le mot de passe respecte les règles suivantes : 
     *  - au moins huit caractères
     *  - au moins une lettre majuscule
     *  - au moins une lettre miniscule 
     *  - au moins chiffre
     *  - au moins un caractère spécial
     *
     * @param string $password
     * @return boolean true si le mot passe de respecte les règles
     */
    function isValidPassword(string $password) {
        $hasNum = false; 
        $hasMaj = false; 
        $hasMin = false; 
        $hasSpec = false; 
        $isLongEnought = strlen($password) >= 8; 
        $spec_char = ",;:!ù*=)_-('\"é&² ~#{[|`\\^@]}¤?./§%µ+°";

        for($i = 0; $i < strlen($password); $i++) {
            $char = $password[$i];
            if($char >= 'A' && $char <= 'Z') {
                $hasMaj = true;
            }
            if($char >= 'a' && $char <= 'z') {
                $hasMin = true;
            }
            if($char >= '0' && $char <= '9') {
                $hasNum = true;
            }
            if(strstr($spec_char, $char)) {
                $hasSpec = true; 
            }
        } 

        return $hasMaj && $hasMin && $hasNum && $hasSpec && $isLongEnought; 
    }


    /**
     * Indique si le mot de passe respecte les règles suivantes : 
     *  - au moins huit caractères
     *  - au moins une lettre majuscule
     *  - au moins une lettre miniscule 
     *  - au moins chiffre
     *  - au moins un caractère spécial
     *
     * @param string $mdp
     * @return boolean true si le mot passe de respecte les règles
     */
    function check_mdp_format($mdp) {
        $containsLetter  = preg_match('/[a-zA-Z]/',    $mdp);
        $containsDigit   = preg_match('/\d/',          $mdp);
        $containsSpecial = preg_match('/[^a-zA-Z\d]/', $mdp);
        
        if(!$containsLetter || !$containsDigit || !$containsSpecial || strlen($mdp) < 8) {
            return false;
        } else { 
            return true;
        }
    }


    /**
     * Fonction permettant de traiter les champs des formulaires afin d'appliquer une protection sur les champs
     *
     * @param array $ListeChamp Les champs a controler
     * @param string $urlRedirection Lien de redirection si un des champs est vide
     * @return ArrayObject Liste des champs filtrés
     */
    function traiterChamps(array $ListeChamp, string $urlRedirection): ArrayObject {
        $result = new ArrayObject();
        foreach ($ListeChamp as $champ) {
            if (empty($_POST[$champ])) {
                // Informer que les champs sont vides 
                redirect_with_error($urlRedirection, "empty");
            } else {
                $result->append(htmlspecialchars($_POST[$champ]));
                
            }
        }
        return $result;
    }


    /**
     * Vérifie si l'utilisateur à est actuellement connecté. Si non connecté l'utilisateur est envoyé sur la page de connexion
     * 
     * Attention, l'appel à cette fonction quitte le script en cours 
     *
     * @return void
     */
    function verifierSiUtilisateurConnecte() {
        if(empty($_SESSION["email"])) {
            header('Location: login_form.php');
            exit;
        }
    }


    /**
     * Renvoie un booléan pour informer si l'utilisateur est connecté
     *
     * @return bool
     */
    function retournerSiUtilisateurConnecte(): bool {
        $result = true;
        if(empty($_SESSION["email"])) {
            $result = false;
        }
        return $result;
    }


    /**
     * Affiche les articles mis en paramètre. Changement de l'affichage si il faut tous les montrer ou seulement montrer les articles d'un utilisateur.
     *
     * @param array $articles Liste des articles à afficher
     * @param boolean $articlesOfUser Si true alors bouton pour modifier, sinon affichage du nom de l'auteur
     * @return void
     */
    function afficherArticles(array $articles, bool $articlesOfUser) {
        if ($articles != [] and json_encode($articles[0]["titre"]) !== "null") {
            echo "<table><tr><th>Titre</th><th>Corps</th><th>Créé le</th><th>Modifié le</th>";

            if (!$articlesOfUser) {
                echo "<th>Auteur</th>";
            }
            echo "</tr>";
            
            foreach ($articles as $article) {
                $id = $article['id'];
                $titre = $article['titre'];
                $corps = $article["corps"];
                $created_at = $article["created_at"];
                $updated_at = $article["updated_at"];
                
                echo "<tr>";

                if ($articlesOfUser) {
                    echo "<form action='modify_article_form.php?id=$id' method='post'>";
                }

                echo "<th>$titre</th><th>$corps</th><th>$created_at</th><th>$updated_at</th>";

                if ($articlesOfUser) {
                    echo "<th><button type='submit'>Modifier</button></th></form>";
                } else {
                    $auteur = $article["email"];
                    echo "<th>$auteur</th>";
                }
                echo "</tr></table";
            }
        } else {
            echo "<p>Aucun article publié</p>";
        }
    }


    /**
     * Affiche les éléments permettant de modifier un article avec les valeurs déja existante.
     *
     * @param array $article Article à modifier
     * @return void
     */
    function afficherArticlesAModifier(array $article) {
        $id = $article['id'];
        $titre = $article['titre'];
        $corps = $article['corps'];
        echo "<form action='modify_article.php?id=$id' method='post'>";
        echo "<p><label>Nouveau titre : </label><input type='text' name='titre' placeholder='$titre' value='$titre' required></p>";
        echo "<p>Nouveau corps : </p>";
        echo "<textarea type='text' name='corps' cols='30' rows='10' required>$corps</textarea>";
        echo "<button type='submit'>Valider</button>";
        echo "</form>";
            
    }


?>