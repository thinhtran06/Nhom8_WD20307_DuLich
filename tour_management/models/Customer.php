<?php
// models/Customer.php

class Customer {
    private $conn;
    private $table = "customers";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT id, ho_ten, dien_thoai FROM " . $this->table . " ORDER BY ho_ten ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    // Lấy thông tin khách hàng theo ID
    public function getById($customer_id) {
        $query = "SELECT id, ho_ten FROM " . $this->table . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $customer_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Tạo một Khách hàng Placeholder (Khách lẻ chưa có thông tin)
     * và trả về ID của khách hàng mới này.
     */
    public function createPlaceholderCustomer($booking_id, $loai_khach, $index) {
        
        $ho_ten = "Khách Lẻ Booking " . $booking_id . " #" . $index;
        $dien_thoai = "000" . str_pad($booking_id, 3, '0', STR_PAD_LEFT) . str_pad($index, 3, '0', STR_PAD_LEFT);
        $cmnd_cccd = "PH" . str_pad($booking_id, 5, '0', STR_PAD_LEFT) . str_pad($index, 2, '0', STR_PAD_LEFT);
        $ngay_sinh = '1900-01-01';
        $ghi_chu = "Khách lẻ - " . $loai_khach;

        $query = "INSERT INTO " . $this->table . " 
                  SET ho_ten=:ho_ten, dien_thoai=:dien_thoai, cmnd_cccd=:cmnd_cccd,
                      ghi_chu=:ghi_chu, ngay_sinh=:ngay_sinh, created_at=NOW(), updated_at=NOW()";
                  
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":ho_ten", $ho_ten);
        $stmt->bindParam(":dien_thoai", $dien_thoai);
        $stmt->bindParam(":cmnd_cccd", $cmnd_cccd);
        $stmt->bindParam(":ghi_chu", $ghi_chu);
        $stmt->bindParam(":ngay_sinh", $ngay_sinh);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }
}