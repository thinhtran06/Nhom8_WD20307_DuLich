<?php
// /public/index.php

// Thiết lập hiển thị lỗi (Quan trọng khi debug)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 1. NHẬN THAM SỐ TỪ URL
$controller_name = isset($_GET['controller']) ? $_GET['controller'] : 'tour';
$action_name = isset($_GET['action']) ? $_GET['action'] : 'index';

// 2. ĐỊNH NGHĨA TÊN CLASS (PHẢI TRƯỚC DÒNG 18)
$controller_class = ucfirst($controller_name) . 'Controller'; 

// 3. LẤY ĐƯỜNG DẪN GỐC CỦA DỰ ÁN (đi từ /public -> /php1_base)
$project_root = dirname(__DIR__); 

// 4. TẠO ĐƯỜNG DẪN TUYỆT ĐỐI đến Controller
$controller_file = $project_root . '/controllers/' . $controller_class . '.php';

// 5. Tải và Khởi tạo Controller
if (file_exists($controller_file)) {
    require_once $controller_file;
    
    $controller = new $controller_class();
    
    if (method_exists($controller, $action_name)) {
        $controller->$action_name();
    } else {
        echo "Lỗi: Action **{$action_name}** không tồn tại!";
    }
} else {
    // Thông báo lỗi cụ thể
    echo "Lỗi: Controller **{$controller_class}** không tồn tại.";
    echo "<br><b>Đường dẫn đã kiểm tra:</b> " . $controller_file;
}
?>