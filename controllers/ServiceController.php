<?php
// Controllers/ServiceController.php
require_once 'Models/Service.php';

class ServiceController {
    private $model;

    public function __construct() {
        global $pdo;
        $this->model = new Service($pdo);
    }

    public function listServices() {
        $services = $this->model->getAllServices();
        require 'Views/services/list.php';
    }
}
?>