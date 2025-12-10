<?php
// models/CustomerSpecialRequest.php

class CustomerSpecialRequest {
    private $conn;
    private $table = "customer_special_request"; // Thêm tên bảng để nhất quán

    public function __construct($db){
        $this->conn = $db;
    }

    // Lấy yêu cầu đặc biệt của khách trong tour
    public function getByTour($tour_id) {
        $sql = "SELECT * FROM {$this->table} WHERE tour_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$tour_id]);
        
        $result = [];
        // Sử dụng FETCH_ASSOC để trả về mảng kết hợp thay vì FETCH_OBJ (giúp nhất quán hơn)
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
             $result[$row['customer_id']] = $row;
        }
        return $result;
    }

    // Thêm hoặc cập nhật (upsert)
    public function upsert($tour_id, $customer_id, $guide_id, $yeu_cau, $ghi_chu) {
        $sql = "
            INSERT INTO {$this->table} (tour_id, customer_id, guide_id, yeu_cau, ghi_chu)
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