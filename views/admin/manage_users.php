?php
require_once '../Models/UserModel.php';

// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=zoo_db', 'username', 'password');

// Création d'une instance du modèle d'utilisateur
$userModel = new UserModel($db);
$users = $userModel->getAllUsers();

$message = "";

// Gérer les actions pour ajouter ou supprimer un utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'delete') {
            $userModel->deleteUser($_POST['user_id']);
            $message = "Utilisateur supprimé avec succès.";
        } elseif ($_POST['action'] === 'create') {
            $userModel->createUser($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['role'], $_POST['password']);
            $message = "Utilisateur créé avec succès.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Utilisateurs</title>
</head>
<body>
    <h2>Gestion des Utilisateurs</h2>
    <?php if (!empty($message)) echo "<p>$message</p>"; ?>

    <h3>Liste des Utilisateurs</h3>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?> (<?= htmlspecialchars($user['role']) ?>)
                <form action="manage_users.php" method="post" style="display:inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                    <input type="submit" value="Supprimer">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <h3>Ajouter un Utilisateur</h3>
    <form action="manage_users.php" method="post">
        <input type="hidden" name="action" value="create">
        <label>Prénom: <input type="text" name="first_name" required></label><br>
        <label>Nom: <input type="text" name="last_name" required></label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Rôle:
            <select name="role">
                <option value="employee">Employé</option>
                <option value="vet">Vétérinaire</option>
                <option value="admin">Administrateur</option>
            </select>
        </label><br>
        <label>Mot de passe: <input type="password" name="password" required></label><br>
        <input type="submit" value="Créer l'Utilisateur">
    </form>
</body>
</html>