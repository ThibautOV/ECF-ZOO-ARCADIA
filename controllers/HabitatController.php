<?php
// Controllers/HabitatController.php
require_once 'Models/Habitat.php';

class HabitatController {
    private $model;

    public function __construct() {
        global $pdo;
        $this->model = new Habitat($pdo);
    }

    public function listHabitats() {
        $habitats = $this->model->getAllHabitats();
        require 'Views/habitats/list.php';
    }

    public function habitatDetails($id) {
        $habitat = $this->model->getHabitatDetails($id);
        require 'Views/habitats/detail.php';
    }
}
?>