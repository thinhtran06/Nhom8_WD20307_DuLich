<?php
// index.php

require_once __DIR__ . '/app/helpers.php';
require_once __DIR__ . '/app/Controllers/UserController.php';
require_once __DIR__ . '/app/Controllers/AdminController.php';
require_once __DIR__ . '/app/Controllers/HdvController.php';

$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';

/**
 * Hàm render view kèm header và footer
 */
function renderView($view, $data = []) {
    extract($data);
    include __DIR__ . '/views/layouts/header.php';
    include __DIR__ . "/views/$view.php";
    include __DIR__ . '/views/layouts/footer.php';
}

/**
 * Router
 */
switch($page){
    // ===== User =====
    case 'user':
        $controller = new UserController();
        if($action == 'index' || $action == 'list') {
            $controller->tourList();
        } elseif($action == 'book') {
            $controller->bookTour();
        } elseif($action == 'detail') {
            $controller->tourDetail();
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

    // ===== HDV =====
    case 'hdv_schedule':
        $controller = new HdvController();
        $controller->viewSchedule();
        break;

    // ===== Trang chủ =====
    case 'home':
    default:
        renderView('home');
        break;
}
