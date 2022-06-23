<?php
    require_once('bdd.php');
    require_once('outils.php');

    $bdd = new MyBDD;
    $result = $bdd->recupererAllArticles();
    afficherArticles($result, false);



?>