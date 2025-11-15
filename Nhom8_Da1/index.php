<?php
// index.php

require_once __DIR__ . '/app/helpers.php';
require_once __DIR__ . '/app/Controllers/AdminController.php';
require_once __DIR__ . '/app/Controllers/HdvController.php';

// Router đơn giản
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Trang chủ, header + footer đẹp
function renderHome() {
    include __DIR__ . '/views/layouts/header.php';
    ?>

    <div class="hero">
        <h1>Chào mừng bạn đến với Web Du Lịch</h1>
        <p>Khám phá những tour hấp dẫn, đặt tour nhanh chóng và tiện lợi.</p>
        <a href="index.php?page=admin_tours&action=list" class="btn-primary">Xem danh sách tour</a>
    </div>

    <div class="section">
        <h2>Tour nổi bật</h2>
        <div class="tour-grid">
            <div class="tour-card">
                <img src="https://via.placeholder.com/300x150" alt="Tour 1">
                <h3>Tour Hà Nội - Hạ Long</h3>
                <p>3 ngày 2 đêm, tham quan Vịnh Hạ Long, trải nghiệm ẩm thực địa phương.</p>
                <a href="#" class="btn-primary">Đặt tour</a>
            </div>
            <div class="tour-card">
                <img src="https://via.placeholder.com/300x150" alt="Tour 2">
                <h3>Tour Đà Nẵng - Hội An</h3>
                <p>4 ngày 3 đêm, khám phá phố cổ Hội An, bãi biển Mỹ Khê tuyệt đẹp.</p>
                <a href="#" class="btn-primary">Đặt tour</a>
            </div>
            <div class="tour-card">
                <img src="https://via.placeholder.com/300x150" alt="Tour 3">
                <h3>Tour Sài Gòn - Cần Thơ</h3>
                <p>3 ngày 2 đêm, trải nghiệm chợ nổi Cần Thơ, khám phá miền Tây sông nước.</p>
                <a href="#" class="btn-primary">Đặt tour</a>
            </div>
        </div>
    </div>

    <?php
    include __DIR__ . '/views/layouts/footer.php';
}

switch($page){
    case 'admin_tours':
        $controller = new AdminController();
        if($action == 'list') $controller->tourList();
        if($action == 'add') $controller->tourAdd();
        break;

    case 'admin_bookings':
        $controller = new AdminController();
        if($action == 'list') $controller->bookingList();
        if($action == 'add') $controller->bookingAdd();
        break;

    case 'hdv_schedule':
        $controller = new HdvController();
        $controller->viewSchedule();
        break;

    case 'home':
    default:
        renderHome();
        break;
}
