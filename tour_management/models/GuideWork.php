<?php
class GuideWork {

    private $conn;
    private $table = "guide_tour"; // DÙNG ĐÚNG TÊN BẢNG TRONG DATABASE

    public function __construct($db){
        $this->conn = $db;
    }

    // Kiểm tra tour đã có HDV chưa
    public function exists($tour_id){
        $sql = "SELECT id FROM {$this->table} WHERE tour_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$tour_id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Lưu phân công HDV cho tour
    public function assign($guide_id, $tour_id){
        $sql = "INSERT INTO {$this->table} (guide_id, tour_id, created_at)
                VALUES (?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$guide_id, $tour_id]);
    }

    // Lấy danh sách tour mà HDV được phân công
    public function getAssignedTours($guide_id){
        $sql = "
            SELECT 
                t.id AS tour_id,
                t.ten_tour,
                t.ngay_khoi_hanh,
                t.so_ngay,
                t.diem_khoi_hanh,
                t.diem_den
            FROM guide_tour gt
            JOIN tours t ON t.id = gt.tour_id
            WHERE gt.guide_id = ?
            ORDER BY t.ngay_khoi_hanh ASC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$guide_id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
