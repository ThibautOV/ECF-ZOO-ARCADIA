<?php
session_start(); // Démarre la session

// Vérifie si l'utilisateur est connecté en tant qu'administrateur
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: connexion.php"); // Redirection vers la page de connexion si non connecté
    exit();
}

require '../components/db.php'; 

// Connexion à la base de données
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    file_put_contents('error_log.txt', $e->getMessage(), FILE_APPEND);
    die("Erreur de connexion. Veuillez réessayer plus tard.");
}

// Gestion de l'ajout d'un nouvel animal
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajouter'])) {
    $nom = trim($_POST['nom']);
    $etat_sante = trim($_POST['etat_sante']);
    $nourriture = trim($_POST['nourriture']);
    $race = trim($_POST['race']);
    $image_url = trim($_POST['image_url']);
    $id_habitat = trim($_POST['id_habitat']);
    $description = trim($_POST['description']); 

    if (empty($nom) || empty($etat_sante) || empty($nourriture) || empty($race) || empty($image_url) || empty($id_habitat) || empty($description)) {
        die("Tous les champs sont requis.");
    }

    if (strlen($description) > 255) {
        die("La description ne peut pas dépasser 255 caractères.");
    }

    try {
        $sql = "INSERT INTO Animals (nom, etat_sante, nourriture, race, image_url, id_habitat, description) 
                VALUES (:nom, :etat_sante, :nourriture, :race, :image_url, :id_habitat, :description)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nom' => $nom,
            ':etat_sante' => $etat_sante,
            ':nourriture' => $nourriture,
            ':race' => $race,
            ':image_url' => $image_url,
            ':id_habitat' => $id_habitat,
            ':description' => $description 
        ]);

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } catch (PDOException $e) {
        file_put_contents('error_log.txt', $e->getMessage(), FILE_APPEND);
        echo "Erreur lors de l'ajout de l'animal. Détails de l'erreur : " . htmlspecialchars($e->getMessage());
    }
}

// Gestion de la suppression d'un animal
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = intval($_GET['delete']);

    try {
        $sql = "DELETE FROM Animals WHERE id_animal = :id"; 
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } catch (PDOException $e) {
        file_put_contents('error_log.txt', $e->getMessage(), FILE_APPEND);
        echo "Erreur lors de la suppression de l'animal. Détails de l'erreur : " . htmlspecialchars($e->getMessage());
    }
}

// Récupération des animaux
try {
    $sql = "SELECT a.*, h.nom_habitat FROM Animals a 
            LEFT JOIN Habitats h ON a.id_habitat = h.id_habitat";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    file_put_contents('error_log.txt', $e->getMessage(), FILE_APPEND);
    echo "Erreur lors de la récupération des animaux. Détails de l'erreur : " . htmlspecialchars($e->getMessage());
}

require '../components/header.php'; 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/admin.css">
    <link rel="stylesheet" href="/public/assets/css/header.css">
    <title>Panel de gestion</title>
</head>
<body>

<div class="form-container">
    <h2>Ajouter un nouvel animal</h2>
    <form method="POST" action="">
        <div class="input-group">
            <label for="nom">Nom de l'animal</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div class="input-group">
            <label for="etat_sante">État de santé</label>
            <input type="text" id="etat_sante" name="etat_sante" required>
        </div>
        <div class="input-group">
            <label for="nourriture">Nourriture</label>
            <input type="text" id="nourriture" name="nourriture" required>
        </div>
        <div class="input-group">
            <label for="race">Race</label>
            <input type="text" id="race" name="race" required>
        </div>
        <div class="input-group">
            <label for="image_url">Image</label>
            <input type="text" id="image_url" name="image_url" required>
        </div>
        <div class="input-group">
            <label for="description">Description (max 255 caractères)</label>
            <textarea id="description" name="description" maxlength="255" required></textarea> 
        </div>
        <div class="input-group">
            <label for="id_habitat">Habitat</label>
            <select id="id_habitat" name="id_habitat" required>
                <?php
                try {
                    $habitats = $conn->query("SELECT * FROM Habitats")->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($habitats as $habitat): ?>
                        <option value="<?= htmlspecialchars($habitat['id_habitat']) ?>"><?= htmlspecialchars($habitat['nom_habitat']) ?></option>
                    <?php endforeach;
                } catch (PDOException $e) {
                    echo "Erreur lors de la récupération des habitats. Détails de l'erreur : " . htmlspecialchars($e->getMessage());
                }
                ?>
            </select>
        </div>
        <input type="submit" name="ajouter" class="button" value="Ajouter l'animal">
    </form>
</div>

<div class="table-container">
    <h2>Liste des Résidents</h2>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>État de santé</th>
                <th>Nourriture</th>
                <th>Race</th>
                <th>Image</th>
                <th>Description</th> 
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($animaux)): ?>
                <?php foreach ($animaux as $animal): ?>
                    <tr id="animal-<?= htmlspecialchars($animal['id_animal']) ?>"> 
                        <td><?= htmlspecialchars($animal['nom']) ?></td>
                        <td><?= htmlspecialchars($animal['etat_sante']) ?></td>
                        <td><?= htmlspecialchars($animal['nourriture']) ?></td>
                        <td><?= htmlspecialchars($animal['race']) ?></td>
                        <td>
                            <?php if (!empty($animal['image_url'])): ?>
                                <img src="<?= htmlspecialchars($animal['image_url']) ?>" alt="<?= htmlspecialchars($animal['nom']) ?>" style="max-width: 100px; max-height: 100px;">
                            <?php else: ?>
                                Pas d'image
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($animal['description']) ?></td> 
                        <td><?= htmlspecialchars($animal['nom_habitat']) ?></td>
                        <td>
                            <button class="delete-button" onclick="deleteAnimal(<?= htmlspecialchars($animal['id_animal']) ?>)">Supprimer</button> 
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Aucun animal trouvé</td> 
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
async function deleteAnimal(animalId) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cet animal ?")) {
        try {
            const response = await fetch(`<?= $_SERVER['PHP_SELF'] ?>?delete=${animalId}`, {
                method: 'GET',
            });

            if (response.ok) {
                document.getElementById(`animal-${animalId}`).remove();
                alert("Animal supprimé avec succès !");
            } else {
                alert("Erreur lors de la suppression de l'animal.");
            }
        } catch (error) {
            console.error("Erreur:", error);
            alert("Erreur lors de la suppression de l'animal. Veuillez réessayer plus tard.");
        }
    }
}
</script>

</body>
</html>