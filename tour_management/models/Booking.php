<?php
// models/Booking.php

class Booking {
    private $conn;
    private $table = "bookings"; 

    // Thuộc tính đối tượng (theo cột trong CSDL)
    // Lưu ý: ngay_dat được dùng để lưu Ngày Khởi Hành theo cấu trúc DB phổ biến.
    public $id;
    public $tour_id;
    public $customer_id;
    public $loai_khach; 
    public $user_id;
    public $ma_dat_tour;
    public $ngay_dat; // Ngày khởi hành của Tour
    public $so_nguoi_lon;
    public $so_tre_em;
    public $trang_thai; 
    public $tong_tien; 
    public $da_thanh_toan; 
    public $con_lai; 
    public $ghi_chu; 

    public function __construct($db) {
        $this->conn = $db;
    }

    // --- PHƯƠNG THỨC CRUD CƠ BẢN ---

    /**
     * Lấy tất cả Booking kèm chi tiết Tour và Khách hàng đại diện.
     * @return PDOStatement
     */
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

    /**
     * Lấy thông tin Booking theo ID và gán vào thuộc tính.
     * @return bool
     */
    public function getById() {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        
        // Làm sạch và bind ID
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row) {
                $this->tour_id = $row['tour_id'];
                $this->customer_id = $row['customer_id'];
                $this->loai_khach = $row['loai_khach'];
                $this->user_id = $row['user_id'];
                $this->ma_dat_tour = $row['ma_dat_tour'];
                $this->ngay_dat = $row['ngay_dat'];
                $this->so_nguoi_lon = $row['so_nguoi_lon'];
                $this->so_tre_em = $row['so_tre_em'];
                $this->trang_thai = $row['trang_thai'];
                $this->tong_tien = $row['tong_tien']; 
                $this->da_thanh_toan = $row['da_thanh_toan']; 
                $this->con_lai = $row['con_lai']; 
                $this->ghi_chu = $row['ghi_chu']; 
                return true;
            }
        }
        return false;
    }

    /**
     * Tạo Booking mới.
     * @return int|bool ID Booking mới hoặc False nếu thất bại.
     */
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                     SET tour_id=:tour_id, customer_id=:customer_id, user_id=:user_id,
                         ma_dat_tour=:ma_dat_tour, ngay_dat=:ngay_dat, loai_khach=:loai_khach,
                         so_nguoi_lon=:so_nguoi_lon, so_tre_em=:so_tre_em, trang_thai=:trang_thai, 
                         tong_tien=:tong_tien, da_thanh_toan=:da_thanh_toan, con_lai=:con_lai, 
                         ghi_chu=:ghi_chu, created_at=NOW(), updated_at=NOW()";
        
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu và Bind
        $this->tour_id = htmlspecialchars(strip_tags($this->tour_id));
        $this->customer_id = htmlspecialchars(strip_tags($this->customer_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->ma_dat_tour = htmlspecialchars(strip_tags($this->ma_dat_tour));
        $this->ngay_dat = htmlspecialchars(strip_tags($this->ngay_dat));
        $this->loai_khach = htmlspecialchars(strip_tags($this->loai_khach));
        $this->so_nguoi_lon = htmlspecialchars(strip_tags($this->so_nguoi_lon));
        $this->so_tre_em = htmlspecialchars(strip_tags($this->so_tre_em));
        $this->trang_thai = htmlspecialchars(strip_tags($this->trang_thai));
        $this->tong_tien = htmlspecialchars(strip_tags($this->tong_tien));
        $this->da_thanh_toan = htmlspecialchars(strip_tags($this->da_thanh_toan));
        $this->con_lai = htmlspecialchars(strip_tags($this->con_lai));
        $this->ghi_chu = htmlspecialchars(strip_tags($this->ghi_chu));


        $stmt->bindParam(":tour_id", $this->tour_id, PDO::PARAM_INT);
        $stmt->bindParam(":customer_id", $this->customer_id, PDO::PARAM_INT);
        $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);
        $stmt->bindParam(":ma_dat_tour", $this->ma_dat_tour);
        $stmt->bindParam(":ngay_dat", $this->ngay_dat);
        $stmt->bindParam(":loai_khach", $this->loai_khach);
        $stmt->bindParam(":so_nguoi_lon", $this->so_nguoi_lon, PDO::PARAM_INT);
        $stmt->bindParam(":so_tre_em", $this->so_tre_em, PDO::PARAM_INT);
        $stmt->bindParam(":trang_thai", $this->trang_thai);
        $stmt->bindParam(":tong_tien", $this->tong_tien); 
        $stmt->bindParam(":da_thanh_toan", $this->da_thanh_toan); 
        $stmt->bindParam(":con_lai", $this->con_lai); 
        $stmt->bindParam(":ghi_chu", $this->ghi_chu); 

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    /**
     * Cập nhật Booking.
     * @return bool
     */
    public function update() {
        $query = "UPDATE " . $this->table . " 
                     SET tour_id=:tour_id, customer_id=:customer_id, 
                         ngay_dat=:ngay_dat, so_nguoi_lon=:so_nguoi_lon, 
                         so_tre_em=:so_tre_em, trang_thai=:trang_thai, loai_khach=:loai_khach,
                         tong_tien=:tong_tien, da_thanh_toan=:da_thanh_toan, con_lai=:con_lai, 
                         ghi_chu=:ghi_chu, updated_at=NOW()
                     WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu và Bind (Cần làm sạch tất cả các thuộc tính trước khi bind)
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->tour_id = htmlspecialchars(strip_tags($this->tour_id));
        $this->customer_id = htmlspecialchars(strip_tags($this->customer_id));
        $this->ngay_dat = htmlspecialchars(strip_tags($this->ngay_dat));
        $this->loai_khach = htmlspecialchars(strip_tags($this->loai_khach));
        $this->so_nguoi_lon = htmlspecialchars(strip_tags($this->so_nguoi_lon));
        $this->so_tre_em = htmlspecialchars(strip_tags($this->so_tre_em));
        $this->trang_thai = htmlspecialchars(strip_tags($this->trang_thai));
        $this->tong_tien = htmlspecialchars(strip_tags($this->tong_tien));
        $this->da_thanh_toan = htmlspecialchars(strip_tags($this->da_thanh_toan));
        $this->con_lai = htmlspecialchars(strip_tags($this->con_lai));
        $this->ghi_chu = htmlspecialchars(strip_tags($this->ghi_chu));
        
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":tour_id", $this->tour_id, PDO::PARAM_INT);
        $stmt->bindParam(":customer_id", $this->customer_id, PDO::PARAM_INT);
        $stmt->bindParam(":ngay_dat", $this->ngay_dat);
        $stmt->bindParam(":loai_khach", $this->loai_khach);
        $stmt->bindParam(":so_nguoi_lon", $this->so_nguoi_lon, PDO::PARAM_INT);
        $stmt->bindParam(":so_tre_em", $this->so_tre_em, PDO::PARAM_INT);
        $stmt->bindParam(":trang_thai", $this->trang_thai);
        $stmt->bindParam(":tong_tien", $this->tong_tien); 
        $stmt->bindParam(":da_thanh_toan", $this->da_thanh_toan); 
        $stmt->bindParam(":con_lai", $this->con_lai); 
        $stmt->bindParam(":ghi_chu", $this->ghi_chu); 

        return $stmt->execute();
    }
    
    /**
     * Xóa Booking.
     * @return bool
     */
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Cập nhật nhanh trạng thái Booking.
     * @param string $new_status Trạng thái mới.
     * @return bool
     */
    public function updateStatus($new_status) {
        $query = "UPDATE " . $this->table . "
                      SET trang_thai = :trang_thai, 
                          updated_at = NOW()
                      WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        // Làm sạch dữ liệu
        $new_status_clean = htmlspecialchars(strip_tags($new_status));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Gán giá trị
        $stmt->bindParam(':trang_thai', $new_status_clean);
        $stmt->bindParam(':id', $this->id);
        
        return $stmt->execute();
    }

    // --- PHƯƠNG THỨC HỖ TRỢ ĐIỂM DANH (ATTENDANCE) ---

    /**
     * Lấy danh sách các chuyến đi (Tour Runs) đang hoạt động để chọn điểm danh.
     * @return PDOStatement
     */
    public function getDistinctTourRuns() {
        $query = "SELECT 
                      b.id AS booking_id, 
                      b.tour_id,
                      t.ten_tour, 
                      b.ngay_dat AS ngay_khoi_hanh, 
                      t.so_ngay,
                      SUM(b.so_nguoi_lon + b.so_tre_em) AS total_guests
                    FROM bookings b
                    JOIN tours t ON b.tour_id = t.id
                    WHERE b.trang_thai = 'Đã xác nhận'
                      AND b.ngay_dat >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) /* Lấy các tour trong 7 ngày gần nhất & tương lai */
                    GROUP BY b.tour_id, b.ngay_dat
                    ORDER BY b.ngay_dat DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Lấy thông tin Tour Run (Booking) để hiển thị chi tiết.
     * @param int $booking_id ID của Booking
     * @return array|bool Dữ liệu Tour hoặc False
     */
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
    
    /**
     * Lấy danh sách Khách lẻ (tên người đại diện) cho Attendance Check.
     * Phương thức này nên được sử dụng để lấy TẤT CẢ các Booking thuộc về cùng một chuyến đi (tour_id và ngay_dat).
     * Tuy nhiên, nếu bạn chỉ muốn lấy một Booking duy nhất (như tham số), code dưới đây là chính xác.
     * @param int $booking_id ID của Booking
     * @return PDOStatement
     */
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
    public function getDetailsById($id) {
    $query = "SELECT 
                b.*, 
                t.ten_tour, 
                c.ho_ten AS customer_name,
                u.ho_ten AS user_name
              FROM " . $this->table . " b
              JOIN tours t ON b.tour_id = t.id
              JOIN customers c ON b.customer_id = c.id
              LEFT JOIN users u ON b.user_id = u.id
              WHERE b.id = :id 
              LIMIT 0,1";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
    
}