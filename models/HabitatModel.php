<?php
class HabitatModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllHabitats() {
        $query = "SELECT * FROM habitats";
        $statement = $this->db->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createHabitat($name, $description, $images) {
        $query = "INSERT INTO habitats (name, description, images) VALUES (:name, :description, :images)";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':images', $images);
        $statement->execute();
    }

    public function deleteHabitat($id) {
        $query = "DELETE FROM habitats WHERE id = :id";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
    }
}
?>