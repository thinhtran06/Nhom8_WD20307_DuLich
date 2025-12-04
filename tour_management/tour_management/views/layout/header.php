<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Tour Du Lịch</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background: #ffffff;
        }

        /* ============================
           NAVBAR
        ============================ */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 2000; /* navbar trên cùng */
        }

        /* ============================
           SIDEBAR
        ============================ */
        .sidebar {
            position: fixed;
            top: 56px; /* dưới navbar */
            left: 0;
            width: 250px;
            height: calc(100vh - 56px);
            background: #f8f9fa;
            border-right: 1px solid #dee2e6;
            overflow-y: auto;
            padding-top: 10px;
            z-index: 100; /* sidebar dưới main-content */
        }

        .sidebar .nav-link {
            color: #333;
            padding: 12px 20px;
            font-size: 14px;
            font-weight: 500;
            display: block;
        }

        .sidebar .nav-link:hover {
            background: #e9ecef;
        }

        .sidebar .nav-link.active {
            background: #dceaff;
            color: #007bff;
            border-left: 3px solid #007bff;
        }

        /* Submenu */
        .submenu {
            background: #eef3f7;
            list-style: none;
            padding-left: 0;
            margin-left: 20px;
            border-left: 3px solid #007bff;
        }

        .submenu a {
            padding: 10px 30px;
            display: block;
            font-size: 13px;
            color: #555;
        }

        .submenu a.active {
            background: #cfe2ff;
            font-weight: bold;
        }

        /* ============================
           MAIN CONTENT – FIX CLICK
        ============================ */
        .main-content {
            margin-left: 250px;
            margin-top: 56px;
            padding: 20px;
            min-height: 100vh;
            background: #ffffff;
            position: relative;
            z-index: 3000 !important;  /* ⭐⭐ QUAN TRỌNG: khiến các nút click được */
        }

        /* Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand font-weight-bold" href="index.php">🏖️ Tour Go</a>
</nav>

<?php $current = $_GET['action'] ?? ''; ?>

<!-- SIDEBAR -->
<nav class="sidebar">
    <ul class="nav flex-column">

        <li class="nav-item">
            <a class="nav-link <?= ($current=='dashboard' || $current=='') ? 'active' : '' ?>"
               href="index.php?action=dashboard">📊 Dashboard</a>
        </li>

        <!-- DANH MỤC -->
        <?php $dmOpen = in_array($current, ['tour_trong_nuoc','tour_ngoai_nuoc','tour_request_index']); ?>
        <li class="nav-item">
            <a class="nav-link <?= $dmOpen?'active':'' ?>" data-toggle="collapse" href="#dmMenu">📁 Quản Lý Danh Mục ▼</a>
            <ul class="collapse submenu <?= $dmOpen?'show':'' ?>" id="dmMenu">
                <li><a href="index.php?action=tour_trong_nuoc" class="<?= $current=='tour_trong_nuoc'?'active':'' ?>">🇻🇳 Tour Trong Nước</a></li>
                <li><a href="index.php?action=tour_ngoai_nuoc" class="<?= $current=='tour_ngoai_nuoc'?'active':'' ?>">🌍 Tour Ngoài Nước</a></li>
                <li><a href="index.php?action=tour_request_index" class="<?= $current=='tour_request_index'?'active':'' ?>">💡 Tour Theo Yêu Cầu</a></li>
            </ul>
        </li>

        <!-- TOUR -->
        <?php $tourOpen = strpos($current, 'tour_') === 0; ?>
        <li class="nav-item">
            <a class="nav-link <?= $tourOpen?'active':'' ?>" data-toggle="collapse" href="#tourMenu">🏝️ Quản Lý Tour ▼</a>
            <ul class="collapse submenu <?= $tourOpen?'show':'' ?>" id="tourMenu">
                <li><a href="index.php?action=tour_index" class="<?= $current=='tour_index'?'active':'' ?>">📋 Danh Sách Tour</a></li>
                <li><a href="index.php?action=tour_create" class="<?= $current=='tour_create'?'active':'' ?>">➕ Tạo Tour</a></li>
            </ul>
        </li>

        <!-- NHÀ CUNG CẤP -->
        <?php $nccOpen = strpos($current, 'supplier_') === 0; ?>
        <li class="nav-item">
            <a class="nav-link <?= $nccOpen?'active':'' ?>" data-toggle="collapse" href="#nccMenu">🏢 Quản Lý NCC ▼</a>
            <ul class="collapse submenu <?= $nccOpen?'show':'' ?>" id="nccMenu">
                <li><a href="index.php?action=supplier_index" class="<?= $current=='supplier_index'?'active':'' ?>">📋 Danh Sách NCC</a></li>
                <li><a href="index.php?action=supplier_create" class="<?= $current=='supplier_create'?'active':'' ?>">➕ Thêm NCC</a></li>
            </ul>
        </li>

        <!-- USER -->
        <?php if (function_exists('isAdmin') && isAdmin()): ?>
            <?php $userOpen = strpos($current, 'user_') === 0; ?>
            <li class="nav-item">
                <a class="nav-link <?= $userOpen?'active':'' ?>" data-toggle="collapse" href="#userMenu">👥 Quản Lý User ▼</a>
                <ul class="collapse submenu <?= $userOpen?'show':'' ?>" id="userMenu">
                    <li><a href="index.php?action=user_index" class="<?= $current=='user_index'?'active':'' ?>">📋 Danh Sách User</a></li>
                    <li><a href="index.php?action=user_create" class="<?= $current=='user_create'?'active':'' ?>">➕ Thêm User</a></li>
                </ul>
            </li>
        <?php endif; ?>

        <!-- BOOKING -->
        <li class="nav-item">
            <a class="nav-link <?= strpos($current, 'booking_')===0?'active':'' ?>"
               href="index.php?action=booking_index">🎫 Quản Lý Đặt Chỗ</a>
        </li>

        <!-- HDV -->
        <?php $guideOpen = strpos($current, 'guide_') === 0; ?>

<li class="nav-item">
    <a class="nav-link <?= $guideOpen ? 'active' : '' ?>" 
       data-toggle="collapse" 
       href="#guideMenu">
        👨‍🏫 Quản Lý Hướng Dẫn Viên ▼
    </a>

    <ul class="collapse submenu <?= $guideOpen ? 'show' : '' ?>" id="guideMenu">

        <li>
            <a href="index.php?action=guide_index" 
               class="<?= $current=='guide_index' ? 'active' : '' ?>">
                📋 Danh Sách Hướng Dẫn Viên
            </a>
        </li>

        <li>
            <a href="index.php?action=guide_create" 
               class="<?= $current=='guide_create' ? 'active' : '' ?>">
                ➕ Thêm Hướng Dẫn Viên
            </a>
        </li>
        <?php $guideOpen = strpos($current, 'guide_') === 0; ?>
    </ul>
</li>


        <!-- LOGOUT -->
        <li class="nav-item">
            <a class="nav-link text-danger" href="index.php?action=logout">🚪 Đăng Xuất</a>
        </li>
    </ul>
</nav>

<!-- MAIN CONTENT WRAPPER -->
<div class="main-content">
