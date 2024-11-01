<?php
// Models/Animal.php

class Animal {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAnimalDetails($id) {
        $stmt = $this->db->prepare("SELECT * FROM animals WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllAnimalsByHabitat($habitatId) {
        $stmt = $this->db->prepare("SELECT * FROM animals WHERE habitat_id = :habitat_id");
        $stmt->bindParam(':habitat_id', $habitatId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>