<?php
// models/Customer.php

class Customer {
    private $conn;
    private $table = "customers";

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Lấy tất cả Khách hàng (ID, Tên, SĐT)
     * @return PDOStatement
     */
    public function getAll() {
        $query = "SELECT id, ho_ten, dien_thoai FROM " . $this->table . " ORDER BY ho_ten ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    /**
     * Lấy thông tin khách hàng theo ID
     * @param int $customer_id ID khách hàng
     * @return array|false
     */
    public function getById($customer_id) {
        $query = "SELECT id, ho_ten FROM " . $this->table . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $customer_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Tạo khách hàng mới từ dữ liệu được cung cấp. (Dùng khi tạo Booking mới cho khách hàng chưa tồn tại)
     * @param array $data Mảng chứa dữ liệu khách hàng (ho_ten, dien_thoai, cmnd_cccd, v.v.).
     * @return int|false ID của khách hàng mới hoặc False nếu thất bại.
     */
    public function createCustomer($data) {
        $query = "INSERT INTO " . $this->table . " (ho_ten, dien_thoai, cmnd_cccd, created_at, updated_at) 
                  VALUES (:ho_ten, :dien_thoai, :cmnd_cccd, NOW(), NOW())";
        
        $stmt = $this->conn->prepare($query);

        // Làm sạch và gán giá trị
        // Đảm bảo rằng các key 'ho_ten', 'dien_thoai', 'cmnd_cccd' tồn tại trong $data
        $ho_ten_clean = htmlspecialchars(strip_tags($data['ho_ten'] ?? ''));
        $dien_thoai_clean = htmlspecialchars(strip_tags($data['dien_thoai'] ?? ''));
        $cccd_clean = htmlspecialchars(strip_tags($data['cmnd_cccd'] ?? ''));

        $stmt->bindParam(':ho_ten', $ho_ten_clean);
        $stmt->bindParam(':dien_thoai', $dien_thoai_clean);
        $stmt->bindParam(':cmnd_cccd', $cccd_clean);
        
        try {
            if ($stmt->execute()) {
                // Trả về ID của khách hàng vừa được tạo
                return $this->conn->lastInsertId();
            }
        } catch (PDOException $e) {
            // Có thể log lỗi chi tiết hơn ở đây
            return false;
        }

        return false;
    }

    /**
     * Tạo một Khách hàng Placeholder (Khách lẻ chưa có thông tin)
     * và trả về ID của khách hàng mới này.
     * @param int $booking_id ID của Booking liên quan
     * @param string $loai_khach Loại khách (Người lớn/Trẻ em)
     * @param int $index Số thứ tự của khách lẻ
     * @return int|false ID khách hàng mới hoặc False
     */
    public function createPlaceholderCustomer($booking_id, $loai_khach, $index) {
        
        // Chuẩn hóa dữ liệu placeholder
        $ho_ten = "Khách Lẻ Booking " . $booking_id . " #" . $index;
        $dien_thoai = "000" . str_pad($booking_id, 3, '0', STR_PAD_LEFT) . str_pad($index, 3, '0', STR_PAD_LEFT);
        $cmnd_cccd = "PH" . str_pad($booking_id, 5, '0', STR_PAD_LEFT) . str_pad($index, 2, '0', STR_PAD_LEFT);
        $ngay_sinh = '1900-01-01'; // Giá trị mặc định
        $ghi_chu = "Khách lẻ - " . $loai_khach;

        $query = "INSERT INTO " . $this->table . " 
                     SET ho_ten=:ho_ten, dien_thoai=:dien_thoai, cmnd_cccd=:cmnd_cccd,
                         ghi_chu=:ghi_chu, ngay_sinh=:ngay_sinh, created_at=NOW(), updated_at=NOW()";
                     
        $stmt = $this->conn->prepare($query);

        // Bind parameters
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