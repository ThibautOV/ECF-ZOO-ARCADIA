<?php
require_once '../Models/HabitatModel.php';

// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=zoo_db', 'username', 'password');

// Création d'une instance du modèle d'habitat
$habitatModel = new HabitatModel($db);
$habitats = $habitatModel->getAllHabitats();

$message = "";

// Gérer les actions pour ajouter ou supprimer un habitat
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'delete') {
            $habitatModel->deleteHabitat($_POST['habitat_id']);
            $message = "Habitat supprimé avec succès.";
        } elseif ($_POST['action'] === 'create') {
            $habitatModel->createHabitat($_POST['name'], $_POST['description'], $_POST['images']);
            $message = "Habitat créé avec succès.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Habitats</title>
</head>
<body>
    <h2>Gestion des Habitats</h2>
    <?php if (!empty($message)) echo "<p>$message</p>"; ?>

    <h3>Liste des Habitats</h3>
    <ul>
        <?php foreach ($habitats as $habitat): ?>
            <li>
                <?= htmlspecialchars($habitat['name']) ?>
                <form action="manage_habitats.php" method="post" style="display:inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="habitat_id" value="<?= $habitat['id'] ?>">
                    <input type="submit" value="Supprimer">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <h3>Ajouter un Habitat</h3>
    <form action="manage_habitats.php" method="post">
        <input type="hidden" name="action" value="create">
        <label>Nom: <input type="text" name="name" required></label><br>
        <label>Description: <textarea name="description" required></textarea></label><br>
        <label>Images (URL, séparés par des virgules): <input type="text" name="images" required></label><br>
        <input type="submit" value="Créer l'Habitat">
    </form>
</body>
</html>