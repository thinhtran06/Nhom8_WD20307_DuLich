<?php
class Schedule {
    private $conn;
    private $table = "schedule";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getByTour($tour_id) {
        $sql = "SELECT * FROM schedule WHERE tour_id = ? ORDER BY ngay_thu ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$tour_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
