<?php
// models/Customer.php

class Customer {
    private $conn;
    private $table = "customers";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function findByPhone($phone) {
        $query = "SELECT id, ho_ten FROM " . $this->table . " WHERE dien_thoai = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$phone]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo khách hàng mới (Đã thêm dữ liệu mặc định cho các cột NOT NULL)
    public function create($data) {
        if (empty($data['ho_ten'])) { return false; }

        $query = "INSERT INTO " . $this->table . " 
                  SET ho_ten = :ho_ten, 
                      dien_thoai = :dien_thoai,
                      email = :email,
                      dia_chi = :dia_chi,
                      cmnd_cccd = :cmnd_cccd,
                      gioi_tinh = :gioi_tinh,
                      created_at = NOW()";
        
        $stmt = $this->conn->prepare($query);

        $ho_ten = $data['ho_ten'];
        $dien_thoai = $data['dien_thoai'] ?? '';

        // DỮ LIỆU GIẢ/MẶC ĐỊNH để thỏa mãn ràng buộc NOT NULL
        $email_gia = 'khach_' . time() . '@noemail.com'; 
        $dia_chi_mac_dinh = 'Chưa cập nhật';
        $cccd_mac_dinh = '000000000';
        $gioi_tinh_mac_dinh = 'Khác';

        $stmt->bindParam(':ho_ten', $ho_ten);
        $stmt->bindParam(':dien_thoai', $dien_thoai);
        $stmt->bindParam(':email', $email_gia);
        $stmt->bindParam(':dia_chi', $dia_chi_mac_dinh);
        $stmt->bindParam(':cmnd_cccd', $cccd_mac_dinh);
        $stmt->bindParam(':gioi_tinh', $gioi_tinh_mac_dinh);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }
    
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>