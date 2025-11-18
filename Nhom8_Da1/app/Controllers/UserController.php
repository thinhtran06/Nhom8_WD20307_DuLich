<?php
require_once __DIR__ . '/../Models/Tour.php';

class UserController {

    // Hiển thị danh sách tour
    public function tourList() {
        $tours = Tour::all(); // Lấy tất cả tour từ DB
        $this->render('user/list', ['tours' => $tours]);
    }

    // Hiển thị trang booking theo ID tour
    public function bookTour() {
        $id = $_GET['id'] ?? null;
        $tour = $this->getTourById($id);
        if (!$tour) {
            echo "<p>Tour không tồn tại.</p>";
            return;
        }
        $this->render('user/book', ['tour' => $tour]);
    }

    // Hiển thị chi tiết tour theo ID
    public function tourDetail() {
        $id = $_GET['id'] ?? null;
        $tour = $this->getTourById($id);
        if (!$tour) {
            echo "<p>Tour không tồn tại.</p>";
            return;
        }
        $this->render('user/detail', ['tour' => $tour]);
    }

    // Hàm tìm tour theo ID
    private function getTourById($id) {
        if (!$id) return null;
        $tours = Tour::all();
        foreach ($tours as $t) {
            if ($t['id'] == $id) return $t;
        }
        return null;
    }

    // Hàm render view kèm header + footer
    private function render($view, $data = []) {
        extract($data);
        include __DIR__ . '/../../views/layouts/header.php';
        include __DIR__ . '/../../views/' . $view . '.php';
        include __DIR__ . '/../../views/layouts/footer.php';
    }
}
