<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
</head>
<body>
    <h2>Contactez-nous</h2>
    <form action="index.php?action=submitContact" method="post">
        <label>Titre: <input type="text" name="title" required></label><br>
        <label>Description: <textarea name="description" required></textarea></label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <input type="submit" value="Envoyer">
    </form>
</body>
</html>