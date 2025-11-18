<?php
require_once __DIR__ . '/app/helpers.php';
require_once __DIR__ . '/app/Controllers/UserController.php';
require_once __DIR__ . '/app/Controllers/AdminController.php';
require_once __DIR__ . '/app/Controllers/HdvController.php';

$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Hàm render view từ ngoài class (dùng cho home)
function renderView($view, $data = []) {
    extract($data);
    include __DIR__ . '/views/layouts/header.php';
    include __DIR__ . "/views/$view.php";
    include __DIR__ . '/views/layouts/footer.php';
}

// Router
switch($page){
    // ===== User =====
    case 'user':
        $controller = new UserController();

        if ($action == 'index' || $action == 'list') {
            $controller->tourList();
        } elseif ($action == 'detail') {
            $controller->tourDetail();
        } elseif ($action == 'showBookingPage') {
            $controller->showBookingPage();
        } elseif ($action == 'book') {
            $controller->bookTour();
        } elseif ($action == 'saveBooking') {
            $controller->saveBooking();
        } elseif ($action == 'contact') {
            $controller->contact();
        } elseif ($action == 'sendContact') {
            $controller->sendContact();
        }
        break;

    // ===== Admin =====
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

    // ===== Login =====
    case 'login':
        if($action == 'index') {
            include __DIR__ . '/views/auth/login.php';
        }
        break;
   case 'register':
    $controller = new UserController();
    if ($action == 'index') {
        $controller->register();
    } elseif ($action == 'saveRegister') {
        $controller->register();
    }
    break;

    

    // ===== Trang chủ =====
    case 'home':
    default:
        renderView('home');
        break;
}
