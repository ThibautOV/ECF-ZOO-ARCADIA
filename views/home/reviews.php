<?php
require_once '../Models/ReviewModel.php';

// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=zoo_db', 'username', 'password');

// Création d'une instance du modèle d'avis
$reviewModel = new ReviewModel($db);
$reviews = $reviewModel->getAllReviews();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Avis</title>
</head>
<body>
    <h2>Avis des Visiteurs</h2>

    <ul>
        <?php foreach ($reviews as $review): ?>
            <li>
                <?= htmlspecialchars($review['review']) ?> (<?= htmlspecialchars($review['rating']) ?>)
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>