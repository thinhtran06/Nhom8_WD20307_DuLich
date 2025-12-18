<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Tour Du Lịch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; }
        .container { max-width: 1200px; }
        h1, h2 { color: #2c3e50; margin-bottom: 20px; }
        .alert { margin-bottom: 20px; }
        
        /* Bổ sung/Chỉnh sửa CSS (Giữ nguyên các style khác) */
        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            width: 250px;
            height: calc(100vh - 56px);
            z-index: 100;
        }
        /* ... các style khác ... */
        
        /* Đảm bảo style sidebar và submenu đã được định nghĩa trong code gốc */
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <a class="navbar-brand" href="index.php">🏖️ Tour Go</a>
    </nav>

<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo (!isset($_GET['action']) || $_GET['action'] == 'dashboard') ? 'active' : ''; ?>" 
                    href="index.php?action=dashboard">
                    📊 Dashboard
                </a>
            </li>
          <?php
// Lấy action hiện tại từ URL
$currentAction = $_GET['action'] ?? '';

// Định nghĩa các action thuộc menu "Quản Lý Danh Mục"
$categoryActions = ['tour_trong_nuoc', 'tour_ngoai_nuoc'];

// Kiểm tra xem menu chính "Quản Lý Danh Mục" có đang active không
$isCategoryActive = in_array($currentAction, $categoryActions);
?>
          <li class="nav-item">
    <a class="nav-link menu-toggle <?php echo $isCategoryActive ? 'active' : ''; ?>" 
       href="#categorySubmenu" data-toggle="collapse" aria-expanded="<?php echo $isCategoryActive ? 'true' : 'false'; ?>">
        📁 Quản Lý Danh Mục
        <span class="arrow">▼</span>
    </a>
 <ul class="collapse submenu <?php echo $isCategoryActive ? 'show' : ''; ?>" id="categorySubmenu">
    <li>
        <a href="index.php?action=tour_trong_nuoc" 
           class="<?php echo ($currentAction == 'tour_trong_nuoc') ? 'active' : ''; ?>">
            🇻🇳 Tour Trong Nước
        </a>
    </li>
    <li>
        <a href="index.php?action=tour_ngoai_nuoc" 
           class="<?php echo ($currentAction == 'tour_ngoai_nuoc') ? 'active' : ''; ?>">
            🌐 Tour Ngoài Nước
        </a>
    </li>
    <li>
        <a href="index.php?action=tour_request_index"
           class="<?php echo ($currentAction == 'tour_request_index') ? 'active' : ''; ?>">
            💡 Tour Theo Yêu cầu
        </a>
    </li>
