<?php
// config/session.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: index.php?action=login");
        exit();
    }
}

function getUserRole() {
    return $_SESSION['role'] ?? null;
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function getUsername() {
    return $_SESSION['username'] ?? 'Guest';
}

function getFullName() {
    return $_SESSION['ho_ten'] ?? 'Guest';
}
?>