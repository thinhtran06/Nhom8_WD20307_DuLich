<?php
// controllers/BookingController.php

class BookingController {
    private $conn;
    private $bookingModel;
    private $tourModel; 

    public function __construct($db) {
        $this->conn = $db;
        $this->bookingModel = new Booking($this->conn);
        $this->tourModel = new Tour($this->conn); 
    }

    public function index() {
        $bookings = $this->bookingModel->getAll();
        include 'views/bookings/index.php';
    }

    public function create() {
        $tours = $this->tourModel->getAll(); 
        include 'views/bookings/create.php';
    }

    // XỬ LÝ LƯU
    public function store() {
        // Đảm bảo Customer Model được include (nếu chưa include ở index.php)
        if (!class_exists('Customer')) { include 'models/Customer.php'; }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $customer_id = null;
            
            // --- BƯỚC 1: XỬ LÝ KHÁCH HÀNG ---
            $customerModel = new Customer($this->conn);
            
            $ten_khach = trim($data['customer_name'] ?? '');
            $sdt_khach = trim($data['customer_phone'] ?? '');

            if (empty($ten_khach)) {
                header('Location: index.php?action=booking_create&error=Vui lòng nhập tên khách hàng');
                exit;
            }

            // Tìm hoặc Tạo khách hàng
            if (!empty($sdt_khach)) {
                $khach_cu = $customerModel->findByPhone($sdt_khach);
                if ($khach_cu) {
                    $customer_id = $khach_cu['id'];
                }
            }

            if (!$customer_id) {
                $du_lieu_khach_moi = [
                    'ho_ten' => $ten_khach,
                    'dien_thoai' => $sdt_khach
                ];
                $customer_id = $customerModel->create($du_lieu_khach_moi);
            }

            if (!$customer_id) {
                header('Location: index.php?action=booking_create&error=Lỗi hệ thống: Không thể tạo hồ sơ khách hàng.');
                exit;
            }

            // --- BƯỚC 2: TẠO ĐẶT CHỖ ---
            $data['customer_id'] = $customer_id;
            $data['ma_dat_tour'] = 'BK-' . strtoupper(uniqid()); 
            
            // FIX LỖI USER ID: Gán ID user hợp lệ vào $data trước khi gọi Model
            // Luôn đảm bảo ID này tồn tại trong bảng `users` (ví dụ: ID = 1)
            $data['user_id'] = $_SESSION['user_id'] ?? 1; 

            // Cần đảm bảo các trường khác có giá trị mặc định để tránh lỗi PHP
            $data['trang_thai'] = $data['trang_thai'] ?? 'Đang chờ';
            $data['da_thanh_toan'] = $data['da_thanh_toan'] ?? 0;
            $data['ghi_chu'] = $data['ghi_chu'] ?? '';
            $data['so_nguoi_lon'] = $data['so_nguoi_lon'] ?? 1;
            $data['so_tre_em'] = $data['so_tre_em'] ?? 0;
            $data['tong_tien'] = $data['tong_tien'] ?? 0;

            if ($this->bookingModel->create($data)) {
                header('Location: index.php?action=booking_index&msg=Thêm đặt chỗ thành công!');
            } else {
                header('Location: index.php?action=booking_create&error=Lỗi CSDL: Không thể lưu đơn đặt chỗ. (Kiểm tra ID Tour hoặc Model Booking)');
            }
            exit;
        }
    }
    
    // Thêm các hàm show, edit, update, destroy khác nếu có...
}
?>