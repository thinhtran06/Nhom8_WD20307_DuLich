<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo (!isset($_GET['action']) || $_GET['action'] == 'dashboard') ? 'active' : ''; ?>" 
                   href="index.php?action=dashboard">
                    📊 Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo (isset($_GET['action']) && strpos($_GET['action'], 'tour_') === 0) ? 'active' : ''; ?>" 
                   href="index.php?action=tour_index">
                    🏖️ Quản Lý Tour
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo (isset($_GET['action']) && strpos($_GET['action'], 'supplier_') === 0) ? 'active' : ''; ?>" 
                   href="index.php?action=supplier_index">
                    🏢 Quản Lý Nhà Cung Cấp
                </a>
            </li>
             <li class="nav-item">
                <a class="nav-link <?php echo (isset($_GET['action']) && strpos($_GET['action'], 'category_') === 0) ? 'active' : ''; ?>" 
                   href="index.php?action=category_index">
                   🏔️ Quản Lý Danh Mục
                </a>
            </li>
            <?php if(isAdmin()): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo (isset($_GET['action']) && strpos($_GET['action'], 'user_') === 0) ? 'active' : ''; ?>" 
                   href="index.php?action=user_index">
                    👥 Quản Lý Tài Khoản
                </a>
            </li>
            <?php endif; ?>
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
    }
    .sidebar-sticky {
        position: relative;
        top: 0;
        height: calc(100vh - 48px);
        padding-top: .5rem;
        overflow-x: hidden;
        overflow-y: auto;
    }
    .sidebar .nav-link {
        font-weight: 500;
        color: #333;
        padding: 15px 20px;
        font-size: 14px;
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
</style>