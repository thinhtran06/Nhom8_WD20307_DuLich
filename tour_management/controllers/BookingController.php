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
   // controllers/BookingController.php

// ... (các phương thức khác giữ nguyên)

// --- 2. TẠO MỚI (CREATE) ---
public function create() {
    // 1. Chuẩn bị dữ liệu ban đầu
    $tours = $this->tour->getAll(); // Cần re-run để render form lại
    $customers = $this->customer->getAll(); // Cần re-run để render form lại
    $error_message = null;
    
    $success_message = $_SESSION['success_message'] ?? null;
    unset($_SESSION['success_message']); 

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        // --- 1. Lấy và làm sạch dữ liệu ---
        $tour_id = htmlspecialchars(strip_tags($_POST['tour_id']));
        $customer_id = htmlspecialchars(strip_tags($_POST['customer_id']));
        $ngay_dat = htmlspecialchars(strip_tags($_POST['ngay_dat']));
        $so_nguoi_lon = htmlspecialchars(strip_tags($_POST['so_nguoi_lon']));
        $so_tre_em = htmlspecialchars(strip_tags($_POST['so_tre_em']));
        $loai_khach = htmlspecialchars(strip_tags($_POST['loai_khach']));
        $da_thanh_toan = htmlspecialchars(strip_tags($_POST['da_thanh_toan'] ?? 0));
        $trang_thai = htmlspecialchars(strip_tags($_POST['trang_thai']));
        $ghi_chu = htmlspecialchars(strip_tags($_POST['ghi_chu'] ?? ''));

        // --- 2. Xử lý logic tính toán và gán giá trị NOT NULL bắt buộc ---
        
        // Lấy giá tour (từ Tour Model)
        $gia_tour_don_vi = $this->tour->getPriceById($tour_id);
        
        // Tính tổng tiền: (Giá tour * Người lớn) + (Giá tour * Trẻ em * 0.5) 
        // Giả định trẻ em tính 50% giá người lớn
        $tong_tien = ($gia_tour_don_vi * $so_nguoi_lon) + ($gia_tour_don_vi * $so_tre_em * 0.5);
        
        // Tính tiền còn lại
        $con_lai = $tong_tien - $da_thanh_toan;
        
        // Tạo Mã Đặt Tour (Ví dụ đơn giản, bạn nên dùng hàm tạo mã phức tạp hơn)
        $ma_dat_tour = 'BOOK_' . strtoupper(substr(md5(time()), 0, 5));
        
        // User ID của người đang tạo booking (Người dùng đang đăng nhập)
        $user_id = $_SESSION['user_id'] ?? 1; // Mặc định là 1 nếu chưa đăng nhập

        // --- 3. Gán dữ liệu vào Booking Model ---
        $this->booking->tour_id = $tour_id;
        $this->booking->customer_id = $customer_id;
        $this->booking->ngay_dat = $ngay_dat;
        $this->booking->so_nguoi_lon = $so_nguoi_lon;
        $this->booking->so_tre_em = $so_tre_em;
        $this->booking->loai_khach = $loai_khach;
        $this->booking->trang_thai = $trang_thai;
        $this->booking->ghi_chu = $ghi_chu;
        
        // Gán các trường NOT NULL đã tính toán
        $this->booking->ma_dat_tour = $ma_dat_tour; // **MỚI**
        $this->booking->user_id = $user_id;         // **MỚI**
        $this->booking->tong_tien = $tong_tien;     // **MỚI**
        $this->booking->da_thanh_toan = $da_thanh_toan;
        $this->booking->con_lai = $con_lai;         // **MỚI**
        
        // --- 4. Thực thi tạo mới (Dòng gây lỗi 1048 lúc trước) ---
        if ($this->booking->create()) {
            $_SESSION['success_message'] = "Tạo Booking thành công! (Mã: {$ma_dat_tour})"; 
            header("Location: index.php?action=booking_create"); 
            exit();
        } else {
            $error_message = "Tạo Booking thất bại. Vui lòng kiểm tra lại dữ liệu.";
        }
    }

    $page_title = "Tạo Booking Mới";
    require_once 'views/booking/create.php';
}

// ... (các phương thức khác giữ nguyên)
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