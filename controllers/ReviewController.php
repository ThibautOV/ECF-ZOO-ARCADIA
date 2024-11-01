<?php
// Controllers/ReviewController.php
require_once 'Models/Review.php';

class ReviewController {
    private $model;

    public function __construct() {
        global $pdo;
        $this->model = new Review($pdo);
    }

    public function submitReview() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pseudo = $_POST['pseudo'];
            $avis = $_POST['avis'];
            if ($this->model->submitReview($pseudo, $avis)) {
                // Rediriger vers la page d'accueil après soumission
                header("Location: index.php?action=home");
                exit();
            }
        }
        require 'Views/reviews/form.php';
    }
}
?>