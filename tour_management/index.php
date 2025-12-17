<?php
// ==================== 1. SESSION & DATABASE ====================
require_once 'config/session.php';
require_once 'config/Database.php';

// ==================== 2. AUTOLOAD ====================
spl_autoload_register(function ($className) {
    if (strpos($className, 'Controller') !== false) {
        $controllerPath = 'controllers/' . $className . '.php';
        if (file_exists($controllerPath)) {
            require_once $controllerPath;
        }
    }

    $modelPath = 'models/' . $className . '.php';
    if (file_exists($modelPath)) {
        require_once $modelPath;
    }
});

// ==================== 3. DB CONNECT ====================
try {
    $database = new Database();
    $conn = $database->getConnection();
} catch (Exception $e) {
    die("Lỗi kết nối CSDL: " . $e->getMessage());
}

// ==================== 4. ROUTES ====================
$routes = [

    // ===== AUTH =====
    'login'                 => ['Auth', 'login', false],
    'process_login'         => ['Auth', 'processLogin', false],
    'logout'                => ['Auth', 'logout', false],

    // ===== DASHBOARD (TRANG CHỦ) =====
    ''                      => ['Dashboard', 'index', true],
    'dashboard'             => ['Dashboard', 'index', true],

    // ===== TOUR =====
    'tour_index'            => ['Tour', 'index', true],
    'tour_trong_nuoc'       => ['Tour', 'listByLoaiTour', true],
    'tour_ngoai_nuoc'       => ['Tour', 'listByLoaiTour', true],
    'tour_create'           => ['Tour', 'create', true],
    'tour_store'            => ['Tour', 'store', true],
    'tour_show'             => ['Tour', 'show', true],
    'tour_edit'             => ['Tour', 'edit', true],
    'tour_update'           => ['Tour', 'update', true],
    'tour_delete'           => ['Tour', 'destroy', true],

    // ===== SUPPLIER =====
    'supplier_index'        => ['Supplier', 'index', true],
    'supplier_create'       => ['Supplier', 'create', true],
    'supplier_store'        => ['Supplier', 'store', true],
    'supplier_show'         => ['Supplier', 'show', true],
    'supplier_edit'         => ['Supplier', 'edit', true],
    'supplier_update'       => ['Supplier', 'update', true],
    'supplier_delete'       => ['Supplier', 'destroy', true],

    // ===== USER =====
    'user_index'            => ['User', 'index', true],
    'user_create'           => ['User', 'create', true],
    'user_store'            => ['User', 'store', true],
    'user_show'             => ['User', 'show', true],
    'user_edit'             => ['User', 'edit', true],
    'user_update'           => ['User', 'update', true],
    'user_delete'           => ['User', 'destroy', true],

    // ===== TOUR REQUEST =====
    'tour_request_create'   => ['TourRequest', 'create', true],
    'tour_request_store'    => ['TourRequest', 'store', true],
    'tour_request_index'    => ['TourRequest', 'index', true],
    'tour_request_show'     => ['TourRequest', 'show', true],

    // ===== BOOKING =====
    'booking_index'         => ['Booking', 'index', true],
    'booking_create'        => ['Booking', 'create', true],
    'booking_edit'          => ['Booking', 'edit', true],
    'booking_delete'        => ['Booking', 'delete', true],
    'booking_update_status' => ['Booking', 'updateStatus', true],
    'booking_attendance'    => ['Booking', 'checkAttendance', true],

    // ===== ATTENDANCE =====
    'attendance_index'      => ['Attendance', 'index', true],

    // ===== GUIDE =====
    'guide_index'           => ['Guide', 'index', true],
    'guide_create'          => ['Guide', 'create', true],
    'guide_store'           => ['Guide', 'store', true],
    'guide_edit'            => ['Guide', 'edit', true],
    'guide_update'          => ['Guide', 'update', true],
    'guide_delete'          => ['Guide', 'destroy', true],

    'guide_schedule'        => ['Guide', 'schedule', true],
    'guide_tour_detail'     => ['Guide', 'tourDetail', true],
    'guide_customers'       => ['Guide', 'customers', true],

    'guide_customer_add'    => ['Guide', 'addCustomerForm', true],
    'guide_customer_store'  => ['Guide', 'customerStore', true],
    'guide_customer_edit'   => ['Guide', 'editCustomerForm', true],
    'guide_customer_update' => ['Guide', 'customerUpdate', true],
    'guide_customer_delete' => ['Guide', 'customerDelete', true],

    'guide_checkin'         => ['Guide', 'checkin', true],
    'guide_save_checkin'    => ['Guide', 'saveCheckin', true],

    'guide_special_request'      => ['Guide', 'specialRequest', true],
    'guide_save_special_request' => ['Guide', 'saveSpecialRequest', true],

    'guide_diary'           => ['GuideDiary', 'index', true],
    'guide_diary_add'       => ['GuideDiary', 'add', true],
    'guide_diary_edit'      => ['GuideDiary', 'edit', true],
    'guide_diary_store'     => ['GuideDiary', 'save', true],
    'guide_diary_delete'    => ['GuideDiary', 'delete', true],

    'guide_work_assign'     => ['GuideWork', 'assignForm', true],
    'guide_work_assign_save'=> ['GuideWork', 'assignSave', true],
];

// ==================== 5. DISPATCH ====================
$action = $_GET['action'] ?? '';
$id     = $_GET['id'] ?? null;

if (!isset($routes[$action])) {
    header("Location: index.php?action=dashboard");
    exit;
}

[$controllerName, $method, $isProtected] = $routes[$action];

if ($isProtected) {
    requireLogin();
}

$controllerClass = $controllerName . 'Controller';
$controller = new $controllerClass($conn);

// ==================== 6. CALL METHOD ====================
if ($method === 'listByLoaiTour') {
    $loai = ($action === 'tour_trong_nuoc') ? 'Trong nước' : 'Ngoài nước';
    $controller->$method($loai);
} elseif (in_array($method, [
    'update', 'updateStatus', 'checkAttendance',
    'edit', 'delete', 'destroy', 'show',
    'customerDelete', 'tourDetail'
])) {
    $controller->$method($id);
} else {
    $controller->$method();
}

exit;
