<?php
class ConsultationModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function recordConsultation($animalId) {
        // Logique pour enregistrer une consultation
        $stmt = $this->db->prepare("INSERT INTO consultations (animal_id) VALUES (:animal_id)");
        $stmt->bindParam(':animal_id', $animalId);
        return $stmt->execute();
    }

    public function getConsultationCount($animalId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM consultations WHERE animal_id = :animal_id");
        $stmt->bindParam(':animal_id', $animalId);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
?>