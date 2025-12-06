<?php
// controllers/AttendanceController.php (ĐÃ SỬA LỖI LOGIC DỮ LIỆU)
require_once 'models/Tour.php';
require_once 'models/Booking.php'; 
require_once 'models/Attendance.php'; 

class AttendanceController {
    private $db;
    private $tour;
    private $booking;
    private $attendance; 

    public function __construct($conn) {
        $this->db = $conn;
        $this->tour = new Tour($this->db);
        $this->booking = new Booking($this->db); 
        $this->attendance = new Attendance($this->db); 
    }

    // 1. HIỂN THỊ DANH SÁCH CHUYẾN ĐI (BOOKING) ĐỂ CHỌN ĐIỂM DANH
    public function index() {
        // Lấy danh sách các Booking đã xác nhận, chưa hoàn thành để làm Tour Run
        $stmt = $this->booking->getDistinctTourRuns(); 
        $tour_runs = $stmt->fetchAll(PDO::FETCH_ASSOC); // Đổi tên biến để phản ánh là danh sách chuyến đi

        $page_title = "Chọn Chuyến Đi (Booking) Để Điểm Danh";
        // Trong views/attendance/index.php, bạn sẽ sử dụng biến $tour_runs
        require_once 'views/attendance/index.php';
    }
    
    // 2. HIỂN THỊ CHI TIẾT CHUYẾN ĐI VÀ LINK ĐIỂM DANH THEO NGÀY
    public function listBookings() {
        $booking_id = $_GET['id'] ?? null;
        if (!$booking_id) {
            header("Location: index.php?action=attendance_index&message=Vui lòng chọn chuyến đi hợp lệ!");
            exit();
        }

        // Lấy thông tin Tour Run (Booking)
        $tour = $this->booking->getTourInfoByBookingId($booking_id);
        
        if (!$tour) {
            header("Location: index.php?action=attendance_index&message=Không tìm thấy thông tin chuyến đi!");
            exit();
        }

        // Lấy danh sách khách hàng (chính là Booking này)
        $bookings = $this->booking->getBookingsForAttendance($booking_id); 
        
        $page_title = "Chi tiết Chuyến đi: " . $tour['ten_tour'];
        require_once 'views/attendance/list_bookings.php'; // Sẽ sử dụng $tour và $bookings
    }
    
    // 3. XỬ LÝ ĐIỂM DANH THEO LỊCH TRÌNH
    public function checkAttendance() {
        $booking_id = $_GET['id'] ?? null;
        $day = $_GET['day'] ?? null;

        if (!$booking_id || !$day) {
            header("Location: index.php?action=attendance_index&message=Thiếu thông tin chuyến đi hoặc Ngày!");
            exit();
        }
        
        // Lấy thông tin Tour Run (Booking)
        $tour = $this->booking->getTourInfoByBookingId($booking_id);
        
        if(!$tour) {
            header("Location: index.php?action=attendance_index&message=Chuyến đi không tồn tại!");
            exit();
        }

        // Lấy danh sách Booking (tên người đại diện) cho Tour Run này (PDOStatement)
        $bookings_stmt = $this->booking->getBookingsForAttendance($booking_id); 
        
        // --- XỬ LÝ LƯU ĐIỂM DANH (POST) ---
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $attendance_data = $_POST['diem_danh'] ?? []; 
            $success_count = 0;

            foreach ($attendance_data as $booking_id_for_save => $status) {
                $status = ($status === 'Có mặt') ? 'Có mặt' : 'Vắng mặt';
                
                // $booking_id_for_save ở đây chính là $booking_id (vì ta điểm danh theo đơn vị booking)
                if ($this->attendance->saveAttendance($tour['tour_id'], $booking_id, $day, $status)) {
                    $success_count++;
                }
            }
            
            header("Location: index.php?action=attendance_check&id=$booking_id&day=$day&message=Đã điểm danh $success_count khách hàng cho Ngày $day thành công!");
            exit();
        }
        
        // --- HIỂN THỊ FORM ĐIỂM DANH (GET) ---
        
        $current_attendance = $this->attendance->getAttendanceStatus($tour['tour_id'], $day);

        $page_title = "Điểm danh Khách Hàng Chuyến đi " . $tour['ten_tour'] . " - Ngày " . $day;
        require_once 'views/attendance/check_form.php';
    }
}
?>