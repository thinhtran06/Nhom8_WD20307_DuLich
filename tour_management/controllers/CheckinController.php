<?php
require_once __DIR__ . '/../config/database.php';

class Checkin
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Lấy danh sách điểm danh theo chặng
    public function getByStage($stage_id)
    {
        $sql = "SELECT c.*, b.customer_name 
                FROM checkin c
                LEFT JOIN bookings b ON c.booking_id = b.id
                WHERE c.stage_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$stage_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tạo bản ghi điểm danh mới
    public function create($booking_id, $stage_id, $status)
    {
        $sql = "INSERT INTO checkin (booking_id, stage_id, status) 
                VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$booking_id, $stage_id, $status]);
    }

    // Cập nhật trạng thái điểm danh
    public function updateStatus($id, $status)
    {
        $sql = "UPDATE checkin SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$status, $id]);
    }
}
