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
    
    // THÊM: Tải Models (Giả định Models nằm trong thư mục 'models/' và tên file = tên class, ví dụ: User.php)
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
    'login'           => ['Auth', 'login', false],
    'process_login'   => ['Auth', 'processLogin', false],
    'logout'          => ['Auth', 'logout', false],

    // --- Dashboard & Default Route (isProtected = true) ---
    ''                => ['Dashboard', 'index', true],
    'dashboard'       => ['Dashboard', 'index', true], 

    // --- Tour Routes (isProtected = true) ---
    'tour_index'      => ['Tour', 'index', true],
    'tour_create'     => ['Tour', 'create', true],
    'tour_store'      => ['Tour', 'store', true],
    'tour_show'       => ['Tour', 'show', true],
    'tour_edit'       => ['Tour', 'edit', true],
    'tour_update'     => ['Tour', 'update', true],
    'tour_delete'     => ['Tour', 'destroy', true],

    // --- Supplier Routes (isProtected = true) ---
    'supplier_index'  => ['Supplier', 'index', true],
    'supplier_create' => ['Supplier', 'create', true],
    'supplier_store'  => ['Supplier', 'store', true],
    'supplier_show'   => ['Supplier', 'show', true],
    'supplier_edit'   => ['Supplier', 'edit', true],
    'supplier_update' => ['Supplier', 'update', true],
    'supplier_delete' => ['Supplier', 'destroy', true],
    
    // --- User Routes (isProtected = true) --- 
    'user_index'      => ['User', 'index', true],
    'user_create'     => ['User', 'create', true],
    'user_store'      => ['User', 'store', true],
    'user_show'       => ['User', 'show', true],
    'user_edit'       => ['User', 'edit', true],
    'user_update'     => ['User', 'update', true],
    'user_delete'     => ['User', 'destroy', true],
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
    
    // 4.2 Khởi tạo Controller và Gọi phương thức
    $controllerClass = $controllerName . 'Controller';
    
    // KHẮC PHỤC LỖI: Truyền đối tượng kết nối $conn vào constructor
    // Tất cả Controllers (kể cả Auth, Dashboard, Tour, Supplier) đều phải nhận $conn
    // nếu chúng sử dụng Model mà Model đó cần $db.
    $controller = new $controllerClass($conn); 
    
    // Gọi phương thức tương ứng.
    $controller->$method($id);
    
    exit(); // Dừng ứng dụng sau khi xử lý route thành công
    
} else {
    // Route không tồn tại: Chuyển hướng về Dashboard 
    header("Location: index.php?action=dashboard");
    exit();
}

// KHỐI CODE LẶP LẠI Ở CUỐI ĐÃ ĐƯỢC XÓA
?>