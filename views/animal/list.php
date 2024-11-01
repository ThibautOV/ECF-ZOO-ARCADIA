<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Animaux</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Liste des Animaux</h1>
    <ul>
        <?php foreach ($animals as $animal): ?>
            <li>
                <a href="index.php?action=showAnimal&id=<?php echo htmlspecialchars($animal['id']); ?>">
                    <?php echo htmlspecialchars($animal['first_name']); ?> (<?php echo htmlspecialchars($animal['species']); ?>)
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="index.php?action=listHabitats">Retour aux habitats</a>
</body>
</html>