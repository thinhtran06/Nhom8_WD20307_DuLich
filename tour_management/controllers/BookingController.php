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
        $error_message = null;
        $success_message = $_SESSION['success_message'] ?? null;
        unset($_SESSION['success_message']); 
        
        // Tải lại dữ liệu cần thiết cho form (luôn chạy)
        $tours = $this->tour->getAll();
        $customers = $this->customer->getAll(); 

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // Lấy dữ liệu từ POST
            $data = $_POST;

            // Xử lý Transaction (đảm bảo atomic)
            $this->db->beginTransaction(); 
            try {
                $customer_id = null;
                
                // 1. XỬ LÝ KHÁCH HÀNG ĐẠI DIỆN (Cũ HOẶC Mới)
                
                $ho_ten_khach = trim($data['ho_ten_khach'] ?? '');
                $dien_thoai_khach = trim($data['dien_thoai_khach'] ?? '');
                $cccd_khach = trim($data['cccd_khach'] ?? '');
                
                if (!empty($data['customer_id'])) {
                    // TRƯỜNG HỢP 1: Khách hàng CŨ đã được chọn
                    $customer_id = (int)htmlspecialchars(strip_tags($data['customer_id']));
                    
                } elseif (!empty($ho_ten_khach) && !empty($dien_thoai_khach) && !empty($cccd_khach)) {
                    // TRƯỜNG HỢP 2: Khách hàng MỚI được nhập
                    
                    // Tạo khách hàng mới trong Customer Model
                    $new_customer_data = [
                        'ho_ten'     => htmlspecialchars(strip_tags($ho_ten_khach)),
                        'dien_thoai' => htmlspecialchars(strip_tags($dien_thoai_khach)),
                        'cmnd_cccd'  => htmlspecialchars(strip_tags($cccd_khach)),
                        // Có thể thêm các trường khác như 'email' nếu có trong form
                    ];
                    
                    $customer_id = $this->customer->createCustomer($new_customer_data); // Giả định hàm này trả về ID mới
    
                    if (!$customer_id) {
                        throw new Exception("Không thể tạo hồ sơ khách hàng mới.");
                    }
    
                } else {
                    // TRƯỜNG HỢP 3: Lỗi - Không chọn khách cũ và cũng không nhập đủ khách mới
                    throw new Exception("Vui lòng chọn Khách hàng đã tồn tại HOẶC nhập đầy đủ Họ Tên, CMND/CCCD và Điện Thoại khách hàng mới.");
                }

                // 2. TÍNH TOÁN VÀ CHUẨN BỊ DỮ LIỆU BOOKING
                
                $tour_id = htmlspecialchars(strip_tags($data['tour_id']));
                $ngay_dat = htmlspecialchars(strip_tags($data['ngay_khoi_hanh'])); // LƯU Ý: Đổi tên key để khớp với View đã sửa
                $so_nguoi_lon = (int)htmlspecialchars(strip_tags($data['so_nguoi_lon']));
                $so_tre_em = (int)htmlspecialchars(strip_tags($data['so_tre_em']));
                $loai_khach = htmlspecialchars(strip_tags($data['loai_khach']));
                $da_thanh_toan = (float)htmlspecialchars(strip_tags($data['da_thanh_toan'] ?? 0));
                $trang_thai = htmlspecialchars(strip_tags($data['trang_thai']));
                $ghi_chu = htmlspecialchars(strip_tags($data['ghi_chu'] ?? ''));

                if (empty($ngay_dat) || $so_nguoi_lon <= 0) {
                     throw new Exception("Ngày khởi hành hoặc Số người lớn không hợp lệ.");
                }
                
                $gia_tour_don_vi = $this->tour->getPriceById($tour_id); // Giả định hàm này hoạt động
                $tong_tien = ($gia_tour_don_vi * $so_nguoi_lon) + ($gia_tour_don_vi * $so_tre_em * 0.5); 
                $con_lai = $tong_tien - $da_thanh_toan;
                $ma_dat_tour = 'BOOK_' . strtoupper(substr(md5(time()), 0, 5));
                $user_id = $_SESSION['user_id'] ?? 1;

                // 3. Gán dữ liệu vào Booking Model và TẠO BOOKING
                
                $this->booking->tour_id = $tour_id;
                $this->booking->customer_id = $customer_id; // ID Khách hàng Đại diện (Cũ hoặc Mới)
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
                
                $new_booking_id = $this->booking->create(); // Giả định hàm create() trả về ID mới
                
                if (!$new_booking_id) {
                    throw new Exception("Tạo Booking thất bại khi gọi Model.");
                }
                
                // 4. TẠO DANH SÁCH KHÁCH HÀNG CÁ NHÂN (TOUR_CUSTOMERS)
                
                $total_guests = $so_nguoi_lon + $so_tre_em;
                $guest_created_count = 0;

                // 4.1. Thêm Khách Hàng Đại Diện vào danh sách khách lẻ
                if ($this->tourCustomer->createGuestEntry($new_booking_id, $customer_id)) {
                    $guest_created_count++;
                }
                
                // 4.2. Thêm các Khách Hàng Placeholder còn lại
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
                
                // Hoàn tất Transaction
                $this->db->commit();
                
                // 5. Chuyển hướng thành công
                $final_message = "Tạo Booking thành công! (Mã: **{$ma_dat_tour}**). Đã tạo $guest_created_count / $total_guests hồ sơ khách hàng cá nhân.";
                $_SESSION['success_message'] = $final_message; 
                header("Location: index.php?action=booking_create"); 
                exit();
                
            } catch (Exception $e) {
                // Xử lý lỗi (Rollback Transaction)
                $this->db->rollBack();
                $error_message = "Lỗi hệ thống khi tạo Booking: " . $e->getMessage();
            }
        }

        $page_title = "Tạo Booking Mới";
        require_once 'views/booking/create.php';
    }

    // --- 3. CHỈNH SỬA (UPDATE - EDIT) ---
    public function edit($id) {
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
        $this->booking->id = htmlspecialchars(strip_tags($id));
        
        // Tải lịch sử điểm danh (Giả định hàm này tồn tại)
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
            
            $this->db->beginTransaction(); // Bắt đầu Transaction cho việc ghi log
            try {
                if (empty($activity_name)) {
                    throw new Exception("Tên hoạt động điểm danh không được để trống!");
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
                    
                    if ($failed_count > 0) {
                         throw new Exception("Cảnh báo: Có $failed_count khách hàng ghi log thất bại.");
                    }
                }
                $this->db->commit();
                
                if ($updated_count > 0) {
                    $_SESSION['success_message'] = "Đã ghi log điểm danh mới cho $updated_count khách hàng! Hoạt động: **$activity_name**";
                }
                
            } catch (Exception $e) {
                $this->db->rollBack();
                $error_message = $e->getMessage();
                $_SESSION['error_message'] = $error_message;
            }
            
            header("Location: index.php?action=booking_attendance&id=$id"); 
            exit();
        }
        

        // 3. Chuẩn bị dữ liệu cho View (GET request)
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
        
        // Lấy trạng thái điểm danh mới nhất của từng khách lẻ (Giả định hàm này tồn tại)
        $guests = $this->tourCustomer->getLatestAttendanceStatusByBookingId($this->booking->id);

        $page_title = "Điểm Danh Khách Hàng - Mã: " . $booking['ma_dat_tour'];
        require_once 'views/booking/attendance.php';
    }
    public function show($id) {
    // 1. Lấy thông tin chi tiết Booking (kèm theo Tên Tour và Tên Khách Hàng)
    // Giả định Model Booking của bạn có hàm getDetailsById($id)
    $bookingData = $this->booking->getDetailsById($id); 

    if (!$bookingData) {
        $_SESSION['error_message'] = "Không tìm thấy thông tin đặt chỗ!";
        header("Location: index.php?action=booking_index");
        exit();
    }

    $page_title = "Chi Tiết Đặt Chỗ: " . $bookingData['ma_dat_tour'];
    
    // Gán vào biến $booking để sử dụng trong View bạn vừa viết
    $booking = $bookingData;

    require_once 'views/booking/show.php';
}
public function attendance($id) {
    // 1. Lấy dữ liệu đơn hàng từ Model
    $booking = $this->booking->getDetailsById($id);

    // 2. Kiểm tra điều kiện trạng thái
    if (!$booking || $booking['trang_thai'] !== 'Đã xác nhận') {
        // Nếu không phải 'Đã xác nhận', thông báo lỗi và đẩy về trang danh sách
        $_SESSION['error_message'] = "Chỉ những đơn hàng 'Đã xác nhận' mới có thể thực hiện điểm danh!";
        header("Location: index.php?action=booking_index");
        exit();
    }

    // 3. Nếu thỏa mãn, tiếp tục load trang điểm danh như bình thường
    require_once 'views/booking/attendance.php';
}
// controllers/BookingController.php

public function statistics() {
    // 1. Gọi hàm lấy dữ liệu từ Model (đã viết ở bước trước)
    $stats = $this->booking->getStatistics();
    
    // 2. Kiểm tra nếu không có dữ liệu thì gán mặc định để tránh lỗi View
    if (!$stats) {
        $stats = [
            'total_bookings' => 0,
            'total_revenue' => 0,
            'actual_received' => 0,
            'canceled_count' => 0,
            'completed_count' => 0
        ];
    }

    // 3. Load file giao diện thống kê
    include 'views/booking/statistics.php';
}
}