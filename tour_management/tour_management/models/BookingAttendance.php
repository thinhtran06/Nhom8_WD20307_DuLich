<?php
// models/BookingAttendance.php

class BookingAttendance {
    private $conn;
    private $table_name = "booking_activity_attendance";

    // Thuộc tính
    public $id;
    public $booking_id;
    public $ngay_hoat_dong;
    public $ten_hoat_dong;
    public $trang_thai_nhom;
    public $chi_tiet;
    public $nguoi_diem_danh_id;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Tạo một bản ghi điểm danh hoạt động mới.
     * @return bool
     */
    public function createLog() {
        $query = "INSERT INTO " . $this->table_name . "
                  SET booking_id = :booking_id, ngay_hoat_dong = :ngay_hoat_dong, 
                      ten_hoat_dong = :ten_hoat_dong, trang_thai_nhom = :trang_thai_nhom, 
                      chi_tiet = :chi_tiet, nguoi_diem_danh_id = :nguoi_diem_danh_id";

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $this->booking_id = htmlspecialchars(strip_tags($this->booking_id));
        $this->ngay_hoat_dong = htmlspecialchars(strip_tags($this->ngay_hoat_dong));
        $this->ten_hoat_dong = htmlspecialchars(strip_tags($this->ten_hoat_dong));
        $this->trang_thai_nhom = htmlspecialchars(strip_tags($this->trang_thai_nhom));
        $this->chi_tiet = htmlspecialchars(strip_tags($this->chi_tiet));
        // Đảm bảo nguoi_diem_danh_id là số hoặc NULL
        $this->nguoi_diem_danh_id = filter_var($this->nguoi_diem_danh_id, FILTER_VALIDATE_INT) ? $this->nguoi_diem_danh_id : null;


        // Binding parameters
        $stmt->bindParam(':booking_id', $this->booking_id);
        $stmt->bindParam(':ngay_hoat_dong', $this->ngay_hoat_dong);
        $stmt->bindParam(':ten_hoat_dong', $this->ten_hoat_dong);
        $stmt->bindParam(':trang_thai_nhom', $this->trang_thai_nhom);
        $stmt->bindParam(':chi_tiet', $this->chi_tiet);
        $stmt->bindParam(':nguoi_diem_danh_id', $this->nguoi_diem_danh_id);


        if ($stmt->execute()) {
            return true;
        }

        // Nếu cần debug: 
        // printf("Error: %s.\n", $stmt->error);
        return false;
    }
    
    /**
     * Lấy lịch sử điểm danh của một Booking
     * @param int $booking_id
     * @return array
     */
    public function getHistoryByBookingId($booking_id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE booking_id = ? 
                  ORDER BY ngay_hoat_dong DESC, created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $booking_id);
        $stmt->execute();

        // Trả về mảng các bản ghi
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>