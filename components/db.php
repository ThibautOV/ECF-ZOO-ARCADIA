<?php

$host = 'mysql-ovelacque.alwaysdata.net'; 
$dbname = 'ovelacque_arcadia'; 
$username = 'ovelacque_thibau';
$password = 'C6b9236a.'; 


try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion :c : " . $e->getMessage();
}
?>