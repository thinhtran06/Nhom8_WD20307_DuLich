<?php
// controllers/BookingController.php

require_once 'models/Booking.php';
require_once 'models/Tour.php'; 
require_once 'models/Customer.php'; 
require_once 'models/BookingAttendance.php'; // <-- THÊM DÒNG NÀY

class BookingController {
    private $db;
    private $booking;
    private $tour;
    private $customer;
    private $bookingAttendance; // <-- THÊM THUỘC TÍNH NÀY

    public function __construct($conn) {
        $this->db = $conn;
        $this->booking = new Booking($this->db);
        $this->tour = new Tour($this->db);
        $this->customer = new Customer($this->db);
        $this->bookingAttendance = new BookingAttendance($this->db); // <-- KHỞI TẠO
    }

    // --- 1. HIỂN THỊ DANH SÁCH (READ - INDEX) ---
    public function index() {
        // ... (Giữ nguyên) ...
        $bookings = $this->booking->getAllBookingsWithDetails(); 
        $message = $_GET['message'] ?? ($_SESSION['success_message'] ?? null);
        unset($_SESSION['success_message']); 
        $page_title = "Quản Lý Đặt Tour";
        
        require_once 'views/booking/index.php';
    }
    
    // --- 2. TẠO MỚI (CREATE) ---
    public function create() {
        // ... (Giữ nguyên) ...
        $tours = $this->tour->getAll();
        $customers = $this->customer->getAll(); 
        $error_message = null;
        
        $success_message = $_SESSION['success_message'] ?? null;
        unset($_SESSION['success_message']); 

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // ... (Logic xử lý POST request) ...
            
            // 4. Thực thi tạo mới
            if ($this->booking->create()) {
                $_SESSION['success_message'] = "Tạo Booking thành công! (Mã: {$this->booking->ma_dat_tour})"; 
                header("Location: index.php?action=booking_create"); 
                exit();
            } else {
                $error_message = "Tạo Booking thất bại. Vui lòng kiểm tra lại dữ liệu.";
            }
        }

        $page_title = "Tạo Booking Mới";
        require_once 'views/booking/create.php';
    }

    // --- 3. CHỈNH SỬA (UPDATE - EDIT) ---
    public function edit($id) {
        // ... (Giữ nguyên) ...
        $this->booking->id = htmlspecialchars(strip_tags($id));
        $error_message = null; 
        
        $success_message = $_SESSION['success_message'] ?? null;
        unset($_SESSION['success_message']); 

        if (!$this->booking->getById()) {
            header("Location: index.php?action=booking_index&message=Booking không tồn tại!");
            exit();
        }
        
        $tours = $this->tour->getAll();
        $customers = $this->customer->getAll(); 
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // ... (Logic xử lý POST request) ...
            if ($this->booking->update()) {
                $_SESSION['success_message'] = "Cập nhật Booking ID $id thành công!";
                header("Location: index.php?action=booking_edit&id=$id"); 
                exit();
            } else {
                $error_message = "Cập nhật Booking thất bại. Vui lòng kiểm tra lại dữ liệu.";
            }
        }

        $booking = [
            'id' => $this->booking->id,
            // ... (Các trường booking khác) ...
            'ghi_chu' => $this->booking->ghi_chu ?? ''
        ]; 

        $page_title = "Chỉnh Sửa Booking ID: $id";
        require_once 'views/booking/edit.php';
    }

    // --- 4. XÓA (DELETE) ---
    public function delete($id) {
        // ... (Giữ nguyên) ...
        $this->booking->id = htmlspecialchars(strip_tags($id));

        if ($this->booking->delete()) {
            header("Location: index.php?action=booking_index&message=Xóa Booking ID $id thành công!");
            exit();
        } else {
            header("Location: index.php?action=booking_index&message=Xóa Booking ID $id thất bại!");
            exit();
        }
    }
    
    // --- 5. CẬP NHẬT TRẠNG THÁI TỪ INDEX ---
    public function updateStatus($id) {
        // ... (Giữ nguyên) ...
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['trang_thai'])) {
            $this->booking->id = htmlspecialchars(strip_tags($id));
            $new_status = htmlspecialchars(strip_tags($_POST['trang_thai']));

            if ($this->booking->getById()) {
                $this->booking->trang_thai = $new_status;
                
                if ($this->booking->update()) {
                    header("Location: index.php?action=booking_index&message=Cập nhật trạng thái Booking ID $id thành công!");
                    exit();
                } else {
                    header("Location: index.php?action=booking_index&message=Lỗi: Cập nhật trạng thái Booking ID $id thất bại!");
                    exit();
                }
            } else {
                header("Location: index.php?action=booking_index&message=Lỗi: Booking không tồn tại!");
                exit();
            }
        }
        header("Location: index.php?action=booking_index");
        exit();
    }

    // ----------------------------------------------------------------------
    // --- 6. CHỨC NĂNG ĐIỂM DANH THEO HOẠT ĐỘNG (Activity Attendance) ---
    // ----------------------------------------------------------------------
    public function checkAttendance($id) {
        $this->booking->id = htmlspecialchars(strip_tags($id));
        $error_message = null; 
        
        // 1. Lấy dữ liệu gốc của booking
        if (!$this->booking->getById()) {
            header("Location: index.php?action=booking_index&message=Booking không tồn tại!");
            exit();
        }
        
        $success_message = $_SESSION['success_message'] ?? null;
        unset($_SESSION['success_message']); 

        // 2. Xử lý POST request: Tạo log điểm danh mới
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ten_hoat_dong'])) {
            
            // Gán dữ liệu vào BookingAttendance Model
            $this->bookingAttendance->booking_id = $this->booking->id;
            $this->bookingAttendance->ngay_hoat_dong = htmlspecialchars(strip_tags($_POST['ngay_hoat_dong']));
            $this->bookingAttendance->ten_hoat_dong = htmlspecialchars(strip_tags($_POST['ten_hoat_dong']));
            $this->bookingAttendance->trang_thai_nhom = htmlspecialchars(strip_tags($_POST['trang_thai_nhom']));
            $this->bookingAttendance->chi_tiet = htmlspecialchars(strip_tags($_POST['chi_tiet'] ?? ''));
            
            // LƯU Ý: Thay thế bằng User ID của người đang đăng nhập (HDV)
            $this->bookingAttendance->nguoi_diem_danh_id = $_SESSION['user_id'] ?? 1; 

            if ($this->bookingAttendance->createLog()) {
                $_SESSION['success_message'] = "Điểm danh hoạt động thành công!";
                // Chuyển hướng về trang hiện tại
                header("Location: index.php?action=booking_attendance&id=$id"); 
                exit();
            } else {
                $error_message = "Lỗi: Không thể lưu log điểm danh. Vui lòng kiểm tra Database hoặc Model.";
            }
        }

        // 3. Chuẩn bị dữ liệu cho View
        $booking = [
            'id' => $this->booking->id,
            'ma_dat_tour' => $this->booking->ma_dat_tour ?? 'N/A',
            'so_nguoi_lon' => $this->booking->so_nguoi_lon,
            'so_tre_em' => $this->booking->so_tre_em,
            'tong_so_khach' => (int)$this->booking->so_nguoi_lon + (int)$this->booking->so_tre_em,
            'trang_thai_booking' => $this->booking->trang_thai
        ];
        
        // Lấy lịch sử điểm danh để hiển thị trong View
        $attendance_history = $this->bookingAttendance->getHistoryByBookingId($this->booking->id);

        $page_title = "Điểm Danh Hoạt Động - Mã: " . $booking['ma_dat_tour'];
        require_once 'views/booking/attendance.php';
    }
}