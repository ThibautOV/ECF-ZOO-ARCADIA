<?php
// index.php
require_once 'config.php';

$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'home':
        require 'Controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
    
    case 'listServices':
        require 'Controllers/ServiceController.php';
        $controller = new ServiceController();
        $controller->listServices();
        break;

    case 'listHabitats':
        require 'Controllers/HabitatController.php';
        $controller = new HabitatController();
        $controller->listHabitats();
        break;

    // Ajoutez d'autres routes pour chaque fonctionnalité
    default:
        echo "Page non trouvée.";
        break;
}
?>