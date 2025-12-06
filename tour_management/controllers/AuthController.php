<?php
// controllers/AuthController.php
// Controller chỉ xử lý Authentication (Login/Logout)

require_once 'config/database.php';
require_once 'config/session.php';
require_once 'models/User.php';

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    // Hiển thị form đăng nhập
    public function login() {
        // Nếu đã đăng nhập rồi thì chuyển về dashboard
        if(isLoggedIn()) {
            header("Location: index.php?action=dashboard");
            exit();
        }
        require_once 'views/auth/login.php';
    }

    // Xử lý đăng nhập
    public function processLogin() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            // Validate input
            if(empty($username) || empty($password)) {
                header("Location: index.php?action=login&error=Vui lòng nhập đầy đủ thông tin");
                exit();
            }

            // Kiểm tra đăng nhập
            if($this->user->login($username, $password)) {
                // Lưu thông tin vào session
                $_SESSION['user_id'] = $this->user->id;
                $_SESSION['username'] = $this->user->username;
                $_SESSION['ho_ten'] = $this->user->ho_ten;
                $_SESSION['role'] = $this->user->role;

                // Chuyển đến dashboard
                header("Location: index.php?action=dashboard");
                exit();
            } else {
                // Đăng nhập thất bại
                header("Location: index.php?action=login&error=Tên đăng nhập hoặc mật khẩu không đúng");
                exit();
            }
        }
    }

    // Đăng xuất
    public function logout() {
        // Xóa toàn bộ session
        session_unset();
        session_destroy();
        
        // Chuyển về trang đăng nhập
        header("Location: index.php?action=login&message=Đăng xuất thành công");
        exit();
    }
}
?>

