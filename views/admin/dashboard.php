<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panneau d'Administration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Panneau d'Administration</h1>
    <h2>Utilisateurs</h2>
    <ul>
        <?php foreach ($users as $user): ?>
            <li><?php echo htmlspecialchars($user['email']); ?> - <?php echo htmlspecialchars($user['role']); ?></li>
        <?php endforeach; ?>
    </ul>
    <a href="index.php?action=home">Retour à l'accueil</a>
</body>
</html>