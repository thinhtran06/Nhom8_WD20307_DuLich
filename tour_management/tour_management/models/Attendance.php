<?php
// models/Attendance.php

class Attendance {
    private $conn;
    private $table = "diem_danh"; 

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy trạng thái điểm danh hiện tại
    public function getAttendanceStatus($tour_id, $day) {
        $query = "SELECT booking_id, trang_thai 
                  FROM " . $this->table . " 
                  WHERE tour_id = :tour_id AND ngay_diem_danh = :ngay_diem_danh";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":tour_id", $tour_id, PDO::PARAM_INT);
        $stmt->bindParam(":ngay_diem_danh", $day, PDO::PARAM_INT);
        $stmt->execute();
        
        $results = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[$row['booking_id']] = $row['trang_thai'];
        }
        return $results;
    }

    // Cập nhật hoặc thêm mới trạng thái điểm danh
    public function saveAttendance($tour_id, $booking_id, $day, $status) {
        $query = "INSERT INTO " . $this->table . " 
                  SET tour_id = :tour_id, booking_id = :booking_id, 
                      ngay_diem_danh = :ngay_diem_danh, trang_thai = :trang_thai
                  ON DUPLICATE KEY UPDATE trang_thai = :trang_thai";

        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":tour_id", $tour_id, PDO::PARAM_INT);
        $stmt->bindParam(":booking_id", $booking_id, PDO::PARAM_INT);
        $stmt->bindParam(":ngay_diem_danh", $day, PDO::PARAM_INT);
        $stmt->bindParam(":trang_thai", $status);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // Log lỗi nếu cần
            return false;
        }
    }
}
?>