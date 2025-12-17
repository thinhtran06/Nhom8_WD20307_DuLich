<?php
// controllers/BookingController.php

require_once 'models/Booking.php';
require_once 'models/Tour.php'; 
require_once 'models/Customer.php'; 
require_once 'models/TourCustomer.php'; 
require_once 'models/Guide.php'; 

class BookingController {
    private $db;
    private $booking;
    private $tour;
    private $customer;
    private $tourCustomer;
    private $guide;

    public function __construct($conn) {
        $this->db = $conn;
        $this->booking = new Booking($this->db);
        $this->tour = new Tour($this->db);
        $this->customer = new Customer($this->db);
        $this->tourCustomer = new TourCustomer($this->db);
        $this->guide = new Guide($this->db);
    }

    // Helper: sanitize input
    private function sanitizeInput($key, $default = null) {
        return isset($_POST[$key]) ? htmlspecialchars(strip_tags($_POST[$key])) : $default;
    }

    // --- 1. HIỂN THỊ DANH SÁCH (INDEX) ---
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
        
        $tours = $this->tour->getAll();
        $customers = $this->customer->getAll();
        $guides = $this->guide->getAll(); 

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->db->beginTransaction(); 
            try {
                $customer_id = null;
                $ho_ten_khach = $this->sanitizeInput('ho_ten_khach', '');
                $dien_thoai_khach = $this->sanitizeInput('dien_thoai_khach', '');
                $cccd_khach = $this->sanitizeInput('cccd_khach', '');

                if (!empty($_POST['customer_id'])) {
                    $customer_id = (int)$this->sanitizeInput('customer_id');
                } elseif (!empty($ho_ten_khach) && !empty($dien_thoai_khach) && !empty($cccd_khach)) {
                    $new_customer_data = [
                        'ho_ten'     => $ho_ten_khach,
                        'dien_thoai' => $dien_thoai_khach,
                        'cmnd_cccd'  => $cccd_khach,
                    ];
                    $customer_id = $this->customer->createCustomer($new_customer_data);
                    if (!$customer_id) throw new Exception("Không thể tạo hồ sơ khách hàng mới.");
                } else {
                    throw new Exception("Vui lòng chọn khách cũ HOẶC nhập đầy đủ thông tin khách mới.");
                }

                $tour_id = $this->sanitizeInput('tour_id');
                $ngay_dat = $this->sanitizeInput('ngay_khoi_hanh');
                $so_nguoi_lon = (int)$this->sanitizeInput('so_nguoi_lon', 0);
                $so_tre_em = (int)$this->sanitizeInput('so_tre_em', 0);
                $loai_khach = $this->sanitizeInput('loai_khach', '');
                $guide_id = !empty($_POST['guide_id']) ? (int)$this->sanitizeInput('guide_id') : null;
                $da_thanh_toan = (float)$this->sanitizeInput('da_thanh_toan', 0);
                $trang_thai = $this->sanitizeInput('trang_thai', '');
                $ghi_chu = $this->sanitizeInput('ghi_chu', '');

                if (empty($ngay_dat) || $so_nguoi_lon <= 0) {
                    throw new Exception("Ngày khởi hành hoặc số người lớn không hợp lệ.");
                }

                $gia_tour_don_vi = $this->tour->getPriceById($tour_id);
                $tong_tien = ($gia_tour_don_vi * $so_nguoi_lon) + ($gia_tour_don_vi * $so_tre_em * 0.5);
                $con_lai = $tong_tien - $da_thanh_toan;
                $ma_dat_tour = 'BOOK_' . strtoupper(substr(md5(time()), 0, 5));
                $user_id = $_SESSION['user_id'] ?? 1;

                // Tạo Booking
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
                $this->booking->guide_id = $guide_id;

                $new_booking_id = $this->booking->create();
                if (!$new_booking_id) throw new Exception("Tạo Booking thất bại.");

                // Tạo khách lẻ (TourCustomer)
                $total_guests = $so_nguoi_lon + $so_tre_em;
                $guest_created_count = 0;

                // Thêm khách đại diện
                if ($this->tourCustomer->createGuestEntry($new_booking_id, $customer_id)) {
                    $guest_created_count++;
                }

                // Thêm placeholder
                $remaining_guests = $total_guests - 1;
                for ($i = 1; $i <= $remaining_guests; $i++) {
                    $placeholder_customer_id = $this->customer->createPlaceholderCustomer($new_booking_id, $loai_khach, $i);
                    if ($placeholder_customer_id) {
                        if ($this->tourCustomer->createGuestEntry($new_booking_id, $placeholder_customer_id)) {
                            $guest_created_count++;
                        } else {
                            throw new Exception("Tạo khách placeholder thất bại.");
                        }
                    }
                }

                $this->db->commit();
                $_SESSION['success_message'] = "Tạo Booking thành công! (Mã: $ma_dat_tour). Đã tạo $guest_created_count / $total_guests hồ sơ khách.";
                header("Location: index.php?action=booking_create");
                exit();

            } catch (Exception $e) {
                $this->db->rollBack();
                $error_message = "Lỗi: " . $e->getMessage();
            }
        }

        $page_title = "Tạo Booking Mới";
        require_once 'views/booking/create.php';
    }

    // --- 3. EDIT ---
    public function edit($id) {
    $error_message = null;
    $success_message = $_SESSION['success_message'] ?? null;
    unset($_SESSION['success_message']);

    // Lấy booking theo ID
    $bookingData = $this->booking->getById($id);
    if (!$bookingData) {
        $_SESSION['error_message'] = "Booking không tồn tại!";
        header("Location: index.php?action=booking_index");
        exit();
    }

    // Load dữ liệu cho form
    $tours = $this->tour->getAll();
    $customers = $this->customer->getAll();
    $guides = $this->guide->getAll();

    // Nếu submit form
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $this->booking->tour_id = $this->sanitizeInput('tour_id');
        $this->booking->guide_id = $this->sanitizeInput('guide_id');
        $this->booking->customer_id = $this->sanitizeInput('customer_id');
        $this->booking->ngay_dat = $this->sanitizeInput('ngay_dat');
        $this->booking->so_nguoi_lon = (int)$this->sanitizeInput('so_nguoi_lon', 0);
        $this->booking->so_tre_em = (int)$this->sanitizeInput('so_tre_em', 0);
        $this->booking->loai_khach = $this->sanitizeInput('loai_khach');
        $da_thanh_toan = (float)$this->sanitizeInput('da_thanh_toan', 0);
        $this->booking->trang_thai = $this->sanitizeInput('trang_thai');
        $this->booking->ghi_chu = $this->sanitizeInput('ghi_chu', '');

        $gia_tour_don_vi = $this->tour->getPriceById($this->booking->tour_id);
        $this->booking->tong_tien = ($gia_tour_don_vi * $this->booking->so_nguoi_lon)
                                  + ($gia_tour_don_vi * $this->booking->so_tre_em * 0.5);

        $this->booking->da_thanh_toan = $da_thanh_toan;
        $this->booking->con_lai = $this->booking->tong_tien - $da_thanh_toan;

        if ($this->booking->update($id)) {
            $_SESSION['success_message'] = "Cập nhật Booking ID $id thành công!";
            header("Location: index.php?action=booking_edit&id=$id");
            exit();
        } else {
            $error_message = "Cập nhật thất bại.";
        }
    }

    // Dữ liệu đưa sang view
    $booking = $bookingData;

    $page_title = "Chỉnh Sửa Booking ID: $id";
    require_once 'views/booking/edit.php';
}

    // --- 4. QUICK STATUS UPDATE ---
    public function updateStatus($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['trang_thai'])) {
            $_SESSION['error_message'] = "Yêu cầu không hợp lệ.";
            header("Location: index.php?action=booking_index");
            exit();
        }

        $this->booking->id = htmlspecialchars(strip_tags($id));
        $new_status = htmlspecialchars(strip_tags($_POST['trang_thai']));

        if (!$this->booking->getById()) {
            $_SESSION['error_message'] = "Booking ID $id không tồn tại.";
            header("Location: index.php?action=booking_index");
            exit();
        }

        if ($this->booking->updateStatus($new_status)) {
            $_SESSION['success_message'] = "Cập nhật trạng thái Booking ID $id thành công! Trạng thái mới: $new_status";
        } else {
            $_SESSION['error_message'] = "Cập nhật trạng thái thất bại.";
        }

        header("Location: index.php?action=booking_index");
        exit();
    }

    // --- 5. DELETE ---
    public function delete($id) {
        $this->booking->id = htmlspecialchars(strip_tags($id));

        if (!$this->booking->getById()) {
            $_SESSION['error_message'] = "Booking ID $id không tồn tại.";
            header("Location: index.php?action=booking_index");
            exit();
        }

        $ma_dat_tour = $this->booking->ma_dat_tour;

        if ($this->booking->delete()) {
            $_SESSION['success_message'] = "Xóa Booking thành công! (ID: $id | Mã: $ma_dat_tour)";
        } else {
            $_SESSION['error_message'] = "Xóa Booking thất bại.";
        }

        header("Location: index.php?action=booking_index");
        exit();
    }

    // --- 6. CHECK ATTENDANCE ---
    public function checkAttendance($id) {

    // Lấy booking theo ID
    $booking = $this->booking->getById($id);

    // Kiểm tra booking tồn tại
    if (!$booking) {
        header("Location: index.php?action=booking_index&message=Booking không tồn tại!");
        exit();
    }

    // Lịch sử điểm danh
    $attendance_history = $this->tourCustomer->getAllAttendanceLogsByBookingId($booking['id']);

    $error_message = null;
    $success_message = $_SESSION['success_message'] ?? null;
    unset($_SESSION['success_message']);

    // Xử lý POST cập nhật điểm danh
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_attendance'])) {

        $updated_count = 0;
        $failed_count = 0;
        $user_id = $_SESSION['user_id'] ?? 1;
        $activity_name = $this->sanitizeInput('activity_name', 'Điểm danh chung');

        $this->db->beginTransaction();

        try {
            if (empty($activity_name)) {
                throw new Exception("Tên hoạt động không được để trống.");
            }

            foreach ($_POST as $key => $value) {
                if (strpos($key, 'attendance_') === 0) {

                    $tour_customer_id = str_replace('attendance_', '', $key);
                    $is_present = ($value === 'Đã đến' || $value === '1') ? 1 : 0;
                    $notes = $this->sanitizeInput('notes_' . $tour_customer_id, null);

                    if ($this->tourCustomer->logAttendance($tour_customer_id, $activity_name, $is_present, $notes, $user_id)) {
                        $updated_count++;
                    } else {
                        $failed_count++;
                    }
                }
            }

            if ($failed_count > 0) {
                throw new Exception("Có $failed_count khách hàng ghi log thất bại.");
            }

            $this->db->commit();

            if ($updated_count > 0) {
                $_SESSION['success_message'] = "Đã ghi log cho $updated_count khách hàng! Hoạt động: $activity_name";
            }

        } catch (Exception $e) {
            $this->db->rollBack();
            $_SESSION['error_message'] = $e->getMessage();
        }

        header("Location: index.php?action=booking_attendance&id=$id");
        exit();
    }

    // Lấy thông tin khách đại diện
    $customer_data = $this->customer->getById($booking['customer_id']);

    // Chuẩn bị dữ liệu cho view
    $booking = [
        'id' => $booking['id'],
        'customer_id' => $booking['customer_id'],
        'ma_dat_tour' => $booking['ma_dat_tour'] ?? 'N/A',
        'ngay_dat' => $booking['ngay_dat'],
        'trang_thai_booking' => $booking['trang_thai'],
        'ho_ten_dai_dien' => $customer_data['ho_ten'] ?? 'N/A',
        'tong_so_khach_model' => (int)$booking['so_nguoi_lon'] + (int)$booking['so_tre_em']
    ];

    // Lấy danh sách khách + trạng thái điểm danh mới nhất
    $guests = $this->tourCustomer->getLatestAttendanceStatusByBookingId($booking['id']);

    $page_title = "Điểm Danh Khách Hàng - Mã: " . $booking['ma_dat_tour'];
    require_once 'views/booking/attendance.php';
}
}
