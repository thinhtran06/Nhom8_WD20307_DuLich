<?php
class DashboardController {
    public function index() {
        // Nếu chưa đăng nhập thì không cho vào dashboard
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }

        require_once 'views/dashboard/index.php';
    }
}
