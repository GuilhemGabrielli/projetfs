<?php

    session_start();
    session_unset();
    session_destroy();

    setcookie(session_name(), '', strtotime("-1 day"));

    echo "Vous êtes déconnecté"

?>
<br>
<a href="/">Accueil</a>