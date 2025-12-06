<?php
// models/Customer.php

class Customer {
    private $conn;
    private $table = "customers";

    // Khai báo các thuộc tính cơ bản nếu cần
    public $id;
    public $ho_ten;
    // ...

    public function __construct($db) {
        $this->conn = $db;
    }

    // PHƯƠNG THỨC getAll (Cần cho BookingController để lấy danh sách khách hàng)
    public function getAll() { 
        $query = "SELECT id, ho_ten FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        
        // Kiểm tra lỗi trước khi execute
        if (!$stmt) {
             // Có thể log lỗi hoặc trả về mảng rỗng
             return null; 
        }
        
        $stmt->execute();
        return $stmt;
    }

    // Thêm các hàm CRUD khác nếu bạn có chức năng quản lý khách hàng
    // ...
}
?>