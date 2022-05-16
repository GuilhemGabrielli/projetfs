<?php

    /**
     * Classe permettant la connection à la base de donné mais aussi aux différentes requêtes
     */
    class MyBDD {

        private $db_user = "student"; 
        private $db_pass = "password"; 
        private $db_name = "projetfs"; 

        /**
         * Permet de faire la connexion avec la base de donnée. Si la connexion est réussi alors un objet PDO 
         *
         * Attention : si la connexion échoue le script en cours est quitté
         * 
         * @return PDO
         */
        private function connecterBDD(): PDO{
            try {
                $bdd_options = ["PDO::ATTR_ERR_MODE" => PDO::ERRMODE_EXCEPTION];
                $bdd = new PDO("mysql:host=localhost;dbname=$this->db_name", $this->db_user, $this->db_pass, $bdd_options);
                return $bdd;
        
            } catch(Exception $e) {
                echo $e->getMessage();
                exit;
            }
        }

        /**
         * Ajoute l'utilisateur dans la base de donnée
         *
         * @param string $email L'email du nouvel utilisateur
         * @param string $hash Mot de passe haché du nouvel utilisateur
         * @return boolean|string true si ajout réussi, false sinon et renvoie "duplicate" si le mail est déja lié à un compte
         */
        function ajouterUtilisateur(string $email, string $hash): bool|string {
            $result = true;
            try {
                $bdd = $this->connecterBDD();
                $rqt = "INSERT INTO utilisateur(email, password) VALUES (:email, :password);"; 

                $requete_preparee = $bdd->prepare($rqt); 
            
                // Associer les paramètres : 
                $requete_preparee->bindParam(":email", $email); 
                $requete_preparee->bindParam(':password', $hash); 
                $requete_preparee->execute();
            } catch (Exception $e) {
                $result = false;
                if($e->getCode() == 23000 ) { // Le code 23000 correspond à une entrée dupliquée :cela signifie que l'adresse mail est déjà en bdd
                    $result = "duplicate";
                }

            }
            return $result;
        }

        /**
         * Renvoie les données de l'utilisateur si l'email est contenue dans la base
         *
         * @param string $email Email de l'utilisateur
         * @return array Si l'utilisateur existe alors un tableau contenant toute ses informations est renvoyé, sinon le tableau renvoyé est vide
         */
        function recupererInfoUtilisateurAvecEmail(string $email): array {
            $result = [];
            try {
                $bdd = $this->connecterBDD();
                $rqt = "SELECT * FROM utilisateur WHERE email=:email;"; 
                $requete_preparee = $bdd->prepare($rqt); 
            
                // Associer les paramètres : 
                $requete_preparee->bindParam(":email", $email); 
                $requete_preparee->execute();
                $result = $requete_preparee->fetch();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            if ($result === false) {
                $result=[];
            }
            return $result;
        }


        /**
         * Ajoute dans la base de donnée l'article avec les informations mises en paramètres. Retourne true ou false selon si l'opération est un succès
         *
         * @param string $titre
         * @param string $corps
         * @param string $date_ajout
         * @param string $date_modification
         * @param integer $id_utilisateur
         * @return boolean
         */
        function ajouterArticle(string $titre, string $corps, string $date_ajout, int $id_utilisateur): bool {
            $result = true;

            try {
                $bdd = $this->connecterBDD();
                $rqt = "INSERT INTO article(titre, corps, created_at, id_utilisateur) VALUES (:titre, :corps, :created_at, :id_utilisateur);"; 

                $requete_preparee = $bdd->prepare($rqt); 
            
                // Associer les paramètres : 
                $requete_preparee->bindParam(":titre", $titre); 
                $requete_preparee->bindParam(':corps', $corps); 
                $requete_preparee->bindParam(":created_at", $date_ajout); 
                $requete_preparee->bindParam(":id_utilisateur", $id_utilisateur); 

                $requete_preparee->execute();
            } catch (Exception $e) {
                $result = false;
                echo $e->getMessage();
            }

            return $result;
        }


        /**
         * Renvoie tous les articles de correspondant au mail mis en paramètre
         *
         * @param string $email
         * @return array
         */
        function recupererArticlesUtilisateur(string $email): array {
            $result = [];
            try {
                $bdd = $this->connecterBDD();
                $rqt = "SELECT a.id, a.titre, a.corps, a.created_at, a.updated_at FROM utilisateur AS u LEFT JOIN article AS a ON u.id = a.id_utilisateur WHERE email=:email;"; 

                $requete_preparee = $bdd->prepare($rqt); 
            
                // Associer les paramètres : 
                $requete_preparee->bindParam(":email", $email); 
                $requete_preparee->execute();
                $result = $requete_preparee->fetchAll();
            } catch (Exception $e) {
                echo $e->getMessage();

            }

            return ($result);

        }



        /**
         * Renvoie un article selon son id mis en paramètres seulement si l'email correspond au compte créateur de l'article
         *
         * @param integer $id_article
         * @param string $email
         * @return array
         */
        function recupererArticleAvecIdEtEmail(int $id_article, string $email): array{
            $result = [];
            try {
                $bdd = $this->connecterBDD();
                $rqt = "SELECT * FROM utilisateur AS u LEFT JOIN article AS a ON u.id = a.id_utilisateur WHERE email=:email AND a.id=:id_article;"; 

                $requete_preparee = $bdd->prepare($rqt); 
            
                // Associer les paramètres : 
                $requete_preparee->bindParam(":email", $email); 
                $requete_preparee->bindParam(":id_article", $id_article);
                $requete_preparee->execute();
                $result = $requete_preparee->fetch();
            } catch (Exception $e) {
                echo $e->getMessage();

            }
            if ($result === false) {
                $result=[];
            }
            return ($result);

        }


        /**
         * Modifie un article en fonction des caractéristiques mises en paramètre
         *
         * @param integer $id_article
         * @param string $email
         * @param string $titre
         * @param string $corps
         * @return void
         */
        function modifierArticle(int $id_article, string $email, string $titre, string $corps) {
            $updated_at = date("Y-m-d");
            try {
                $bdd = $this->connecterBDD();
                $id_utilisateur = $this->recupererInfoUtilisateurAvecEmail($email)["id"];
                $rqt = "UPDATE article SET titre=:titre, corps=:corps, updated_at=:updated_at WHERE id=:id_article AND id_utilisateur=:id_utilisateur;"; 

                $requete_preparee = $bdd->prepare($rqt); 
            
                // Associer les paramètres : 
                $requete_preparee->bindParam(":titre", $titre); 
                $requete_preparee->bindParam(":corps", $corps); 
                $requete_preparee->bindParam(":updated_at", $updated_at); 
                $requete_preparee->bindParam(":id_article", $id_article); 
                $requete_preparee->bindParam(":id_utilisateur", $id_utilisateur); 
                $requete_preparee->execute();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        
        }


        /**
         * Renvoie sous forme de liste la totalité des articles dans la base de donnée
         *
         * @return array
         */
        function recupererAllArticles(): array {
            $result = [];
            try {
                $bdd = $this->connecterBDD();
                $rqt = "SELECT a.id, a.titre, a.corps, a.created_at, a.updated_at, u.email FROM article AS a LEFT JOIN utilisateur as u ON u.id = a.id_utilisateur;"; 

                $requete_preparee = $bdd->prepare($rqt); 
                $requete_preparee->execute();
                $result = $requete_preparee->fetchAll();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            
            return $result;
        }
    }

?>