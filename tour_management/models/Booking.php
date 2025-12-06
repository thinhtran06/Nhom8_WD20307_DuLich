<?php
// models/Booking.php

class Booking {
    private $conn;
    private $table = "bookings";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($data) {
        // Kiểm tra dữ liệu quan trọng
        if (empty($data['tour_id']) || empty($data['customer_id'])) {
            return false;
        }

        $query = "INSERT INTO " . $this->table . " 
                  SET ma_dat_tour = :ma_dat_tour,
                      tour_id = :tour_id,
                      customer_id = :customer_id,
                      user_id = :user_id,
                      so_nguoi_lon = :so_nguoi_lon,
                      so_tre_em = :so_tre_em,
                      tong_tien = :tong_tien,
                      trang_thai = :trang_thai,
                      da_thanh_toan = :da_thanh_toan,
                      ghi_chu = :ghi_chu,
                      ngay_dat = NOW()";

        $stmt = $this->conn->prepare($query);

        // Xử lý dữ liệu số (tránh lỗi nếu rỗng)
        $so_nguoi_lon = !empty($data['so_nguoi_lon']) ? $data['so_nguoi_lon'] : 1;
        $so_tre_em    = !empty($data['so_tre_em']) ? $data['so_tre_em'] : 0;
        $tong_tien    = !empty($data['tong_tien']) ? $data['tong_tien'] : 0;
        $da_thanh_toan= !empty($data['da_thanh_toan']) ? $data['da_thanh_toan'] : 0;
        
        // FIX LỖI 1452: Lấy user_id đã được xác định ở Controller
        $user_id = $data['user_id'] ?? 1; // Giá trị đã được xác định là 1 (hoặc ID hợp lệ khác) ở Controller

        $stmt->bindParam(':ma_dat_tour', $data['ma_dat_tour']);
        $stmt->bindParam(':tour_id', $data['tour_id']);
        $stmt->bindParam(':customer_id', $data['customer_id']);
        $stmt->bindParam(':user_id', $user_id); // Dùng biến đã được kiểm tra
        $stmt->bindParam(':so_nguoi_lon', $so_nguoi_lon);
        $stmt->bindParam(':so_tre_em', $so_tre_em);
        $stmt->bindParam(':tong_tien', $tong_tien);
        $stmt->bindParam(':trang_thai', $data['trang_thai']);
        $stmt->bindParam(':da_thanh_toan', $da_thanh_toan);
        $stmt->bindParam(':ghi_chu', $data['ghi_chu']);

        if ($stmt->execute()) { // Lỗi 1452 xảy ra ở đây
            return true;
        }
        return false;
    }
    
    public function getAll() {
        $query = "SELECT b.*, t.ten_tour, c.ho_ten as customer_name 
                  FROM bookings b
                  LEFT JOIN tours t ON b.tour_id = t.id
                  LEFT JOIN customers c ON b.customer_id = c.id
                  ORDER BY b.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>