<?php
require_once '../Models/ServiceModel.php';

// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=zoo_db', 'username', 'password');

// Création d'une instance du modèle de service
$serviceModel = new ServiceModel($db);
$services = $serviceModel->getAllServices();

$message = "";

// Gérer les actions pour ajouter ou supprimer un service
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'delete') {
            $serviceModel->deleteService($_POST['service_id']);
            $message = "Service supprimé avec succès.";
        } elseif ($_POST['action'] === 'create') {
            $serviceModel->createService($_POST['name'], $_POST['description']);
            $message = "Service créé avec succès.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Services</title>
</head>
<body>
    <h2>Gestion des Services</h2>
    <?php if (!empty($message)) echo "<p>$message</p>"; ?>

    <h3>Liste des Services</h3>
    <ul>
        <?php foreach ($services as $service): ?>
            <li>
                <?= htmlspecialchars($service['name']) ?>
                <form action="manage_services.php" method="post" style="display:inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="service_id" value="<?= $service['id'] ?>">
                    <input type="submit" value="Supprimer">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <h3>Ajouter un Service</h3>
    <form action="manage_services.php" method="post">
        <input type="hidden" name="action" value="create">
        <label>Nom: <input type="text" name="name" required></label><br>
        <label>Description: <textarea name="description" required></textarea></label><br>
        <input type="submit" value="Créer le Service">
    </form>
</body>
</html>