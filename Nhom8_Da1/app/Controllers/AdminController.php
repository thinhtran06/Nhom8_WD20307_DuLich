<?php
// app/Controllers/AdminController.php

require_once __DIR__ . '/../models/Tour.php';
require_once __DIR__ . '/../models/Booking.php';

class AdminController {

    // Hiển thị danh sách tour
    public function tourList() {
        $tours = Tour::all();
        include __DIR__ . '/../../views/layouts/header.php';
        include __DIR__ . '/../../views/admin/tours/list.php';
        include __DIR__ . '/../../views/layouts/footer.php';
    }

    // Thêm tour mới
    public function tourAdd() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Tour::create($_POST);
            header("Location: index.php?page=admin_tours&action=list");
            exit;
        }
        include __DIR__ . '/../../views/layouts/header.php';
        include __DIR__ . '/../../views/admin/tours/add.php';
        include __DIR__ . '/../../views/layouts/footer.php';
    }

    // Hiển thị danh sách booking
    public function bookingList() {
        $bookings = Booking::all();
        include __DIR__ . '/../../views/layouts/header.php';
        include __DIR__ . '/../../views/admin/bookings/list.php';
        include __DIR__ . '/../../views/layouts/footer.php';
    }

    // Thêm booking mới
    public function bookingAdd() {
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
