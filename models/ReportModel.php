<?php
class ReportModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createReport($animalId, $state, $foodGiven, $quantity, $date, $details) {
        $stmt = $this->db->prepare("INSERT INTO vet_reports (animal_id, state, food_given, quantity, date, details) VALUES (:animal_id, :state, :food_given, :quantity, :date, :details)");
        $stmt->bindParam(':animal_id', $animalId);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':food_given', $foodGiven);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':details', $details);
        return $stmt->execute();
    }

    public function getReportsByAnimal($animalId) {
        $stmt = $this->db->prepare("SELECT * FROM vet_reports WHERE animal_id = :animal_id");
        $stmt->bindParam(':animal_id', $animalId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>