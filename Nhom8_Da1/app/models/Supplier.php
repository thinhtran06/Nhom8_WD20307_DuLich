<?php
require_once __DIR__ . '/../config/database.php';

class Supplier {
    private static $table = 'suppliers';

    // Lấy tất cả supplier
    public static function all() {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM " . self::$table . " ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy supplier theo ID
    public static function find($id) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM " . self::$table . " WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm mới supplier
    public static function create($data) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("INSERT INTO " . self::$table . " (name) VALUES (:name)");
        $stmt->bindParam(':name', $data['name']);
        return $stmt->execute();
    }

    // Cập nhật supplier
    public static function update($id, $data) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("UPDATE " . self::$table . " SET name = :name WHERE id = :id");
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Xóa supplier
    public static function delete($id) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("DELETE FROM " . self::$table . " WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