</ul>
</li>
            
            <li class="nav-item">
                <a class="nav-link menu-toggle <?php echo (isset($_GET['action']) && strpos($_GET['action'], 'tour_') === 0) ? 'active' : ''; ?>" 
                    href="#tourSubmenu" data-toggle="collapse" aria-expanded="<?php echo (isset($_GET['action']) && strpos($_GET['action'], 'tour_') === 0) ? 'true' : 'false'; ?>">
                    🏖️ Quản Lý Tour
                    <span class="arrow">▼</span>
                </a>
                <ul class="collapse submenu <?php echo (isset($_GET['action']) && strpos($_GET['action'], 'tour_') === 0) ? 'show' : ''; ?>" id="tourSubmenu">
                    <li>
                        <a href="index.php?action=tour_index" class="<?php echo (isset($_GET['action']) && $_GET['action'] == 'tour_index' && !isset($_GET['category'])) ? 'active' : ''; ?>">
                            📋 Danh Sách Tour (Chung)
                        </a>
                    </li>
                    <li>
                        <a href="index.php?action=tour_create" class="<?php echo (isset($_GET['action']) && $_GET['action'] == 'tour_create') ? 'active' : ''; ?>">
                            ➕ Tạo Tour Mới
                        </a>
                    </li>
                </ul>
            </li>
            
            <li class="nav-item">
                <a class="nav-link menu-toggle <?php echo (isset($_GET['action']) && strpos($_GET['action'], 'supplier_') === 0) ? 'active' : ''; ?>" 
                    href="#supplierSubmenu" data-toggle="collapse" aria-expanded="<?php echo (isset($_GET['action']) && strpos($_GET['action'], 'supplier_') === 0) ? 'true' : 'false'; ?>">
                    🏢 Quản Lý Nhà Cung Cấp
                    <span class="arrow">▼</span>
                </a>
                <ul class="collapse submenu <?php echo (isset($_GET['action']) && strpos($_GET['action'], 'supplier_') === 0) ? 'show' : ''; ?>" id="supplierSubmenu">
                    <li>
                        <a href="index.php?action=supplier_index" class="<?php echo (isset($_GET['action']) && $_GET['action'] == 'supplier_index' && !isset($_GET['type'])) ? 'active' : ''; ?>">
                            📋 Danh Sách Nhà Cung Cấp
                        </a>
                    </li>
                    <li>
                        <a href="index.php?action=supplier_create" class="<?php echo (isset($_GET['action']) && $_GET['action'] == 'supplier_create') ? 'active' : ''; ?>">
                            ➕ Thêm Nhà Cung Cấp
                        </a>
                    </li>
                    <li>
                        <a href="index.php?action=supplier_index&type=hotel" class="<?php echo (isset($_GET['type']) && $_GET['type'] == 'hotel') ? 'active' : ''; ?>">
                            🏨 Khách Sạn
                        </a>
                    </li>
                    <li>
                        <a href="index.php?action=supplier_index&type=transport" class="<?php echo (isset($_GET['type']) && $_GET['type'] == 'transport') ? 'active' : ''; ?>">
                            🚗 Vận Chuyển
                        </a>
                    </li>
                    <li>
                        <a href="index.php?action=supplier_index&type=restaurant" class="<?php echo (isset($_GET['type']) && $_GET['type'] == 'restaurant') ? 'active' : ''; ?>">
                            🍽️ Nhà Hàng
                        </a>
                    </li>
                </ul>
            </li>
            
            <?php if(isAdmin()): ?>
            <li class="nav-item">
                <a class="nav-link menu-toggle <?php echo (isset($_GET['action']) && strpos($_GET['action'], 'user_') === 0) ? 'active' : ''; ?>" 
                    href="#userSubmenu" data-toggle="collapse" aria-expanded="<?php echo (isset($_GET['action']) && strpos($_GET['action'], 'user_') === 0) ? 'true' : 'false'; ?>">
                    👥 Quản Lý Tài Khoản
                    <span class="arrow">▼</span>
                </a>
                <ul class="collapse submenu <?php echo (isset($_GET['action']) && strpos($_GET['action'], 'user_') === 0) ? 'show' : ''; ?>" id="userSubmenu">
                    <li>
                        <a href="index.php?action=user_index" class="<?php echo (isset($_GET['action']) && $_GET['action'] == 'user_index') ? 'active' : ''; ?>">
                            📋 Danh Sách User
                        </a>
                    </li>
                    <li>
                        <a href="index.php?action=user_create" class="<?php echo (isset($_GET['action']) && $_GET['action'] == 'user_create') ? 'active' : ''; ?>">
                            ➕ Thêm User Mới
                        </a>
                    </li>
                </ul>
            </li>
            <?php endif; ?>
                   <li class="nav-item">
                <a class="nav-link <?php echo (isset($_GET['action']) && strpos($_GET['action'], 'booking_') === 0) ? 'active' : ''; ?>" 
                    href="index.php?action=booking_index">
                    🎫 Quản Lý Đặt Chỗ
                </a>
            </li>
            </li>
            
       <!-- <li class="nav-item">
 <a class="nav-link 
                    href="index.php?action=attendance_index">
                    📋 Quản Lý Điểm Danh
                </a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link <?php echo (isset($_GET['action']) && strpos($_GET['action'], 'hdv_') === 0) ? 'active' : ''; ?>" 
                    href="index.php?action=guide_index">
                    👨‍💼 Quản Lý Hướng Dẫn Viên
                </a>
            </li>
            <li class="nav-item">
    <a class="nav-link" href="index.php?action=booking_stats">
        <i class="fas fa-chart-bar"></i>  📋Thống Kê
    </a>
