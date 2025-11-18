<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Web Du Lịch</title>
    <link rel="stylesheet" href="public/css/admin.css">
</head>
<body>
<header class="admin-header">
    <h1>Admin Panel</h1>
    <div class="admin-user">
        Xin chào, <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Admin') ?>
        | <a href="index.php?page=login&action=logout">Đăng xuất</a>
    </div>
</header>
<div class="admin-container">
