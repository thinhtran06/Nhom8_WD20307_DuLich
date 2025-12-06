<?php
class GuideAssignment {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Gán HDV vào tour
    public function assign($tour_id, $guide_id) {
        $sql = "INSERT INTO tour_hdv (tour_id, guide_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$tour_id, $guide_id]);
    }

    // Lấy HDV theo tour
    public function getGuideByTour($tour_id) {
        $sql = "SELECT guides.*
                FROM tour_hdv
                JOIN guides ON guides.id = tour_hdv.guide_id
                WHERE tour_hdv.tour_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$tour_id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Lấy tour theo HDV
    public function getToursByGuide($guide_id) {
        $sql = "SELECT tours.*
                FROM tour_hdv
                JOIN tours ON tours.id = tour_hdv.tour_id
                WHERE tour_hdv.guide_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$guide_id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