</li>
            
            <li class="nav-item">
                <a class="nav-link" href="index.php?action=logout" 
                    onclick="return confirm('Bạn có chắc muốn đăng xuất?')">
                    🚪 Đăng Xuất
                </a>
            </li>
        </ul>
    </div>
</nav>

<style>
    .sidebar {
        position: fixed;
        top: 56px;
        bottom: 0;
        left: 0;
        z-index: 100;
        padding: 48px 0 0;
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        overflow-y: auto;
    }
    
    /* Đẩy nội dung sang phải để tránh sidebar */
    main, .main-content, .container-fluid {
        margin-left: 250px; /* Độ rộng của sidebar */
        padding: 20px;
    }
    
    /* Hoặc nếu dùng class container */
    body .container {
        margin-left: 250px;
        max-width: calc(100% - 270px);
    }

    
    .sidebar-sticky {
        position: relative;
        top: 0;
        height: calc(100vh - 48px);
        padding-top: .5rem;
        overflow-x: hidden;
        overflow-y: auto;
    }
    
    /* Layout chính */
    body {
        margin: 0;
        padding: 0;
    }
    
    /* Navbar không bị che */
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1030;
    }
    
    /* Sidebar */
    .sidebar {
        position: fixed;
        top: 56px; /* Chiều cao navbar */
        left: 0;
        width: 250px;
        height: calc(100vh - 56px);
        z-index: 100;
    }
    
    /* Content area - đẩy sang phải */
    .main-content {
        margin-left: 250px; /* Bằng width của sidebar */
        margin-top: 56px; /* Bằng height của navbar */
        padding: 20px;
        min-height: calc(100vh - 56px);
    }
    
    /* Main Menu Links */
    .sidebar .nav-link {
        font-weight: 500;
        color: #333;
        padding: 15px 20px;
        font-size: 14px;
        position: relative;
        transition: all 0.3s ease;
    }
    
    .sidebar .nav-link:hover {
        background-color: #e9ecef;
        border-left: 3px solid #007bff;
    }
    
    .sidebar .nav-link.active {
        color: #007bff;
        background-color: #e7f1ff;
        border-left: 3px solid #007bff;
    }
    
    /* Menu Toggle with Arrow */
    .menu-toggle {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .menu-toggle .arrow {
        font-size: 10px;
        transition: transform 0.3s ease;
    }
    
    .menu-toggle[aria-expanded="true"] .arrow {
        transform: rotate(-180deg);
    }
    
    /* Submenu Styles */
    .submenu {
        list-style: none;
        padding-left: 0;
        background-color: #f8f9fa;
        border-left: 3px solid #007bff;
        margin-left: 20px;
    }
    
    .submenu li {
        margin: 0;
    }
    
    .submenu li a {
        display: block;
        padding: 10px 20px 10px 30px;
        color: #555;
        text-decoration: none;
        font-size: 13px;
        transition: all 0.2s ease;
        border-left: 2px solid transparent;
    }
    
    .submenu li a:hover {
        background-color: #e9ecef;
        color: #007bff;
        border-left-color: #007bff;
        padding-left: 35px;
    }
    
    .submenu li a.active {
        background-color: #d4e6f7;
        color: #007bff;
        font-weight: 600;
        border-left-color: #007bff;
    }
    
    /* Smooth Collapse Animation */
    .submenu.collapsing {
        transition: height 0.3s ease;
    }
    
    /* Scrollbar Styling */
    .sidebar::-webkit-scrollbar {
        width: 6px;
    }
    
    .sidebar::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    .sidebar::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }
    
    .sidebar::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>