<?php 
class AdminController {

    private function checkAdmin() {
        session_start();
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?page=login");
            exit();
        }
    }

    public function tourList() {
        $this->checkAdmin(); // kiểm tra quyền admin
        $tours = Tour::all();
        include __DIR__ . '/../../views/layouts/header.php';
        include __DIR__ . '/../../views/admin/tours/list.php';
        include __DIR__ . '/../../views/layouts/footer.php';
    }

    public function tourAdd() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Tour::create($_POST);
            header("Location: index.php?page=admin_tours&action=list");
            exit;
        }
        include __DIR__ . '/../../views/layouts/header.php';
        include __DIR__ . '/../../views/admin/tours/add.php';
        include __DIR__ . '/../../views/layouts/footer.php';
    }

    public function bookingList() {
        $this->checkAdmin();
        $bookings = Booking::all();
        include __DIR__ . '/../../views/layouts/header.php';
        include __DIR__ . '/../../views/admin/bookings/list.php';
        include __DIR__ . '/../../views/layouts/footer.php';
    }

    public function bookingAdd() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Booking::create($_POST);
            header("Location: index.php?page=admin_bookings&action=list");
            exit;
        }
        include __DIR__ . '/../../views/layouts/header.php';
        include __DIR__ . '/../../views/admin/bookings/add.php';
        include __DIR__ . '/../../views/layouts/footer.php';
    }
}
