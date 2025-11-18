<?php
require_once __DIR__ . '/../Models/Tour.php';
require_once __DIR__ . '/../Models/Booking.php';
require_once __DIR__ . '/../Models/User.php'; // Thêm để xử lý đăng ký

class UserController {

    // =====================
    // Hiển thị danh sách tour
    // =====================
    public function tourList() {
        $tours = Tour::all(); 
        $this->renderView('user/list', ['tours' => $tours]);
    }

    // =====================
    // Chi tiết tour
    // =====================
    public function tourDetail() {
        $id = $_GET['id'] ?? null;
        $tour = $this->getTourById($id);
        if (!$tour) {
            echo "<p>Tour không tồn tại.</p>";
            return;
        }
        $this->renderView('user/detail', ['tour' => $tour]);
    }

    // =====================
    // Trang chọn tour để đặt
    // =====================
    public function showBookingPage() {
        $tours = Tour::all();
        $this->renderView('user/book_select', ['tours' => $tours]);
    }

    // =====================
    // Trang booking theo ID tour
    // =====================
    public function bookTour() {
        $id = $_GET['id'] ?? null;
        $tour = $this->getTourById($id);
        if (!$tour) {
            echo "<p>Tour không tồn tại.</p>";
            return;
        }
        $this->renderView('user/book', ['tour' => $tour]);
    }

    // =====================
    // Lưu booking
    // =====================
    public function saveBooking() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo "Phương thức không hợp lệ!";
            return;
        }

        $data = [
            'tour_id'       => $_POST['tour_id'],
            'customer_name' => $_POST['customer_name'],
            'phone'         => $_POST['phone'],
            'quantity'      => $_POST['quantity'],
            'notes'         => $_POST['notes'],
            'status'        => 'pending',
            'created_at'    => date('Y-m-d H:i:s')
        ];

        Booking::create($data);

        echo "<h3>Đặt tour thành công! Chờ admin xác nhận.</h3>";
        echo "<a href='index.php?page=user&action=list'>Quay lại danh sách tour</a>";
    }

    // =====================
    // Form liên hệ
    // =====================
    public function contact() {
        $this->renderView('user/contact');
    }

    // =====================
    // Xử lý gửi form liên hệ
    // =====================
    public function sendContact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'message' => $_POST['message'] ?? '',
                'created_at' => date('Y-m-d H:i:s')
            ];

            $file = __DIR__ . '/../../storage/contact.txt';
            if (!file_exists(dirname($file))) mkdir(dirname($file), 0777, true);

            file_put_contents($file, json_encode($data) . PHP_EOL, FILE_APPEND);

            echo "<h3>Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm.</h3>";
            echo "<a href='index.php'>Quay lại trang chủ</a>";
        } else {
            echo "Phương thức không hợp lệ!";
        }
    }

    // =====================
    // Đăng ký user
    // =====================
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'role' => 'user'
            ];

            User::create($data);

            echo "<h3>Đăng ký thành công!</h3>";
            echo "<a href='index.php?page=login&action=index'>Đăng nhập ngay</a>";
        } else {
            $this->renderView('auth/register');
        }
    }

    // =====================
    // Lấy tour theo ID
    // =====================
    private function getTourById($id) {
        if (!$id) return null;
        foreach (Tour::all() as $t) {
            if ($t['id'] == $id) return $t;
        }
        return null;
    }

    // =====================
    // Render view
    // =====================
    private function renderView($view, $data = []) {
        extract($data);
        include __DIR__ . '/../../views/layouts/header.php';
        include __DIR__ . '/../../views/' . $view . '.php';
        include __DIR__ . '/../../views/layouts/footer.php';
    }
}
