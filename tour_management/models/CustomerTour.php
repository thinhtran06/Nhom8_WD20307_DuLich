<?php
class CustomerTour {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getByTour($tour_id) {
        $sql = "SELECT * FROM bookings WHERE tour_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$tour_id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
