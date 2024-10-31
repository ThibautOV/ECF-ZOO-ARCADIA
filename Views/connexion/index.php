<?php
// connexion.php
require '../../components/db.php';
session_start();

$message = "";

// Connexion à la base de données
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $message = "Veuillez remplir tous les champs.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifie le mot de passe pour l'utilisateur
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_logged_in'] = true;
            $_SESSION['username'] = $user['name'];
            header("Location: ../../Views/index.php");
            exit();
        } else {
            $message = "Adresse e-mail ou mot de passe incorrect.";
        }
    }
}
include '../../components/header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page de Connexion</title>
    <link rel="stylesheet" href="/public/assets/css/header.css">
    <link rel="stylesheet" href="/Public/assets/css/connexion.css">
</head>
<body>
    <div class="container">
        <h2>Connexion</h2>
        <form action="" method="post">
            <label for="email">Adresse E-mail :</label>
            <input type="email" name="email" id="email" required><br><br>

            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required><br><br>

            <button type="submit">Se connecter</button>
        </form>

        <?php if ($message): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
    </div>
</body>
</html>