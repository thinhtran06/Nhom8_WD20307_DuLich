<?php
class Attendance {
    private $conn;
    private $table = "attendance";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy danh sách điểm danh theo lịch trình (schedule_id)
    public function getBySchedule($schedule_id) {
        $sql = "SELECT * FROM attendance WHERE schedule_id = :schedule_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":schedule_id", $schedule_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
