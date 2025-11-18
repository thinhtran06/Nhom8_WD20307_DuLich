<?php
// app/Models/User.php
require_once __DIR__ . '/../../config/database.php';

class User {
    public static function create($data) {
        $db = Database::getConnection(); // lấy kết nối PDO từ config/database.php

        $stmt = $db->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)");

        // Mã hóa password trước khi lưu
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $data['role']);

        return $stmt->execute();
    }

    // Kiểm tra đăng nhập
    public static function checkLogin($email, $password) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
