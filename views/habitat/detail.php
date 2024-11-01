<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de l'Habitat</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Détails de l'Habitat : <?php echo htmlspecialchars($habitat['name']); ?></h1>
    <p><strong>Type:</strong> <?php echo htmlspecialchars($habitat['type']); ?></p>
    <p><strong>Description:</strong> <?php echo htmlspecialchars($habitat['description']); ?></p>
    <a href="index.php?action=listHabitats">Retour à la liste des habitats</a>
</body>
</html>