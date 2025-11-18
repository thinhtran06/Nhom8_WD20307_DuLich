<?php
// app/models/Booking.php

require_once __DIR__ . '/../../config/database.php';

class Booking {

    // Lấy tất cả booking
    public static function all() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM bookings ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tìm booking theo ID
    public static function find($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM bookings WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo booking mới
    public static function create($data) {
        global $pdo;

        $sql = "INSERT INTO bookings 
                (tour_id, customer_name, phone, quantity, notes, status, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            $data['tour_id'],
            $data['customer_name'],
            $data['phone'],
            $data['quantity'],
            $data['notes'],
            $data['status'],      // pending / confirmed / deposit / completed / canceled
            $data['created_at']
        ]);
    }

    // Update trạng thái (admin dùng)
    public static function updateStatus($id, $status) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    // Xoá booking
    public static function delete($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
