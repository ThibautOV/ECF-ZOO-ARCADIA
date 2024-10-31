<?php
require '../components/db.php';

// Connexion à la base de données
function connectDB()
{
    global $host, $dbname, $username, $password; // Déclare les variables globales

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}


function genererCartesAnimaux()
{

    $pdo = connectDB();


    $sql = "
        SELECT 
            a.nom, 
            a.etat_sante, 
            a.nourriture, 
            h.nom_habitat AS habitat, 
            a.race, 
            a.image_url,
            a.description -- Ajout de la colonne description
        FROM 
            Animals a
        JOIN 
            Habitats h ON a.id_habitat = h.id_habitat";
    $stmt = $pdo->query($sql);

    // Génération des cartes
    while ($animal = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<div class="carte">';
        echo '<h2>' . htmlspecialchars($animal['nom']) . '</h2>';
        echo '<p><strong>Habitat :</strong> ' . htmlspecialchars($animal['habitat']) . '</p>';
        echo '<p><strong>Race :</strong> ' . htmlspecialchars($animal['race']) . '</p>';
        echo '<p><strong>État de santé :</strong> ' . htmlspecialchars($animal['etat_sante']) . '</p>';
        echo '<p><strong>Nourriture :</strong> ' . htmlspecialchars($animal['nourriture']) . '</p>';


        echo '<p><strong>Description :</strong> ' . htmlspecialchars($animal['description']) . '</p>';

        if (!empty($animal['image_url'])) {
            echo '<img src="' . htmlspecialchars($animal['image_url']) . '" alt="' . htmlspecialchars($animal['nom']) . '" style="width:100%; height:auto;">';
        }
        echo '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Nos Résidents</title>
    <link rel="stylesheet" href="/Public/assets/css/animaux.css">
</head>

<body>
    <?php genererCartesAnimaux(); ?>
</body>

</html>