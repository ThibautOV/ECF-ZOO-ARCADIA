<?php

session_start(); // Démarrage de la session

require '../components/db.php'; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    file_put_contents('error_log.txt', $e->getMessage(), FILE_APPEND);
    die("Erreur de connexion. Veuillez réessayer plus tard.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $mot_de_passe = $_POST['mot_de_passe'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "Adresse email invalide.";
    } else {
        // Vérifiez si l'email existe déjà
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $_SESSION['message'] = "Cet email est déjà enregistré.";
        } else {
            // Vérifiez si le role_id existe dans la table roles
            $role_id = 1; // Remplacez par la valeur appropriée

            $stmt = $pdo->prepare("SELECT COUNT(*) FROM roles WHERE id = :role_id");
            $stmt->execute([':role_id' => $role_id]);
            $roleExists = $stmt->fetchColumn();

            if ($roleExists === 0) {
                $_SESSION['message'] = "Le rôle spécifié n'existe pas.";
            } else {
                $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_BCRYPT);
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role_id) VALUES (:nom, :email, :mot_de_passe, :role_id)");
                $stmt->execute([
                    ':nom' => $nom,
                    ':email' => $email,
                    ':mot_de_passe' => $mot_de_passe_hache,
                    ':role_id' => $role_id
                ]);
                $_SESSION['message'] = "Inscription réussie.";
            }
        }
    }
}

require '../components/header.php'; // Inclusion de la navbar
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="/Public/assets/css/inscription.css"> 
    <link rel="stylesheet" href="/Public/assets/css/header.css"> 
</head>

<body>
    <div class="form-container">
        <h2>Inscription</h2>

        <!-- Affichage du message d'alerte s'il y en a un -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert">
                <?= htmlspecialchars($_SESSION['message']) ?>
            </div>
            <?php unset($_SESSION['message']); // Supprimez le message après l'affichage ?>
        <?php endif; ?>

        <form action="inscription.php" method="post">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <label for="mot_de_passe">Mot de passe :</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>

            <button type="submit">S'inscrire</button>
        </form>
    </div>
</body>
</html>