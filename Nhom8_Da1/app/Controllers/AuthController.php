<?php
require_once __DIR__ . '/../Models/User.php';

class AuthController {

    // =====================
    // Hiển thị form login
    // =====================
    public function loginForm() {
        // Bắt buộc start session để session hoạt động
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        include __DIR__ . '/../../views/auth/login.php';
       
    }

    // =====================
    // Xử lý login
    // =====================
    public function checkLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = User::checkLogin($email, $password); // giả sử User::checkLogin trả về mảng user hoặc false

            if ($user) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user'] = [
                    'id'    => $user['id'],
                    'name'  => $user['name'],
                    'email' => $user['email'],
                    'role'  => $user['role']
                ];

                // Redirect theo quyền
                switch ($user['role']) {
                    case 'admin':
                        header('Location: index.php?page=admin_tours&action=list');
                        exit;
                    case 'hdv':
                        header('Location: index.php?page=hdv_schedule&action=viewSchedule');
                        exit;
                    default:
                        header('Location: index.php?page=user&action=list');
                        exit;
                }
            } else {
                $error = "Email hoặc mật khẩu không đúng!";
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                include __DIR__ . '/../../views/layouts/header.php';
                include __DIR__ . '/../../views/auth/login.php';
                include __DIR__ . '/../../views/layouts/footer.php';
            }
        } else {
            echo "Phương thức không hợp lệ!";
        }
    }

    // =====================
    // Đăng xuất
    // =====================
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: index.php?page=login&action=loginForm');
        exit;
    }
}
