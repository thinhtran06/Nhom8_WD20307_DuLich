<?php
class CustomerSpecialRequest {
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    // Lấy yêu cầu đặc biệt của khách trong tour
    public function getByTour($tour_id) {
        $sql = "SELECT * FROM customer_special_request WHERE tour_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$tour_id]);
        
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
            $result[$row->customer_id] = $row;
        }
        return $result;
    }

    // Thêm hoặc cập nhật (upsert)
    public function upsert($tour_id, $customer_id, $guide_id, $yeu_cau, $ghi_chu) {
        $sql = "
            INSERT INTO customer_special_request(tour_id, customer_id, guide_id, yeu_cau, ghi_chu)
            VALUES(?,?,?,?,?)
            ON DUPLICATE KEY UPDATE 
                yeu_cau = VALUES(yeu_cau),
                ghi_chu = VALUES(ghi_chu),
                updated_at = NOW()
        ";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$tour_id, $customer_id, $guide_id, $yeu_cau, $ghi_chu]);
    }
}
