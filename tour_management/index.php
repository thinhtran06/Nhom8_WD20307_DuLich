<?php
// index.php - Router chính (ĐÃ CẬP NHẬT HOÀN CHỈNH)

// ==================== 1. Requires & Autoloading ====================

// 1.1 Khởi tạo Session
require_once 'config/session.php';
// 1.2 Khởi tạo Kết nối Database (Cần thiết cho các Controllers/Models)
require_once 'config/Database.php'; 


// 1.3 Thiết lập Autoloading
spl_autoload_register(function ($className) {
    
    // Tải Controllers
    if (strpos($className, 'Controller') !== false) {
        $filePath = 'controllers/' . $className . '.php';
        if (file_exists($filePath)) {
            require_once $filePath;
        }
    }
    
    // Tải Models (Giả định Models nằm trong thư mục 'models/' và tên file = tên class)
    if (file_exists('models/' . $className . '.php')) {
        require_once 'models/' . $className . '.php';
    }
});


// ==================== 2. Khởi tạo Kết nối Database ====================

try {
    $database = new Database();
    $conn = $database->getConnection(); // $conn là đối tượng PDO được sử dụng trong Models
} catch (Exception $e) {
    // Xử lý lỗi kết nối DB
    die("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage());
}


// ==================== 3. Router Map (Bản đồ định tuyến) ====================

$routes = [
    // --- Authentication Routes (isProtected = false) ---
    'login'             => ['Auth', 'login', false],
    'process_login'     => ['Auth', 'processLogin', false],
    'logout'            => ['Auth', 'logout', false],

    // --- Dashboard & Default Route (isProtected = true) ---
    ''                  => ['Dashboard', 'index', true],
    'dashboard'         => ['Dashboard', 'index', true], 

    // --- Tour Routes (isProtected = true) ---
    'tour_index'        => ['Tour', 'index', true],
    
    // Các routes cho việc lọc tour theo loại (dùng listByLoaiTour)
    'tour_trong_nuoc'   => ['Tour', 'listByLoaiTour', true], 
    'tour_ngoai_nuoc'   => ['Tour', 'listByLoaiTour', true], 
    
    'tour_create'       => ['Tour', 'create', true],
    'tour_store'        => ['Tour', 'store', true],
    'tour_show'         => ['Tour', 'show', true],
    'tour_edit'         => ['Tour', 'edit', true],
    'tour_update'       => ['Tour', 'update', true],
    'tour_delete'       => ['Tour', 'destroy', true],

    // --- Supplier Routes (isProtected = true) ---
    'supplier_index'    => ['Supplier', 'index', true],
    'supplier_create'   => ['Supplier', 'create', true],
    'supplier_store'    => ['Supplier', 'store', true],
    'supplier_show'     => ['Supplier', 'show', true],
    'supplier_edit'     => ['Supplier', 'edit', true],
    'supplier_update'   => ['Supplier', 'update', true],
    'supplier_delete'   => ['Supplier', 'destroy', true],
    
    // --- User Routes (isProtected = true) --- 
    'user_index'        => ['User', 'index', true],
    'user_create'       => ['User', 'create', true],
    'user_store'        => ['User', 'store', true],
    'user_show'         => ['User', 'show', true],
    'user_edit'         => ['User', 'edit', true],
    'user_update'       => ['User', 'update', true],
    'user_delete'       => ['User', 'destroy', true],
    
    // --- Tour Request Routes (isProtected = true) ---
    'tour_request_create'  => ['TourRequest', 'create', true], 
    'tour_request_store'   => ['TourRequest', 'store', true], 
    'tour_request_index'   => ['TourRequest', 'index', true],
    'tour_request_show'    => ['TourRequest', 'show', true],
    
    // 🌟 --- Booking Routes (CRUD & Thao tác) (isProtected = true) ---
    'booking_index'         => ['Booking', 'index', true],
    'booking_create'        => ['Booking', 'create', true],
    'booking_edit'          => ['Booking', 'edit', true],
    'booking_delete'        => ['Booking', 'delete', true],
    
    // <--- CÁC ROUTES MỚI ĐƯỢC THÊM --->
    'booking_update_status' => ['Booking', 'updateStatus', true],   // Dùng cho form cập nhật trạng thái
    'booking_attendance'    => ['Booking', 'checkAttendance', true], // Dùng cho trang điểm danh chi tiết
    // <--- KẾT THÚC CÁC ROUTES MỚI --->
    
    // 🌟 --- Attendance Routes (Tổng quan) (isProtected = true) ---
    // (Cần tạo AttendanceController.php với phương thức index)
    'attendance_index'      => ['Attendance', 'index', true], 

    // --- GUIDE ROUTES ---
    'guide_index'            => ['Guide', 'index', true],
    'guide_create'           => ['Guide', 'create', true],
    'guide_store'            => ['Guide', 'store', true],
    'guide_edit'             => ['Guide', 'edit', true],
    'guide_update'           => ['Guide', 'update', true],
    'guide_delete'           => ['Guide', 'destroy', true],

    // Lịch làm việc HDV
    'guide_schedule'         => ['Guide', 'schedule', true],

    // Chi tiết tour HDV
    'guide_tour_detail'      => ['Guide', 'tourDetail', true],

    // Danh sách khách theo tour
    'guide_customers'        => ['Guide', 'customers', true],

    //  THÊM KHÁCH HÀNG
    'guide_customer_add'      => ['Guide', 'addCustomerForm', true],
    'guide_customer_store'    => ['Guide', 'customerStore', true],
    //  Xóa_Sửa   KHÁCH HÀNG
    'guide_customer_delete' => ['Guide', 'customerDelete', true],
    'guide_customer_update' => ['Guide', 'customerUpdate', true],
    'guide_customer_edit' => ['Guide', 'customerEdit', true],

    // Điểm danh khách
    'guide_checkin'          => ['Guide', 'checkin', true],
    'guide_save_checkin'     => ['Guide', 'saveCheckin', true],

    // Yêu cầu đặc biệt
    'guide_special_request'        => ['Guide', 'specialRequest', true],
    'guide_save_special_request'   => ['Guide', 'saveSpecialRequest', true],

    // NHẬT KÝ TOUR — DÙNG GuideDiaryController
    'guide_diary'         => ['GuideDiary', 'index', true],
    'guide_diary_add'     => ['GuideDiary', 'add', true],
    'guide_diary_edit'    => ['GuideDiary', 'edit', true],
    'guide_diary_store'    => ['GuideDiary', 'save', true],
    'guide_diary_delete' => ['GuideDiary', 'delete', true],

    'guide_work_assign'       => ['GuideWork', 'assignForm', true],
    'guide_work_assign_save'  => ['GuideWork', 'assignSave', true],
    
    // Loại bỏ các route cũ không cần thiết, vì đã dùng 'booking_attendance'
    // 'attendance_list_bookings' => ['Attendance', 'listBookings', true], 
    // 'attendance_check'         => ['Attendance', 'checkAttendance', true],
    
];


// ==================== 4. Xử lý Route Chính ====================

$action = isset($_GET['action']) ? $_GET['action'] : ''; 
$id = isset($_GET['id']) ? $_GET['id'] : null;

if (isset($routes[$action])) {
    // Lấy thông tin Controller/Method từ Router Map
    list($controllerName, $method, $isProtected) = $routes[$action];
    
    // 4.1 Kiểm tra Đăng nhập
    if ($isProtected) {
        // Giả định hàm requireLogin() đã được định nghĩa
        requireLogin();
    }
    
    // 4.2 Khởi tạo Controller
    $controllerClass = $controllerName . 'Controller';
    
    // Truyền đối tượng kết nối $conn vào constructor
    // Đảm bảo các Controller Class đã được định nghĩa (ví dụ: BookingController)
    $controller = new $controllerClass($conn); 
    
    // 4.3 Gọi phương thức tương ứng
    if ($method === 'listByLoaiTour') {
        // Xử lý logic lọc Tour: Xác định loại tour cần truyền vào Controller
        $loai_tour = ($action === 'tour_trong_nuoc') ? 'Trong nước' : 'Ngoài nước';
        $controller->$method($loai_tour);
    } elseif (in_array($method, ['updateStatus', 'checkAttendance', 'edit', 'delete', 'show', 'destroy'])) {
        // Gọi các phương thức cần truyền ID
        $controller->$method($id);
    } else {
        // Gọi các phương thức không cần ID (index, create, store, destroy, v.v.)
        $controller->$method();
    }
    
    exit(); // Dừng ứng dụng sau khi xử lý route thành công
    
} else {
    // Route không tồn tại: Chuyển hướng về Dashboard 
    header("Location: index.php?action=dashboard");
    exit();
}
?>