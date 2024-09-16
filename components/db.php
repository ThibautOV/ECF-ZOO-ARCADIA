<?php
// Paramètres de connexion à la base de données
$host = 'mysql-ovelacque.alwaysdata.net'; 
$dbname = 'ovelacque_arcadia'; 
$username = 'ovelacque_thibau';
$password = 'C6b9236a.'; 

try {
    // Création d'une nouvelle instance PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connexion à la base de données réussie :)!";
} catch (PDOException $e) {
    // Si erreur, afficher le message
    echo "Erreur de connexion :c : " . $e->getMessage();
}
