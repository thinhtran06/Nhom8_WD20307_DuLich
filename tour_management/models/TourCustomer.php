<?php
// models/TourCustomer.php

class TourCustomer {
    private $conn;
    private $table = "tour_customers"; 

    // Thuộc tính đối tượng
    public $id;
    public $booking_id;
    public $customer_id;
    public $ho_ten; 
    public $gioi_tinh;
    public $ngay_sinh;
    public $cccd;
    public $trang_thai_checkin = 'Chưa đến';
    public $phong_khach_san;
    public $ghi_chu;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Tạo một hồ sơ khách hàng cá nhân trong bảng tour_customers
     * Bằng cách lấy dữ liệu từ bảng customers. (Ví dụ: khách đại diện)
     * @param int $booking_id ID của Booking
     * @param int $customer_id ID của khách hàng trong bảng 'customers'
     * @return bool True nếu thành công, False nếu thất bại
     */
    public function createGuestEntry($booking_id, $customer_id) {
        // Đây là logic tạo hồ sơ khách hàng cá nhân.
        // Bạn cần viết truy vấn INSERT/SELECT để sao chép thông tin từ bảng customers sang tour_customers.
        // Ví dụ:
        $query = "INSERT INTO " . $this->table . " (booking_id, customer_id, ho_ten, gioi_tinh, ngay_sinh, cccd)
                  SELECT :booking_id, id, ho_ten, gioi_tinh, ngay_sinh, cmnd_cccd
                  FROM customers 
                  WHERE id = :customer_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":booking_id", $booking_id, PDO::PARAM_INT);
        $stmt->bindParam(":customer_id", $customer_id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Ghi lại lịch sử điểm danh mới (Log) vào bảng guest_attendance_logs.
     */
    public function logAttendance($tour_customer_id, $activity_name, $is_present, $notes = null, $user_id = 1) {
        $query = "INSERT INTO guest_attendance_logs 
                  SET tour_customer_id = :tc_id, 
                      attendance_time = NOW(), 
                      activity_name = :activity, 
                      is_present = :present, 
                      notes = :notes, 
                      user_id = :user_id";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":tc_id", $tour_customer_id, PDO::PARAM_INT);
        $stmt->bindParam(":activity", $activity_name);
        $stmt->bindParam(":present", $is_present, PDO::PARAM_INT);
        $stmt->bindParam(":notes", $notes);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Lấy danh sách khách hàng và lịch sử điểm danh gần nhất của từng khách.
     * Logic này sử dụng LEFT JOIN và truy vấn phụ để đảm bảo lấy đúng log mới nhất.
     */
public function getLatestAttendanceStatusByBookingId($booking_id) {
    
    // 1. Lấy danh sách khách hàng (tc.*) và thông tin liên hệ (c.dien_thoai, c.email)
    // *** ĐÃ SỬA LỖI KHOẢNG TRẮNG: FROM [table] tc LEFT JOIN... ***
    $query_guests = "SELECT tc.*, c.dien_thoai, c.email 
                     FROM " . $this->table . " tc 
                     LEFT JOIN customers c ON tc.customer_id = c.id
                     WHERE tc.booking_id = :booking_id 
                     ORDER BY tc.id ASC";
    
    $stmt_guests = $this->conn->prepare($query_guests);
    $stmt_guests->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
    $stmt_guests->execute();
    $guests_list = $stmt_guests->fetchAll(PDO::FETCH_ASSOC);

    // 2. Lặp qua từng khách để lấy log điểm danh mới nhất
    foreach ($guests_list as &$guest) {
        $query_log = "SELECT activity_name, is_present, notes, attendance_time 
                      FROM guest_attendance_logs 
                      WHERE tour_customer_id = :tour_customer_id 
                      ORDER BY attendance_time DESC LIMIT 1";
        
        $stmt_log = $this->conn->prepare($query_log);
        $stmt_log->bindParam(':tour_customer_id', $guest['id'], PDO::PARAM_INT);
        $stmt_log->execute();
        $latest_log = $stmt_log->fetch(PDO::FETCH_ASSOC);

        // Gán dữ liệu log vào mảng khách
        $guest['latest_log'] = $latest_log ?: null;
        $guest['current_status'] = $latest_log['is_present'] ?? null; 
    }
    
    return $guests_list;
}   
    /**
     * Lấy danh sách khách hàng cá nhân (Guest) thuộc một Booking (Phương thức cũ, không dùng cho điểm danh nhiều lần)
     */
    public function getGuestsByBookingId($booking_id) {
        $query = "SELECT tc.*, c.dien_thoai, c.email
                  FROM " . $this->table . " tc
                  LEFT JOIN customers c ON tc.customer_id = c.id
                  WHERE tc.booking_id = ? 
                  ORDER BY tc.id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $booking_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Phương thức cũ: Cập nhật trạng thái điểm danh của khách hàng cá nhân (Bỏ qua khi dùng Log)
     * Phương thức này không cần thiết nếu bạn chỉ dùng logAttendance.
     */
    public function updateAttendanceStatus($id, $status) {
        $query = "UPDATE " . $this->table . " SET trang_thai_checkin = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function getAttendanceHistoryByGuestId($tour_customer_id) {
    $query = "SELECT * FROM guest_attendance_logs
              WHERE tour_customer_id = :tc_id
              ORDER BY attendance_time DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':tc_id', $tour_customer_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getAllAttendanceLogsByBookingId($booking_id) {
    // Truy vấn LEFT JOIN để lấy tên khách hàng từ tour_customers
    $query = "SELECT gal.*, tc.ho_ten, tc.cccd 
              FROM guest_attendance_logs gal
              JOIN tour_customers tc ON gal.tour_customer_id = tc.id
              WHERE tc.booking_id = :booking_id
              ORDER BY gal.attendance_time DESC";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}