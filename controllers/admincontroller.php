<?php
// Controllers/AdminController.php

require_once 'Models/User.php';

class AdminController {
    private $model;

    public function __construct() {
        global $pdo;
        $this->model = new User($pdo);
    }

    public function dashboard() {
        $users = $this->model->getAllUsers();
        require 'Views/admin/dashboard.php';
    }
}
?>