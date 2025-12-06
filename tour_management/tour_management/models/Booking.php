<?php
// models/Booking.php

class Booking {
    private $conn;
    private $table = "bookings"; 

    // Thuộc tính đối tượng (theo cột trong CSDL)
    public $id;
    public $tour_id;
    public $customer_id;
    public $loai_khach; 
    public $user_id;
    public $ma_dat_tour;
    public $ngay_dat;
    public $so_nguoi_lon;
    public $so_tre_em;
    public $trang_thai; 
    public $tong_tien;       // <-- BỔ SUNG: Bắt buộc NOT NULL
    public $da_thanh_toan;   // <-- BỔ SUNG
    public $con_lai;         // <-- BỔ SUNG: Bắt buộc NOT NULL
    public $ghi_chu;         // <-- BỔ SUNG (Nếu có trong schema và muốn quản lý)

    public function __construct($db) {
        $this->conn = $db;
    }

    // --- PHƯƠNG THỨC CRUD CƠ BẢN ---

    // Lấy tất cả Booking kèm chi tiết Tour và Khách hàng
    public function getAllBookingsWithDetails() {
        $query = "SELECT 
                    b.*, 
                    t.ten_tour, 
                    c.ho_ten
                  FROM " . $this->table . " b
                  JOIN tours t ON b.tour_id = t.id
                  JOIN customers c ON b.customer_id = c.id
                  ORDER BY b.ngay_dat DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Lấy thông tin Booking theo ID và gán vào thuộc tính (ĐÃ CẬP NHẬT)
    public function getById() {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row) {
                // Gán các thuộc tính
                $this->tour_id = $row['tour_id'];
                $this->customer_id = $row['customer_id'];
                $this->loai_khach = $row['loai_khach'];
                $this->user_id = $row['user_id'];
                $this->ma_dat_tour = $row['ma_dat_tour'];
                $this->ngay_dat = $row['ngay_dat'];
                $this->so_nguoi_lon = $row['so_nguoi_lon'];
                $this->so_tre_em = $row['so_tre_em'];
                $this->trang_thai = $row['trang_thai'];
                $this->tong_tien = $row['tong_tien'];      // <-- BỔ SUNG
                $this->da_thanh_toan = $row['da_thanh_toan']; // <-- BỔ SUNG
                $this->con_lai = $row['con_lai'];          // <-- BỔ SUNG
                $this->ghi_chu = $row['ghi_chu'];          // <-- BỔ SUNG
                return true;
            }
        }
        return false;
    }

    // Tạo Booking mới (ĐÃ CẬP NHẬT)
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  SET tour_id=:tour_id, customer_id=:customer_id, user_id=:user_id,
                      ma_dat_tour=:ma_dat_tour, ngay_dat=:ngay_dat, loai_khach=:loai_khach,
                      so_nguoi_lon=:so_nguoi_lon, so_tre_em=:so_tre_em, trang_thai=:trang_thai, 
                      tong_tien=:tong_tien, da_thanh_toan=:da_thanh_toan, con_lai=:con_lai, ghi_chu=:ghi_chu";
        
        $stmt = $this->conn->prepare($query);

        // Bind dữ liệu
        $stmt->bindParam(":tour_id", $this->tour_id, PDO::PARAM_INT);
        $stmt->bindParam(":customer_id", $this->customer_id, PDO::PARAM_INT);
        $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);
        $stmt->bindParam(":ma_dat_tour", $this->ma_dat_tour);
        $stmt->bindParam(":ngay_dat", $this->ngay_dat);
        $stmt->bindParam(":loai_khach", $this->loai_khach);
        $stmt->bindParam(":so_nguoi_lon", $this->so_nguoi_lon, PDO::PARAM_INT);
        $stmt->bindParam(":so_tre_em", $this->so_tre_em, PDO::PARAM_INT);
        $stmt->bindParam(":trang_thai", $this->trang_thai);
        $stmt->bindParam(":tong_tien", $this->tong_tien);        // <-- BIND THÊM
        $stmt->bindParam(":da_thanh_toan", $this->da_thanh_toan);  // <-- BIND THÊM
        $stmt->bindParam(":con_lai", $this->con_lai);            // <-- BIND THÊM
        $stmt->bindParam(":ghi_chu", $this->ghi_chu);            // <-- BIND THÊM

        return $stmt->execute();
    }

    // Cập nhật Booking (ĐÃ CẬP NHẬT)
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET tour_id=:tour_id, customer_id=:customer_id, 
                      ngay_dat=:ngay_dat, so_nguoi_lon=:so_nguoi_lon, 
                      so_tre_em=:so_tre_em, trang_thai=:trang_thai, loai_khach=:loai_khach,
                      tong_tien=:tong_tien, da_thanh_toan=:da_thanh_toan, con_lai=:con_lai, ghi_chu=:ghi_chu
                  WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);

        // Bind dữ liệu
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":tour_id", $this->tour_id, PDO::PARAM_INT);
        $stmt->bindParam(":customer_id", $this->customer_id, PDO::PARAM_INT);
        $stmt->bindParam(":ngay_dat", $this->ngay_dat);
        $stmt->bindParam(":loai_khach", $this->loai_khach);
        $stmt->bindParam(":so_nguoi_lon", $this->so_nguoi_lon, PDO::PARAM_INT);
        $stmt->bindParam(":so_tre_em", $this->so_tre_em, PDO::PARAM_INT);
        $stmt->bindParam(":trang_thai", $this->trang_thai);
        $stmt->bindParam(":tong_tien", $this->tong_tien);        // <-- BIND THÊM
        $stmt->bindParam(":da_thanh_toan", $this->da_thanh_toan);  // <-- BIND THÊM
        $stmt->bindParam(":con_lai", $this->con_lai);            // <-- BIND THÊM
        $stmt->bindParam(":ghi_chu", $this->ghi_chu);            // <-- BIND THÊM

        return $stmt->execute();
    }
    
    // Xóa Booking
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // --- PHƯƠNG THỨC HỖ TRỢ ĐIỂM DANH (Cần thiết cho AttendanceController) ---

    // 1. Lấy danh sách các Chuyến Đi (Booking đã xác nhận) để chọn điểm danh
    public function getDistinctTourRuns() {
        $query = "SELECT 
                    b.id AS booking_id, 
                    b.tour_id,
                    t.ten_tour, 
                    b.ngay_dat AS ngay_khoi_hanh, 
                    t.so_ngay 
                  FROM bookings b
                  JOIN tours t ON b.tour_id = t.id
                  WHERE b.trang_thai = 'Đã xác nhận' 
                  AND DATE_ADD(b.ngay_dat, INTERVAL t.so_ngay DAY) >= CURDATE()
                  ORDER BY b.ngay_dat DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // 2. Lấy thông tin Tour Run (Booking) để hiển thị chi tiết
    public function getTourInfoByBookingId($booking_id) {
        $query = "SELECT 
                    b.id AS booking_id,
                    t.id AS tour_id,
                    t.ten_tour, 
                    t.so_ngay,
                    b.ngay_dat AS ngay_khoi_hanh
                  FROM bookings b
                  JOIN tours t ON b.tour_id = t.id
                  WHERE b.id = :booking_id
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":booking_id", $booking_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // 3. Lấy danh sách Booking (tên người đại diện) cho Attendance Check
    public function getBookingsForAttendance($booking_id) {
        $query = "SELECT 
                    b.id AS booking_id, 
                    c.ho_ten, 
                    b.so_nguoi_lon, 
                    b.so_tre_em,
                    (b.so_nguoi_lon + b.so_tre_em) AS tong_khach 
                  FROM bookings b
                  JOIN customers c ON b.customer_id = c.id
                  WHERE b.id = :booking_id 
                  AND b.trang_thai = 'Đã xác nhận'
                  ORDER BY b.id ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":booking_id", $booking_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
}
// KHÔNG CẦN THẺ ĐÓNG PHP ?>