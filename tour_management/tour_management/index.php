<?php
// index.php - Router chính (Đã hoàn chỉnh và xử lý kết nối DB)

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
    
    // THÊM: Tải Models (Giả định Models nằm trong thư mục 'models/' và tên file = tên class)
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
    'tour_index'        => ['Tour', 'index', true], // Hiển thị tất cả tour (mặc định)
    
    // THÊM: Các routes cho việc lọc tour theo loại (dùng listByLoaiTour)
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
    
    // THÊM: Route mới để xử lý lưu yêu cầu nội bộ
    'tour_request_store'   => ['TourRequest', 'store', true], 
    
    'tour_request_index'   => ['TourRequest', 'index', true],
    'tour_request_show'    => ['TourRequest', 'show', true],
];


// ==================== 4. Xử lý Route Chính ====================

$action = isset($_GET['action']) ? $_GET['action'] : ''; 
$id = isset($_GET['id']) ? $_GET['id'] : null;

if (isset($routes[$action])) {
    // Lấy thông tin Controller/Method từ Router Map
    list($controllerName, $method, $isProtected) = $routes[$action];
    
    // 4.1 Kiểm tra Đăng nhập
    if ($isProtected) {
        requireLogin();
    }
    
    // 4.2 Khởi tạo Controller
    $controllerClass = $controllerName . 'Controller';
    
    // Truyền đối tượng kết nối $conn vào constructor
    $controller = new $controllerClass($conn); 
    
    // 4.3 Gọi phương thức tương ứng, xử lý trường hợp lọc Tour
    if ($method === 'listByLoaiTour') {
        // Xử lý logic lọc Tour: Xác định loại tour cần truyền vào Controller
        $loai_tour = ($action === 'tour_trong_nuoc') ? 'Trong nước' : 'Ngoài nước';
        $controller->$method($loai_tour);
    } else {
        // Gọi phương thức thông thường (truyền $id nếu cần, hoặc null)
        $controller->$method($id);
    }
    
    exit(); // Dừng ứng dụng sau khi xử lý route thành công
    
} else {
    // Route không tồn tại: Chuyển hướng về Dashboard 
    header("Location: index.php?action=dashboard");
    exit();
}
?>