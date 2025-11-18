<?php
// app/models/Booking.php

require_once __DIR__ . '/../../config/database.php';

class Booking {
    public static function all() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM bookings");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO bookings (tour_id, customer_name, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$data['tour_id'], $data['customer_name'], $data['quantity']]);
    }
}
