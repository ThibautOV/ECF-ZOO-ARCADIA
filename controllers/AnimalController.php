<?php
// Controllers/AnimalController.php

require_once 'Models/Animal.php';
require_once 'NoSql.php';

class AnimalController {
    private $model;
    private $noSql;

    public function __construct() {
        global $pdo;
        $this->model = new Animal($pdo);
        $this->noSql = new NoSql();
    }

    public function showAnimal($id) {
        $animal = $this->model->getAnimalDetails($id);
        // Augmente la consultation de l'animal dans NoSQL
        $this->noSql->increaseConsultation($animal['first_name']);
        require 'Views/animals/detail.php';
    }

    public function listAnimalsByHabitat($habitatId) {
        $animals = $this->model->getAllAnimalsByHabitat($habitatId);
        require 'Views/animals/list.php';
    }
}
?>