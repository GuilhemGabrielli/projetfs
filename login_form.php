<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Connexion</h1>
    
    <?php
        require_once('outils.php');
        check_and_display_error();
    ?>

    <form action="login.php" method="post">
        <p>
            <label for="email">email</label>
            <input type="email" name="email"  required>
        </p>
        <p>
            <label for="password">password</label>
            <input type="password" name="password"  required>
        </p>
        <button type="submit">Connexion</button>
    </form>
    
    <a href="register_form.php">S'incrire</a>

</body>
</html>