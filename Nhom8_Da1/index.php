<?php
session_start();

require_once __DIR__ . '/app/helpers.php';
require_once __DIR__ . '/app/Controllers/UserController.php';
require_once __DIR__ . '/app/Controllers/AdminController.php';
require_once __DIR__ . '/app/Controllers/HdvController.php';
require_once __DIR__ . '/app/Controllers/AuthController.php';

$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Hàm render view từ ngoài class (dùng cho home)
function renderView($view, $data = []) {
    extract($data);
    include __DIR__ . '/views/layouts/header.php';
    include __DIR__ . "/views/$view.php";
    include __DIR__ . '/views/layouts/footer.php';
}

// ===== Router =====
switch($page){
    // ===== Auth =====
    case 'login':
        $auth = new AuthController();
        if ($action == 'loginForm' || $action == 'index') {
            $auth->loginForm();
        } elseif ($action == 'checkLogin') {
            $auth->checkLogin();
        } elseif ($action == 'logout') {
            $auth->logout();
        }
        break;

    // ===== User =====
    case 'user':
        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] !== 'user' && $_SESSION['user']['role'] !== 'hdv')) {
            header('Location: index.php?page=login&action=loginForm');
            exit;
        }

        $controller = new UserController();
        switch($action) {
            case 'list':
            case 'index':
                $controller->tourList();
                break;
            case 'detail':
                $controller->tourDetail();
                break;
            case 'showBookingPage':
                $controller->showBookingPage();
                break;
            case 'book':
                $controller->bookTour();
                break;
            case 'saveBooking':
                $controller->saveBooking();
                break;
            case 'contact':
                $controller->contact();
                break;
            case 'sendContact':
                $controller->sendContact();
                break;
            case 'register':
                $controller->register();
                break;
            case 'saveRegister':
                $controller->saveRegister();
                break;
            default:
                $controller->tourList();
                break;
        }
        break;

    // ===== Admin =====
    case 'admin_dashboard':
    case 'admin_categories':
    case 'admin_tours':
    case 'admin_users':
    case 'admin_suppliers':
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?page=login&action=loginForm');
            exit;
        }

        $controller = new AdminController();

        switch($page) {
            case 'admin':
                $controller->dashboard();
                break;

            case 'admin_categories':
                if ($action == 'list') $controller->categoryList();
                elseif ($action == 'add') $controller->categoryAdd();
                elseif ($action == 'edit') $controller->categoryEdit();
                elseif ($action == 'delete') $controller->categoryDelete();
                break;

            case 'admin_tours':
                if ($action == 'list') $controller->tourList();
                elseif ($action == 'add') $controller->tourAdd();
               
                break;

          

           
        }
        break;

    // ===== Home =====
    case 'home':
    default:
        renderView('home');
        break;
}
