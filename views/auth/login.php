<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>
    <form action="index.php?action=login" method="post">
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Mot de passe: <input type="password" name="password" required></label><br>
        <input type="submit" value="Se connecter">
    </form>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>