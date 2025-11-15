<?php
// app/Controllers/AdminController.php
require_once __DIR__ . '/../Models/Tour.php';
require_once __DIR__ . '/../Models/Booking.php';

class AdminController {
    public function tourList(){
        $tours = Tour::all();
        include __DIR__ . '/../../views/layouts/header.php';
        include __DIR__ . '/../../views/admin/tours/list.php';
        include __DIR__ . '/../../views/layouts/footer.php';
    }

    public function tourAdd(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            Tour::create($_POST);
            header("Location: index.php?page=admin_tours&action=list");
            exit;
        }
        include __DIR__ . '/../../views/layouts/header.php';
        include __DIR__ . '/../../views/admin/tours/add.php';
        include __DIR__ . '/../../views/layouts/footer.php';
    }

    public function bookingList(){
        $bookings = Booking::all();
        include __DIR__ . '/../../views/layouts/header.php';
        include __DIR__ . '/../../views/admin/bookings/list.php';
        include __DIR__ . '/../../views/layouts/footer.php';
    }

    public function bookingAdd(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            Booking::create($_POST);
            header("Location: index.php?page=admin_bookings&action=list");
            exit;
        }
        include __DIR__ . '/../../views/layouts/header.php';
        include __DIR__ . '/../../views/admin/bookings/add.php';
        include __DIR__ . '/../../views/layouts/footer.php';
    }
}
