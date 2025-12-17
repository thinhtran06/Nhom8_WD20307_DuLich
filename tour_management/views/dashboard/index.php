<?php
// ==================== 1. SESSION & DB ====================
require_once 'config/session.php';
require_once 'config/Database.php';

// ==================== 2. AUTOLOAD ====================
spl_autoload_register(function ($className) {
    // Controllers
    if (strpos($className, 'Controller') !== false) {
        $file = 'controllers/' . $className . '.php';
        if (file_exists($file)) require_once $file;
    }

    // Models
    $modelFile = 'models/' . $className . '.php';
    if (file_exists($modelFile)) require_once $modelFile;
});

// ==================== 3. DB CONNECT ====================
$database = new Database();
$conn = $database->getConnection();

// ==================== 4. ROUTES ====================
$routes = [
    // AUTH
    'login'         => ['Auth', 'login', false],
    'process_login' => ['Auth', 'processLogin', false],
    'logout'        => ['Auth', 'logout', false],

    // TRANG 2 = TRANG CHỦ THẬT
    'dashboard'     => ['Dashboard', 'index', true],
];

// ==================== 5. ACTION MẶC ĐỊNH (NHẢY VÀO TRANG 2)
$action = $_GET['action'] ?? 'dashboard';
$id     = $_GET['id'] ?? null;

// ==================== 6. CHECK ROUTE ====================
if (!isset($routes[$action])) {
    $action = 'dashboard';
}

[$controllerName, $method, $protected] = $routes[$action];

// ==================== 7. LOGIN CHECK ====================
if ($protected) {
    requireLogin(); // nếu chưa login → login
}

// ==================== 8. INIT CONTROLLER ====================
$controllerClass = $controllerName . 'Controller';
$controller = new $controllerClass($conn);

// ==================== 9. LAYOUT START ====================
include 'views/layout/header.php';

// ==================== 10. CALL METHOD ====================
$controller->$method();

// ==================== 11. LAYOUT END ====================
include 'views/layout/footer.php';
