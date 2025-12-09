<?php
// controllers/BookingController.php

require_once 'models/Booking.php';
require_once 'models/Tour.php'; 
require_once 'models/Customer.php'; 
require_once 'models/TourCustomer.php'; 

class BookingController {
    private $db;
    private $booking;
    private $tour;
    private $customer;
    private $tourCustomer;

    public function __construct($conn) {
        $this->db = $conn;
        $this->booking = new Booking($this->db);
        $this->tour = new Tour($this->db);
        $this->customer = new Customer($this->db);
        $this->tourCustomer = new TourCustomer($this->db);
    }

    // --- 1. HIỂN THỊ DANH SÁCH (READ - INDEX) ---
    public function index() {
        $bookings = $this->booking->getAllBookingsWithDetails(); 
        $message = $_GET['message'] ?? ($_SESSION['success_message'] ?? ($_SESSION['error_message'] ?? null));
        unset($_SESSION['success_message']); 
        unset($_SESSION['error_message']); 
        $page_title = "Quản Lý Đặt Tour";
        
        require_once 'views/booking/index.php';
    }
    
    // --- 2. TẠO MỚI (CREATE) ---
    public function create() {
        // ... (Giữ nguyên logic tạo mới) ...
        $tours = $this->tour->getAll();
        $customers = $this->customer->getAll(); 
        $error_message = null;
        
        $success_message = $_SESSION['success_message'] ?? null;
        unset($_SESSION['success_message']); 

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // 1. Lấy và làm sạch dữ liệu
            $tour_id = htmlspecialchars(strip_tags($_POST['tour_id']));
            $customer_id = htmlspecialchars(strip_tags($_POST['customer_id'])); 
            $ngay_dat = htmlspecialchars(strip_tags($_POST['ngay_dat']));
            $so_nguoi_lon = (int)htmlspecialchars(strip_tags($_POST['so_nguoi_lon']));
            $so_tre_em = (int)htmlspecialchars(strip_tags($_POST['so_tre_em']));
            $loai_khach = htmlspecialchars(strip_tags($_POST['loai_khach']));
            $da_thanh_toan = (float)htmlspecialchars(strip_tags($_POST['da_thanh_toan'] ?? 0));
            $trang_thai = htmlspecialchars(strip_tags($_POST['trang_thai']));
            $ghi_chu = htmlspecialchars(strip_tags($_POST['ghi_chu'] ?? ''));

            // 2. Xử lý logic tính toán
            $gia_tour_don_vi = $this->tour->getPriceById($tour_id);
            $tong_tien = ($gia_tour_don_vi * $so_nguoi_lon) + ($gia_tour_don_vi * $so_tre_em * 0.5); 
            $con_lai = $tong_tien - $da_thanh_toan;
            $ma_dat_tour = 'BOOK_' . strtoupper(substr(md5(time()), 0, 5));
            $user_id = $_SESSION['user_id'] ?? 1;

            // 3. Gán dữ liệu vào Booking Model 
            $this->booking->tour_id = $tour_id;
            $this->booking->customer_id = $customer_id;
            $this->booking->ngay_dat = $ngay_dat;
            $this->booking->so_nguoi_lon = $so_nguoi_lon;
            $this->booking->so_tre_em = $so_tre_em;
            $this->booking->loai_khach = $loai_khach;
            $this->booking->trang_thai = $trang_thai;
            $this->booking->ghi_chu = $ghi_chu;
            $this->booking->ma_dat_tour = $ma_dat_tour; 
            $this->booking->user_id = $user_id; 
            $this->booking->tong_tien = $tong_tien; 
            $this->booking->da_thanh_toan = $da_thanh_toan;
            $this->booking->con_lai = $con_lai; 
            
            // 4. Thực thi tạo mới Booking
            if ($this->booking->create()) {
                
                $new_booking_id = $this->db->lastInsertId();
                
                // 5. TẠO DANH SÁCH KHÁCH HÀNG CÁ NHÂN (TOUR_CUSTOMERS)
                $total_guests = $so_nguoi_lon + $so_tre_em;
                $guest_created_count = 0;

                // 5.1. Thêm Khách Hàng Đại Diện
                if ($this->tourCustomer->createGuestEntry($new_booking_id, $customer_id)) {
                    $guest_created_count++;
                }
                
                // 5.2. Thêm các Khách Hàng Placeholder còn lại
                $remaining_guests = $total_guests - 1; 
                
                for ($i = 1; $i <= $remaining_guests; $i++) {
                    $placeholder_customer_id = $this->customer->createPlaceholderCustomer(
                        $new_booking_id, 
                        $loai_khach, 
                        $i
                    );
                    
                    if ($placeholder_customer_id) {
                        if ($this->tourCustomer->createGuestEntry($new_booking_id, $placeholder_customer_id)) {
                            $guest_created_count++;
                        }
                    }
                }
                
                $final_message = "Tạo Booking thành công! (Mã: {$ma_dat_tour}). Đã tạo $guest_created_count / $total_guests hồ sơ khách hàng cá nhân.";
                $_SESSION['success_message'] = $final_message; 
                header("Location: index.php?action=booking_create"); 
                exit();
                
            } else {
                $error_message = "Tạo Booking thất bại. Vui lòng kiểm tra lại dữ liệu và kết nối DB.";
            }
        }

        $page_title = "Tạo Booking Mới";
        if (!isset($tours) || !isset($customers)) {
            $tours = $this->tour->getAll();
            $customers = $this->customer->getAll(); 
        }
        require_once 'views/booking/create.php';
    }

    // --- 3. CHỈNH SỬA (UPDATE - EDIT) ---
    public function edit($id) {
        // ... (Giữ nguyên logic chỉnh sửa chi tiết) ...
        $this->booking->id = htmlspecialchars(strip_tags($id));
        $error_message = null; 
        
        $success_message = $_SESSION['success_message'] ?? null;
        unset($_SESSION['success_message']); 

        if (!$this->booking->getById()) {
            $_SESSION['error_message'] = "Booking không tồn tại!";
            header("Location: index.php?action=booking_index");
            exit();
        }
        
        $tours = $this->tour->getAll();
        $customers = $this->customer->getAll(); 
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // Logic Cập nhật Booking
            $this->booking->tour_id = htmlspecialchars(strip_tags($_POST['tour_id']));
            $this->booking->customer_id = htmlspecialchars(strip_tags($_POST['customer_id']));
            $this->booking->ngay_dat = htmlspecialchars(strip_tags($_POST['ngay_dat']));
            $this->booking->so_nguoi_lon = (int)htmlspecialchars(strip_tags($_POST['so_nguoi_lon']));
            $this->booking->so_tre_em = (int)htmlspecialchars(strip_tags($_POST['so_tre_em']));
            $this->booking->loai_khach = htmlspecialchars(strip_tags($_POST['loai_khach']));
            $da_thanh_toan = (float)htmlspecialchars(strip_tags($_POST['da_thanh_toan'] ?? 0));
            $this->booking->trang_thai = htmlspecialchars(strip_tags($_POST['trang_thai']));
            $this->booking->ghi_chu = htmlspecialchars(strip_tags($_POST['ghi_chu'] ?? ''));

            // Tính toán lại tổng tiền và còn lại
            $gia_tour_don_vi = $this->tour->getPriceById($this->booking->tour_id);
            $this->booking->tong_tien = ($gia_tour_don_vi * $this->booking->so_nguoi_lon) + ($gia_tour_don_vi * $this->booking->so_tre_em * 0.5); 
            $this->booking->da_thanh_toan = $da_thanh_toan;
            $this->booking->con_lai = $this->booking->tong_tien - $da_thanh_toan;


            if ($this->booking->update()) {
                $_SESSION['success_message'] = "Cập nhật Booking ID $id thành công!";
                header("Location: index.php?action=booking_edit&id=$id"); 
                exit();
            } else {
                $error_message = "Cập nhật Booking thất bại. Vui lòng kiểm tra lại dữ liệu.";
            }
        }

        // Lấy lại dữ liệu Booking sau khi update hoặc lần đầu vào edit
        $this->booking->getById();
        $booking = [
            'id' => $this->booking->id,
            'tour_id' => $this->booking->tour_id,
            'customer_id' => $this->booking->customer_id,
            'ngay_dat' => $this->booking->ngay_dat,
            'so_nguoi_lon' => $this->booking->so_nguoi_lon,
            'so_tre_em' => $this->booking->so_tre_em,
            'loai_khach' => $this->booking->loai_khach,
            'trang_thai' => $this->booking->trang_thai,
            'da_thanh_toan' => $this->booking->da_thanh_toan,
            'ghi_chu' => $this->booking->ghi_chu ?? ''
        ]; 

        $page_title = "Chỉnh Sửa Booking ID: $id";
        require_once 'views/booking/edit.php';
    }

    // --- 4. CẬP NHẬT TRẠNG THÁI NHANH (QUICK STATUS UPDATE) ---
    public function updateStatus($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['trang_thai'])) {
            $_SESSION['error_message'] = "Yêu cầu không hợp lệ.";
            header("Location: index.php?action=booking_index");
            exit();
        }
        
        $this->booking->id = htmlspecialchars(strip_tags($id));
        $new_status = htmlspecialchars(strip_tags($_POST['trang_thai']));
        
        // 1. Kiểm tra Booking có tồn tại không
        if (!$this->booking->getById()) {
            $_SESSION['error_message'] = "Booking ID $id không tồn tại.";
            header("Location: index.php?action=booking_index");
            exit();
        }

        // 2. Chỉ cập nhật trạng thái
        if ($this->booking->updateStatus($new_status)) {
            $_SESSION['success_message'] = "Cập nhật trạng thái Booking ID $id thành công! Trạng thái mới: **$new_status**";
        } else {
            $_SESSION['error_message'] = "Cập nhật trạng thái Booking ID $id thất bại.";
        }
        
        // 3. Quay lại trang danh sách
        header("Location: index.php?action=booking_index");
        exit();
    }
    
    // --- 5. XÓA (DELETE) ---
    public function delete($id) {
        $this->booking->id = htmlspecialchars(strip_tags($id));
        
        // 1. Kiểm tra tồn tại và lấy thông tin cần thiết
        if (!$this->booking->getById()) {
            $_SESSION['error_message'] = "Booking ID $id không tồn tại.";
            header("Location: index.php?action=booking_index");
            exit();
        }
        
        $ma_dat_tour = $this->booking->ma_dat_tour;

        // 2. Thực hiện xóa
        if ($this->booking->delete()) {
            $_SESSION['success_message'] = "Xóa Booking thành công! (ID: $id | Mã: {$ma_dat_tour})";
            header("Location: index.php?action=booking_index");
            exit();
        } else {
            $_SESSION['error_message'] = "Xóa Booking ID $id thất bại. Vui lòng kiểm tra lại.";
            header("Location: index.php?action=booking_index");
            exit();
        }
    }
    
    // --- 6. CHỨC NĂNG ĐIỂM DANH KHÁCH HÀNG CÁ NHÂN (Individual Attendance) ---
    public function checkAttendance($id) {
        // ... (Giữ nguyên logic điểm danh) ...
        $this->booking->id = htmlspecialchars(strip_tags($id));
        
        $attendance_history = $this->tourCustomer->getAllAttendanceLogsByBookingId($this->booking->id);
        $error_message = null; 
        
        if (!$this->booking->getById()) {
            header("Location: index.php?action=booking_index&message=Booking không tồn tại!");
            exit();
        }
        
        $success_message = $_SESSION['success_message'] ?? null;
        unset($_SESSION['success_message']); 

        // 2. Xử lý POST request: Ghi log điểm danh mới
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_attendance'])) {
            $updated_count = 0;
            $failed_count = 0;
            $user_id = $_SESSION['user_id'] ?? 1;
            
            $activity_name = htmlspecialchars(strip_tags($_POST['activity_name'] ?? 'Điểm danh chung')); 
            
            if (empty($activity_name)) {
                $error_message = "Tên hoạt động điểm danh không được để trống!";
            } else {
                foreach ($_POST as $key => $value) {
                    if (strpos($key, 'attendance_') === 0) {
                        $tour_customer_id = str_replace('attendance_', '', $key);
                        
                        $is_present = ($value === 'Đã đến' || $value === '1') ? 1 : 0; 
                        
                        $notes = htmlspecialchars(strip_tags($_POST['notes_' . $tour_customer_id] ?? null));
                        
                        if ($this->tourCustomer->logAttendance($tour_customer_id, $activity_name, $is_present, $notes, $user_id)) {
                            $updated_count++;
                        } else {
                            $failed_count++;
                        }
                    }
                }
                
                if ($updated_count > 0) {
                    $_SESSION['success_message'] = "Đã ghi log điểm danh mới cho $updated_count khách hàng! Hoạt động: **$activity_name**";
                }
                if ($failed_count > 0) {
                    $error_message = "Cảnh báo: Có $failed_count khách hàng ghi log thất bại.";
                }
            }
            
            header("Location: index.php?action=booking_attendance&id=$id"); 
            exit();
        }

        // 3. Chuẩn bị dữ liệu cho View
        $customer_data = $this->customer->getById($this->booking->customer_id);
        
        $this->booking->getById(); 
        
        $booking = [
            'id' => $this->booking->id,
            'customer_id' => $this->booking->customer_id, 
            'ma_dat_tour' => $this->booking->ma_dat_tour ?? 'N/A',
            'ngay_dat' => $this->booking->ngay_dat,
            'trang_thai_booking' => $this->booking->trang_thai,
            'ho_ten_dai_dien' => $customer_data['ho_ten'] ?? 'N/A', 
            'tong_so_khach_model' => (int)$this->booking->so_nguoi_lon + (int)$this->booking->so_tre_em
        ];
        
        $guests = $this->tourCustomer->getLatestAttendanceStatusByBookingId($this->booking->id);

        $page_title = "Điểm Danh Khách Hàng - Mã: " . $booking['ma_dat_tour'];
        require_once 'views/booking/attendance.php';
    }
}